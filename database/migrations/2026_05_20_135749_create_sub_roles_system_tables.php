<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sub_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('sub_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_role_id')->constrained()->cascadeOnDelete();
            $table->enum('permission', [
                'view_queue',
                'confirm_appointments',
                'scan_qr_checkin',
                'update_application_status',
                'view_documents',
                'verify_documents',
                'view_analytics',
                'manage_off_days',
            ]);
            $table->timestamps();
            $table->unique(['sub_role_id', 'permission']);
        });

        Schema::create('user_sub_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'sub_role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sub_roles');
        Schema::dropIfExists('sub_role_permissions');
        Schema::dropIfExists('sub_roles');
    }
};
