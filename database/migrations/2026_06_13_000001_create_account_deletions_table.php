<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Audit trail for administrative account deletions.
     * Each deletion is permanently recorded — who removed which account,
     * when, and the official reason — even after the user row is gone.
     */
    public function up(): void
    {
        Schema::create('account_deletions', function (Blueprint $table) {
            $table->id();

            // Snapshot of the deleted account (kept after the user row is removed).
            $table->unsignedBigInteger('deleted_user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('role')->nullable();
            $table->string('gov_id')->nullable();

            // Official reason for the deletion (required at the controller layer).
            $table->text('reason');

            // Who performed the deletion.
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('deleted_by_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_deletions');
    }
};
