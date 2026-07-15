<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Therapist;
use App\Models\Appointment;
use App\Models\Cancellation;
use App\Models\FollowUp;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $patients = Patient::all();
        $therapists = Therapist::all();
        $appointments = Appointment::with('patient','therapist','cancellation')->get();
        $cancellations = Cancellation::with('appointment')->get();
        $followUps = FollowUp::with('appointment')->get();

        return view('admin.dashboard', compact('patients','therapists','appointments','cancellations','followUps'));
    }

    public function verifyTherapist($id)
    {
        $t = Therapist::findOrFail($id);
        $t->VerificationStatus = 'Verified';
        $t->save();
        return back()->with('success','Therapist verified.');
    }
}
