@extends('layouts.admin')

@section('title', 'Dashboard')
@section('main_class', 'admin-main--dash')

@section('content')
@php
    $totalOrders = $stats['orders_paid'] + $stats['orders_pending'];
    $paidPct = $totalOrders > 0 ? round(($stats['orders_paid'] / $totalOrders) * 100) : 0;
    $pendingPct = 100 - $paidPct;
    $topMatches = $matchInventory->sortByDesc('tickets_sold')->take(3);
    $maxMatchSold = max($topMatches->pluck('tickets_sold')->map(fn ($v) => (int) $v)->all() ?: [1]);
    $inventoryPreview = $matchInventory->take(5);
    $ordersPreview = $recentOrders->take(5);
@endphp

@include('partials.dash-styles')

<div class="dash">
    <header class="dash-head dash-head--admin">
        <div>
            <div class="dash-head__tag">GoalPass Admin</div>
            <h1>Hello, {{ auth()->user()->name }}</h1>
            <p>World Cup 2026 ticket sales overview</p>
        </div>
        <div class="dash-head__actions">
            <a href="{{ route('admin.matches.index') }}" class="btn btn--ghost">Matches</a>
            <a href="{{ route('admin.matches.create') }}" class="btn">Add match</a>
        </div>
    </header>

    <div class="dash-stats">
        <div class="dash-stat">
            <div class="dash-stat__icon dash-stat__icon--green">REV</div>
            <div>
                <div class="dash-stat__label">Revenue</div>
                <div class="dash-stat__value">${{ number_format($stats['revenue'], 0) }}</div>
                <div class="dash-stat__hint">{{ $stats['orders_paid'] }} paid orders</div>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat__icon dash-stat__icon--blue">TKT</div>
            <div>
                <div class="dash-stat__label">Tickets sold</div>
                <div class="dash-stat__value">{{ number_format($stats['tickets_sold']) }}</div>
                <div class="dash-stat__hint">{{ $stats['buyers'] }} buyers</div>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat__icon dash-stat__icon--violet">MTC</div>
            <div>
                <div class="dash-stat__label">Matches live</div>
                <div class="dash-stat__value">{{ $stats['matches_published'] }}</div>
                <div class="dash-stat__hint">{{ $stats['matches_total'] }} total</div>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat__icon dash-stat__icon--amber">USR</div>
            <div>
                <div class="dash-stat__label">Users</div>
                <div class="dash-stat__value">{{ number_format($stats['users_total']) }}</div>
                <div class="dash-stat__hint">{{ $stats['orders_pending'] }} pending orders</div>
            </div>
        </div>
    </div>

    <div class="dash-mid">
        <div class="dash-card">
            <div class="dash-card__head">
                <h2>Revenue trend</h2>
                <span>Last 6 months</span>
            </div>
            <div class="dash-card__body">
                @include('partials.dash-bar-chart', [
                    'values' => $salesTrend['values'],
                    'labels' => $salesTrend['labels'],
                    'gradientId' => 'adminRevenueBar',
                    'barColor' => '#2563eb',
                    'barColorEnd' => '#60a5fa',
                    'ariaLabel' => 'Revenue trend chart',
                ])
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card__head">
                <h2>Orders</h2>
                <span>Paid vs pending</span>
            </div>
            <div class="dash-card__body">
                @include('partials.dash-donut-chart', [
                    'paidPct' => $paidPct,
                    'pendingPct' => $pendingPct,
                    'paidCount' => $stats['orders_paid'],
                    'pendingCount' => $stats['orders_pending'],
                ])
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card__head">
                <h2>Top matches</h2>
                <span>By tickets sold</span>
            </div>
            <div class="dash-card__body">
                @if ($topMatches->isNotEmpty())
                    <div class="dash-bars">
                        @foreach ($topMatches as $match)
                            @php $sold = (int) ($match->tickets_sold ?? 0); @endphp
                            <div class="dash-bar">
                                <div class="dash-bar__name">{{ $match->matchupTitle() }}<span>{{ $match->stage }}</span></div>
                                <div class="dash-bar__track"><div class="dash-bar__fill" style="width:{{ max(($sold / max($maxMatchSold, 1)) * 100, 6) }}%"></div></div>
                                <div class="dash-bar__val">{{ $sold }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="muted" style="margin:0;font-size:12px">No sales yet.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="dash-bottom">
        <div class="dash-card">
            <div class="dash-card__head">
                <h2>Match inventory</h2>
                <span>Latest {{ $inventoryPreview->count() }}</span>
            </div>
            <div class="dash-table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Match</th>
                            <th>Sold</th>
                            <th>Fill</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventoryPreview as $match)
                            @php
                                $sold = (int) ($match->tickets_sold ?? 0);
                                $available = $match->tickets_available;
                                $remaining = $available !== null ? max(0, $available - $sold) : null;
                                $fill = $available ? min(100, round(($sold / max($available, 1)) * 100)) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $match->matchupTitle() }}</strong>
                                    <div class="muted">{{ $match->match_date->format('M j') }} · {{ $match->city }}</div>
                                </td>
                                <td>{{ number_format($sold) }}</td>
                                <td>
                                    @if ($available)
                                        <div class="fill"><div class="progress"><span style="width:{{ $fill }}%"></span></div><span class="muted">{{ $fill }}%</span></div>
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($remaining === 0)
                                        <span class="badge badge--soldout">Sold out</span>
                                    @elseif ($match->is_published)
                                        <span class="badge badge--published">Live</span>
                                    @else
                                        <span class="badge badge--draft">Draft</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4">No matches yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="dash-card__foot"><a href="{{ route('admin.matches.index') }}">View all matches →</a></div>
        </div>

        <div class="dash-card">
            <div class="dash-card__head">
                <h2>Recent orders</h2>
                <span>Latest {{ $ordersPreview->count() }}</span>
            </div>
            <div class="dash-table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Buyer</th>
                            <th>Match</th>
                            <th>Amt</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ordersPreview as $order)
                            @php
                                $initials = collect(explode(' ', $order->user->name))->filter()->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('');
                            @endphp
                            <tr>
                                <td>
                                    <div class="dash-buyer">
                                        <span class="dash-buyer__av">{{ $initials ?: 'U' }}</span>
                                        <div>
                                            <strong>{{ $order->user->name }}</strong>
                                            <div class="muted">{{ $order->created_at->format('M j') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $order->worldCupMatch->matchupTitle() }}</td>
                                <td><strong>{{ $order->formattedAmount() }}</strong></td>
                                <td>
                                    <span class="badge badge--{{ $order->status === 'paid' ? 'paid' : 'pending' }}">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="dash-card__foot"><a href="{{ route('admin.tickets.index') }}">View all orders →</a></div>
        </div>
    </div>
</div>
@endsection
