@extends('layouts.app')

@section('title', __('site.meta.title'))
@section('description', __('site.meta.description'))

@php
    $teamFlags = $teams->pluck('flag', 'name')->all();
@endphp

@section('content')
<div class="site-dark">
    <x-site-header />

    <div class="shell">
        <section class="wc-hero">
            <div>
                <h1>{{ __('site.hero.title') }}</h1>
                <p class="wc-hero__subtitle">{{ __('site.hero.subtitle') }}</p>
                <span class="wc-hero__badge">🛡 {{ __('site.hero.badge') }}</span>
            </div>
            <div class="wc-hero__art" aria-hidden="true">
                <div class="wc-hero__art-text">{!! nl2br(e(__('site.hero.art'))) !!}</div>
            </div>
        </section>

        <section class="section--dark" id="popular-teams">
            <div class="section-head">
                <h2>{{ __('site.popular_teams') }}</h2>
                <a class="view-all" href="#all-teams">{{ __('site.view_all') }}</a>
            </div>
            <div class="popular-row">
                @foreach ($popularTeams as $team)
                    <x-team-pill
                        :name="$team['name']"
                        :matches="$team['matches']"
                        :flag="$team['flag']"
                        href="#all-teams"
                    />
                @endforeach
            </div>
        </section>
    </div>
</div>

<div class="site-light">
    <div class="shell">
        <section class="section stages-section" id="stages">
            <div class="section-head section-head--light">
                <h2>{{ __('site.stages_title') }}</h2>
                <div class="stages-nav" aria-label="{{ __('site.stages_title') }}">
                    <button type="button" class="stages-nav__btn" id="stages-prev" aria-label="{{ __('site.stages_prev') }}">‹</button>
                    <button type="button" class="stages-nav__btn" id="stages-next" aria-label="{{ __('site.stages_next') }}">›</button>
                </div>
            </div>
            <div class="stages-row" id="stages-track">
                @foreach ($stages as $stage)
                    <x-stage-card
                        :label="$stage['label']"
                        :short="$stage['short']"
                        :count="$stage['matches']"
                        :banner="$stage['banner']"
                        :gradient="$stage['gradient']"
                    />
                @endforeach
            </div>
        </section>

        <section class="section schedule-section" id="schedule">
            <h2 class="section-title">{{ __('site.schedule_title') }}</h2>

        <div class="schedule-filters">
            <select class="filter-select" id="filter-city" aria-label="{{ __('site.filter_location') }}">
                <option value="">{{ __('site.filter_location') }}</option>
                @foreach ($cities as $city)
                    <option value="{{ $city }}">{{ $city }}</option>
                @endforeach
            </select>
            <select class="filter-select" id="filter-stage" aria-label="{{ __('site.filter_stage') }}">
                <option value="">{{ __('site.filter_stage') }}</option>
                @foreach ($stages as $stage)
                    <option value="{{ $stage['label'] }}">{{ $stage['label'] }}</option>
                @endforeach
                @foreach ($matches->pluck('stage')->unique() as $stage)
                    <option value="{{ $stage }}">{{ $stage }}</option>
                @endforeach
            </select>
            <select class="filter-select" id="filter-team" aria-label="{{ __('site.filter_team') }}">
                <option value="">{{ __('site.filter_team') }}</option>
                @foreach ($teams as $team)
                    <option value="{{ $team['name'] }}">{{ $team['name'] }}</option>
                @endforeach
            </select>
        </div>

        @if ($matches->isEmpty())
            <div class="matches-empty">
                <p>{{ __('site.no_matches') }}</p>
                <p style="margin-top:8px;"><a href="{{ route('admin.matches.create') }}">{{ __('site.no_matches_admin') }}</a> {{ __('site.no_matches_admin_suffix') }}</p>
            </div>
        @else
            <div class="match-list" id="match-list">
                @foreach ($matches as $match)
                    <x-match-row :match="$match" :team-flags="$teamFlags" />
                @endforeach
            </div>
            <div class="show-more-wrap">
                <button type="button" class="show-more" id="show-more-matches" hidden>{{ __('site.show_more') }}</button>
            </div>
        @endif
        </section>
    </div>
</div>

<section class="section" id="host-cities">
    <div class="shell">
        <h2 class="section-title">{{ __('site.host_cities') }}</h2>
        <div class="cities-row">
            @foreach ($cities as $city)
                <x-city-pill :city="$city" />
            @endforeach
        </div>
    </div>
</section>

<div class="shell">
    <x-trust-banner />
</div>

