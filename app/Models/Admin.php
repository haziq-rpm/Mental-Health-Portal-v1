<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $primaryKey = 'AdminID';
    public $timestamps = false;

    protected $fillable = ['FullName', 'Email', 'Password', 'Role'];
    protected $hidden = ['Password'];

    public function getAuthPassword()
    {
        return $this->Password;
    }
}