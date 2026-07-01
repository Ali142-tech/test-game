@extends('layouts.user')

@section('title', 'Dashboard')
@section('main_class', 'user-main--dash')

@section('content')
@php
    $paidOrders = $orders->where('status', 'paid');
    $paidCount = $paidOrders->count();
    $pendingCount = $orders->where('status', 'pending')->count();
    $paidPct = $orders->count() > 0 ? round(($paidCount / $orders->count()) * 100) : 0;
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
            <div class="dash-head__tag">GoalPass · Dashboard</div>
            <h1>Hello, {{ auth()->user()->name }}</h1>
            <p>Your World Cup 2026 ticket overview</p>
        </div>
        <div class="dash-head__actions">
            <a href="/#schedule" class="btn btn--ghost">Browse matches</a>
            <a href="/#schedule" class="btn">Buy tickets</a>
        </div>
    </header>

    <div class="dash-quick">
        <a href="{{ route('user.tickets') }}" class="dash-quick__card">
            <span class="dash-quick__icon">🎟</span>
            <span class="dash-quick__label">My tickets</span>
            <span class="dash-quick__value">{{ $paidCount }} order{{ $paidCount === 1 ? '' : 's' }}</span>
            <span class="dash-quick__hint">View your ticket wallet</span>
        </a>
        <a href="{{ route('user.orders') }}" class="dash-quick__card">
            <span class="dash-quick__icon">📋</span>
            <span class="dash-quick__label">Order history</span>
            <span class="dash-quick__value">{{ $orders->count() }} total</span>
            <span class="dash-quick__hint">Payments &amp; delivery status</span>
        </a>
    </div>

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
                <a href="{{ route('user.tickets') }}" style="font-size:12px;font-weight:700;color:var(--brand);">View all</a>
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
                    <p class="muted" style="margin:0;font-size:12px">No upcoming matches yet. <a href="/#schedule">Browse schedule</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
