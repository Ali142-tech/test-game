@php
    $toasts = collect();

    if (session('toast')) {
        $sessionToast = session('toast');
        $toasts = $toasts->merge(isset($sessionToast['type']) ? [$sessionToast] : $sessionToast);
    }

    if (session('status')) {
        $toasts->push(['type' => 'success', 'title' => 'Done', 'message' => session('status')]);
    }

    if (session('success')) {
        $toasts->push(['type' => 'success', 'title' => 'Success', 'message' => session('success')]);
    }

    if (session('error')) {
        $toasts->push(['type' => 'error', 'title' => 'Error', 'message' => session('error')]);
    }

    if (session('warning')) {
        $toasts->push(['type' => 'warning', 'title' => 'Warning', 'message' => session('warning')]);
    }

    if (isset($errors) && $errors->any()) {
        $toasts->push([
            'type' => 'error',
            'title' => 'Please check your details',
            'message' => $errors->first(),
        ]);
    }

    $icons = [
        'success' => '✓',
        'error' => '!',
        'warning' => '⚠',
        'info' => 'i',
    ];
@endphp

@if ($toasts->isNotEmpty())
    @once
        <style>
            .toast-stack {
                position: fixed; top: 18px; right: 18px; z-index: 9999;
                display: grid; gap: 10px; width: min(380px, calc(100vw - 36px));
                pointer-events: none;
            }
            html[dir="rtl"] .toast-stack { right: auto; left: 18px; }
            .toast {
                pointer-events: auto; display: grid; grid-template-columns: auto 1fr auto; gap: 12px;
                align-items: start; padding: 14px 14px 18px; border-radius: 16px;
                background: #fff; border: 1px solid rgba(15,23,42,.08);
                box-shadow: 0 18px 40px rgba(15,23,42,.16), 0 4px 12px rgba(15,23,42,.08);
                transform: translateX(120%); opacity: 0;
                animation: toast-in .45s cubic-bezier(.22,1,.36,1) forwards;
                position: relative; overflow: hidden;
            }
            html[dir="rtl"] .toast { transform: translateX(-120%); }
            @keyframes toast-in {
                to { transform: translateX(0); opacity: 1; }
            }
            .toast.is-leaving {
                animation: toast-out .3s ease forwards;
            }
            @keyframes toast-out {
                to { transform: translateX(120%); opacity: 0; }
            }
            html[dir="rtl"] .toast.is-leaving { animation-name: toast-out-rtl; }
            @keyframes toast-out-rtl {
                to { transform: translateX(-120%); opacity: 0; }
            }
            .toast__icon {
                width: 36px; height: 36px; border-radius: 12px; display: grid; place-items: center;
                font-size: 16px; font-weight: 900; flex-shrink: 0;
            }
            .toast--success .toast__icon { background: #ecfdf5; color: #059669; }
            .toast--error .toast__icon { background: #fef2f2; color: #dc2626; }
            .toast--warning .toast__icon { background: #fffbeb; color: #d97706; }
            .toast--info .toast__icon { background: #eff6ff; color: #2563eb; }
            .toast__title { font-size: 14px; font-weight: 800; color: #111827; margin-bottom: 3px; letter-spacing: -.01em; }
            .toast__message { font-size: 13px; color: #4b5563; line-height: 1.45; font-weight: 500; }
            .toast__close {
                border: 0; background: transparent; color: #9ca3af; cursor: pointer;
                width: 28px; height: 28px; border-radius: 8px; font-size: 18px; line-height: 1;
                transition: background .15s ease, color .15s ease;
            }
            .toast__close:hover { background: #f3f4f6; color: #374151; }
            .toast__bar {
                position: absolute; left: 0; bottom: 0; height: 3px; width: 100%;
                transform-origin: left; animation: toast-bar 5s linear forwards;
            }
            html[dir="rtl"] .toast__bar { transform-origin: right; }
            @keyframes toast-bar { from { transform: scaleX(1); } to { transform: scaleX(0); } }
            .toast--success .toast__bar { background: #10b981; }
            .toast--error .toast__bar { background: #ef4444; }
            .toast--warning .toast__bar { background: #f59e0b; }
            .toast--info .toast__bar { background: #3b82f6; }
            @media (max-width: 520px) {
                .toast-stack { top: 12px; right: 12px; left: 12px; width: auto; }
                html[dir="rtl"] .toast-stack { left: 12px; right: 12px; }
            }
        </style>
        <script>
        (() => {
            const dismiss = (toast) => {
                if (!toast || toast.classList.contains('is-leaving')) return;
                toast.classList.add('is-leaving');
                setTimeout(() => toast.remove(), 300);
            };

            document.querySelectorAll('[data-toast]').forEach((toast) => {
                const close = toast.querySelector('[data-toast-close]');
                close?.addEventListener('click', () => dismiss(toast));
                setTimeout(() => dismiss(toast), 5200);
            });
        })();
        </script>
    @endonce

    <div class="toast-stack" aria-live="polite" aria-atomic="true">
        @foreach ($toasts as $toast)
            @php $type = $toast['type'] ?? 'info'; @endphp
            <div class="toast toast--{{ $type }}" data-toast role="alert">
                <div class="toast__icon" aria-hidden="true">{{ $icons[$type] ?? 'i' }}</div>
                <div>
                    <div class="toast__title">{{ $toast['title'] ?? 'Notification' }}</div>
                    <div class="toast__message">{{ $toast['message'] ?? '' }}</div>
                </div>
                <button type="button" class="toast__close" data-toast-close aria-label="Dismiss">×</button>
                <span class="toast__bar" aria-hidden="true"></span>
            </div>
        @endforeach
    </div>
@endif
