<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Therapist extends Authenticatable
{
    protected $table = 'therapist';
    protected $primaryKey = 'TherapistID';
    public $timestamps = false;

    protected $fillable = [
        'FullName', 'Email', 'Password', 'LicenseNumber',
        'AvailabilityStatus', 'Phone', 'VerificationStatus', 'SpecializationID'
    ];

    protected $hidden = ['Password'];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'SpecializationID', 'SpecializationID');
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'TherapistID', 'TherapistID');
    }
}