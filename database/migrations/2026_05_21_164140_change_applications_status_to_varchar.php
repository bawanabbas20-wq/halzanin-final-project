<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE applications MODIFY COLUMN current_status VARCHAR(100) NOT NULL DEFAULT 'submitted'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE applications MODIFY COLUMN current_status ENUM('submitted','checked_in','under_review','approved','rejected') NOT NULL DEFAULT 'submitted'");
    }
};
