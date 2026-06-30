<?php

namespace App\Support;

class TeamFlag
{
    public static function url(string $code, int $width = 80): string
    {
        return 'https://flagcdn.com/w'.$width.'/'.strtolower($code).'.png';
    }
}
