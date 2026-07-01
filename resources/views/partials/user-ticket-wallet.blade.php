@props(['orders'])

@if ($orders->isEmpty())
    <div class="dash-empty">
        <strong>No tickets yet</strong>
        <p>Browse the World Cup schedule and buy your first match ticket.</p>
        <a href="/#schedule" class="btn">View matches</a>
    </div>
@else
    <div class="dash-tickets">
        @foreach ($orders as $order)
            @php
                $match = $order->worldCupMatch;
                $stripeClass = match (true) {
                    $order->isRefunded() => 'rejected',
                    ! $order->isPaid() => 'pending',
                    $order->delivery_status === 'delivered' => 'delivered',
                    $order->delivery_status === 'rejected' => 'rejected',
                    default => 'delivery-pending',
                };
                $deliveryBadge = match ($order->delivery_status) {
                    'delivered' => 'delivered',
                    'rejected' => 'rejected',
                    default => 'delivery-pending',
                };
            @endphp
            <article class="dash-ticket">
                <div class="dash-ticket__stripe dash-ticket__stripe--{{ $stripeClass }}"></div>
                <div class="dash-ticket__body">
                    <div class="dash-ticket__stage">{{ $match->stageLabel() }}</div>
                    <div class="dash-ticket__title">{{ $match->matchupTitle() }}</div>
                    <div class="dash-ticket__meta">
                        <x-match-kickoff :match="$match" :show-local="false" /> · {{ $match->locationLine() }}<br>
                        Order #{{ $order->id }} · {{ $order->created_at->format('M j, Y') }}
                    </div>
                    <div class="dash-ticket__badges">
                        <span class="badge badge--{{ $order->isRefunded() ? 'refunded' : ($order->isPaid() ? 'paid' : 'pending') }}">{{ $order->paymentStatusLabel() }}</span>
                        @if ($order->isPaid())
                            <span class="badge badge--{{ $deliveryBadge }}">{{ $order->deliveryStatusLabel() }}</span>
                        @elseif ($order->isRefunded())
                            <span class="badge badge--rejected">{{ $order->deliveryStatusLabel() }}</span>
                        @endif
                    </div>
                    @if ($order->isRefunded())
                        <div class="muted" style="font-size:12px;margin-top:8px;line-height:1.5;">
                            @if ($order->isRefundPending())
                                Your refund is processing. It may take 5–10 business days to appear on your card.
                            @else
                                Your payment was refunded. It may take 5–10 business days to appear on your card.
                            @endif
                        </div>
                    @endif
                    @if ($order->delivery_status === 'rejected' && $order->delivery_note)
                        <div class="dash-ticket__note">
                            <strong>Why this ticket was rejected</strong>
                            {{ $order->delivery_note }}
                        </div>
                    @elseif ($order->isPaid() && $order->delivery_status === 'pending')
                        <div class="muted" style="font-size:12px;margin-top:8px;">Delivery within 2 days</div>
                    @endif
                </div>
                <div class="dash-ticket__side">
                    <div class="dash-ticket__price">{{ $order->formattedAmount() }}</div>
                    <div class="dash-ticket__qty">{{ $order->quantity }} ticket{{ $order->quantity > 1 ? 's' : '' }}</div>
                </div>
            </article>
        @endforeach
    </div>
@endif
