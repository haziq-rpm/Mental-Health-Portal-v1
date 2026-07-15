<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Therapist;
use App\Models\MoodLog;
class TherapistController extends Controller
{
    public function dashboard()
    {
        $therapistId = Auth::id();
        $upcoming = Appointment::where('TherapistID', $therapistId)
            ->where('SessionDate', '>=', now()->toDateString())
            ->with('patient','cancellation')
            ->orderBy('SessionDate','asc')
            ->get();

        // Unique patients via appointments
        $patients = Appointment::where('TherapistID', $therapistId)
            ->with('patient')
            ->get()
            ->pluck('patient')
            ->unique('PatientID')
            ->values();

        return view('therapist.dashboard', compact('upcoming','patients'));
    }
    public function viewPatient($id)
{
    $therapistId = Auth::id();

    // Ensure this therapist has had at least one appointment with the patient
    $allowed = Appointment::where('TherapistID', $therapistId)
        ->where('PatientID', $id)
        ->exists();

    if (!$allowed) {
        abort(403);
    }

    $patient = Patient::findOrFail($id);

    $appointments = Appointment::where('PatientID', $id)
        ->where('TherapistID', $therapistId)
        ->orderBy('SessionDate', 'desc')
        ->get();

    $moodLogs = MoodLog::where('PatientID', $id)
        ->orderBy('LogDate', 'desc')
        ->get();

    return view(
        'therapist.patient-profile',
        compact('patient','appointments','moodLogs')
    );
}

public function reschedule(Request $request, $id)
{
    $request->validate([
        'SessionDate' => 'required|date',
        'StartTime' => 'required',
        'EndTime' => 'required'
    ]);

    $appointment = Appointment::findOrFail($id);

    // Security check
    if ($appointment->TherapistID != Auth::id()) {
        abort(403);
    }

    $appointment->SessionDate = $request->SessionDate;
    $appointment->StartTime = $request->StartTime;
    $appointment->EndTime = $request->EndTime;
    $appointment->Status = "Rescheduled";

    $appointment->save();

    return back()->with('success','Session rescheduled successfully.');
}
public function updateAvailability(Request $request)
{
    $request->validate([
        'AvailabilityStatus' => 'required|in:Available,Unavailable'
    ]);

    $therapist = Auth::user();

    $therapist->AvailabilityStatus = $request->AvailabilityStatus;

    $therapist->save();

    return redirect()->route('therapist.dashboard')
        ->with('success', 'Availability Updated.');
}

public function editAvailability()
{
    return view('therapist.availability', [
        'therapist' => Auth::user()
    ]);
}
}
