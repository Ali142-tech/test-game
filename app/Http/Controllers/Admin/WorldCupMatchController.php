<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorldCupMatch;
use App\Support\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorldCupMatchController extends Controller
{
    public function index(): View
    {
        $matches = WorldCupMatch::query()
            ->withSum(['ticketOrders as tickets_sold' => fn ($q) => $q->where('status', 'paid')], 'quantity')
            ->ordered()
            ->get();

        return view('admin.matches.index', compact('matches'));
    }

    public function create(): View
    {
        return view('admin.matches.form', [
            'match' => new WorldCupMatch,
            ...$this->formOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        WorldCupMatch::create($this->validated($request));

        return redirect()
            ->route('admin.matches.index')
            ->with(Notify::success('The match is now live on the public schedule.', 'Match added'));
    }

    public function edit(WorldCupMatch $worldCupMatch): View
    {
        return view('admin.matches.form', [
            'match' => $worldCupMatch,
            ...$this->formOptions(),
        ]);
    }

    public function update(Request $request, WorldCupMatch $worldCupMatch): RedirectResponse
    {
        $worldCupMatch->update($this->validated($request));

        return redirect()
            ->route('admin.matches.index')
            ->with(Notify::success('Match details and pricing have been saved.', 'Match updated'));
    }

    public function destroy(WorldCupMatch $worldCupMatch): RedirectResponse
    {
        $worldCupMatch->delete();

        return redirect()
            ->route('admin.matches.index')
            ->with(Notify::info('The match has been removed from the schedule.', 'Match deleted'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'stage' => ['required', 'string', 'max:120'],
            'home_team' => ['required', 'string', 'max:120', 'different:away_team'],
            'away_team' => ['required', 'string', 'max:120', 'different:home_team'],
            'match_date' => ['required', 'date'],
            'match_time' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:160'],
            'venue' => ['required', 'string', 'max:160'],
            'price_from' => ['nullable', 'integer', 'min:0'],
            'tickets_available' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $request->input('sort_order', 0),
        ];
    }

    private function formOptions(): array
    {
        $teams = collect(require resource_path('data/teams.php'))
            ->pluck('name')
            ->sort()
            ->values();

        return [
            'teams' => $teams,
            'stages' => collect(require resource_path('data/match-stages.php')),
            'venues' => collect(require resource_path('data/stadiums.php')),
        ];
    }
}
