@extends('layouts.user')

@section('title', 'Order history')
@section('main_class', 'user-main--dash')

@section('content')
@include('partials.dash-styles')

<div class="dash">
    <header class="dash-head dash-head--user">
        <div>
            <div class="dash-head__tag">GoalPass · Orders</div>
            <h1>Order history</h1>
            <p>See what you paid, which match you bought, and whether your ticket was delivered.</p>
        </div>
        <div class="dash-head__actions">
            <a href="{{ route('user.tickets') }}" class="btn btn--ghost">My tickets</a>
            <a href="/#schedule" class="btn">Buy tickets</a>
        </div>
    </header>

    <div class="dash-card">
        <div class="dash-card__head">
            <h2>All orders</h2>
            <span>{{ $orders->count() }} order{{ $orders->count() === 1 ? '' : 's' }}</span>
        </div>
        @include('partials.user-order-table', ['orders' => $orders])
    </div>
</div>
@endsection
