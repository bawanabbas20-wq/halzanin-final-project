<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE applications MODIFY COLUMN current_status ENUM('submitted','under_review','approved','rejected','checked_in') NOT NULL DEFAULT 'submitted'");
    }

    public function down(): void
    {
        DB::table('applications')->where('current_status', 'checked_in')->update(['current_status' => 'submitted']);
        DB::statement("ALTER TABLE applications MODIFY COLUMN current_status ENUM('submitted','under_review','approved','rejected') NOT NULL DEFAULT 'submitted'");
    }
};
