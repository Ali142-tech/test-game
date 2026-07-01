<?php

namespace App\Support;

class VenueTimezone
{
    /** @var array<string, string> */
    private const CITY_MAP = [
        'Los Angeles, CA' => 'America/Los_Angeles',
        'San Francisco, CA' => 'America/Los_Angeles',
        'Seattle, WA' => 'America/Los_Angeles',
        'Vancouver, BC' => 'America/Vancouver',
        'Houston, TX' => 'America/Chicago',
        'Dallas, TX' => 'America/Chicago',
        'Kansas City, MO' => 'America/Chicago',
        'Atlanta, GA' => 'America/New_York',
        'Miami, FL' => 'America/New_York',
        'Boston, MA' => 'America/New_York',
        'New York / New Jersey' => 'America/New_York',
        'Philadelphia, PA' => 'America/New_York',
        'Toronto, ON' => 'America/Toronto',
        'Mexico City, Mexico' => 'America/Mexico_City',
        'Monterrey, Mexico' => 'America/Monterrey',
        'Guadalajara, Mexico' => 'America/Mexico_City',
    ];

    public static function forCity(string $city): string
    {
        return self::CITY_MAP[$city] ?? 'America/New_York';
    }
}
