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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ministry_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('name_ku');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('description_ku')->nullable();
            $table->boolean('is_active')->default(false);
            $table->json('required_documents')->nullable();
            $table->json('form_schema')->nullable();
            $table->json('statuses')->nullable();
            $table->unsignedTinyInteger('estimated_days')->default(14);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
