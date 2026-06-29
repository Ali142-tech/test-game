<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('locales.default', config('app.locale')));
        $supported = config('locales.supported', ['en']);

        if (in_array($locale, $supported, true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
