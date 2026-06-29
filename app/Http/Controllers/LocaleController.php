<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        $supported = config('locales.supported', ['en']);

        if (! in_array($locale, $supported, true)) {
            abort(404);
        }

        session(['locale' => $locale]);

        return redirect()->back();
    }
}
