@extends('layouts.admin')

@section('title', $match->exists ? 'Edit match' : 'Add match')

@php
    $selectedStage = old('stage', $match->stage);
    $selectedHome = old('home_team', $match->home_team);
    $selectedAway = old('away_team', $match->away_team);
    $selectedCity = old('city', $match->city);
    $selectedVenue = old('venue', $match->venue);

    $teamOptions = $teams->values();
    if ($selectedHome && ! $teamOptions->contains($selectedHome)) {
        $teamOptions = $teamOptions->prepend($selectedHome);
    }
    if ($selectedAway && ! $teamOptions->contains($selectedAway)) {
        $teamOptions = $teamOptions->prepend($selectedAway);
    }

    $stageOptions = $stages->values();
    if ($selectedStage && ! $stageOptions->contains($selectedStage)) {
        $stageOptions = $stageOptions->prepend($selectedStage);
    }

    $locationValue = collect($venues)->search(fn ($v) => $v['city'] === $selectedCity && $v['venue'] === $selectedVenue);
@endphp

@section('content')
<div class="admin-topbar">
    <div>
        <h1>{{ $match->exists ? 'Edit match' : 'Add match' }}</h1>
        <p>Pick stage, teams, and host venue from the dropdown lists.</p>
    </div>
</div>

<div class="form-card">
    <form method="post" action="{{ $match->exists ? route('admin.matches.update', $match) : route('admin.matches.store') }}" id="match-form">
        @csrf
        @if ($match->exists)
            @method('PUT')
        @endif

        <div class="field">
            <label for="stage">Stage</label>
            <select id="stage" name="stage" required>
                <option value="">Select stage</option>
                @foreach ($stageOptions as $stage)
                    <option value="{{ $stage }}" @selected($selectedStage === $stage)>{{ $stage }}</option>
                @endforeach
            </select>
            @error('stage')<div style="color:#dc2626;font-size:13px;">{{ $message }}</div>@enderror
        </div>

        <div class="grid">
            <div class="field">
                <label for="home_team">Home team</label>
                <select id="home_team" name="home_team" required>
                    <option value="">Select home team</option>
                    @foreach ($teamOptions->unique() as $team)
                        <option value="{{ $team }}" @selected($selectedHome === $team)>{{ $team }}</option>
                    @endforeach
                </select>
                @error('home_team')<div style="color:#dc2626;font-size:13px;">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="away_team">Away team</label>
                <select id="away_team" name="away_team" required>
                    <option value="">Select away team</option>
                    @foreach ($teamOptions->unique() as $team)
                        <option value="{{ $team }}" @selected($selectedAway === $team)>{{ $team }}</option>
                    @endforeach
                </select>
                @error('away_team')<div style="color:#dc2626;font-size:13px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="grid">
            <div class="field">
                <label for="match_date">Date</label>
                <input id="match_date" type="date" name="match_date" value="{{ old('match_date', optional($match->match_date)->format('Y-m-d')) }}" required />
            </div>
            <div class="field">
                <label for="match_time">Time (stadium local)</label>
                <input id="match_time" type="time" name="match_time" value="{{ $matchTimeInput }}" required />
                <span class="muted" style="font-size:12px;display:block;margin-top:6px;">Kickoff time in the host city’s timezone (auto-detected from city).</span>
                @error('match_time')<div style="color:#dc2626;font-size:13px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field">
            <label for="location">Location</label>
            <select id="location" required>
                <option value="">Select city and stadium</option>
                @foreach ($venues as $index => $venue)
                    <option
                        value="{{ $index }}"
                        data-city="{{ $venue['city'] }}"
                        data-venue="{{ $venue['venue'] }}"
                        @selected($locationValue === $index)
                    >
                        {{ $venue['city'] }} — {{ $venue['venue'] }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="city" id="city" value="{{ $selectedCity }}" />
            <input type="hidden" name="venue" id="venue" value="{{ $selectedVenue }}" />
            @error('city')<div style="color:#dc2626;font-size:13px;">{{ $message }}</div>@enderror
            @error('venue')<div style="color:#dc2626;font-size:13px;">{{ $message }}</div>@enderror
        </div>

        <div class="grid">
            <div class="field">
                <label for="price_from">Ticket price from (USD)</label>
                <input id="price_from" type="number" name="price_from" value="{{ old('price_from', $match->price_from) }}" min="0" placeholder="741" />
            </div>
            <div class="field">
                <label for="tickets_available">Tickets available</label>
                <input id="tickets_available" type="number" name="tickets_available" value="{{ old('tickets_available', $match->tickets_available) }}" min="0" placeholder="500" />
                <span class="muted" style="font-size:12px;display:block;margin-top:6px;">How many tickets can be sold for this match.</span>
            </div>
        </div>

        <div class="grid">
            <div class="field">
                <label for="sort_order">Sort order</label>
                <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $match->sort_order ?? 0) }}" min="0" />
            </div>
            <div class="field check" style="align-self:end;padding-bottom:10px;">
                <input id="is_published" type="checkbox" name="is_published" value="1" @checked(old('is_published', $match->is_published ?? true)) />
                <label for="is_published" style="margin:0;">Published on public page</label>
            </div>
        </div>

        @if ($match->exists)
            <div class="flash" style="margin-top:8px;">
                Sold so far: <strong>{{ $match->ticketsSold() }}</strong>
                @if ($match->tickets_available !== null)
                    · Remaining: <strong>{{ $match->ticketsRemaining() }}</strong>
                @endif
            </div>
        @endif

        <div class="actions">
            <button type="submit" class="btn" data-loading-text="{{ $match->exists ? 'Saving changes...' : 'Creating match...' }}">{{ $match->exists ? 'Save changes' : 'Create match' }}</button>
            <a href="{{ route('admin.matches.index') }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
</div>

<script>
(() => {
    const locationSelect = document.getElementById('location');
    const cityInput = document.getElementById('city');
    const venueInput = document.getElementById('venue');
    const form = document.getElementById('match-form');

    const syncLocation = () => {
        const option = locationSelect.options[locationSelect.selectedIndex];
        if (!option || !option.dataset.city) {
            cityInput.value = '';
            venueInput.value = '';
            return;
        }
        cityInput.value = option.dataset.city;
        venueInput.value = option.dataset.venue;
    };

    locationSelect?.addEventListener('change', syncLocation);

    form?.addEventListener('submit', (event) => {
        syncLocation();
        if (!cityInput.value || !venueInput.value) {
            event.preventDefault();
            alert('Please select a location.');
            locationSelect.focus();
        }
    });

    if (locationSelect && !locationSelect.value && cityInput.value && venueInput.value) {
        for (const option of locationSelect.options) {
            if (option.dataset.city === cityInput.value && option.dataset.venue === venueInput.value) {
                locationSelect.value = option.value;
                break;
            }
        }
    }
})();
</script>
@endsection
