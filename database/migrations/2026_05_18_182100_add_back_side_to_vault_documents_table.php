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
        Schema::table('vault_documents', function (Blueprint $table) {
            $table->string('back_image_path')->nullable()->after('encrypted_pdf_path');
            $table->string('back_pdf_path')->nullable()->after('back_image_path');
        });
    }

    public function down(): void
    {
        Schema::table('vault_documents', function (Blueprint $table) {
            $table->dropColumn(['back_image_path', 'back_pdf_path']);
        });
    }
};
