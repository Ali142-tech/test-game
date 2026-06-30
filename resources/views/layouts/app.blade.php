<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('site.meta.title'))</title>
    <meta name="description" content="@yield('description', __('site.meta.description'))">
    @include('partials.site-styles')
    @stack('styles')
</head>
<body>
    @include('partials.toasts')
    @yield('content')
    @stack('scripts')
    @include('partials.submit-loader')
</body>
</html>
