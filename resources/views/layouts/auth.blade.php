<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — GoalPass</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @include('partials.auth-styles')
    @stack('styles')
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; margin: 0; }</style>
</head>
<body class="auth-page">
    @include('partials.toasts')

    <div class="auth-shell">
        <aside class="auth-hero" aria-hidden="true">
            <div class="auth-hero__pitch"></div>
            <div class="auth-hero__content">
                <a href="/" class="auth-hero__brand">GOALPASS</a>
                <div class="auth-hero__badge">FIFA World Cup 2026</div>
                <h2 class="auth-hero__title">Your seat to<br>every big match.</h2>
                <p class="auth-hero__text">Buy official-style World Cup tickets, track orders, and get match-day ready — all in one place.</p>
                <ul class="auth-hero__stats">
                    <li><strong>48</strong><span>teams</span></li>
                    <li><strong>104</strong><span>matches</span></li>
                    <li><strong>3</strong><span>host nations</span></li>
                </ul>
                <div class="auth-hero__hosts">
                    <span>🇺🇸 USA</span>
                    <span>🇲🇽 Mexico</span>
                    <span>🇨🇦 Canada</span>
                </div>
            </div>
            <div class="auth-hero__ball" aria-hidden="true">⚽</div>
        </aside>

        <div class="auth-panel">
            <header class="auth-header">
                <div class="auth-header__inner">
                    <a href="/" class="auth-header__brand auth-header__brand--mobile">GOALPASS</a>
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
        </div>
    </div>

    @include('partials.auth-validation')
    @stack('scripts')
    @include('partials.submit-loader')
</body>
</html>
