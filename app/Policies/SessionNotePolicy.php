<?php
namespace App\Policies;

use App\Models\SessionNote;
use App\Models\Therapist;
use App\Models\User;

class SessionNotePolicy
{
    public function view(Therapist $therapist, SessionNote $note)
    {
        return $therapist->TherapistID === $note->TherapistID;
    }

    public function create(Therapist $therapist)
    {
        return true;
    }
}
