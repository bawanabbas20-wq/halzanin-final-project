<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Extend the role enum to include ministry_admin
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('citizen','staff','admin','ministry_admin') NOT NULL DEFAULT 'citizen'");
    }

    public function down(): void
    {
        // First move any ministry_admin users back to admin to avoid data loss
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'ministry_admin'");
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('citizen','staff','admin') NOT NULL DEFAULT 'citizen'");
    }
};
