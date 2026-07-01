<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class MatchKickoff
{
    /**
     * @return array{starts_at: CarbonInterface, timezone: string}
     */
    public static function buildUtc(string $date, string $time, string $city): array
    {
        $timezone = VenueTimezone::forCity($city);
        $local = Carbon::parse($date.' '.self::normalizeTime($time), $timezone);

        return [
            'starts_at' => $local->copy()->utc(),
            'timezone' => $timezone,
        ];
    }

    public static function normalizeTime(string $time): string
    {
        if (preg_match('/^\d{2}:\d{2}$/', $time)) {
            return $time.':00';
        }

        $normalized = strtolower(str_replace(' ', '', $time));

        return Carbon::createFromFormat('g:ia', $normalized)->format('H:i:s');
    }
}
