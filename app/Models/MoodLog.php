<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodLog extends Model
{
    protected $table = 'moodlog';
    protected $primaryKey = 'MoodLogID';
    public $timestamps = false;

    protected $fillable = [
    'PatientID',
    'MoodType',
    'MoodDescription',
    'LogDate',
    'CreatedAt'
];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }
}