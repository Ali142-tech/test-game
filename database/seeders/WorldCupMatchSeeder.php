<?php

namespace Database\Seeders;

use App\Models\WorldCupMatch;
use Illuminate\Database\Seeder;

class WorldCupMatchSeeder extends Seeder
{
    public function run(): void
    {
        WorldCupMatch::query()->delete();

        $now = now();
        $matches = array_merge($this->roundOf32(), $this->roundOf16());

        WorldCupMatch::insert(array_map(fn (array $match) => $match + [
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ], $matches));
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function roundOf32(): array
    {
        $fixtures = [
            ['USA', 'Paraguay', '2026-06-28', '12:00pm', 'Los Angeles, CA', 'SoFi Stadium', 275],
            ['Mexico', 'Ecuador', '2026-06-28', '3:00pm', 'Mexico City, Mexico', 'Estadio Azteca', 300],
            ['Brazil', 'Colombia', '2026-06-28', '6:00pm', 'Houston, TX', 'NRG Stadium', 325],
            ['Argentina', 'Uruguay', '2026-06-29', '12:00pm', 'Miami, FL', 'Hard Rock Stadium', 350],
            ['France', 'Morocco', '2026-06-29', '3:00pm', 'Dallas, TX', 'AT&T Stadium', 375],
            ['England', 'Senegal', '2026-06-29', '6:00pm', 'Atlanta, GA', 'Mercedes-Benz Stadium', 400],
            ['Spain', 'Japan', '2026-06-30', '12:00pm', 'New York / New Jersey', 'MetLife Stadium', 425],
            ['Germany', 'Croatia', '2026-06-30', '3:00pm', 'Philadelphia, PA', 'Lincoln Financial Field', 450],
            ['Portugal', 'Switzerland', '2026-06-30', '6:00pm', 'Boston, MA', 'Gillette Stadium', 275],
            ['Netherlands', 'Austria', '2026-07-01', '12:00pm', 'Seattle, WA', 'Lumen Field', 300],
            ['Belgium', 'Tunisia', '2026-07-01', '3:00pm', 'San Francisco, CA', "Levi's Stadium", 325],
            ['Turkey', 'Czechia', '2026-07-01', '6:00pm', 'Kansas City, MO', 'GEHA Field at Arrowhead Stadium', 350],
            ['South Korea', 'Australia', '2026-07-02', '12:00pm', 'Toronto, ON', 'BMO Field', 375],
            ['Canada', 'Ghana', '2026-07-02', '3:00pm', 'Vancouver, BC', 'BC Place Stadium', 400],
            ['Egypt', 'Ivory Coast', '2026-07-02', '6:00pm', 'Monterrey, Mexico', 'Estadio BBVA Bancomer', 425],
            ['Saudi Arabia', 'Iran', '2026-07-03', '3:00pm', 'Guadalajara, Mexico', 'Estadio Akron', 450],
        ];

        return $this->mapFixtures('Round of 32', $fixtures, 1);
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function roundOf16(): array
    {
        $fixtures = [
            ['USA', 'Brazil', '2026-07-04', '12:00pm', 'Los Angeles, CA', 'SoFi Stadium', 400],
            ['Argentina', 'France', '2026-07-04', '6:00pm', 'Dallas, TX', 'AT&T Stadium', 425],
            ['England', 'Spain', '2026-07-05', '12:00pm', 'Miami, FL', 'Hard Rock Stadium', 450],
            ['Germany', 'Netherlands', '2026-07-05', '6:00pm', 'Atlanta, GA', 'Mercedes-Benz Stadium', 475],
            ['Portugal', 'Belgium', '2026-07-06', '12:00pm', 'New York / New Jersey', 'MetLife Stadium', 500],
            ['Mexico', 'Japan', '2026-07-06', '6:00pm', 'Houston, TX', 'NRG Stadium', 400],
            ['Croatia', 'South Korea', '2026-07-07', '12:00pm', 'Seattle, WA', 'Lumen Field', 450],
            ['Canada', 'Morocco', '2026-07-07', '6:00pm', 'Toronto, ON', 'BMO Field', 500],
        ];

        return $this->mapFixtures('Round of 16', $fixtures, 17);
    }

    /**
     * @param  list<array{0: string, 1: string, 2: string, 3: string, 4: string, 5: string, 6: int}>  $fixtures
     * @return list<array<string, mixed>>
     */
    private function mapFixtures(string $stage, array $fixtures, int $sortStart): array
    {
        return collect($fixtures)->map(function (array $row, int $index) use ($stage, $sortStart) {
            return [
                'stage' => $stage,
                'home_team' => $row[0],
                'away_team' => $row[1],
                'match_date' => $row[2],
                'match_time' => $row[3],
                'city' => $row[4],
                'venue' => $row[5],
                'price_from' => $row[6],
                'tickets_available' => 50,
                'sort_order' => $sortStart + $index,
            ];
        })->all();
    }
}
