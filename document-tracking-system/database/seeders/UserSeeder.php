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
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'citizen',
        ]);

        \App\Models\User::create([
            'name' => 'Staff User',
            'email' => 'staff@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'staff',
        ]);

        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
