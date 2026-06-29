@php
    $locale = app()->getLocale();
    $localeLabels = config('locales.labels', []);
    $currentLabel = $localeLabels[$locale] ?? strtoupper($locale);
    $dashboardUrl = auth()->check()
        ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard'))
        : route('login');
    $dashboardLabel = auth()->check()
        ? (auth()->user()->isAdmin() ? __('site.header.admin') : __('site.header.my_tickets'))
        : __('site.header.sign_in');
@endphp

<header class="site-header">
    <div class="site-header__inner">
        <a href="/" class="site-header__brand">GOALPASS</a>

        <div class="site-header__search" role="search">
            <span class="site-header__search-icon" aria-hidden="true">⌕</span>
            <span class="site-header__search-placeholder">{{ __('site.header.search_placeholder') }}</span>
        </div>

        <div class="site-header__actions">
            <div class="lang-dropdown">
                <button type="button" class="lang-dropdown__trigger" id="lang-trigger" aria-haspopup="listbox" aria-expanded="false">
                    <span class="lang-dropdown__current">{{ $currentLabel }}</span>
                    <span class="lang-dropdown__sep">|</span>
                    <span>{{ __('site.header.currency') }}</span>
                    <span class="lang-dropdown__caret" aria-hidden="true">▾</span>
                </button>
                <div class="lang-dropdown__menu" id="lang-menu" role="listbox" aria-label="{{ __('site.header.language') }}" hidden>
                    @foreach (config('locales.supported', ['en']) as $code)
                        <a
                            href="{{ route('locale.switch', $code) }}"
                            class="lang-dropdown__option {{ $locale === $code ? 'is-active' : '' }}"
                            role="option"
                            aria-selected="{{ $locale === $code ? 'true' : 'false' }}"
                        >
                            {{ $localeLabels[$code] ?? strtoupper($code) }}
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="#" class="site-header__link">{{ __('site.header.sell') }}</a>
            <a href="#" class="site-header__link">{{ __('site.header.support') }}</a>
            <a href="{{ $dashboardUrl }}" class="site-header__signin">{{ $dashboardLabel }}</a>
        </div>
    </div>
</header>

<script>
(() => {
    const trigger = document.getElementById('lang-trigger');
    const menu = document.getElementById('lang-menu');
    if (!trigger || !menu) return;

    const close = () => {
        menu.hidden = true;
        trigger.setAttribute('aria-expanded', 'false');
    };

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const open = menu.hidden;
        menu.hidden = !open;
        trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    document.addEventListener('click', close);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });
})();
</script>
