@props([
    'label',
    'short',
    'count',
    'banner',
    'gradient',
])

<button type="button" class="stage-card" data-stage="{{ $label }}" {{ $attributes }}>
    <div class="stage-card__art" style="background: {{ $gradient }}">
        <span class="stage-card__heart" aria-hidden="true">♥</span>
        <span class="stage-card__banner">{{ $banner }}</span>
    </div>
    <span class="stage-card__title">{{ $short }}</span>
    <span class="stage-card__count">{{ trans_choice('site.matches', (int) $count) }}</span>
</button>
