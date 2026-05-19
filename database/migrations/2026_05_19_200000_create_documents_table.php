<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->string('document_name');
            $table->enum('source', ['vault', 'upload', 'confirmed']);
            $table->foreignId('vault_document_id')->nullable()->constrained('vault_documents')->nullOnDelete();
            $table->string('file_path')->nullable();
            $table->string('original_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
