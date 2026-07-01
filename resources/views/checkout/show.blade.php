@extends('layouts.app')

@section('title', 'Checkout — '.$match->matchupTitle())

@php
    $genericFlag = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='10' fill='%234a5568'/%3E%3C/svg%3E";
    $stageLower = strtolower($match->stage);
    $heroClass = 'checkout-page__hero';
    if (str_contains($stageLower, 'final')) {
        $heroClass .= ' checkout-page__hero--final';
    } elseif (str_contains($stageLower, 'semi') || str_contains($stageLower, 'quarter') || str_contains($stageLower, 'round of')) {
        $heroClass .= ' checkout-page__hero--knockout';
    }
    $unitPrice = (int) $match->price_from;
@endphp

@push('styles')
    @include('partials.checkout-styles')
@endpush

@section('content')
<div class="checkout-page">
    <header class="{{ $heroClass }}">
        <div class="checkout-shell">
            <nav class="checkout-nav">
                <a href="/" class="checkout-nav__brand">GOALPASS</a>
                <div style="display:flex;gap:16px;">
                    <a href="/#schedule">← Matches</a>
                    <a href="{{ route('user.tickets') }}">My tickets</a>
                </div>
            </nav>

            <span class="checkout-stage">🏆 {{ $match->stageLabel() }}</span>

            <div class="checkout-matchup">
                <div class="checkout-team">
                    <div class="checkout-team__flag">
                        <img src="{{ $homeFlag ?? $genericFlag }}" alt="" />
                    </div>
                    <div class="checkout-team__name">{{ $match->home_team }}</div>
                </div>
                <div class="checkout-vs">VS</div>
                <div class="checkout-team">
                    <div class="checkout-team__flag">
                        <img src="{{ $awayFlag ?? $genericFlag }}" alt="" />
                    </div>
                    <div class="checkout-team__name">{{ $match->away_team }}</div>
                </div>
            </div>

            <div class="checkout-venue-card">
                <h1>{{ $match->venue }}</h1>
                <p>{{ $match->city }} · FIFA World Cup 2026</p>
                <div class="checkout-details">
                    <span class="checkout-detail"><span class="checkout-detail__icon">📅</span> {{ $match->formattedVenueDateLong() }}</span>
                    <span class="checkout-detail checkout-detail--time">
                        <span class="checkout-detail__icon">🕐</span>
                        <x-match-kickoff :match="$match" />
                    </span>
                    <span class="checkout-detail"><span class="checkout-detail__icon">📍</span> {{ $match->city }}</span>
                    @if ($match->tickets_available !== null)
                        <span class="checkout-detail"><span class="checkout-detail__icon">🎟</span> {{ $match->ticketsRemaining() }} left</span>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="checkout-body">
        <div class="checkout-shell">
            <div class="checkout-grid">
                <div class="checkout-panel">
                    <div class="checkout-panel__head">Order summary</div>
                    <div class="checkout-panel__body">
                        <div class="checkout-summary-row">
                            <strong>{{ $match->matchupTitle() }}</strong>
                        </div>
                        <div class="checkout-summary-row">
                            <span>Stage</span>
                            <strong>{{ $match->stageLabel() }}</strong>
                        </div>
                        <div class="checkout-summary-row">
                            <span>Venue</span>
                            <strong>{{ $match->venue }}</strong>
                        </div>
                        <div class="checkout-summary-row">
                            <span>Date & time</span>
                            <strong>{{ $match->formattedDate() }}</strong>
                        </div>
                        <div class="checkout-summary-row">
                            <span>Price per ticket</span>
                            <strong>${{ number_format($unitPrice) }}</strong>
                        </div>
                        <div class="checkout-summary-row">
                            <span>Quantity</span>
                            <strong id="summary-qty">1</strong>
                        </div>
                        <div class="checkout-summary-total">
                            <div>
                                Total
                                <small>Taxes & fees included</small>
                            </div>
                            <strong id="summary-total">${{ number_format($unitPrice) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="checkout-panel">
                    <div class="checkout-panel__head">Complete your purchase</div>
                    <div class="checkout-panel__body">
                        <form method="post" action="{{ route('checkout.pay', $match) }}" class="checkout-form" id="checkout-form">
                            @csrf

                            @if ($match->tickets_available !== null)
                                <p class="checkout-stock">Only {{ $match->ticketsRemaining() }} tickets remaining — secure yours now.</p>
                            @endif

                            <label>How many tickets?</label>
                            <div class="checkout-qty" id="qty-picker">
                                @for ($i = 1; $i <= $maxQuantity; $i++)
                                    <div>
                                        <input
                                            type="radio"
                                            name="quantity"
                                            id="qty-{{ $i }}"
                                            value="{{ $i }}"
                                            @checked($i === 1)
                                            data-total="{{ $unitPrice * $i }}"
                                        />
                                        <label for="qty-{{ $i }}">
                                            {{ $i }}
                                            <small>${{ number_format($unitPrice * $i) }}</small>
                                        </label>
                                    </div>
                                @endfor
                            </div>

                            <button class="checkout-pay-btn" type="submit" id="pay-btn" data-loading-text="Redirecting to payment...">
                                Continue to secure payment
                            </button>

                            <div class="checkout-secure">
                                @if (config('services.stripe.secret'))
                                    <span>🔒 Stripe secure checkout</span>
                                    <span>🛡 Every ticket protected</span>
                                @else
                                    <span>⚡ Demo mode — instant confirmation</span>
                                @endif
                            </div>
                        </form>

                        <div class="checkout-trust" style="margin-top:22px;">
                            <div class="checkout-trust-item">
                                <div class="checkout-trust-item__icon">✓</div>
                                <div>
                                    <strong>Official match tickets</strong>
                                    <span>Verified listings for {{ $match->venue }} with instant order confirmation.</span>
                                </div>
                            </div>
                            <div class="checkout-trust-item">
                                <div class="checkout-trust-item__icon">⚡</div>
                                <div>
                                    <strong>Fast digital delivery</strong>
                                    <span>Tickets appear in your GoalPass wallet right after payment.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
    const unitPrice = {{ $unitPrice }};
    const qtyInputs = document.querySelectorAll('#qty-picker input[name="quantity"]');
    const summaryQty = document.getElementById('summary-qty');
    const summaryTotal = document.getElementById('summary-total');
    const payBtn = document.getElementById('pay-btn');

    const formatMoney = (n) => '$' + n.toLocaleString('en-US');

    const update = () => {
        const selected = document.querySelector('#qty-picker input[name="quantity"]:checked');
        if (!selected) return;
        const qty = parseInt(selected.value, 10);
        const total = unitPrice * qty;
        summaryQty.textContent = qty;
        summaryTotal.textContent = formatMoney(total);
        payBtn.textContent = `Continue to secure payment — ${formatMoney(total)}`;
    };

    qtyInputs.forEach((input) => input.addEventListener('change', update));
    update();
})();
</script>
@endpush
