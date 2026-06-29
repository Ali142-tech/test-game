<?php

namespace Database\Seeders;

use App\Models\WorldCupMatch;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DemoUserSeeder::class,
            WorldCupMatchSeeder::class,
        ]);
    }
}
