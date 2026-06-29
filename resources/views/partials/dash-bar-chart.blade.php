@php
    $chartValues = $values ?? [];
    $chartLabels = $labels ?? [];
    $chartMax = max($chartValues ?: [0]);
    $chartMax = $chartMax > 0 ? $chartMax : 1;
    $barCount = max(count($chartValues), 1);
    $slotWidth = 240 / $barCount;
    $barWidth = min(28, max(12, $slotWidth - 10));
    $gradientId = $gradientId ?? 'dashBarGrad';
    $barColor = $barColor ?? '#3b82f6';
    $barColorEnd = $barColorEnd ?? '#60a5fa';
@endphp
<div class="dash-chart-wrap">
    <svg class="dash-chart dash-chart--bars" viewBox="0 0 280 120" preserveAspectRatio="xMidYMid meet" role="img" aria-label="{{ $ariaLabel ?? 'Chart' }}">
        <defs>
            <linearGradient id="{{ $gradientId }}" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="{{ $barColorEnd }}"></stop>
                <stop offset="100%" stop-color="{{ $barColor }}"></stop>
            </linearGradient>
        </defs>
        <line class="dash-chart__axis" x1="16" y1="94" x2="264" y2="94"></line>
        @foreach ($chartValues as $index => $value)
            @php
                $numeric = (float) $value;
                $slotX = 20 + ($index * $slotWidth);
                $x = $slotX + (($slotWidth - $barWidth) / 2);
                $height = $numeric > 0 ? max(($numeric / $chartMax) * 76, 12) : 6;
                $y = 94 - $height;
            @endphp
            <rect class="dash-chart__bar" x="{{ round($x, 1) }}" y="{{ round($y, 1) }}" width="{{ round($barWidth, 1) }}" height="{{ round($height, 1) }}" rx="6" fill="url(#{{ $gradientId }})">
                <title>{{ ($chartLabels[$index] ?? 'Month') }}: {{ number_format($numeric, 0) }}</title>
            </rect>
        @endforeach
        @if (array_sum($chartValues) <= 0)
            <text class="dash-chart__empty" x="140" y="58" text-anchor="middle">No data yet</text>
        @endif
    </svg>
    @if (! empty($chartLabels))
        <div class="dash-labels">
            @foreach ($chartLabels as $label)
                <span>{{ $label }}</span>
            @endforeach
        </div>
    @endif
</div>
