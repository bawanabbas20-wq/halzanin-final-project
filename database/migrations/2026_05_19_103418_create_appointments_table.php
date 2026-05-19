<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop orphaned tables from a previous session (no active code references them)
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('status_logs');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('appointments');
        Schema::enableForeignKeyConstraints();

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->enum('time_slot', ['09:00', '10:00', '11:00', '12:00', '13:00']);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            // One slot per citizen per day (can't double-book same slot)
            $table->unique(['date', 'time_slot']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
