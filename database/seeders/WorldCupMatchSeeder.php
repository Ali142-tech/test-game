<?php

namespace Database\Seeders;

use App\Models\WorldCupMatch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WorldCupMatchSeeder extends Seeder
{
    public function run(): void
    {
        WorldCupMatch::query()->delete();

        $schedule = require resource_path('data/world-cup-2026-knockout.php');
        $now = now();
        $today = $now->copy()->startOfDay();

        $rows = collect();

        foreach ($schedule['round_of_32'] as $index => $fixture) {
            $rows->push($this->mapFixture('Round of 32', $fixture, $index + 1));
        }

        foreach ($schedule['round_of_16'] as $index => $fixture) {
            $rows->push($this->mapFixture('Round of 16', $fixture, 17 + $index));
        }

        // Only seed matches from tomorrow onward (real schedule, upcoming fixtures).
        $upcoming = $rows->filter(
            fn (array $match) => Carbon::parse($match['match_date'])->greaterThan($today)
        )->values();

        if ($upcoming->isEmpty()) {
            $upcoming = $rows;
        }

        WorldCupMatch::insert($upcoming->map(fn (array $match) => $match + [
            'tickets_available' => 50,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all());
    }

    /**
     * @param  array{0: string, 1: string, 2: string, 3: string, 4: string, 5: string, 6: int}  $fixture
     * @return array<string, mixed>
     */
    private function mapFixture(string $stage, array $fixture, int $sortOrder): array
    {
        return [
            'stage' => $stage,
            'home_team' => $fixture[0],
            'away_team' => $fixture[1],
            'match_date' => $fixture[2],
            'match_time' => $fixture[3],
            'city' => $fixture[4],
            'venue' => $fixture[5],
            'price_from' => $fixture[6],
            'sort_order' => $sortOrder,
        ];
    }
}
