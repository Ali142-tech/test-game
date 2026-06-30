<?php

namespace App\Support;

class Notify
{
    public static function flash(string $type, string $message, ?string $title = null): array
    {
        return [
            'toast' => [
                'type' => $type,
                'title' => $title ?? match ($type) {
                    'success' => 'Success',
                    'error' => 'Something went wrong',
                    'warning' => 'Heads up',
                    'info' => 'Notice',
                    default => 'Notification',
                },
                'message' => $message,
            ],
        ];
    }

    public static function success(string $message, ?string $title = null): array
    {
        return self::flash('success', $message, $title);
    }

    public static function error(string $message, ?string $title = null): array
    {
        return self::flash('error', $message, $title);
    }

    public static function warning(string $message, ?string $title = null): array
    {
        return self::flash('warning', $message, $title);
    }

    public static function info(string $message, ?string $title = null): array
    {
        return self::flash('info', $message, $title);
    }
}
