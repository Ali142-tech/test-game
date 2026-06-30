<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'My Account') — GoalPass</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --panel: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --line: #e5e7eb;
            --brand: #2563eb;
            --brand-soft: #eff6ff;
            --good: #059669;
            --good-soft: #ecfdf5;
            --warn: #d97706;
            --warn-soft: #fffbeb;
            --danger: #dc2626;
            --bg-main: #f3f4f6;
            --sidebar-bg: linear-gradient(180deg, #0e0e0f 0%, #171717 100%);
            --sidebar-text: #f5f5f5;
        }
        html[data-theme="dark"] {
            --panel: #1f2937;
            --text: #f3f4f6;
            --muted: #9ca3af;
            --line: #374151;
            --brand: #60a5fa;
            --brand-soft: #1e3a8a;
            --good: #10b981;
            --good-soft: #064e3b;
            --warn: #f59e0b;
            --warn-soft: #78350f;
            --danger: #ef4444;
            --bg-main: #0f172a;
            --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #1e1b4b 100%);
            --sidebar-text: #e0e7ff;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background: var(--bg-main); color: var(--text); transition: background-color .3s ease, color .3s ease; -webkit-font-smoothing: antialiased; }
        a { color: inherit; text-decoration: none; }

        .user-shell {
            display: grid;
            grid-template-columns: 240px minmax(0, 1fr);
            min-height: 100vh;
            width: 100%;
        }
        .user-sidebar {
            grid-column: 1; grid-row: 1;
            width: 240px; min-height: 100vh;
            display: flex; flex-direction: column;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            padding: 24px 18px;
            overflow-y: auto;
            transition: background .3s ease, color .3s ease;
        }
        .user-brand { font-size: 18px; font-weight: 900; letter-spacing: .04em; color: #fff; }
        .user-brand span { display: block; font-size: 12px; font-weight: 600; color: #9ca3af; margin-top: 5px; letter-spacing: 0; }
        .user-profile {
            margin-top: 22px; padding: 14px; border-radius: 14px;
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);
        }
        .user-profile strong { display: block; font-size: 14px; font-weight: 700; }
        .user-profile span { display: block; margin-top: 4px; font-size: 11px; color: #9ca3af; word-break: break-word; font-weight: 500; }
        .user-nav { display: grid; gap: 6px; margin-top: 22px; }
        .user-nav a {
            padding: 11px 12px; border-radius: 12px; color: #d1d5db;
            font-size: 14px; font-weight: 600; transition: background .15s ease;
        }
        .user-nav a:hover, .user-nav a.is-active { background: rgba(255,255,255,.08); color: #fff; }
        .user-side-actions { margin-top: auto; padding-top: 24px; display: grid; gap: 8px; }
        .user-side-actions a, .user-side-actions button {
            display: block; width: 100%; text-align: left; padding: 10px 12px; border-radius: 10px;
            border: 1px solid rgba(255,255,255,.1); background: transparent; color: #d1d5db;
            cursor: pointer; font: inherit; transition: all .2s ease;
        }
        .user-side-actions a:hover, .user-side-actions button:hover { background: rgba(255,255,255,.1); color: #fff; }

        .user-main {
            grid-column: 2; grid-row: 1;
            min-width: 0; max-width: 100%; min-height: 100vh;
            padding: 28px; margin: 0; box-sizing: border-box; overflow-x: hidden;
        }
        .shell-topbar {
            display: flex; align-items: center; justify-content: flex-end;
            margin: -4px 0 16px; padding-bottom: 14px; border-bottom: 1px solid var(--line);
        }
        .shell-topbar__spacer { flex: 1; }
        .theme-switch {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 6px 14px 6px 6px; border-radius: 999px;
            border: 1px solid var(--line); background: var(--panel); color: var(--text);
            cursor: pointer; font: inherit; font-size: 12px; font-weight: 700;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .theme-switch:hover { border-color: var(--brand); box-shadow: 0 0 0 3px var(--brand-soft); }
        .theme-switch__track {
            width: 42px; height: 24px; border-radius: 999px; background: #cbd5e1;
            position: relative; transition: background .2s ease; flex-shrink: 0;
        }
        .theme-switch[data-theme="dark"] .theme-switch__track { background: var(--brand); }
        .theme-switch__thumb {
            position: absolute; top: 3px; left: 3px; width: 18px; height: 18px;
            border-radius: 50%; background: #fff; box-shadow: 0 1px 4px rgba(15,23,42,.25);
            transition: transform .2s ease;
        }
        .theme-switch[data-theme="dark"] .theme-switch__thumb { transform: translateX(18px); }
        .theme-switch__label { min-width: 72px; text-align: left; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; padding: 10px 14px; border-radius: 12px;
            border: 0; background: var(--brand); color: #fff; font-weight: 700; cursor: pointer; font-size: 14px;
        }
        .btn--ghost { background: #fff; color: var(--text); border: 1px solid var(--line); }
        .flash { background: var(--good-soft); color: var(--good); padding: 12px 14px; border-radius: 12px; margin-bottom: 18px; font-size: 14px; font-weight: 600; }
        .badge {
            display: inline-flex; align-items: center; padding: 4px 9px; border-radius: 999px;
            font-size: 11px; font-weight: 700;
        }
        .badge--paid { background: var(--good-soft); color: var(--good); }
        .badge--pending { background: var(--warn-soft); color: var(--warn); }
        .badge--published { background: var(--brand-soft); color: var(--brand); }
        .badge--draft { background: #f3f4f6; color: #6b7280; }
        .badge--soldout { background: #fef2f2; color: var(--danger); }
        .link { color: var(--brand); font-weight: 600; }

        @media (max-width: 900px) {
            .user-shell { grid-template-columns: 1fr; }
            .user-sidebar { grid-column: 1; grid-row: 1; width: 100%; min-height: auto; }
            .user-main { grid-column: 1; grid-row: 2; min-height: 0; padding: 20px 16px; }
        }
    </style>
</head>
<body>
    @include('partials.toasts')
    <div class="user-shell">
        <aside class="user-sidebar">
            <div class="user-brand">
                GOALPASS
                <span>My account</span>
            </div>

            <div class="user-profile">
                <strong>{{ auth()->user()->name }}</strong>
                <span>{{ auth()->user()->email }}</span>
                @if (auth()->user()->formattedPhone())
                    <span>{{ auth()->user()->formattedPhone() }}</span>
                @endif
            </div>

            <nav class="user-nav">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}">My tickets</a>
                <a href="/#schedule">Browse matches</a>
            </nav>

            <div class="user-side-actions">
                <a href="/">Back to homepage</a>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" data-loading-text="Signing out...">Sign out</button>
                </form>
            </div>
        </aside>

        <div class="user-main @yield('main_class')">
            @include('partials.theme-topbar')
            @yield('content')
        </div>
    </div>
    @include('partials.submit-loader')
</body>
</html>
