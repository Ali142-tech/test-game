<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Inter, system-ui, sans-serif; background: #f4f6f8; color: #102033; }
        .auth-wrap { min-height: 100vh; display: grid; place-items: center; padding: 24px; }
        .auth-card { width: 100%; max-width: 420px; background: #fff; border: 1px solid #e5ebf2; border-radius: 18px; padding: 28px; box-shadow: 0 12px 30px rgba(16,32,51,.08); }
        h1 { margin: 0 0 8px; font-size: 24px; }
        p { margin: 0 0 20px; color: #5c6b7f; font-size: 14px; }
        label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; }
        input { width: 100%; padding: 11px 12px; border: 1px solid #d9e2ec; border-radius: 10px; font: inherit; margin-bottom: 14px; }
        .btn { width: 100%; border: 0; border-radius: 12px; padding: 12px; background: #181818; color: #fff; font-weight: 800; cursor: pointer; }
        .link { color: #0b5fff; text-decoration: none; font-size: 14px; }
        .error { color: #c62828; font-size: 13px; margin-bottom: 12px; }
        .row { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-top: 16px; }
        .check { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; font-size: 14px; }
        .check input { width: auto; margin: 0; }
        .phone-field { margin-bottom: 14px; }
        .phone-field label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; }
        .phone-field__row { display: flex; gap: 10px; }
        .phone-field__country { position: relative; flex: 0 0 118px; }
        .phone-field__country-btn {
            width: 100%; display: flex; align-items: center; gap: 6px; padding: 11px 10px;
            border: 1px solid #d9e2ec; border-radius: 10px; background: #fff; cursor: pointer; font: inherit;
        }
        .phone-field__flag { font-size: 18px; line-height: 1; }
        .phone-field__dial { font-size: 14px; font-weight: 700; color: #102033; }
        .phone-field__caret { margin-left: auto; color: #5c6b7f; font-size: 12px; }
        .phone-field__input {
            flex: 1; padding: 11px 12px; border: 1px solid #d9e2ec; border-radius: 10px; font: inherit; margin-bottom: 0;
        }
        .phone-field__dropdown {
            position: absolute; top: calc(100% + 6px); left: 0; z-index: 20; width: 280px; max-height: 240px;
            overflow: auto; margin: 0; padding: 6px; list-style: none; background: #fff; border: 1px solid #d9e2ec;
            border-radius: 12px; box-shadow: 0 12px 30px rgba(16,32,51,.12);
        }
        .phone-field__option {
            width: 100%; display: flex; align-items: center; gap: 8px; padding: 10px; border: 0; background: transparent;
            border-radius: 8px; cursor: pointer; text-align: left; font: inherit;
        }
        .phone-field__option:hover, .phone-field__option.is-selected { background: #f4f6f8; }
        .phone-field__option-flag { font-size: 18px; }
        .phone-field__option-dial { font-weight: 700; min-width: 42px; }
        .phone-field__option-name { color: #5c6b7f; font-size: 14px; }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
