@extends('layouts.user')

@section('title', 'My tickets')
@section('main_class', 'user-main--dash')

@section('content')
@include('partials.dash-styles')

<div class="dash">
    <header class="dash-head dash-head--user">
        <div>
            <div class="dash-head__tag">GoalPass · Ticket wallet</div>
            <h1>My tickets</h1>
            <p>Every match you purchased — payment and delivery status at a glance.</p>
        </div>
        <div class="dash-head__actions">
            <a href="{{ route('user.orders') }}" class="btn btn--ghost">Order history</a>
            <a href="/#schedule" class="btn">Buy more tickets</a>
        </div>
    </header>

    <div class="dash-card">
        <div class="dash-card__head">
            <h2>Your tickets</h2>
            <span>{{ $orders->count() }} order{{ $orders->count() === 1 ? '' : 's' }}</span>
        </div>
        @include('partials.user-ticket-wallet', ['orders' => $orders])
    </div>
</div>
@endsection
