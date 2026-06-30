@extends('layouts.auth')

@section('title', 'Sign in')

@section('showcase')
    <span class="auth-showcase__tag">🛡 Every ticket protected</span>
    <h1>World Cup 2026 tickets</h1>
    <p>Sign in to buy match tickets, manage your wallet, and track orders in one place.</p>
    <ul class="auth-showcase__list">
        <li><span>🎟</span> Buy tickets for every World Cup match</li>
        <li><span>📱</span> Digital ticket wallet on your dashboard</li>
        <li><span>🔒</span> Secure Stripe checkout</li>
    </ul>
    <div class="auth-showcase__art">World Cup<br>2026</div>
@endsection

@section('content')
    <h2>Sign in</h2>
    <p class="auth-card__lead">Welcome back — log in to continue to your tickets.</p>

    <form method="post" action="{{ route('login') }}">
        @csrf
        @if ($redirect)
            <input type="hidden" name="redirect" value="{{ $redirect }}" />
        @endif

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" />

        <x-password-input id="password" name="password" label="Password" required autocomplete="current-password" />

        <label class="check">
            <input type="checkbox" name="remember" value="1" />
            Remember me
        </label>

        <button class="btn" type="submit">Sign in</button>
    </form>

    <div class="row">
        <a class="link" href="{{ route('register', $redirect ? ['redirect' => $redirect] : []) }}">Create account</a>
        <a class="link" href="/">← Back to homepage</a>
    </div>
@endsection
