@once
    @push('scripts')
        <script>
        (() => {
            const messages = @json(__('auth.validation'));

            const msg = (key, replacements = {}) => {
                let text = messages[key] || 'Please check this field.';
                Object.entries(replacements).forEach(([k, v]) => {
                    text = text.replace(`:${k}`, String(v));
                });
                return text;
            };

            const validators = {
                name(value) {
                    const v = value.trim();
                    if (!v) return msg('name.required');
                    if (v.length < 2) return msg('name.min', { min: 2 });
                    if (v.length > 120) return msg('name.max', { max: 120 });
                    if (!/^[\p{L}\s'\-.]+$/u.test(v)) return msg('name.regex');
                    return null;
                },
                email(value) {
                    const v = value.trim();
                    if (!v) return msg('email.required');
                    if (v.length > 255) return msg('email.max', { max: 255 });
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return msg('email.email');
                    return null;
                },
                phone(value) {
                    const v = value.trim();
                    if (!v) return msg('phone.required');
                    if (!/^[0-9\s\-()]+$/.test(v)) return msg('phone.regex');
                    const digits = v.replace(/\D/g, '');
                    if (digits.length < 7 || digits.length > 15) return msg('phone.regex');
                    return null;
                },
                password(value, formType) {
                    if (!value) return msg('password.required');
                    if (formType === 'register' && value.length < 8) return msg('password.min', { min: 8 });
                    return null;
                },
                password_confirmation(value, form) {
                    const password = form.querySelector('[name="password"]')?.value ?? '';
                    if (!value) return msg('password.confirmed');
                    if (value !== password) return msg('password.confirmed');
                    return null;
                },
            };

            const formFields = {
                login: ['email', 'password'],
                register: ['name', 'email', 'phone', 'password', 'password_confirmation'],
            };

            const getFieldGroup = (form, fieldName) => {
                if (['phone', 'phone_country', 'phone_dial_code'].includes(fieldName)) {
                    return form.querySelector('[data-phone-field]');
                }
                const input = form.querySelector(`[name="${fieldName}"]`);
                return input?.closest('.auth-field, .password-field') ?? null;
            };

            const setFieldError = (form, fieldName, message) => {
                const group = getFieldGroup(form, fieldName);
                if (!group) return;

                group.classList.add('has-error');
                const input = fieldName === 'phone'
                    ? form.querySelector('[name="phone"]')
                    : form.querySelector(`[name="${fieldName}"]`);
                input?.setAttribute('aria-invalid', 'true');

                let errorEl = group.querySelector('.auth-field__error[data-js-error]');
                if (!errorEl) {
                    errorEl = document.createElement('p');
                    errorEl.className = 'auth-field__error';
                    errorEl.dataset.jsError = '1';
                    errorEl.setAttribute('role', 'alert');
                    group.appendChild(errorEl);
                }
                errorEl.textContent = message;
            };

            const clearFieldError = (form, fieldName) => {
                const group = getFieldGroup(form, fieldName);
                if (!group) return;

                group.classList.remove('has-error');
                const input = fieldName === 'phone'
                    ? form.querySelector('[name="phone"]')
                    : form.querySelector(`[name="${fieldName}"]`);
                input?.removeAttribute('aria-invalid');
                group.querySelectorAll('.auth-field__error').forEach((el) => el.remove());
            };

            const validateField = (fieldName, form, formType) => {
                if (fieldName === 'password_confirmation') {
                    const value = form.querySelector('[name="password_confirmation"]')?.value ?? '';
                    return validators.password_confirmation(value, form);
                }

                const input = form.querySelector(`[name="${fieldName}"]`);
                const value = input?.value ?? '';

                if (fieldName === 'password') return validators.password(value, formType);
                return validators[fieldName]?.(value) ?? null;
            };

            const validateForm = (form, formType) => {
                const fields = formFields[formType] || [];
                const errors = {};

                fields.forEach((fieldName) => {
                    const error = validateField(fieldName, form, formType);
                    if (error) errors[fieldName] = error;
                });

                return errors;
            };

            const applyErrors = (form, errors) => {
                const fields = formFields[form.dataset.authValidate] || [];
                fields.forEach((fieldName) => {
                    if (errors[fieldName]) {
                        setFieldError(form, fieldName, errors[fieldName]);
                    } else {
                        clearFieldError(form, fieldName);
                    }
                });
            };

            const bindForm = (form) => {
                const formType = form.dataset.authValidate;
                const fields = formFields[formType];
                if (!fields) return;

                if (form.querySelector('.has-error')) {
                    form.dataset.attempted = '1';
                }

                form.addEventListener('submit', (event) => {
                    form.dataset.attempted = '1';
                    const errors = validateForm(form, formType);
                    if (Object.keys(errors).length) {
                        event.preventDefault();
                        applyErrors(form, errors);
                    }
                });

                const revalidate = (fieldName) => {
                    if (!form.dataset.attempted) return;
                    const error = validateField(fieldName, form, formType);
                    if (error) {
                        setFieldError(form, fieldName, error);
                    } else {
                        clearFieldError(form, fieldName);
                    }
                };

                form.addEventListener('input', (event) => {
                    const name = event.target.name;
                    if (!fields.includes(name)) return;
                    revalidate(name);
                    if (name === 'password') {
                        revalidate('password_confirmation');
                    }
                });

                form.addEventListener('change', (event) => {
                    if (event.target.name === 'phone_country') {
                        revalidate('phone');
                    }
                });
            };

            const init = () => {
                document.querySelectorAll('[data-auth-validate]').forEach(bindForm);
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
        </script>
    @endpush
@endonce
