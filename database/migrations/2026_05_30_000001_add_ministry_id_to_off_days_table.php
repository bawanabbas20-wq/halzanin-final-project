<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('off_days', function (Blueprint $table) {
            // null = global closure (affects all ministries); set to close one ministry only
            $table->foreignId('ministry_id')->nullable()->after('reason')
                ->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('off_days', function (Blueprint $table) {
            $table->dropForeign(['ministry_id']);
            $table->dropColumn('ministry_id');
        });
    }
};
