@extends('layouts.auth')

@section('title', 'Create account')
@section('wrap_class', 'auth-wrap--register')
@section('card_class', 'auth-card--wide')

@section('content')
    <div class="auth-card__eyebrow">Join GoalPass</div>
    <h1>Create account</h1>
    <p class="auth-card__lead">Register once, then buy and manage World Cup 2026 tickets anytime.</p>

    <nav class="auth-tabs" aria-label="Account type">
        <a href="{{ route('login', request()->only('redirect')) }}">Sign in</a>
        <a href="{{ route('register', request()->only('redirect')) }}" class="is-active">Create account</a>
    </nav>

    <form method="post" action="{{ route('register') }}" novalidate data-auth-validate="register">
        @csrf
        @if ($redirect)
            <input type="hidden" name="redirect" value="{{ $redirect }}" />
        @endif

        <div class="auth-field @error('name') has-error @enderror">
            <label for="name">Full name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                autofocus
                autocomplete="name"
                placeholder="Your name"
                @error('name') aria-invalid="true" @enderror
            />
            <x-auth-error field="name" />
        </div>

        <div class="auth-field @error('email') has-error @enderror">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="email"
                placeholder="you@email.com"
                @error('email') aria-invalid="true" @enderror
            />
            <x-auth-error field="email" />
        </div>

        <x-phone-input :countries="$countries" :selected-country="old('phone_country', 'US')" />

        <x-password-input id="password" name="password" label="Password" autocomplete="new-password" placeholder="Min. 8 characters" />
        <x-password-input id="password_confirmation" name="password_confirmation" label="Confirm password" autocomplete="new-password" placeholder="Repeat password" />

        <button class="auth-btn" type="submit">Create account</button>
        <p class="auth-trust">🛡 Every ticket protected on GoalPass</p>
    </form>
@endsection