<section class="section" id="all-teams">
    <div class="shell">
        <h2 class="section-title">{{ __('site.teams_title') }}</h2>
        <div class="teams-grid">
            @foreach ($teams as $team)
                <x-team-grid-item :name="$team['name']" :flag="$team['flag']" href="#schedule" />
            @endforeach
        </div>
    </div>
</section>

<div class="shell">
    <x-trust-banner />
</div>

<section class="section">
    <div class="shell content-block">
        <h2>{{ __('site.content.intro_title') }}</h2>
        <p>{{ __('site.content.intro_p1') }}</p>
        <p>{{ __('site.content.intro_p2') }}</p>

        <h3>{{ __('site.content.winners_title') }}</h3>
        <table class="data-table">
            <thead>
                <tr><th>{{ __('site.content.year') }}</th><th>{{ __('site.content.winner') }}</th></tr>
            </thead>
            <tbody>
                @foreach ($winners as $row)
                    <tr>
                        <td>{{ $row['year'] }}</td>
                        <td>{{ $row['winner'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="faq-list">
            @foreach ($faqs as $index => $faq)
                <x-faq-item :question="$faq['question']" :answer="$faq['answer']" :open="$index === 0" />
            @endforeach
        </div>

        <h3 style="margin-top:36px;">{{ __('site.content.seating_title') }}</h3>
        <table class="data-table">
            <thead>
                <tr><th>{{ __('site.content.host_city') }}</th><th>{{ __('site.content.venue') }}</th></tr>
            </thead>
            <tbody>
                @foreach ($stadiums as $stadium)
                    <tr>
                        <td>{{ $stadium['city'] }}</td>
                        <td>{{ $stadium['venue'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<x-site-footer />
@endsection

@push('scripts')
<script>
(() => {
    const rows = [...document.querySelectorAll('.match-card')];
    const cityFilter = document.getElementById('filter-city');
    const stageFilter = document.getElementById('filter-stage');
    const teamFilter = document.getElementById('filter-team');
    const showMoreBtn = document.getElementById('show-more-matches');
    const limit = 12;
    let visibleLimit = limit;

    function applyFilters() {
        const city = cityFilter?.value || '';
        const stage = stageFilter?.value || '';
        const team = teamFilter?.value || '';
        let shown = 0;

        rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            const matchCity = row.dataset.city || '';
            const matchStage = row.dataset.stage || '';
            const passesCity = !city || matchCity.includes(city);
            const passesStage = !stage || matchStage === stage || matchStage.includes(stage);
            const passesTeam = !team || text.includes(team.toLowerCase());
            const passes = passesCity && passesStage && passesTeam;

            if (!passes) {
                row.style.display = 'none';
                return;
            }

            shown++;
            row.style.display = shown <= visibleLimit ? '' : 'none';
        });

        if (showMoreBtn) {
            const hidden = rows.filter((row) => {
                const city = cityFilter?.value || '';
                const stage = stageFilter?.value || '';
                const team = teamFilter?.value || '';
                const text = row.textContent.toLowerCase();
                const passesCity = !city || (row.dataset.city || '').includes(city);
                const passesStage = !stage || (row.dataset.stage || '').includes(stage);
                const passesTeam = !team || text.includes(team.toLowerCase());
                return passesCity && passesStage && passesTeam;
            }).length;
            showMoreBtn.hidden = hidden <= visibleLimit;
        }
    }

    [cityFilter, stageFilter, teamFilter].forEach((el) => el?.addEventListener('change', () => {
        visibleLimit = limit;
        applyFilters();
    }));

    showMoreBtn?.addEventListener('click', () => {
        visibleLimit += limit;
        applyFilters();
    });

    document.querySelectorAll('.stage-card').forEach((card) => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.stage-card').forEach((c) => c.classList.remove('is-active'));
            card.classList.add('is-active');
            if (stageFilter) {
                stageFilter.value = card.dataset.stage || '';
                visibleLimit = limit;
                applyFilters();
                document.getElementById('schedule')?.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    const stagesTrack = document.getElementById('stages-track');
    const scrollStep = document.documentElement.dir === 'rtl' ? 240 : -240;
    const scrollForward = document.documentElement.dir === 'rtl' ? -240 : 240;
    document.getElementById('stages-prev')?.addEventListener('click', () => {
        stagesTrack?.scrollBy({ left: scrollStep, behavior: 'smooth' });
    });
    document.getElementById('stages-next')?.addEventListener('click', () => {
        stagesTrack?.scrollBy({ left: scrollForward, behavior: 'smooth' });
    });

    if (rows.length) applyFilters();
})();
</script>
@endpush
