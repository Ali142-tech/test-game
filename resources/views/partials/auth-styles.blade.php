<style>
    .auth-page {
        min-height: 100vh;
        background:
            radial-gradient(ellipse 70% 50% at 20% 0%, rgba(37, 99, 235, .22), transparent 55%),
            radial-gradient(ellipse 50% 40% at 90% 10%, rgba(16, 185, 129, .12), transparent 50%),
            linear-gradient(165deg, #0f172a 0%, #111827 40%, #0e0e0f 100%);
        color: #fff;
    }
    .auth-header {
        position: sticky; top: 0; z-index: 50;
        border-bottom: 1px solid rgba(255,255,255,.08);
        background: rgba(14,14,15,.92);
        backdrop-filter: blur(12px);
    }
    .auth-header__inner {
        max-width: 1100px; margin: 0 auto; padding: 14px 24px;
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
    }
    .auth-header__brand {
        font-size: 17px; font-weight: 900; letter-spacing: .06em; color: #fff;
    }
    .auth-header__links { display: flex; align-items: center; gap: 16px; font-size: 13px; font-weight: 600; }
    .auth-header__links a { color: rgba(255,255,255,.72); transition: color .15s ease; }
    .auth-header__links a:hover { color: #fff; }
    .auth-header__links a.is-active { color: #fff; }

    .auth-shell {
        max-width: 1100px; margin: 0 auto; padding: 40px 24px 56px;
        display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;
        min-height: calc(100vh - 65px);
    }
    .auth-showcase { padding: 12px 8px 12px 0; }
    .auth-showcase__tag {
        display: inline-flex; align-items: center; gap: 8px; padding: 7px 14px; border-radius: 999px;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
        font-size: 11px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: #93c5fd;
        margin-bottom: 18px;
    }
    .auth-showcase h1 {
        margin: 0 0 12px; font-size: clamp(30px, 4vw, 44px); line-height: 1.05; font-weight: 800; letter-spacing: -.03em;
    }
    .auth-showcase p { margin: 0 0 24px; color: rgba(255,255,255,.65); font-size: 16px; max-width: 420px; line-height: 1.6; }
    .auth-showcase__list { display: grid; gap: 12px; margin: 0; padding: 0; list-style: none; }
    .auth-showcase__list li {
        display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 600; color: rgba(255,255,255,.85);
    }
    .auth-showcase__list span {
        width: 32px; height: 32px; border-radius: 10px; display: grid; place-items: center;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.1); font-size: 14px;
    }
    .auth-showcase__art {
        margin-top: 28px; width: 100%; max-width: 360px; aspect-ratio: 1.15;
        border-radius: 20px; overflow: hidden;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 45%, #f59e0b 100%);
        box-shadow: 0 24px 60px rgba(37, 99, 235, .28);
        display: grid; place-items: center; text-align: center; padding: 20px;
        font-size: 28px; font-weight: 900; line-height: 1.15; letter-spacing: -.02em;
    }

    .auth-card {
        width: 100%; background: #fff; color: #181818; border-radius: 22px;
        border: 1px solid rgba(255,255,255,.12);
        box-shadow: 0 28px 60px rgba(0,0,0,.35);
        padding: 32px 30px 28px;
    }
    .auth-card h2 { margin: 0 0 6px; font-size: 26px; font-weight: 800; letter-spacing: -.02em; color: #111; }
    .auth-card .auth-card__lead { margin: 0 0 22px; color: #676767; font-size: 14px; line-height: 1.5; }
    .auth-card label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #181818; }
    .auth-card input:not([type="checkbox"]) {
        width: 100%; padding: 12px 14px; border: 1px solid #e8e8e8; border-radius: 12px;
        font: inherit; margin-bottom: 14px; background: #fafafa; color: #181818;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .auth-card input:not([type="checkbox"]):focus {
        outline: none; border-color: #2563eb; background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .auth-card .password-field { margin-bottom: 14px; }
    .auth-card .password-field label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; }
    .auth-card .password-field__wrap { position: relative; }
    .auth-card .password-field__wrap input { margin-bottom: 0; padding-right: 44px; }
    .auth-card .password-field__toggle {
        position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
        display: grid; place-items: center; width: 34px; height: 34px;
        border: 0; border-radius: 8px; background: transparent; color: #676767; cursor: pointer;
    }
    .auth-card .password-field__toggle:hover { color: #181818; background: #f0f0f0; }
    .auth-card .password-field__icon { display: block; }
    .auth-card .password-field__icon--hide { display: none; }
    .auth-card .password-field__toggle.is-visible .password-field__icon--show { display: none; }
    .auth-card .password-field__toggle.is-visible .password-field__icon--hide { display: block; }

    .auth-card .btn {
        width: 100%; border: 0; border-radius: 999px; padding: 14px 18px; margin-top: 4px;
        background: linear-gradient(135deg, #111827 0%, #2563eb 100%);
        color: #fff; font-weight: 800; font-size: 15px; cursor: pointer;
        box-shadow: 0 10px 28px rgba(37,99,235,.3); transition: transform .15s ease, box-shadow .15s ease;
    }
    .auth-card .btn:hover { transform: translateY(-1px); box-shadow: 0 14px 32px rgba(37,99,235,.35); }
    .auth-card .link { color: #2563eb; text-decoration: none; font-size: 14px; font-weight: 600; }
    .auth-card .link:hover { text-decoration: underline; }
    .auth-card .row {
        display: flex; justify-content: space-between; align-items: center; gap: 12px;
        margin-top: 18px; padding-top: 18px; border-top: 1px solid #f0f0f0;
    }
    .auth-card .check {
        display: flex; align-items: center; gap: 8px; margin-bottom: 14px;
        font-size: 14px; color: #4b5563; font-weight: 500;
    }
    .auth-card .check input { width: auto; margin: 0; accent-color: #2563eb; }

    .auth-card .phone-field { margin-bottom: 14px; }
    .auth-card .phone-field label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; }
    .auth-card .phone-field__row { display: flex; gap: 10px; }
    .auth-card .phone-field__country { position: relative; flex: 0 0 118px; }
    .auth-card .phone-field__country-btn {
        width: 100%; display: flex; align-items: center; gap: 6px; padding: 12px 10px;
        border: 1px solid #e8e8e8; border-radius: 12px; background: #fafafa; cursor: pointer; font: inherit;
    }
    .auth-card .phone-field__flag { font-size: 18px; line-height: 1; }
    .auth-card .phone-field__dial { font-size: 14px; font-weight: 700; color: #181818; }
    .auth-card .phone-field__caret { margin-left: auto; color: #676767; font-size: 12px; }
    .auth-card .phone-field__input {
        flex: 1; padding: 12px 14px; border: 1px solid #e8e8e8; border-radius: 12px;
        font: inherit; margin-bottom: 0; background: #fafafa;
    }
    .auth-card .phone-field__input:focus {
        outline: none; border-color: #2563eb; background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .auth-card .phone-field__dropdown {
        position: absolute; top: calc(100% + 6px); left: 0; z-index: 20; width: 280px; max-height: 240px;
        overflow: auto; margin: 0; padding: 6px; list-style: none; background: #fff;
        border: 1px solid #e8e8e8; border-radius: 12px; box-shadow: 0 16px 40px rgba(15,23,42,.15);
    }
    .auth-card .phone-field__option {
        width: 100%; display: flex; align-items: center; gap: 8px; padding: 10px; border: 0;
        background: transparent; border-radius: 8px; cursor: pointer; text-align: left; font: inherit;
    }
    .auth-card .phone-field__option:hover, .auth-card .phone-field__option.is-selected { background: #f5f5f5; }
    .auth-card .phone-field__option-flag { font-size: 18px; }
    .auth-card .phone-field__option-dial { font-weight: 700; min-width: 42px; }
    .auth-card .phone-field__option-name { color: #676767; font-size: 14px; }

    @media (max-width: 900px) {
        .auth-shell { grid-template-columns: 1fr; gap: 28px; min-height: 0; padding-top: 28px; }
        .auth-showcase { text-align: center; padding: 0; }
        .auth-showcase p { margin-left: auto; margin-right: auto; }
        .auth-showcase__list { max-width: 320px; margin: 0 auto; }
        .auth-showcase__art { margin: 20px auto 0; }
    }
    @media (max-width: 520px) {
        .auth-header__inner, .auth-shell { padding-left: 16px; padding-right: 16px; }
        .auth-card { padding: 24px 20px; border-radius: 18px; }
        .auth-header__links { gap: 10px; font-size: 12px; }
    }
</style>
