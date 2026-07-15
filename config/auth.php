<?php

use App\Models\User;
use App\Models\Patient;
use App\Models\Therapist;
use App\Models\Admin;

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // New guards
        'patient' => [
            'driver' => 'session',
            'provider' => 'patients',
        ],

        'therapist' => [
            'driver' => 'session',
            'provider' => 'therapists',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => User::class,
        ],

        // New providers
        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class,
        ],

        'therapists' => [
            'driver' => 'eloquent',
            'model' => App\Models\Therapist::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
