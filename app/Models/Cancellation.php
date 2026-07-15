<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    protected $table = 'cancellation';
    protected $primaryKey = 'SessionID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['SessionID', 'CancellationReason', 'CancellationTimestamp'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'SessionID', 'SessionID');
    }
}
