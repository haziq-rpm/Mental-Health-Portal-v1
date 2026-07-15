<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    protected $table = 'sessionnote';
    protected $primaryKey = 'NoteID';
    public $timestamps = false;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = null;

    protected $fillable = ['SessionID', 'EncryptedNote', 'CreatedAt'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'SessionID', 'SessionID');
    }
}
