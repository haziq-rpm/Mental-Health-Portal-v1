<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Cancellation;
use Illuminate\Support\Facades\DB;

class CancellationController extends Controller
{
    // Create a cancellation record for a session
    public function store(Request $request, $sessionId)
    {
        $request->validate([
            'CancellationReason' => 'nullable|string|max:2000',
        ]);

        // Find appointment
        $appointment = Appointment::findOrFail($sessionId);

        // Determine which guard is authenticated and get user id
        $user = Auth::user();
        $guard = null;
        if (Auth::guard('patient')->check()) {
            $guard = 'patient';
            $userId = Auth::guard('patient')->id();
            $isAllowed = ($appointment->PatientID == $userId);
        } elseif (Auth::guard('therapist')->check()) {
            $guard = 'therapist';
            $userId = Auth::guard('therapist')->id();
            $isAllowed = ($appointment->TherapistID == $userId);
        } else {
            // Not allowed
            abort(403, 'Unauthorized to cancel this session.');
        }

        if (! $isAllowed) {
            abort(403, 'You are not associated with this session.');
        }

        // Prevent duplicate cancellation
        if ($appointment->cancellation) {
            return back()->withErrors(['msg' => 'This session is already cancelled.']);
        }

        DB::transaction(function() use ($appointment, $request, $guard, $userId) {
            Cancellation::create([
                'SessionID' => $appointment->SessionID,
                'CancellationReason' => $request->input('CancellationReason'),
                'CancellationTimestamp' => now(),
            ]);

            // Update appointment status
            $appointment->Status = 'Cancelled';
            $appointment->save();
        });

        return back()->with('success', 'Session cancelled successfully.');
    }
}
