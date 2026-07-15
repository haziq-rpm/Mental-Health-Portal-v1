<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MoodLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MoodLogController extends Controller
{
    // Patient records a mood entry
    public function store(Request $request)
    {
        $request->validate([
            'LogDate'        => 'required|date',
            'MoodType'       => 'required|string|max:50',
            'MoodDescription'=> 'nullable|string|max:2000',
        ]);

        $patientId = Auth::id();

        // Prevent duplicate mood log for same date
        $exists = MoodLog::where('PatientID', $patientId)
            ->where('LogDate', $request->LogDate)
            ->exists();

        if ($exists) {
            return back()->withErrors(['LogDate' => 'Mood already recorded for this date.'])->withInput();
        }

        MoodLog::create([
            'PatientID'      => $patientId,
            'LogDate'        => $request->LogDate,
            'MoodType'       => $request->MoodType,
            'MoodDescription'=> $request->MoodDescription,
            'CreatedAt'      => now(),
        ]);

        return back()->with('success', 'Mood logged.');
    }

    // Patient views own mood logs
    public function index()
    {
        $patientId = Auth::id();
        $logs = MoodLog::where('PatientID', $patientId)->orderBy('LogDate','desc')->get();
        return view('patient.moodlog.index', compact('logs'));
    }

    // Therapist views aggregated trends for a patient
    public function trends($patientId)
    {
        $therapistId = Auth::id();

        $hasRelation = DB::table('appointment')
            ->where('PatientID', $patientId)
            ->where('TherapistID', $therapistId)
            ->exists();

        if (! $hasRelation) {
            abort(403);
        }

        $since = Carbon::now()->subDays(90)->toDateString();

        $trend = MoodLog::where('PatientID', $patientId)
            ->where('LogDate', '>=', $since)
            ->selectRaw('MoodType, COUNT(*) as count')
            ->groupBy('MoodType')
            ->orderByDesc('count')
            ->get();

        $recent = MoodLog::where('PatientID', $patientId)
            ->orderBy('LogDate','desc')
            ->limit(30)
            ->get();

        return view('therapist.moodlog.trends', compact('trend','recent','patientId'));
    }

    // Show edit form
public function edit($id)
{
    $log = MoodLog::where('MoodLogID', $id)
        ->where('PatientID', Auth::id())
        ->firstOrFail();

    return view('patient.moodlog.edit', compact('log'));
}

// Update mood log
public function update(Request $request, $id)
{
    $request->validate([
        'LogDate' => 'required|date',
        'MoodType' => 'required|string|max:50',
        'MoodDescription' => 'nullable|string|max:2000',
    ]);

    $log = MoodLog::where('MoodLogID', $id)
        ->where('PatientID', Auth::id())
        ->firstOrFail();

    $duplicate = MoodLog::where('PatientID', Auth::id())
        ->where('LogDate', $request->LogDate)
        ->where('MoodLogID', '!=', $id)
        ->exists();

    if ($duplicate) {
        return back()
            ->withErrors(['LogDate' => 'Mood already recorded for this date.'])
            ->withInput();
    }

    $log->update([
        'LogDate' => $request->LogDate,
        'MoodType' => $request->MoodType,
        'MoodDescription' => $request->MoodDescription,
    ]);

    return redirect()->route('patient.dashboard')
        ->with('success', 'Mood log updated successfully.');
}

// Delete mood log
public function destroy($id)
{
    $log = MoodLog::where('MoodLogID', $id)
        ->where('PatientID', Auth::id())
        ->firstOrFail();

    $log->delete();

    return redirect()->route('patient.dashboard')
        ->with('success', 'Mood log deleted successfully.');
}
}
