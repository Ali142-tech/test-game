@php
    $themeToggleId = $themeToggleId ?? 'themeToggle';
@endphp
<div class="shell-topbar">
    <div class="shell-topbar__spacer"></div>
    <button class="theme-switch" id="{{ $themeToggleId }}" type="button" aria-label="Toggle light and dark theme">
        <span class="theme-switch__track" aria-hidden="true">
            <span class="theme-switch__thumb"></span>
        </span>
        <span class="theme-switch__label" data-light="Light mode" data-dark="Dark mode">Light mode</span>
    </button>
</div>
<script>
    (function () {
        const btn = document.getElementById(@json($themeToggleId));
        const html = document.documentElement;
        const label = btn?.querySelector('.theme-switch__label');
        const apply = (theme) => {
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            if (btn) btn.setAttribute('data-theme', theme);
            if (label) label.textContent = theme === 'dark' ? label.dataset.dark : label.dataset.light;
        };
        apply(localStorage.getItem('theme') || 'light');
        btn?.addEventListener('click', () => {
            apply(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        });
    })();
</script>
