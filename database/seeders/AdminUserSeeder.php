<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user if it doesn't exist
        Admin::firstOrCreate(
            ['email' => 'admin@derowntech.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@derowntech.com',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Create additional admin user
        Admin::firstOrCreate(
            ['email' => 'saif@derowntech.com'],
            [
                'name' => 'Saif Admin',
                'email' => 'saif@derowntech.com',
                'password' => Hash::make('saif123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}