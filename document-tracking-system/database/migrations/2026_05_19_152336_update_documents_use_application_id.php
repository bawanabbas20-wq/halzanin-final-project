<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Recreate applications table (dropped by 2026_05_19_103418_create_appointments_table)
        if (!Schema::hasTable('applications')) {
            Schema::create('applications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
                $table->string('tracking_code')->unique();
                $table->enum('current_status', ['submitted', 'under_review', 'approved', 'rejected'])->default('submitted');
                $table->timestamp('submitted_at')->nullable();
                $table->timestamps();
            });
        }

        // Recreate status_logs table (also dropped by same migration)
        if (!Schema::hasTable('status_logs')) {
            Schema::create('status_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')->constrained()->cascadeOnDelete();
                $table->string('status');
                $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Swap appointment_id → application_id on documents (idempotent)
        if (Schema::hasColumn('documents', 'appointment_id') && !Schema::hasColumn('documents', 'application_id')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->dropForeign(['appointment_id']);
                $table->dropColumn('appointment_id');
                $table->foreignId('application_id')->after('id')->constrained()->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['application_id']);
            $table->dropColumn('application_id');
            $table->foreignId('appointment_id')->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::dropIfExists('status_logs');
        Schema::dropIfExists('applications');
    }
};
