<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout — {{ $match->matchupTitle() }}</title>
    @include('partials.site-styles')
    <style>
        .checkout { max-width: 720px; margin: 40px auto; padding: 0 24px; }
        .checkout-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 18px; padding: 24px; }
        .checkout h1 { margin: 0 0 8px; font-size: 28px; }
        .checkout p { color: #676767; }
        .checkout-meta { margin: 18px 0; line-height: 1.7; }
        .checkout-meta strong { display: block; font-size: 18px; }
        label { display: block; font-weight: 700; margin: 16px 0 8px; }
        select, input { width: 100%; padding: 12px; border: 1px solid #e8e8e8; border-radius: 12px; font: inherit; }
        .pay-btn { margin-top: 20px; width: 100%; border: 0; border-radius: 999px; padding: 14px; background: #181818; color: #fff; font-weight: 800; font-size: 16px; cursor: pointer; }
        .top-links { display: flex; gap: 16px; margin-bottom: 20px; font-size: 14px; }
        .top-links a { color: #0b5fff; }
    </style>
</head>
<body>
    <div class="checkout">
        <div class="top-links">
            <a href="/">← Back to matches</a>
            <a href="{{ route('dashboard') }}">My dashboard</a>
        </div>

        <div class="checkout-card">
            <p>{{ $match->stageLabel() }}</p>
            <h1>{{ $match->matchupTitle() }}</h1>
            <div class="checkout-meta">
                <span>{{ $match->formattedDayTime() }}</span><br>
                <span>{{ $match->locationLine() }}</span>
            </div>

            <form method="post" action="{{ route('checkout.pay', $match) }}">
                @csrf
                <label for="quantity">Number of tickets</label>
                <select id="quantity" name="quantity">
                    @for ($i = 1; $i <= $maxQuantity; $i++)
                        <option value="{{ $i }}">{{ $i }} ticket{{ $i > 1 ? 's' : '' }} — ${{ number_format($match->price_from * $i) }}</option>
                    @endfor
                </select>

                @if ($match->tickets_available !== null)
                    <p style="margin-top:10px;font-size:13px;color:#676767;">{{ $match->ticketsRemaining() }} tickets left for this match.</p>
                @endif

                <button class="pay-btn" type="submit">
                    Continue to payment — From ${{ number_format($match->price_from) }}
                </button>
            </form>

            <p style="margin-top:14px;font-size:13px;color:#676767;">
                @if (config('services.stripe.secret'))
                    You will be redirected to Stripe to complete payment securely.
                @else
                    Demo mode: payment will be recorded instantly without Stripe keys.
                @endif
            </p>
        </div>
    </div>
</body>
</html>
