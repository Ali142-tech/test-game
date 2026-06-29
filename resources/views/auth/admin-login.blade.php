@extends('layouts.auth')

@section('title', 'Admin login')

@section('content')
<h1>Admin login</h1>
<p>Manage World Cup matches and ticket prices.</p>

@if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
@endif

<form method="post" action="{{ route('admin.login') }}">
    @csrf

    <label for="email">Admin email</label>
    <input id="email" type="email" name="email" value="{{ old('email', 'admin@goalpass.local') }}" required autofocus />

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required />

    <label class="check">
        <input type="checkbox" name="remember" value="1" />
        Remember me
    </label>

    <button class="btn" type="submit">Sign in to admin</button>
</form>

<div class="row">
    <a class="link" href="/">Back to site</a>
</div>
@endsection
