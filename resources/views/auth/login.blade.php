@extends('layouts.auth')

@section('title', 'Sign in')

@section('content')
    <div class="auth-card__icon" aria-hidden="true">⚽</div>
    <div class="auth-card__eyebrow">World Cup 2026 · Ticket access</div>
    <h1>Welcome back, fan</h1>
    <p class="auth-card__lead">Sign in to grab knockout tickets and manage your match-day passes.</p>

    <nav class="auth-tabs" aria-label="Account type">
        <a href="{{ route('login', request()->only('redirect')) }}" class="is-active">Sign in</a>
        <a href="{{ route('register', request()->only('redirect')) }}">Create account</a>
    </nav>

    <form method="post" action="{{ route('login') }}" novalidate data-auth-validate="login">
        @csrf
        @if ($redirect)
            <input type="hidden" name="redirect" value="{{ $redirect }}" />
        @endif

        <div class="auth-field @error('email') has-error @enderror">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autofocus
                autocomplete="email"
                placeholder="you@email.com"
                @error('email') aria-invalid="true" @enderror
            />
            <x-auth-error field="email" />
        </div>

        <x-password-input id="password" name="password" label="Password" autocomplete="current-password" placeholder="Your password" />

        <label class="auth-check">
            <input type="checkbox" name="remember" value="1" />
            Remember me
        </label>

        <button class="auth-btn" type="submit" data-loading-text="Signing in...">Sign in</button>
        <p class="auth-trust">🔒 Secure checkout · Tickets delivered within 2 days</p>
    </form>
@endsection
