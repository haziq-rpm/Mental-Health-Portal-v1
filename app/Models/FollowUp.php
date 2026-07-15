<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $table = 'followup';
    protected $primaryKey = 'FollowUpID';
    public $timestamps = false;

    protected $fillable = ['SessionID', 'FollowUpDate', 'ReminderMessage', 'Status'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'SessionID', 'SessionID');
    }
}