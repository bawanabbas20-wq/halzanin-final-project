<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE applications MODIFY COLUMN current_status ENUM('submitted','checked_in','under_review','approved','rejected') NOT NULL DEFAULT 'submitted'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE applications MODIFY COLUMN current_status ENUM('submitted','under_review','approved','rejected') NOT NULL DEFAULT 'submitted'");
    }
};
