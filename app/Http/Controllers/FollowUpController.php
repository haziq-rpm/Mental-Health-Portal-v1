<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FollowUp;
use App\Models\Appointment;

class FollowUpController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Therapist creates follow-up
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'SessionID' => 'required|exists:appointment,SessionID',
            'FollowUpDate' => 'required|date|after_or_equal:today',
            'ReminderMessage' => 'nullable|string|max:500',
        ]);

        FollowUp::create([
            'SessionID' => $request->SessionID,
            'FollowUpDate' => $request->FollowUpDate,
            'ReminderMessage' => $request->ReminderMessage,
            'Status' => 'Pending',
        ]);

        return back()->with('success', 'Follow-up created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Patient confirms follow-up
    |--------------------------------------------------------------------------
    */
    public function confirm(Request $request, $id)
    {
        $request->validate([
            'StartTime' => 'required',
            'EndTime' => 'required|after:StartTime',
        ]);

        $followUp = FollowUp::findOrFail($id);

        $appointment = Appointment::findOrFail($followUp->SessionID);

        Appointment::create([
            'PatientID'   => $appointment->PatientID,
            'TherapistID' => $appointment->TherapistID,
            'SessionDate' => $followUp->FollowUpDate,
            'StartTime'   => $request->StartTime,
            'EndTime'     => $request->EndTime,
            'Status'      => 'Scheduled',
        ]);

        $followUp->Status = 'Confirmed';
        $followUp->save();

        return redirect()
            ->route('patient.dashboard')
            ->with('success', 'Follow-up confirmed successfully.');
    }
}