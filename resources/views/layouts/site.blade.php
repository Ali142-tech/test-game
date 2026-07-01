<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — GoalPass</title>
    <meta name="description" content="@yield('description', __('site.meta.description'))">
    @include('partials.site-styles')
    @stack('styles')
    <style>
        .site-page { background: #fff; color: #181818; padding: 32px 0 64px; min-height: 60vh; }
        .site-page__head { margin-bottom: 28px; max-width: 720px; }
        .site-page__back { display: inline-block; font-size: 14px; font-weight: 700; color: #2563eb; margin-bottom: 16px; text-decoration: none; }
        .site-page__back:hover { text-decoration: underline; }
        .site-page h1 { margin: 0 0 10px; font-size: clamp(28px, 4vw, 40px); font-weight: 900; letter-spacing: -.03em; }
        .site-page__lead { margin: 0; font-size: 16px; line-height: 1.6; color: #64748b; font-weight: 500; }
        .site-page__body { max-width: 720px; }
        .site-page__section { margin-bottom: 28px; }
        .site-page__section h2 { margin: 0 0 12px; font-size: 18px; font-weight: 800; }
        .site-page__section p { margin: 0 0 12px; line-height: 1.65; color: #334155; font-size: 15px; }
        .site-page__section ul { margin: 0 0 12px; padding-left: 20px; color: #334155; line-height: 1.65; }
        .site-page__cta { margin-top: 32px; }
        .btn--dark {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 12px 20px; border-radius: 999px; background: #111; color: #fff;
            font-weight: 800; font-size: 14px; text-decoration: none;
        }
        .btn--dark:hover { background: #333; }
    </style>
</head>
<body>
    @include('partials.toasts')
    <div class="site-dark">
        <x-site-header />
    </div>
    @yield('content')
    <x-site-footer />
    @stack('scripts')
    @include('partials.submit-loader')
</body>
</html>
