<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add nullable first so existing rows don't violate NOT NULL
        Schema::table('users', function (Blueprint $table) {
            $table->string('gov_id', 20)->nullable()->unique()->after('id');
        });

        // Backfill every existing user with a unique gov_id
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $len   = strlen($chars);

        DB::table('users')->whereNull('gov_id')->orderBy('id')->each(function ($user) use ($chars, $len) {
            do {
                $part1 = $part2 = '';
                for ($i = 0; $i < 8; $i++) $part1 .= $chars[random_int(0, $len - 1)];
                for ($i = 0; $i < 4; $i++) $part2 .= $chars[random_int(0, $len - 1)];
                $govId = 'KRG-' . $part1 . '-' . $part2;
            } while (DB::table('users')->where('gov_id', $govId)->exists());

            DB::table('users')->where('id', $user->id)->update(['gov_id' => $govId]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['gov_id']);
            $table->dropColumn('gov_id');
        });
    }
};
