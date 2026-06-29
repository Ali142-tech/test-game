@php
    $paidPct = (int) ($paidPct ?? 0);
    $pendingPct = (int) ($pendingPct ?? 0);
    $paidCount = (int) ($paidCount ?? 0);
    $pendingCount = (int) ($pendingCount ?? 0);
    $circ = 2 * M_PI * 40;
    $paidLen = $circ * ($paidPct / 100);
    $pendLen = $circ * ($pendingPct / 100);
@endphp
<div class="dash-donut-box">
    <svg class="dash-donut" viewBox="0 0 100 100" aria-hidden="true">
        <circle class="track" cx="50" cy="50" r="40"></circle>
        <g transform="rotate(-90 50 50)">
            @if ($paidCount > 0)
                <circle class="paid" cx="50" cy="50" r="40" stroke-dasharray="{{ $paidLen }} {{ $circ }}"></circle>
            @endif
            @if ($pendingCount > 0)
                <circle class="pending" cx="50" cy="50" r="40" stroke-dasharray="{{ $pendLen }} {{ $circ }}" stroke-dashoffset="{{ -$paidLen }}"></circle>
            @endif
        </g>
        <text class="dash-donut__center" x="50" y="54" text-anchor="middle">{{ $paidPct }}%</text>
    </svg>
    <div class="dash-legend">
        <div><i style="background:#10b981"></i><div>Paid<small>{{ $paidCount }} · {{ $paidPct }}%</small></div></div>
        <div><i style="background:#f59e0b"></i><div>Pending<small>{{ $pendingCount }} · {{ $pendingPct }}%</small></div></div>
    </div>
</div>
