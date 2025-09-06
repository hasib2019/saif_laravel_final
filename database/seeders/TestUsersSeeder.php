<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\SuperAdmin;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create regular user
        User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        // Create admin user
        Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        // Create super admin user
        SuperAdmin::create([
            'name' => 'Test Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Test users created successfully!');
        $this->command->info('Regular User: user@gmail.com / 123456');
        $this->command->info('Admin: admin@gmail.com / 123456');
        $this->command->info('Super Admin: superadmin@gmail.com / 123456');
    }
}
