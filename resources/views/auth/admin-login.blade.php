@extends('layouts.auth')

@section('title', 'Admin login')

@section('content')
    <div class="auth-card__eyebrow">Admin</div>
    <h1>Admin sign in</h1>
    <p class="auth-card__lead">Manage matches, pricing, and ticket sales.</p>

    <form method="post" action="{{ route('admin.login') }}">
        @csrf

        <div class="auth-field">
            <label for="email">Admin email</label>
            <input id="email" type="email" name="email" value="{{ old('email', 'admin@goalpass.local') }}" required autofocus autocomplete="email" />
        </div>

        <x-password-input id="password" name="password" label="Password" required autocomplete="current-password" />

        <label class="auth-check">
            <input type="checkbox" name="remember" value="1" />
            Remember me
        </label>

        <button class="auth-btn" type="submit" data-loading-text="Signing in...">Sign in to admin</button>
    </form>

    <p class="auth-trust" style="margin-top:20px">
        <a href="{{ route('login') }}" style="color:#2563eb;font-weight:700;text-decoration:none">← User sign in</a>
    </p>
@endsection
