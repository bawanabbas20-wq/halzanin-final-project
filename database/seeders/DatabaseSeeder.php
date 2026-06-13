<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Order matters: ministries/services must exist before UserSeeder,
        // which links the demo staff/ministry-admin accounts to a ministry.
        $this->call([
            MinistriesAndServicesSeeder::class,
            UserSeeder::class,
        ]);
    }
}
