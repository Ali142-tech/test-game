@props([
    'name',
    'matches' => null,
    'href' => '#',
    'flag' => null,
])

<a {{ $attributes->merge(['class' => 'team-pill', 'href' => $href]) }}>
    <span class="team-pill__flag">
        @if ($flag)
            <img src="{{ $flag }}" alt="" />
        @else
            {{ $slot }}
        @endif
    </span>
    <span class="team-pill__copy">
        <strong>{{ $name }}</strong>
        @if ($matches !== null)
            <span>{{ trans_choice('site.matches', (int) $matches) }}</span>
        @endif
    </span>
    <span class="team-pill__arrow" aria-hidden="true">›</span>
</a>
