<style>
    .auth-page,
    .auth-page *,
    .auth-page *::before,
    .auth-page *::after {
        box-sizing: border-box;
    }

    .auth-page {
        min-height: 100vh;
        background:
            radial-gradient(circle at 15% 0%, rgba(255,255,255,.04), transparent 35%),
            linear-gradient(180deg, #121212 0%, #0e0e0f 100%);
        color: #fff;
    }

    .auth-header {
        position: sticky; top: 0; z-index: 50;
        background: rgba(14,14,15,.97);
        border-bottom: 1px solid rgba(255,255,255,.08);
        backdrop-filter: blur(10px);
    }
    .auth-header__inner {
        max-width: 1180px; margin: 0 auto; padding: 12px 24px;
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
    }
    .auth-header__brand { font-size: 17px; font-weight: 900; letter-spacing: .06em; color: #fff; }
    .auth-header__link {
        font-size: 13px; font-weight: 600; color: rgba(255,255,255,.75);
        padding: 8px 14px; border-radius: 999px;
        border: 1px solid rgba(255,255,255,.14); background: rgba(255,255,255,.06);
        transition: background .15s ease, color .15s ease;
    }
    .auth-header__link:hover { color: #fff; background: rgba(255,255,255,.1); }

    .auth-main {
        display: flex; align-items: center; justify-content: center;
        padding: 48px 20px 64px;
        min-height: calc(100vh - 58px);
    }
    .auth-wrap { width: 100%; max-width: 440px; }
    .auth-wrap--register { max-width: 480px; }

    .auth-card {
        background: #fff; color: #181818; border-radius: 24px;
        box-shadow: 0 24px 64px rgba(0,0,0,.45);
        padding: 36px 32px 30px;
        width: 100%;
        overflow: hidden;
    }
    .auth-card--wide { max-width: 480px; }

    .auth-card__eyebrow {
        text-align: center; font-size: 11px; font-weight: 800; letter-spacing: .1em;
        text-transform: uppercase; color: #2563eb; margin-bottom: 10px;
    }
    .auth-card h1 {
        margin: 0 0 8px; text-align: center; font-size: 28px; font-weight: 800;
        letter-spacing: -.03em; color: #111;
    }
    .auth-card__lead {
        margin: 0 0 24px; text-align: center; color: #676767;
        font-size: 14px; line-height: 1.55;
    }

    .auth-tabs {
        display: grid; grid-template-columns: 1fr 1fr; gap: 6px;
        padding: 5px; margin-bottom: 28px; border-radius: 14px; background: #f3f4f6;
    }
    .auth-tabs a {
        display: block; text-align: center; padding: 11px 12px; border-radius: 10px;
        font-size: 14px; font-weight: 700; color: #6b7280; transition: all .15s ease;
    }
    .auth-tabs a:hover { color: #111; }
    .auth-tabs a.is-active {
        background: #fff; color: #111;
        box-shadow: 0 2px 8px rgba(15,23,42,.08);
    }

    .auth-field { margin-bottom: 16px; width: 100%; min-width: 0; }
    .auth-field label {
        display: block; font-size: 12px; font-weight: 700; letter-spacing: .03em;
        text-transform: uppercase; color: #6b7280; margin-bottom: 8px;
    }
    .auth-field input:not([type="checkbox"]) {
        display: block; width: 100%; max-width: 100%; padding: 13px 14px; border: 1px solid #e5e7eb; border-radius: 12px;
        font: inherit; font-size: 15px; background: #fff; color: #111;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .auth-field input:not([type="checkbox"]):focus {
        outline: none; border-color: #111; box-shadow: 0 0 0 3px rgba(17,17,17,.08);
    }
    .auth-field.has-error input:not([type="checkbox"]) {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220,38,38,.1);
    }
    .auth-field__error {
        margin: 8px 0 0; font-size: 13px; font-weight: 600; color: #dc2626; line-height: 1.4;
    }

    .auth-card .password-field.has-error .password-field__wrap input {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220,38,38,.1);
    }
    .auth-card .phone-field.has-error .phone-field__input,
    .auth-card .phone-field.has-error .phone-field__country-btn {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220,38,38,.1);
    }

    .auth-card .password-field { margin-bottom: 16px; width: 100%; min-width: 0; }
    .auth-card .password-field label {
        display: block; font-size: 12px; font-weight: 700; letter-spacing: .03em;
        text-transform: uppercase; color: #6b7280; margin-bottom: 8px;
    }
    .auth-card .password-field__wrap { position: relative; width: 100%; min-width: 0; }
    .auth-card .password-field__wrap input {
        display: block; width: 100%; max-width: 100%; padding: 13px 44px 13px 14px;
        border: 1px solid #e5e7eb; border-radius: 12px;
        font: inherit; font-size: 15px; margin-bottom: 0; background: #fff;
    }
    .auth-card .password-field__wrap input:focus {
        outline: none; border-color: #111; box-shadow: 0 0 0 3px rgba(17,17,17,.08);
    }
    .auth-card .password-field__toggle {
        position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
        width: 34px; height: 34px; border: 0; border-radius: 8px;
        background: transparent; color: #9ca3af; cursor: pointer;
        display: grid; place-items: center;
    }
    .auth-card .password-field__toggle:hover { background: #f3f4f6; color: #374151; }
    .auth-card .password-field__icon--hide { display: none; }
    .auth-card .password-field__toggle.is-visible .password-field__icon--show { display: none; }
    .auth-card .password-field__toggle.is-visible .password-field__icon--hide { display: block; }

    .auth-check {
        display: flex; align-items: center; gap: 10px; margin: 4px 0 20px;
        font-size: 14px; color: #4b5563; font-weight: 500;
    }
    .auth-check input { width: 16px; height: 16px; accent-color: #111; margin: 0; }

    .auth-card form { width: 100%; min-width: 0; }

    .auth-btn {
        display: block; width: 100%; max-width: 100%; border: 0; border-radius: 999px; padding: 15px 20px;
        background: #181818; color: #fff; font-weight: 800; font-size: 15px;
        cursor: pointer; transition: background .15s ease, transform .15s ease;
    }
    .auth-btn:hover { background: #333; transform: translateY(-1px); }

    .auth-trust {
        margin-top: 16px; text-align: center; font-size: 12px; font-weight: 600; color: #9ca3af;
    }

    .auth-foot {
        display: flex; justify-content: center; margin-top: 20px;
    }
    .auth-foot a {
        font-size: 14px; font-weight: 600; color: rgba(255,255,255,.7);
        transition: color .15s ease;
    }
    .auth-foot a:hover { color: #fff; }

    .auth-card .phone-field { margin-bottom: 16px; width: 100%; min-width: 0; }
    .auth-card .phone-field label {
        display: block; font-size: 12px; font-weight: 700; letter-spacing: .03em;
        text-transform: uppercase; color: #6b7280; margin-bottom: 8px;
    }
    .auth-card .phone-field__row { display: flex; gap: 10px; width: 100%; min-width: 0; }
    .auth-card .phone-field__country { position: relative; flex: 0 0 112px; min-width: 0; }
    .auth-card .phone-field__country-btn {
        width: 100%; height: 100%; min-height: 48px;
        display: flex; align-items: center; gap: 6px; padding: 0 10px;
        border: 1px solid #e5e7eb; border-radius: 12px; background: #fff; cursor: pointer; font: inherit;
    }
    .auth-card .phone-field__flag,
    .auth-card .phone-field__option-flag {
        width: 22px; height: 16px; object-fit: cover; border-radius: 2px;
        flex-shrink: 0; display: block;
    }
    .auth-card .phone-field__dial { font-size: 14px; font-weight: 700; }
    .auth-card .phone-field__caret { margin-left: auto; color: #9ca3af; font-size: 11px; }
    .auth-card .phone-field__input {
        flex: 1; min-width: 0; width: 100%; max-width: 100%;
        padding: 13px 14px; border: 1px solid #e5e7eb; border-radius: 12px;
        font: inherit; font-size: 15px; margin-bottom: 0;
    }
    .auth-card .phone-field__input:focus {
        outline: none; border-color: #111; box-shadow: 0 0 0 3px rgba(17,17,17,.08);
    }
    .auth-card .phone-field__dropdown {
        position: absolute; top: calc(100% + 6px); left: 0; z-index: 30; width: 280px; max-height: 220px;
        overflow: auto; margin: 0; padding: 6px; list-style: none; background: #fff;
        border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 16px 40px rgba(0,0,0,.12);
    }
    .auth-card .phone-field__option {
        width: 100%; display: flex; align-items: center; gap: 8px; padding: 10px;
        border: 0; background: transparent; border-radius: 8px; cursor: pointer; text-align: left; font: inherit;
    }
    .auth-card .phone-field__option:hover, .auth-card .phone-field__option.is-selected { background: #f3f4f6; }
    .auth-card .phone-field__option-dial { font-weight: 700; min-width: 40px; }
    .auth-card .phone-field__option-name { color: #6b7280; font-size: 13px; }

    @media (max-width: 520px) {
        .auth-main { padding: 28px 16px 40px; }
        .auth-card { padding: 28px 22px 24px; border-radius: 20px; }
        .auth-header__inner { padding: 12px 16px; }
    }
</style>
