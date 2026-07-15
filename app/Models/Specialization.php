<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $table = 'specialization';
    protected $primaryKey = 'SpecializationID';
    public $timestamps = false;

    protected $fillable = [
        'SpecializationName',
        'Description'
    ];

    public function therapists()
    {
        return $this->hasMany(
            Therapist::class,
            'SpecializationID',
            'SpecializationID'
        );
    }
}