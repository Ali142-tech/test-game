<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — GoalPass</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('partials.auth-styles')
    @stack('styles')
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; margin: 0; }</style>
</head>
<body class="auth-page">
    @include('partials.toasts')

    <header class="auth-header">
        <div class="auth-header__inner">
            <a href="/" class="auth-header__brand">GOALPASS</a>
            <a href="/#schedule" class="auth-header__link">Browse matches</a>
        </div>
    </header>

    <main class="auth-main">
        <div class="auth-wrap @yield('wrap_class')">
            <div class="auth-card @yield('card_class')">
                @yield('content')
            </div>
            <div class="auth-foot">
                <a href="/">← Back to homepage</a>
            </div>
        </div>
    </main>

    @include('partials.auth-validation')
    @stack('scripts')
</body>
</html>
