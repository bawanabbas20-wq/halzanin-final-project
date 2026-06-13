<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // firstOrCreate keeps this seeder safe to re-run on an environment
        // that already has these accounts (e.g. a live deployment).
        \App\Models\User::firstOrCreate(
            ['email' => 'citizen@test.com'],
            [
                'name' => 'Citizen User',
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'citizen',
            ]
        );

        // Civil Registry is the default ministry for scoped demo accounts.
        $ministryId = \App\Models\Ministry::where('slug', 'civil-registry')->value('id');

        \App\Models\User::firstOrCreate(
            ['email' => 'staff@test.com'],
            [
                'name' => 'Staff User',
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'staff',
                'ministry_id' => $ministryId,
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'ministry.admin@test.com'],
            [
                'name' => 'Ministry Admin User',
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'ministry_admin',
                'ministry_id' => $ministryId,
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }
}
