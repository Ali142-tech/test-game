@extends('layouts.user')

@section('title', 'My tickets')
@section('main_class', 'user-main--dash')

@section('content')
@php
    $paidOrders = $orders->where('status', 'paid');
    $pendingOrders = $orders->where('status', 'pending');
    $paidCount = $paidOrders->count();
    $pendingCount = $pendingOrders->count();
    $totalOrderCount = $paidCount + $pendingCount;
    $paidPct = $totalOrderCount > 0 ? round(($paidCount / $totalOrderCount) * 100) : 0;
    $pendingPct = 100 - $paidPct;
    $upcomingOrders = $paidOrders
        ->filter(fn ($o) => $o->worldCupMatch?->match_date?->isFuture())
        ->sortBy(fn ($o) => $o->worldCupMatch->match_date)
        ->take(3);
    $maxUpcomingQty = max($upcomingOrders->pluck('quantity')->map(fn ($v) => (int) $v)->all() ?: [1]);
@endphp

@include('partials.dash-styles')

<div class="dash">
    <header class="dash-head dash-head--user">
        <div>
            <div class="dash-head__tag">GoalPass · My tickets</div>
            <h1>Hello, {{ auth()->user()->name }}</h1>
            <p>Your World Cup 2026 ticket wallet &amp; order history</p>
        </div>
        <div class="dash-head__actions">
            <a href="/#schedule" class="btn btn--ghost">Browse matches</a>
            <a href="/#schedule" class="btn">Buy tickets</a>
        </div>
    </header>

    <div class="dash-stats">
        <div class="dash-stat">
            <div class="dash-stat__icon dash-stat__icon--blue">TKT</div>
            <div>
                <div class="dash-stat__label">Tickets owned</div>
                <div class="dash-stat__value">{{ number_format($stats['tickets']) }}</div>
                <div class="dash-stat__hint">Confirmed purchases</div>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat__icon dash-stat__icon--green">USD</div>
            <div>
                <div class="dash-stat__label">Total spent</div>
                <div class="dash-stat__value">${{ number_format($stats['spent'], 0) }}</div>
                <div class="dash-stat__hint">On paid orders</div>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat__icon dash-stat__icon--violet">ORD</div>
            <div>
                <div class="dash-stat__label">Orders</div>
                <div class="dash-stat__value">{{ number_format($stats['orders']) }}</div>
                <div class="dash-stat__hint">{{ $paidCount }} paid · {{ $pendingCount }} pending</div>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat__icon dash-stat__icon--amber">UPC</div>
            <div>
                <div class="dash-stat__label">Upcoming</div>
                <div class="dash-stat__value">{{ number_format($stats['upcoming']) }}</div>
                <div class="dash-stat__hint">Future matches in wallet</div>
            </div>
        </div>
    </div>

    <div class="dash-mid">
        <div class="dash-card">
            <div class="dash-card__head">
                <h2>Ticket activity</h2>
                <span>Last 6 months</span>
            </div>
            <div class="dash-card__body">
                @include('partials.dash-bar-chart', [
                    'values' => $activityData['values'],
                    'labels' => $activityData['labels'],
                    'gradientId' => 'userActivityBar',
                    'barColor' => '#6366f1',
                    'barColorEnd' => '#a78bfa',
                    'ariaLabel' => 'Ticket activity chart',
                ])
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card__head">
                <h2>Order status</h2>
                <span>Your orders</span>
            </div>
            <div class="dash-card__body">
                @include('partials.dash-donut-chart', [
                    'paidPct' => $paidPct,
                    'pendingPct' => $pendingPct,
                    'paidCount' => $paidCount,
                    'pendingCount' => $pendingCount,
                ])
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card__head">
                <h2>Upcoming matches</h2>
                <span>Next in your wallet</span>
            </div>
            <div class="dash-card__body">
                @if ($upcomingOrders->isNotEmpty())
                    <div class="dash-bars">
                        @foreach ($upcomingOrders as $order)
                            @php $match = $order->worldCupMatch; @endphp
                            <div class="dash-bar">
                                <div class="dash-bar__name">
                                    {{ $match->matchupTitle() }}
                                    <span>{{ $match->match_date->format('M j') }}</span>
                                </div>
                                <div class="dash-bar__track">
                                    <div class="dash-bar__fill dash-bar__fill--user" style="width:{{ max(($order->quantity / max($maxUpcomingQty, 1)) * 100, 8) }}%"></div>
                                </div>
                                <div class="dash-bar__val">{{ $order->quantity }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="muted" style="margin:0;font-size:12px">No upcoming matches yet.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card__head">
            <h2>Your ticket wallet</h2>
            <span>{{ $orders->count() }} order{{ $orders->count() === 1 ? '' : 's' }}</span>
        </div>

        @if ($orders->isEmpty())
            <div class="dash-empty">
                <strong>No tickets yet</strong>
                <p>Browse the World Cup schedule and buy your first match ticket.</p>
                <a href="/#schedule" class="btn">View matches</a>
            </div>
        @else
            <div class="dash-tickets">
                @foreach ($orders as $order)
                    @php $match = $order->worldCupMatch; @endphp
                    <article class="dash-ticket">
                        <div class="dash-ticket__stripe {{ $order->status === 'pending' ? 'dash-ticket__stripe--pending' : '' }}"></div>
                        <div class="dash-ticket__body">
                            <div class="dash-ticket__stage">{{ $match->stageLabel() }}</div>
                            <div class="dash-ticket__title">{{ $match->matchupTitle() }}</div>
                            <div class="dash-ticket__meta">
                                {{ $match->formattedDayTime() }} · {{ $match->locationLine() }}<br>
                                Ordered {{ $order->created_at->format('M j, Y') }}
                            </div>
                            <span class="badge badge--{{ $order->status === 'paid' ? 'paid' : 'pending' }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="dash-ticket__side">
                            <div class="dash-ticket__price">{{ $order->formattedAmount() }}</div>
                            <div class="dash-ticket__qty">{{ $order->quantity }} ticket{{ $order->quantity > 1 ? 's' : '' }}</div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
