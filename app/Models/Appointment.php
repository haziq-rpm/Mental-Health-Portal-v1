<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'Appointment';
    protected $primaryKey = 'SessionID';
    public $timestamps = false;

    protected $fillable = [
        'PatientID', 'TherapistID', 'SessionDate', 'StartTime', 'EndTime', 'Status'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }

    public function therapist()
    {
        return $this->belongsTo(Therapist::class, 'TherapistID', 'TherapistID');
    }

    public function seassionNotes()
    {
        return $this->hasMany(SessionNote::class, 'SessionID', 'SessionID');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'SessionID', 'SessionID');
    }

    public function cancellation()
    {
        return $this->hasOne(Cancellation::class, 'SessionID', 'SessionID');
    }
}