@props(['match', 'showLocal' => true])

@php
    $iso = $match->kickoffIso();
@endphp

<span {{ $attributes->merge(['class' => 'match-kickoff']) }} @if ($iso) data-kickoff="{{ $iso }}" @endif>
    <span class="match-kickoff__venue">{{ $match->formattedVenueKickoff() }}</span>
    @if ($showLocal && $iso)
        <span class="match-kickoff__local" aria-label="Your local time"></span>
    @endif
</span>
