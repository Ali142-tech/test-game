@extends('layouts.auth')

@section('title', 'Sign in')

@section('content')
<h1>Sign in</h1>
<p>Log in to buy tickets and view your dashboard.</p>

<form method="post" action="{{ route('login') }}">
    @csrf
    @if ($redirect)
        <input type="hidden" name="redirect" value="{{ $redirect }}" />
    @endif

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />

    <x-password-input id="password" name="password" label="Password" required />

    <label class="check">
        <input type="checkbox" name="remember" value="1" />
        Remember me
    </label>

    <button class="btn" type="submit">Sign in</button>
</form>

<div class="row">
    <a class="link" href="{{ route('register', $redirect ? ['redirect' => $redirect] : []) }}">Create account</a>
    <a class="link" href="/">Back to site</a>
</div>
@endsection
