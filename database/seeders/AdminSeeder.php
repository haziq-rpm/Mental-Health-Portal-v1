<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'FullName' => 'System Admin',
            'Email' => 'admin@admin.com',
            'Password' => Hash::make('admin123'),
            'Role' => 'SuperAdmin',
        ]);

        Admin::create([
            'FullName' => 'Support Admin',
            'Email' => 'support@admin.com',
            'Password' => Hash::make('support123'),
            'Role' => 'Support',
        ]);
    }
}
