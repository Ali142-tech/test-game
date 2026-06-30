@props([
    'id',
    'name',
    'label',
])

<div class="password-field @error($name) has-error @enderror">
    <label for="{{ $id }}">{{ $label }}</label>
    <div class="password-field__wrap">
        <input
            id="{{ $id }}"
            type="password"
            name="{{ $name }}"
            @error($name) aria-invalid="true" @enderror
            {{ $attributes }}
        />
        <button type="button" class="password-field__toggle" data-password-toggle aria-label="Show password">
            <svg class="password-field__icon password-field__icon--show" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
            <svg class="password-field__icon password-field__icon--hide" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"></path>
                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
                <path d="M1 1l22 22"></path>
                <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path>
            </svg>
        </button>
    </div>
    <x-auth-error :field="$name" />
</div>

@once
    @push('scripts')
    <script>
    (() => {
        document.querySelectorAll('[data-password-toggle]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const input = btn.closest('.password-field__wrap')?.querySelector('input');
                if (!input) return;

                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.classList.toggle('is-visible', show);
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        });
    })();
    </script>
    @endpush
@endonce
