<?php

namespace App\Support;

class TeamFlag
{
    public static function url(string $code): string
    {
        return 'https://flagcdn.com/w80/'.strtolower($code).'.png';
    }
}
