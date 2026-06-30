@extends('layouts.auth')

@section('title', 'Sign in')

@section('content')
    <div class="auth-card__eyebrow">GoalPass · World Cup 2026</div>
    <h1>Welcome back</h1>
    <p class="auth-card__lead">Sign in to access your tickets and buy World Cup matches.</p>

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

        <button class="auth-btn" type="submit">Sign in</button>
        <p class="auth-trust">🔒 Secure login · Stripe checkout on ticket purchases</p>
    </form>
@endsection
