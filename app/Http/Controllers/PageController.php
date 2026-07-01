<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    private const PAGES = ['about', 'help', 'privacy', 'terms', 'sell'];

    public function about(): View
    {
        return $this->show('about');
    }

    public function help(): View
    {
        return $this->show('help');
    }

    public function privacy(): View
    {
        return $this->show('privacy');
    }

    public function terms(): View
    {
        return $this->show('terms');
    }

    public function sell(): View
    {
        return $this->show('sell');
    }

    private function show(string $page): View
    {
        if (! in_array($page, self::PAGES, true)) {
            abort(404);
        }

        return view('pages.show', [
            'page' => $page,
            'title' => __("site.pages.{$page}.title"),
            'description' => __("site.pages.{$page}.description"),
        ]);
    }
}
