<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — GoalPass</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @include('partials.auth-styles')
    @stack('styles')
    <style>body { font-family: Inter, system-ui, sans-serif; margin: 0; }</style>
</head>
<body class="auth-page">
    @include('partials.toasts')

    <header class="auth-header">
        <div class="auth-header__inner">
            <a href="/" class="auth-header__brand">GOALPASS</a>
            <nav class="auth-header__links" aria-label="Auth navigation">
                <a href="/#schedule">Browse matches</a>
                @if (request()->routeIs('login'))
                    <a href="{{ route('register', request()->only('redirect')) }}" class="is-active">Sign up</a>
                @elseif (request()->routeIs('register'))
                    <a href="{{ route('login', request()->only('redirect')) }}" class="is-active">Sign in</a>
                @else
                    <a href="{{ route('login') }}">Sign in</a>
                @endif
            </nav>
        </div>
    </header>

    <main class="auth-shell">
        <section class="auth-showcase" aria-hidden="true">
            @yield('showcase')
        </section>

        <div class="auth-card">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
