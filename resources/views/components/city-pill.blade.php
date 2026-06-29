@props(['city'])

<a href="#schedule" class="city-pill" {{ $attributes }}>
    <span>{{ $city }}</span>
    <span class="city-pill__arrow" aria-hidden="true">›</span>
</a>
