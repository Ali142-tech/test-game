@extends('layouts.admin')

@section('title', 'Ticket orders')

@section('content')
<div class="admin-topbar">
    <div>
        <h1>Ticket orders</h1>
        <p>See which users bought which match tickets and track payment status.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card stat-card--blue">
        <div class="stat-card__label">Total orders</div>
        <div class="stat-card__value">{{ number_format($stats['total']) }}</div>
    </div>
    <div class="stat-card stat-card--green">
        <div class="stat-card__label">Paid orders</div>
        <div class="stat-card__value">{{ number_format($stats['paid']) }}</div>
        <div class="stat-card__hint">${{ number_format($stats['revenue'], 0) }} revenue</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__label">Tickets sold</div>
        <div class="stat-card__value">{{ number_format($stats['tickets_sold']) }}</div>
    </div>
    <div class="stat-card stat-card--amber">
        <div class="stat-card__label">Pending</div>
        <div class="stat-card__value">{{ number_format($stats['pending']) }}</div>
    </div>
</div>

<div class="panel">
    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Buyer</th>
                <th>Match</th>
                <th>Tickets</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        <strong>{{ $order->user->name }}</strong><br>
                        <span class="muted">{{ $order->user->email }}</span>
                        @if ($order->user->formattedPhone())
                            <br><span class="muted">{{ $order->user->formattedPhone() }}</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $order->worldCupMatch->matchupTitle() }}</strong><br>
                        <span class="muted">{{ $order->worldCupMatch->stage }} · {{ $order->worldCupMatch->formattedDayTime() }}</span>
                    </td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->formattedAmount() }}</td>
                    <td>
                        <span class="badge badge--{{ $order->status === 'paid' ? 'paid' : 'pending' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('M j, Y g:ia') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No ticket orders yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($orders->hasPages())
        <div class="pagination">
            @if ($orders->onFirstPage())
                <span>&laquo; Prev</span>
            @else
                <a href="{{ $orders->previousPageUrl() }}">&laquo; Prev</a>
            @endif

            <span class="current">Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</span>

            @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}">Next &raquo;</a>
            @else
                <span>Next &raquo;</span>
            @endif
        </div>
    @endif
</div>
@endsection
