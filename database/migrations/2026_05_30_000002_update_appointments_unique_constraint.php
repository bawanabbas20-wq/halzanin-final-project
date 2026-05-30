<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the old global constraint — it prevented any two appointments
            // sharing the same date+time_slot regardless of ministry/service.
            // The new constraint allows each service to have its own independent slots.
            $table->dropUnique(['date', 'time_slot']);

            // One slot per service per day — different services can run the same
            // time slot in parallel (they're separate physical offices).
            $table->unique(['date', 'time_slot', 'service_id'], 'appointments_date_slot_service_unique');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropUnique('appointments_date_slot_service_unique');
            $table->unique(['date', 'time_slot']);
        });
    }
};
