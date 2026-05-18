<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate any existing 'received' rows to 'under_review' before removing from enum
        DB::table('applications')
            ->where('current_status', 'received')
            ->update(['current_status' => 'under_review']);

        // Also fix status_logs table
        DB::table('status_logs')
            ->where('status', 'received')
            ->update(['status' => 'under_review']);

        // Now safely modify the enum
        DB::statement("ALTER TABLE applications MODIFY COLUMN current_status ENUM('submitted','under_review','approved','rejected') NOT NULL DEFAULT 'submitted'");
    }

    public function down(): void
    {
        // Restore 'received' to the enum
        DB::statement("ALTER TABLE applications MODIFY COLUMN current_status ENUM('submitted','received','under_review','approved','rejected') NOT NULL DEFAULT 'submitted'");
    }
};
