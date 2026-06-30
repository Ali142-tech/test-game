@props([
    'countries' => null,
    'selectedCountry' => null,
    'phone' => null,
])

@php
    use App\Support\TeamFlag;

    $countries = $countries ?? collect(require resource_path('data/countries.php'));
    $selectedCountry = old('phone_country', $selectedCountry ?? 'US');
    $phone = old('phone', $phone);
    $selected = $countries->firstWhere('code', $selectedCountry) ?? $countries->first();
    $flagWidth = 40;
@endphp

<div class="phone-field @if ($errors->has('phone') || $errors->has('phone_country') || $errors->has('phone_dial_code')) has-error @endif" data-phone-field>
    <label for="phone_country_btn">Phone number</label>
    <div class="phone-field__row">
        <div class="phone-field__country">
            <button
                type="button"
                class="phone-field__country-btn"
                id="phone_country_btn"
                aria-haspopup="listbox"
                aria-expanded="false"
                data-phone-country-btn
            >
                <img
                    class="phone-field__flag"
                    data-phone-flag
                    src="{{ TeamFlag::url($selected['code'], $flagWidth) }}"
                    alt=""
                    width="22"
                    height="16"
                    loading="lazy"
                />
                <span class="phone-field__dial" data-phone-dial>{{ $selected['dial'] }}</span>
                <span class="phone-field__caret" aria-hidden="true">▾</span>
            </button>
            <input type="hidden" name="phone_country" value="{{ $selectedCountry }}" data-phone-country-input />
            <input type="hidden" name="phone_dial_code" value="{{ old('phone_dial_code', $selected['dial']) }}" data-phone-dial-input />
            <ul class="phone-field__dropdown" role="listbox" hidden data-phone-dropdown>
                @foreach ($countries as $country)
                    <li>
                        <button
                            type="button"
                            role="option"
                            class="phone-field__option {{ $country['code'] === $selectedCountry ? 'is-selected' : '' }}"
                            data-code="{{ $country['code'] }}"
                            data-dial="{{ $country['dial'] }}"
                            data-flag-url="{{ TeamFlag::url($country['code'], $flagWidth) }}"
                        >
                            <img
                                class="phone-field__option-flag"
                                src="{{ TeamFlag::url($country['code'], $flagWidth) }}"
                                alt=""
                                width="22"
                                height="16"
                                loading="lazy"
                            />
                            <span class="phone-field__option-dial">{{ $country['dial'] }}</span>
                            <span class="phone-field__option-name">{{ $country['name'] }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
        <input
            id="phone"
            type="tel"
            name="phone"
            class="phone-field__input"
            value="{{ $phone }}"
            placeholder="Phone number"
            inputmode="tel"
            autocomplete="tel-national"
            @error('phone') aria-invalid="true" @enderror
        />
    </div>
    @if ($errors->has('phone_country') || $errors->has('phone_dial_code'))
        <x-auth-error field="phone_country" />
    @else
        <x-auth-error field="phone" />
    @endif
</div>

@once
    @push('scripts')
        <script>
        document.querySelectorAll('[data-phone-field]').forEach((field) => {
            const btn = field.querySelector('[data-phone-country-btn]');
            const dropdown = field.querySelector('[data-phone-dropdown]');
            const countryInput = field.querySelector('[data-phone-country-input]');
            const dialInput = field.querySelector('[data-phone-dial-input]');
            const flagEl = field.querySelector('[data-phone-flag]');
            const dialEl = field.querySelector('[data-phone-dial]');

            const close = () => {
                dropdown.hidden = true;
                btn.setAttribute('aria-expanded', 'false');
            };

            btn?.addEventListener('click', () => {
                const open = dropdown.hidden;
                dropdown.hidden = !open;
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });

            field.querySelectorAll('[data-code]').forEach((option) => {
                option.addEventListener('click', () => {
                    countryInput.value = option.dataset.code;
                    dialInput.value = option.dataset.dial;
                    if (flagEl && option.dataset.flagUrl) {
                        flagEl.src = option.dataset.flagUrl;
                    }
                    dialEl.textContent = option.dataset.dial;
                    field.querySelectorAll('.phone-field__option').forEach((el) => el.classList.remove('is-selected'));
                    option.classList.add('is-selected');
                    close();
                    countryInput.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });

            document.addEventListener('click', (event) => {
                if (!field.contains(event.target)) close();
            });
        });
        </script>
    @endpush
@endonce
