<style>
    .auth-page,
    .auth-page *,
    .auth-page *::before,
    .auth-page *::after {
        box-sizing: border-box;
    }

    .auth-page {
        min-height: 100vh;
        background: #0a120e;
        color: #fff;
    }

    .auth-shell {
        display: grid;
        grid-template-columns: minmax(300px, 1fr) minmax(340px, 520px);
        min-height: 100vh;
    }

    /* Football hero panel */
    .auth-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(ellipse 90% 70% at 20% 0%, rgba(34, 197, 94, .35), transparent 55%),
            radial-gradient(ellipse 60% 50% at 100% 100%, rgba(234, 179, 8, .12), transparent 50%),
            linear-gradient(165deg, #0b3d22 0%, #14532d 38%, #0a1f14 100%);
        padding: 40px 44px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-hero__pitch {
        position: absolute;
        inset: 0;
        opacity: .22;
        background:
            repeating-linear-gradient(
                90deg,
                transparent,
                transparent 48px,
                rgba(255, 255, 255, .07) 48px,
                rgba(255, 255, 255, .07) 96px
            ),
            linear-gradient(0deg, transparent 48%, rgba(255,255,255,.12) 48%, rgba(255,255,255,.12) 52%, transparent 52%);
        pointer-events: none;
    }

    .auth-hero__content {
        position: relative;
        z-index: 2;
        max-width: 420px;
    }

    .auth-hero__brand {
        display: inline-block;
        font-size: 15px;
        font-weight: 900;
        letter-spacing: .14em;
        color: #fff;
        margin-bottom: 28px;
        text-decoration: none;
    }

    .auth-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(0, 0, 0, .25);
        border: 1px solid rgba(255, 255, 255, .2);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #fde68a;
        margin-bottom: 20px;
    }

    .auth-hero__badge::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 10px #22c55e;
    }

    .auth-hero__title {
        margin: 0 0 16px;
        font-size: clamp(32px, 4vw, 46px);
        font-weight: 900;
        line-height: 1.05;
        letter-spacing: -.03em;
        color: #fff;
    }

    .auth-hero__text {
        margin: 0 0 28px;
        font-size: 15px;
        line-height: 1.65;
        color: rgba(255, 255, 255, .78);
        font-weight: 500;
    }

    .auth-hero__stats {
        display: flex;
        gap: 12px;
        list-style: none;
        margin: 0 0 24px;
        padding: 0;
        flex-wrap: wrap;
    }

    .auth-hero__stats li {
        flex: 1;
        min-width: 88px;
        padding: 14px 12px;
        border-radius: 16px;
        background: rgba(0, 0, 0, .22);
        border: 1px solid rgba(255, 255, 255, .12);
        text-align: center;
    }

    .auth-hero__stats strong {
        display: block;
        font-size: 22px;
        font-weight: 900;
        color: #fff;
        line-height: 1.1;
    }

    .auth-hero__stats span {
        display: block;
        margin-top: 4px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: rgba(255, 255, 255, .55);
    }

    .auth-hero__hosts {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        font-size: 13px;
        font-weight: 700;
        color: rgba(255, 255, 255, .85);
    }

    .auth-hero__hosts span {
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .12);
    }

    .auth-hero__ball {
        position: absolute;
        right: -20px;
        bottom: -30px;
        font-size: clamp(120px, 18vw, 200px);
        opacity: .12;
        transform: rotate(-18deg);
        pointer-events: none;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,.4));
    }

    /* Form panel */
    .auth-panel {
        display: flex;
        flex-direction: column;
        background:
            radial-gradient(circle at 50% 0%, rgba(34, 197, 94, .08), transparent 45%),
            linear-gradient(180deg, #111827 0%, #0a0f0d 100%);
        border-inline-start: 1px solid rgba(255, 255, 255, .06);
    }

    .auth-header {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(10, 15, 13, .92);
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        backdrop-filter: blur(12px);
    }

    .auth-header__inner {
        padding: 14px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .auth-header__brand--mobile {
        display: none;
        font-size: 15px;
        font-weight: 900;
        letter-spacing: .1em;
        color: #fff;
        text-decoration: none;
    }

    .auth-header__link {
        font-size: 13px;
        font-weight: 700;
        color: rgba(255, 255, 255, .8);
        padding: 9px 16px;
        border-radius: 999px;
        border: 1px solid rgba(34, 197, 94, .35);
        background: rgba(34, 197, 94, .1);
        transition: background .15s ease, border-color .15s ease, color .15s ease;
        text-decoration: none;
    }

    .auth-header__link:hover {
        color: #fff;
        background: rgba(34, 197, 94, .2);
        border-color: rgba(34, 197, 94, .55);
    }

    .auth-main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px 24px 48px;
    }

    .auth-wrap { width: 100%; max-width: 420px; }
    .auth-wrap--register { max-width: 440px; }

    .auth-card {
        position: relative;
        background: rgba(255, 255, 255, .97);
        color: #111827;
        border-radius: 24px;
        box-shadow:
            0 0 0 1px rgba(255, 255, 255, .08),
            0 24px 64px rgba(0, 0, 0, .45),
            0 0 80px rgba(34, 197, 94, .08);
        padding: 32px 28px 28px;
        width: 100%;
        overflow: hidden;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #15803d, #22c55e 45%, #eab308);
    }

    .auth-card--wide { max-width: 440px; }

    .auth-card__icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 16px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        font-size: 26px;
        background: linear-gradient(145deg, #ecfdf5, #d1fae5);
        border: 1px solid #a7f3d0;
        box-shadow: 0 8px 20px rgba(34, 197, 94, .15);
    }

    .auth-card__eyebrow {
        text-align: center;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #15803d;
        margin-bottom: 8px;
    }

    .auth-card h1 {
        margin: 0 0 8px;
        text-align: center;
        font-size: 26px;
        font-weight: 900;
        letter-spacing: -.03em;
        color: #0f172a;
    }

    .auth-card__lead {
        margin: 0 0 22px;
        text-align: center;
        color: #64748b;
        font-size: 14px;
        line-height: 1.55;
        font-weight: 500;
    }

    .auth-tabs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        padding: 5px;
        margin-bottom: 24px;
        border-radius: 14px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
    }

    .auth-tabs a {
        display: block;
        text-align: center;
        padding: 11px 12px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        color: #64748b;
        transition: all .15s ease;
        text-decoration: none;
    }

    .auth-tabs a:hover { color: #0f172a; }

    .auth-tabs a.is-active {
        background: #fff;
        color: #15803d;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .08);
    }

    .auth-field { margin-bottom: 16px; width: 100%; min-width: 0; }

    .auth-field label,
    .auth-card .password-field label,
    .auth-card .phone-field label {
        display: block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 8px;
    }

    .auth-field input:not([type="checkbox"]) {
        display: block;
        width: 100%;
        max-width: 100%;
        padding: 13px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font: inherit;
        font-size: 15px;
        background: #f8fafc;
        color: #0f172a;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }

    .auth-field input:not([type="checkbox"]):focus {
        outline: none;
        border-color: #22c55e;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, .15);
    }

    .auth-field.has-error input:not([type="checkbox"]) {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .1);
    }

    .auth-field__error {
        margin: 8px 0 0;
        font-size: 13px;
        font-weight: 600;
        color: #dc2626;
        line-height: 1.4;
    }

    .auth-card .password-field.has-error .password-field__wrap input,
    .auth-card .phone-field.has-error .phone-field__input,
    .auth-card .phone-field.has-error .phone-field__country-btn {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .1);
    }

    .auth-card .password-field { margin-bottom: 16px; width: 100%; min-width: 0; }

    .auth-card .password-field__wrap { position: relative; width: 100%; min-width: 0; }

    .auth-card .password-field__wrap input {
        display: block;
        width: 100%;
        max-width: 100%;
        padding: 13px 44px 13px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font: inherit;
        font-size: 15px;
        margin-bottom: 0;
        background: #f8fafc;
        color: #0f172a;
    }

    .auth-card .password-field__wrap input:focus {
        outline: none;
        border-color: #22c55e;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, .15);
    }

    .auth-card .password-field__toggle {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #94a3b8;
        cursor: pointer;
        display: grid;
        place-items: center;
    }

    .auth-card .password-field__toggle:hover { background: #f1f5f9; color: #475569; }
    .auth-card .password-field__icon--hide { display: none; }
    .auth-card .password-field__toggle.is-visible .password-field__icon--show { display: none; }
    .auth-card .password-field__toggle.is-visible .password-field__icon--hide { display: block; }

    .auth-check {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 4px 0 20px;
        font-size: 14px;
        color: #475569;
        font-weight: 500;
    }

    .auth-check input { width: 16px; height: 16px; accent-color: #16a34a; margin: 0; }

    .auth-card form { width: 100%; min-width: 0; }

    .auth-btn {
        display: block;
        width: 100%;
        max-width: 100%;
        border: 0;
        border-radius: 999px;
        padding: 15px 20px;
        background: linear-gradient(135deg, #15803d 0%, #22c55e 55%, #16a34a 100%);
        color: #fff;
        font-weight: 800;
        font-size: 15px;
        cursor: pointer;
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
        box-shadow: 0 10px 28px rgba(34, 197, 94, .35);
    }

    .auth-btn:hover {
        transform: translateY(-1px);
        filter: brightness(1.05);
        box-shadow: 0 14px 32px rgba(34, 197, 94, .4);
    }

    .auth-trust {
        margin-top: 16px;
        text-align: center;
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
        line-height: 1.5;
    }

    .auth-trust a {
        color: #15803d;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-trust a:hover { text-decoration: underline; }

    .auth-foot {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .auth-foot a {
        font-size: 14px;
        font-weight: 600;
        color: rgba(255, 255, 255, .65);
        transition: color .15s ease;
        text-decoration: none;
    }

    .auth-foot a:hover { color: #86efac; }

    .auth-card .phone-field { margin-bottom: 16px; width: 100%; min-width: 0; }

    .auth-card .phone-field__row { display: flex; gap: 10px; width: 100%; min-width: 0; }
    .auth-card .phone-field__country { position: relative; flex: 0 0 112px; min-width: 0; }

    .auth-card .phone-field__country-btn {
        width: 100%;
        height: 100%;
        min-height: 48px;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0 10px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        cursor: pointer;
        font: inherit;
    }

    .auth-card .phone-field__flag,
    .auth-card .phone-field__option-flag {
        width: 22px;
        height: 16px;
        object-fit: cover;
        border-radius: 2px;
        flex-shrink: 0;
        display: block;
    }

    .auth-card .phone-field__dial { font-size: 14px; font-weight: 700; }
    .auth-card .phone-field__caret { margin-left: auto; color: #94a3b8; font-size: 11px; }

    .auth-card .phone-field__input {
        flex: 1;
        min-width: 0;
        width: 100%;
        max-width: 100%;
        padding: 13px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font: inherit;
        font-size: 15px;
        margin-bottom: 0;
        background: #f8fafc;
    }

    .auth-card .phone-field__input:focus {
        outline: none;
        border-color: #22c55e;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, .15);
    }

    .auth-card .phone-field__dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        z-index: 30;
        width: 280px;
        max-height: 220px;
        overflow: auto;
        margin: 0;
        padding: 6px;
        list-style: none;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, .12);
    }

    .auth-card .phone-field__option {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px;
        border: 0;
        background: transparent;
        border-radius: 8px;
        cursor: pointer;
        text-align: left;
        font: inherit;
    }

    .auth-card .phone-field__option:hover,
    .auth-card .phone-field__option.is-selected { background: #f0fdf4; }

    .auth-card .phone-field__option-dial { font-weight: 700; min-width: 40px; }
    .auth-card .phone-field__option-name { color: #64748b; font-size: 13px; }

    @media (max-width: 960px) {
        .auth-shell { grid-template-columns: 1fr; }
        .auth-hero { display: none; }
        .auth-header__brand--mobile { display: block; }
        .auth-panel { border-inline-start: 0; }
    }

    @media (max-width: 520px) {
        .auth-main { padding: 24px 16px 36px; }
        .auth-card { padding: 26px 20px 22px; border-radius: 20px; }
        .auth-header__inner { padding: 12px 16px; }
    }
</style>
