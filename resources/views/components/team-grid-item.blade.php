@props([
    'name',
    'flag',
    'href' => '#',
])

<a {{ $attributes->merge(['class' => 'team-grid-item', 'href' => $href]) }}>
    <span class="team-grid-item__flag">
        <img src="{{ $flag }}" alt="" loading="lazy" decoding="async" />
    </span>
    <span class="team-grid-item__name">{{ $name }}</span>
</a>
