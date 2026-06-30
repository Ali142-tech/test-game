@props(['match', 'teamFlags' => []])

@php
    $homeFlag = $teamFlags[$match->home_team] ?? null;
    $awayFlag = $teamFlags[$match->away_team] ?? null;
    $generic = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='10' fill='%234a5568'/%3E%3C/svg%3E";
    $checkoutUrl = route('checkout.show', $match);
    $href = auth()->check() ? $checkoutUrl : route('login', ['redirect' => $checkoutUrl]);
@endphp

<article class="match-card" data-stage="{{ $match->stage }}" data-city="{{ $match->city }}">
    <div class="match-card__left">
        <div class="match-card__flags" aria-hidden="true">
            <img src="{{ $homeFlag ?? $generic }}" alt="" class="match-card__flag match-card__flag--back" />
            <img src="{{ $awayFlag ?? $generic }}" alt="" class="match-card__flag match-card__flag--front" />
        </div>
        <div class="match-card__datebox">
            <strong>{{ $match->formattedShortDate() }}</strong>
            <span>{{ $match->formattedDayTime() }}</span>
        </div>
    </div>

    <div class="match-card__body">
        <span class="match-card__stage">{{ $match->stageLabel() }}</span>
        <strong class="match-card__title">{{ $match->matchupTitle() }}</strong>
        <span class="match-card__venue">{{ $match->locationLine() }}</span>
    </div>

    <div class="match-card__action">
        @if ($match->isSoldOut())
            <span class="match-card__btn match-card__btn--disabled">{{ __('site.match.sold_out') }}</span>
        @elseif ($match->price_from)
            <a href="{{ $href }}" class="match-card__btn">
                <span class="match-card__btn-label">{{ __('site.match.buy_ticket') }}</span>
                <span class="match-card__btn-price">{{ __('site.match.buy_ticket_price', ['price' => number_format($match->price_from)]) }}</span>
            </a>
        @else
            <span class="match-card__btn match-card__btn--disabled">{{ __('site.match.tba') }}</span>
        @endif
    </div>
</article>
