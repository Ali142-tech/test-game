<?php

use App\Models\WorldCupMatch;
use App\Support\MatchKickoff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('world_cup_matches', function (Blueprint $table) {
            $table->timestamp('starts_at')->nullable()->after('match_time');
            $table->string('timezone', 64)->nullable()->after('starts_at');
        });

        WorldCupMatch::query()->each(function (WorldCupMatch $match) {
            if (! $match->match_date || ! $match->match_time || ! $match->city) {
                return;
            }

            $kickoff = MatchKickoff::buildUtc(
                $match->match_date->format('Y-m-d'),
                $match->match_time,
                $match->city,
            );

            $match->update([
                'starts_at' => $kickoff['starts_at'],
                'timezone' => $kickoff['timezone'],
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('world_cup_matches', function (Blueprint $table) {
            $table->dropColumn(['starts_at', 'timezone']);
        });
    }
};
