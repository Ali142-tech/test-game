@extends('layouts.auth')

@section('title', 'Admin login')

@section('showcase')
    <span class="auth-showcase__tag">GoalPass Admin</span>
    <h1>Manage your ticket store</h1>
    <p>Add matches, set prices, and track ticket sales for World Cup 2026.</p>
    <ul class="auth-showcase__list">
        <li><span>📋</span> Publish match schedule</li>
        <li><span>💰</span> Control ticket pricing</li>
        <li><span>📊</span> View sales dashboard</li>
    </ul>
    <div class="auth-showcase__art" style="background:linear-gradient(135deg,#0f172a,#1e3a8a,#4338ca);">Admin<br>Panel</div>
@endsection

@section('content')
    <h2>Admin sign in</h2>
    <p class="auth-card__lead">Manage World Cup matches and ticket prices.</p>

    <form method="post" action="{{ route('admin.login') }}">
        @csrf

        <label for="email">Admin email</label>
        <input id="email" type="email" name="email" value="{{ old('email', 'admin@goalpass.local') }}" required autofocus autocomplete="email" />

        <x-password-input id="password" name="password" label="Password" required autocomplete="current-password" />

        <label class="check">
            <input type="checkbox" name="remember" value="1" />
            Remember me
        </label>

        <button class="btn" type="submit">Sign in to admin</button>
    </form>

    <div class="row">
        <a class="link" href="{{ route('login') }}">User sign in</a>
        <a class="link" href="/">← Back to homepage</a>
    </div>
@endsection
