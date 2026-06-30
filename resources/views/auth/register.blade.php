@extends('layouts.auth')

@section('title', 'Create account')

@section('showcase')
    <span class="auth-showcase__tag">GoalPass · FIFA World Cup 2026</span>
    <h1>Join GoalPass</h1>
    <p>Create your account in seconds and start booking World Cup match tickets across USA, Canada &amp; Mexico.</p>
    <ul class="auth-showcase__list">
        <li><span>⚽</span> Full schedule &amp; host city matches</li>
        <li><span>💳</span> Fast checkout with Stripe</li>
        <li><span>✓</span> Verified ticket marketplace</li>
    </ul>
    <div class="auth-showcase__art">World Cup<br>2026</div>
@endsection

@section('content')
    <h2>Create account</h2>
    <p class="auth-card__lead">Register to purchase tickets and access your personal wallet.</p>

    <form method="post" action="{{ route('register') }}">
        @csrf
        @if ($redirect)
            <input type="hidden" name="redirect" value="{{ $redirect }}" />
        @endif

        <label for="name">Full name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />

        <x-phone-input :countries="$countries" :selected-country="old('phone_country', 'US')" />

        <x-password-input id="password" name="password" label="Password" required autocomplete="new-password" />
        <x-password-input id="password_confirmation" name="password_confirmation" label="Confirm password" required autocomplete="new-password" />

        <button class="btn" type="submit">Create account</button>
    </form>

    <div class="row">
        <a class="link" href="{{ route('login', $redirect ? ['redirect' => $redirect] : []) }}">Already have an account?</a>
        <a class="link" href="/">← Back to homepage</a>
    </div>
@endsection
