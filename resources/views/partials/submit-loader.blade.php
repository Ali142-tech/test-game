@once('submit-loader-styles')
    <style>
        .submit-spinner {
            display: inline-block;
            width: 1.05em;
            height: 1.05em;
            border: 2px solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: submit-spin .65s linear infinite;
            flex-shrink: 0;
        }
        @keyframes submit-spin { to { transform: rotate(360deg); } }

        .is-loading.auth-btn,
        .is-loading.checkout-pay-btn,
        .is-loading.btn,
        button.is-loading[type="submit"] {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: wait;
            opacity: 0.92;
            pointer-events: none;
        }
    </style>
@endonce

@once('submit-loader-scripts')
    <script>
    (() => {
        const activate = (button) => {
            if (!button || button.classList.contains('is-loading')) return;

            const text = button.dataset.loadingText || 'Please wait...';
            button.dataset.originalHtml = button.innerHTML;
            button.disabled = true;
            button.classList.add('is-loading');
            button.setAttribute('aria-busy', 'true');
            button.innerHTML = `<span class="submit-spinner" aria-hidden="true"></span><span>${text}</span>`;
        };

        const bindForms = () => {
            document.querySelectorAll('form').forEach((form) => {
                if (form.dataset.submitLoaderBound) return;
                form.dataset.submitLoaderBound = '1';

                form.addEventListener('submit', (event) => {
                    const button = event.submitter
                        || form.querySelector('button[type="submit"][data-loading-text], input[type="submit"][data-loading-text]');

                    if (!button?.dataset.loadingText) return;

                    window.setTimeout(() => {
                        if (event.defaultPrevented) return;
                        activate(button);
                    }, 0);
                });
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bindForms);
        } else {
            bindForms();
        }
    })();
    </script>
@endonce
