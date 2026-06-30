@extends('layouts.auth')

@section('title', 'Create account')

@section('content')
<h1>Create account</h1>
<p>Register to purchase World Cup tickets.</p>

<form method="post" action="{{ route('register') }}">
    @csrf
    @if ($redirect)
        <input type="hidden" name="redirect" value="{{ $redirect }}" />
    @endif

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus />

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required />

    <x-phone-input :countries="$countries" :selected-country="old('phone_country', 'US')" />

    <x-password-input id="password" name="password" label="Password" required />
    <x-password-input id="password_confirmation" name="password_confirmation" label="Confirm password" required />

    <button class="btn" type="submit">Create account</button>
</form>

<div class="row">
    <a class="link" href="{{ route('login', $redirect ? ['redirect' => $redirect] : []) }}">Already have an account?</a>
    <a class="link" href="/">Back to site</a>
</div>
@endsection
