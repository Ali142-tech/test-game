<?php

namespace Database\Seeders;

use App\Models\WorldCupMatch;
use Illuminate\Database\Seeder;

class WorldCupMatchSeeder extends Seeder
{
    public function run(): void
    {
        if (WorldCupMatch::count() > 0) {
            return;
        }

        WorldCupMatch::insert([
            [
                'stage' => 'Round of 32',
                'home_team' => 'Brazil',
                'away_team' => 'Japan',
                'match_date' => '2026-06-29',
                'match_time' => '12:00pm',
                'city' => 'Houston, TX',
                'venue' => 'NRG Stadium',
                    'price_from' => 741,
                    'tickets_available' => 500,
                    'is_published' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stage' => 'Group D',
                'home_team' => 'USA',
                'away_team' => 'Paraguay',
                'match_date' => '2026-06-12',
                'match_time' => '6:00pm',
                'city' => 'Los Angeles, CA',
                'venue' => 'SoFi Stadium',
                    'price_from' => 1477,
                    'tickets_available' => 800,
                    'is_published' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
