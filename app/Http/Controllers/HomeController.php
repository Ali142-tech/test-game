<?php

namespace App\Http\Controllers;

use App\Models\WorldCupMatch;
use App\Support\TeamFlag;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $rawTeams = require resource_path('data/teams.php');
        $teams = $this->teamsWithFlags($rawTeams)->sortBy('name')->values();
        $popularTeams = $this->teamsWithFlags($rawTeams)
            ->whereIn('name', ['Portugal', 'Brazil', 'USA']);
        $stages = $this->localizedStages(require resource_path('data/stages.php'));
        $cities = require resource_path('data/cities.php');
        $stadiums = require resource_path('data/stadiums.php');
        $faqs = __('site.faqs');
        $winners = require resource_path('data/world-cup-winners.php');

        $matches = WorldCupMatch::published()->ordered()->get();

        return view('welcome', compact(
            'teams',
            'popularTeams',
            'stages',
            'cities',
            'stadiums',
            'faqs',
            'winners',
            'matches',
        ));
    }

    private function teamsWithFlags(array $teams)
    {
        return collect($teams)->map(function (array $team) {
            $code = $team['code'] ?? null;

            return array_merge($team, [
                'flag' => $code ? TeamFlag::url($code) : ($team['flag'] ?? ''),
            ]);
        });
    }

    private function localizedStages(array $stages): array
    {
        return collect($stages)->map(function (array $stage) {
            $slug = $stage['slug'];
            $key = "site.stages.{$slug}";

            return array_merge($stage, [
                'label' => __($key.'.label'),
                'short' => __($key.'.short'),
                'banner' => __($key.'.banner'),
            ]);
        })->all();
    }
}
