<footer class="site-footer">
    <div class="site-footer__inner">
        <div class="site-footer__brand">GOALPASS</div>
        <nav class="site-footer__links" aria-label="Footer">
            <a href="#">{{ __('site.footer.about') }}</a>
            <a href="#">{{ __('site.footer.help') }}</a>
            <a href="#">{{ __('site.footer.privacy') }}</a>
            <a href="#">{{ __('site.footer.terms') }}</a>
            <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('admin.login') }}">{{ __('site.footer.admin') }}</a>
        </nav>
        <p class="site-footer__copy">{{ __('site.footer.copy', ['year' => date('Y')]) }}</p>
    </div>
</footer>
