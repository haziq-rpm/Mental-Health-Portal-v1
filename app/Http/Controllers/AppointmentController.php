<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Appointment;
use App\Models\Therapist;

class AppointmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Patient Books Appointment
    |--------------------------------------------------------------------------
    */

    public function book(Request $request)
    {
        $request->validate([
            'TherapistID' => [
                'required',
                'integer',
                Rule::exists('therapist', 'TherapistID')
            ],

            'SessionDate' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'StartTime' => [
                'required',
                'date_format:H:i'
            ],

            'EndTime' => [
                'required',
                'date_format:H:i',
                'after:StartTime'
            ],
        ]);

        $patientId = Auth::id();

        $therapist = Therapist::findOrFail($request->TherapistID);

        /*
        |--------------------------------------------------------------------------
        | Therapist Availability
        |--------------------------------------------------------------------------
        */

        if ($therapist->AvailabilityStatus != "Available") {

            return back()
                ->withErrors([
                    'TherapistID' => 'This therapist is currently unavailable.'
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Check Time Conflict
        |--------------------------------------------------------------------------
        */

        $overlap = Appointment::where('TherapistID', $request->TherapistID)
            ->where('SessionDate', $request->SessionDate)
            ->where(function ($query) use ($request) {

                $query

                    ->whereBetween(
                        'StartTime',
                        [$request->StartTime, $request->EndTime]
                    )

                    ->orWhereBetween(
                        'EndTime',
                        [$request->StartTime, $request->EndTime]
                    )

                    ->orWhere(function ($q) use ($request) {

                        $q->where('StartTime', '<=', $request->StartTime)
                          ->where('EndTime', '>=', $request->EndTime);

                    });

            })
            ->exists();

        if ($overlap) {

            return back()
                ->withErrors([
                    'SessionDate' => 'Therapist already has another appointment during this time.'
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Create Appointment
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($request, $patientId) {

            Appointment::create([

                'PatientID'   => $patientId,
                'TherapistID' => $request->TherapistID,
                'SessionDate' => $request->SessionDate,
                'StartTime'   => $request->StartTime,
                'EndTime'     => $request->EndTime,
                'Status'      => 'Scheduled',

            ]);

        });

        return redirect()
            ->route('patient.dashboard')
            ->with('success', 'Appointment booked successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Therapist Reschedules Appointment
    |--------------------------------------------------------------------------
    */

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'SessionDate' => 'required|date|after_or_equal:today',
            'StartTime'   => 'required|date_format:H:i',
            'EndTime'     => 'required|date_format:H:i|after:StartTime',
        ]);

        $appointment = Appointment::findOrFail($id);

        // Only the assigned therapist can reschedule
        if ($appointment->TherapistID != Auth::id()) {
            abort(403);
        }

        // Check for another appointment at the same time
        $overlap = Appointment::where('TherapistID', Auth::id())
            ->where('SessionID', '!=', $appointment->SessionID)
            ->where('SessionDate', $request->SessionDate)
            ->where(function ($query) use ($request) {

                $query

                    ->whereBetween(
                        'StartTime',
                        [$request->StartTime, $request->EndTime]
                    )

                    ->orWhereBetween(
                        'EndTime',
                        [$request->StartTime, $request->EndTime]
                    )

                    ->orWhere(function ($q) use ($request) {

                        $q->where('StartTime', '<=', $request->StartTime)
                          ->where('EndTime', '>=', $request->EndTime);

                    });

            })
            ->exists();

        if ($overlap) {

            return back()->withErrors([
                'SessionDate' => 'Another appointment already exists during this time.'
            ]);
        }

        $appointment->update([

            'SessionDate' => $request->SessionDate,
            'StartTime'   => $request->StartTime,
            'EndTime'     => $request->EndTime,

        ]);

        return back()->with('success', 'Session rescheduled successfully.');
    }
}