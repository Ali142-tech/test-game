@props(['label', 'count', 'slug' => ''])

<button type="button" class="stage-pill" data-stage="{{ $label }}" {{ $attributes }}>
    <span class="stage-pill__label">{{ $label }}</span>
    <span class="stage-pill__count">{{ $count }} matches</span>
</button>
