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
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('citizen_id');
            $table->string('national_id_number')->nullable()->after('full_name');
            $table->string('document_type')->nullable()->after('national_id_number');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'national_id_number', 'document_type']);
        });
    }
};
