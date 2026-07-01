@props(['orders'])

@if ($orders->isEmpty())
    <div class="dash-empty">
        <strong>No orders yet</strong>
        <p>Browse the World Cup schedule and buy your first match ticket.</p>
        <a href="/#schedule" class="btn">View matches</a>
    </div>
@else
    <div class="dash-orders">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Match</th>
                    <th>Tickets</th>
                    <th>Amount paid</th>
                    <th>Payment</th>
                    <th>Ticket status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    @php
                        $match = $order->worldCupMatch;
                        $deliveryBadge = match ($order->delivery_status) {
                            'delivered' => 'delivered',
                            'rejected' => 'rejected',
                            default => 'delivery-pending',
                        };
                    @endphp
                    <tr>
                        <td>
                            <strong>#{{ $order->id }}</strong><br>
                            <span class="muted" style="font-size:12px;">{{ $order->created_at->format('M j, Y g:ia') }}</span>
                        </td>
                        <td class="dash-orders__match">
                            <strong>{{ $match->matchupTitle() }}</strong>
                            <span>{{ $match->stageLabel() }}</span>
                            <span>{{ $match->formattedDayTime() }}</span>
                            <span>{{ $match->locationLine() }}</span>
                        </td>
                        <td>{{ $order->quantity }}</td>
                        <td><strong>{{ $order->formattedAmount() }}</strong></td>
                        <td>
                            <span class="badge badge--{{ $order->isRefunded() ? 'refunded' : ($order->isPaid() ? 'paid' : 'pending') }}">
                                {{ $order->paymentStatusLabel() }}
                            </span>
                            @if ($order->refundStatusLabel())
                                <div class="muted" style="font-size:12px;margin-top:6px;">{{ $order->refundStatusLabel() }}</div>
                            @endif
                        </td>
                        <td>
                            @if ($order->isPaid())
                                <span class="badge badge--{{ $deliveryBadge }}">{{ $order->deliveryStatusLabel() }}</span>
                                @if ($order->delivery_status === 'rejected' && $order->delivery_note)
                                    <div class="dash-orders__note">
                                        <strong>Admin note</strong>
                                        {{ $order->delivery_note }}
                                    </div>
                                @elseif ($order->delivery_status === 'pending')
                                    <div class="muted" style="font-size:12px;margin-top:6px;">Delivered within 2 days</div>
                                @endif
                            @elseif ($order->isRefunded())
                                <span class="badge badge--rejected">{{ $order->deliveryStatusLabel() }}</span>
                                @if ($order->delivery_note)
                                    <div class="dash-orders__note">
                                        <strong>Admin note</strong>
                                        {{ $order->delivery_note }}
                                    </div>
                                @endif
                                <div class="muted" style="font-size:12px;margin-top:6px;line-height:1.45;">
                                    Refund sent to your card. Allow 5–10 business days for your bank to post it.
                                </div>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
