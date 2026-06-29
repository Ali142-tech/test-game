<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('world_cup_matches', function (Blueprint $table) {
            $table->id();
            $table->string('stage');
            $table->string('home_team');
            $table->string('away_team');
            $table->date('match_date');
            $table->string('match_time', 20);
            $table->string('city');
            $table->string('venue');
            $table->unsignedInteger('price_from')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('world_cup_matches');
    }
};
