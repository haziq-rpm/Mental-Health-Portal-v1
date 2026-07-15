<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\SessionNote;
use App\Models\Appointment;

class SessionNoteController extends Controller
{
    // Store an encrypted session note (therapist only)
    public function store(Request $request)
    {
        $request->validate([
            'SessionID'     => 'required|integer|exists:appointment,SessionID',
            'EncryptedNote' => 'required|string',
        ]);

        $therapistId = Auth::id();

        // Ensure therapist owns the session
        $appointment = Appointment::where('SessionID', $request->SessionID)
            ->where('TherapistID', $therapistId)
            ->firstOrFail();

        // Encrypt server-side (defense in depth)
        $cipherText = Crypt::encryptString($request->EncryptedNote);

        SessionNote::create([
            'SessionID'     => $appointment->SessionID,
            'TherapistID'   => $therapistId,
            'EncryptedNote' => $cipherText,
            'CreatedAt'     => now(),
        ]);

        return back()->with('success', 'Session note saved.');
    }

    // Optional: show a decrypted note (therapist only)
    public function show($noteId)
    {
        $therapistId = Auth::id();
        $note = SessionNote::findOrFail($noteId);

        if ($note->TherapistID !== $therapistId) {
            abort(403);
        }

        try {
            $decrypted = Crypt::decryptString($note->EncryptedNote);
        } catch (\Exception $e) {
            $decrypted = '[Unable to decrypt note]';
        }

        return view('therapist.sessionnote.show', compact('note','decrypted'));
    }
}
