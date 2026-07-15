<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Therapist;

class TherapistSeeder extends Seeder
{
    public function run()
    {
        Therapist::create([
            'FullName' => 'Dr. Ali Khan',
            'Email' => 'ali@therapy.com',
            'Password' => Hash::make('therapist123'),
            'LicenseNumber' => 'LIC004',
            'AvailabilityStatus' => 'Available',
            'Phone' => '03001234567',
            'VerificationStatus' => 'Verified',
            'SpecializationID' => 1,
        ]);

        Therapist::create([
            'FullName' => 'Dr. Sara Ahmed',
            'Email' => 'sara@therapy.com',
            'Password' => Hash::make('therapist456'),
            'LicenseNumber' => 'LIC002',
            'AvailabilityStatus' => 'Available',
            'Phone' => '03007654321',
            'VerificationStatus' => 'Pending',
            'SpecializationID' => 2,
        ]);

        Therapist::create([
            'FullName' => 'Dr. Bilal Hussain',
            'Email' => 'bilal@therapy.com',
            'Password' => Hash::make('therapist789'),
            'LicenseNumber' => 'LIC005',
            'AvailabilityStatus' => 'Unavailable',
            'Phone' => '03009876543',
            'VerificationStatus' => 'Verified',
            'SpecializationID' => 3,
        ]);
    }
}
