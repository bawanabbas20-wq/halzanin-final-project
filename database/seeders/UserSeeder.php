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
        \App\Models\User::create([
            'name' => 'Citizen User',
            'email' => 'citizen@test.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'citizen',
        ]);

        // Civil Registry is the default ministry for scoped demo accounts.
        $ministryId = \App\Models\Ministry::where('slug', 'civil-registry')->value('id');

        \App\Models\User::create([
            'name' => 'Staff User',
            'email' => 'staff@test.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'staff',
            'ministry_id' => $ministryId,
        ]);

        \App\Models\User::create([
            'name' => 'Ministry Admin User',
            'email' => 'ministry.admin@test.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'ministry_admin',
            'ministry_id' => $ministryId,
        ]);

        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
