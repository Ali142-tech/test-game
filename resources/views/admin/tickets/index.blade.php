@extends('layouts.admin')

@section('title', 'Ticket orders')

@section('content')
<div class="admin-topbar">
    <div>
        <h1>Ticket delivery</h1>
        <p>Manage ticket delivery status for paid orders. Rejecting an order refunds the buyer via Stripe.</p>
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
    <div class="stat-card stat-card--amber">
        <div class="stat-card__label">Pending delivery</div>
        <div class="stat-card__value">{{ number_format($stats['delivery_pending']) }}</div>
    </div>
    <div class="stat-card stat-card--green">
        <div class="stat-card__label">Delivered</div>
        <div class="stat-card__value">{{ number_format($stats['delivery_delivered']) }}</div>
    </div>
    <div class="stat-card" style="border-color:#fecaca;">
        <div class="stat-card__label">Rejected / refunded</div>
        <div class="stat-card__value" style="color:#dc2626;">{{ number_format($stats['delivery_rejected']) }}</div>
        <div class="stat-card__hint">{{ number_format($stats['refunded']) }} refunded</div>
    </div>
</div>

<div class="panel">
    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Buyer</th>
                <th>Match</th>
                <th>Qty</th>
                <th>Paid</th>
                <th>Payment</th>
                <th>Ticket delivery</th>
                <th>Ordered</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        <strong>{{ $order->user->name }}</strong><br>
                        <span class="muted">{{ $order->user->email }}</span>
                    </td>
                    <td>
                        <strong>{{ $order->worldCupMatch->matchupTitle() }}</strong><br>
                        <span class="muted">{{ $order->worldCupMatch->stage }} · {{ $order->worldCupMatch->formattedDayTime() }}</span><br>
                        <span class="muted">{{ $order->worldCupMatch->locationLine() }}</span>
                    </td>
                    <td>{{ $order->quantity }}</td>
                    <td><strong>{{ $order->formattedAmount() }}</strong></td>
                    <td>
                        @if ($order->isRefunded())
                            <span class="badge badge--refunded">Refunded</span>
                            @if ($order->refundStatusLabel())
                                <div class="muted" style="font-size:11px;margin-top:4px;">{{ $order->refundStatusLabel() }}</div>
                            @endif
                        @else
                            <span class="badge badge--{{ $order->status === 'paid' ? 'paid' : 'pending' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif
                    </td>
                    <td style="min-width:260px;">
                        @if ($order->isRefunded())
                            <span class="badge badge--rejected">Rejected</span>
                            @if ($order->delivery_note)
                                <div class="muted" style="font-size:12px;margin-top:6px;line-height:1.45;">{{ $order->delivery_note }}</div>
                            @endif
                            <div class="muted" style="font-size:11px;margin-top:6px;">Payment refunded to buyer</div>
                        @elseif ($order->isPaid())
                            <form method="post" action="{{ route('admin.tickets.update', $order) }}" class="ticket-delivery-form">
                                @csrf
                                @method('PATCH')
                                <select name="delivery_status" class="ticket-delivery-form__select" data-delivery-select>
                                    <option value="pending" @selected($order->delivery_status === 'pending')>Pending</option>
                                    <option value="delivered" @selected($order->delivery_status === 'delivered')>Delivered</option>
                                    <option value="rejected" @selected($order->delivery_status === 'rejected')>Rejected</option>
                                </select>
                                <textarea
                                    name="delivery_note"
                                    class="ticket-delivery-form__note"
                                    rows="2"
                                    placeholder="Reason for rejection (shown only to this buyer)…"
                                    data-delivery-note
                                    @if ($order->delivery_status !== 'rejected') hidden @endif
                                >{{ $order->delivery_note }}</textarea>
                                <button type="submit" class="btn" style="margin-top:8px;padding:8px 12px;font-size:12px;">Save</button>
                            </form>
                        @else
                            <span class="muted">Awaiting payment</span>
                        @endif
                    </td>
                    <td>{{ $order->created_at->format('M j, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No ticket orders yet.</td>
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

<style>
    .ticket-delivery-form__select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid var(--line);
        border-radius: 10px;
        font: inherit;
        font-size: 13px;
        background: #fff;
    }
    .ticket-delivery-form__note {
        width: 100%;
        margin-top: 8px;
        padding: 8px 10px;
        border: 1px solid var(--line);
        border-radius: 10px;
        font: inherit;
        font-size: 12px;
        resize: vertical;
        min-height: 56px;
    }
</style>

<script>
(() => {
    document.querySelectorAll('[data-delivery-select]').forEach((select) => {
        const form = select.closest('.ticket-delivery-form');
        const note = form?.querySelector('[data-delivery-note]');
        if (!note) return;

        const sync = () => {
            const rejected = select.value === 'rejected';
            note.hidden = !rejected;
            note.required = rejected;
        };

        select.addEventListener('change', sync);
        sync();
    });
})();
</script>
@endsection
