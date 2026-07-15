<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\MoodLog;
use App\Models\FollowUp;
use Illuminate\Support\Facades\Hash;


class PatientController extends Controller
{
    public function dashboard()
    {
        $patientId = Auth::id(); // auth:patient guard returns Patient model id
        $upcoming = Appointment::where('PatientID', $patientId)
            ->where('SessionDate', '>=', now()->toDateString())
            ->with('therapist','cancellation')
            ->orderBy('SessionDate','asc')
            ->get();

        $past = Appointment::where('PatientID', $patientId)
            ->where('SessionDate', '<', now()->toDateString())
            ->with('therapist','sessionNotes','cancellation')
            ->orderBy('SessionDate','desc')
            ->get();

        $moodLogs = MoodLog::where('PatientID', $patientId)->orderBy('LogDate','desc')->get();
        $followUps = FollowUp::whereHas('appointment', fn($q) => $q->where('PatientID', $patientId))->get();

        return view('patient.dashboard', compact('upcoming','past','moodLogs','followUps'));
    }


    public function editProfile()
{
    $patient = Auth::guard('patient')->user();

    return view('patient.edit-profile', compact('patient'));
}

public function updateProfile(Request $request)
{
    $patient = Auth::guard('patient')->user();

    $request->validate([
        'FullName' => 'required|max:100',
        'Email' => 'required|email|unique:patient,Email,' . $patient->PatientID . ',PatientID',
        'Phone' => 'required|max:20',
        'Gender' => 'required',
        'DOB' => 'required|date',
    ]);

    $patient->FullName = $request->FullName;
    $patient->Email = $request->Email;
    $patient->Phone = $request->Phone;
    $patient->Gender = $request->Gender;
    $patient->DOB = $request->DOB;

    if($request->filled('Password'))
    {
        $request->validate([
            'Password'=>'min:6|confirmed'
        ]);

        $patient->Password = Hash::make($request->Password);
    }

    $patient->save();

    return redirect()->route('patient.dashboard')
        ->with('success','Profile updated successfully.');
}
}
