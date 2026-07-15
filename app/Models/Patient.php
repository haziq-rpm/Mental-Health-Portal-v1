<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Patient extends Authenticatable
{
    protected $table = 'patient';
    protected $primaryKey = 'PatientID';
    public $timestamps = false;

    protected $fillable = [
        'FullName', 'Email', 'Password', 'Gender', 'DOB', 'Phone', 'RegistrationDate'
    ];

    protected $hidden = ['Password'];

    // Laravel auth expects a 'password' accessor
    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'PatientID', 'PatientID');
    }

    public function moodLogs()
    {
        return $this->hasMany(MoodLog::class, 'PatientID', 'PatientID');
    }
}