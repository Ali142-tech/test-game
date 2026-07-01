<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — World Cup Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f1419;
            --sidebar: #111827;
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
            --sidebar-bg: linear-gradient(180deg, #111827 0%, #0b1220 100%);
            --sidebar-text: #e5e7eb;
            --bg-main: #f3f4f6;
        }
        html[data-theme="dark"] {
            --bg: #0f172a;
            --sidebar: #0f172a;
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
            --sidebar-bg: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            --sidebar-text: #e0e7ff;
            --bg-main: #0f172a;
        }        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background: var(--bg-main); color: var(--text); transition: background-color 0.3s ease, color 0.3s ease; -webkit-font-smoothing: antialiased; }
        a { color: inherit; text-decoration: none; }
        .admin-shell {
            display: grid;
            grid-template-columns: 240px minmax(0, 1fr);
            min-height: 100vh;
            width: 100%;
        }
        .admin-sidebar {
            grid-column: 1;
            grid-row: 1;
            width: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            padding: 24px 18px;
            overflow-y: auto;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .admin-brand { font-size: 18px; font-weight: 900; letter-spacing: .04em; color: #fff; margin-bottom: 6px; }
        .admin-brand span { display: block; font-size: 12px; font-weight: 600; color: #9ca3af; letter-spacing: 0; margin-top: 4px; }
        .admin-nav { display: grid; gap: 6px; margin-top: 28px; }
        .admin-nav a {
            display: flex; align-items: center; gap: 10px; padding: 11px 12px; border-radius: 12px;
            color: #d1d5db; font-size: 14px; font-weight: 600;
        }
        .admin-nav a:hover, .admin-nav a.is-active { background: rgba(255,255,255,.08); color: #fff; }
        .admin-side-actions { margin-top: auto; padding-top: 24px; display: grid; gap: 8px; }
        .admin-side-actions a, .admin-side-actions button {
            display: block; width: 100%; text-align: left; padding: 10px 12px; border-radius: 10px;
            border: 1px solid rgba(255,255,255,.1); background: transparent; color: #d1d5db; cursor: pointer; font: inherit; transition: all 0.2s ease;
        }
        .admin-side-actions a:hover, .admin-side-actions button:hover {
            background: rgba(255,255,255,.1); color: #fff;
        }
        .admin-main {
            grid-column: 2;
            grid-row: 1;
            min-width: 0;
            max-width: 100%;
            min-height: 100vh;
            padding: 28px;
            margin: 0;
            box-sizing: border-box;
            overflow-x: hidden;
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
        .admin-topbar { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 24px; }
        .admin-topbar-title { flex: 1; }
        .admin-topbar-actions { display: flex; gap: 12px; align-items: center; }
        .admin-topbar h1 { margin: 0 0 6px; font-size: 28px; }
        .admin-topbar p { margin: 0; color: var(--muted); font-size: 14px; }
        .admin-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; padding: 10px 14px; border-radius: 12px;
            border: 0; background: var(--brand); color: #fff; font-weight: 700; cursor: pointer; font-size: 14px;
        }
        .btn--ghost { background: #fff; color: var(--text); border: 1px solid var(--line); }
        .btn--danger { background: var(--danger); color: #fff; }
        .flash { background: var(--good-soft); color: var(--good); padding: 12px 14px; border-radius: 12px; margin-bottom: 18px; font-size: 14px; font-weight: 600; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--panel); border: 1px solid var(--line); border-radius: 18px; padding: 18px;
            box-shadow: 0 8px 24px rgba(17,24,39,.04);
        }
        .chart-grid { display: grid; grid-template-columns: 0.95fr 1.05fr; gap: 16px; padding: 18px; }
        .chart-card {
            border-radius: 18px; padding: 18px; border: 1px solid var(--line); min-height: 220px;
            display: flex; flex-direction: column; justify-content: space-between; gap: 12px;
        }
        .chart-card--accent { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); }
        .chart-card--soft { background: #f9fafb; }
        .chart-card__eyebrow { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--good); }
        .chart-card__title { font-size: 22px; font-weight: 800; color: var(--text); }
        .chart-card__text { font-size: 14px; color: var(--muted); line-height: 1.5; }
        .chart-card__svg { width: 100%; height: 140px; }
        .chart-visual { position: relative; padding-top: 10px; padding-bottom: 8px; }
        .chart-bar { animation: slideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both; }
        @keyframes slideUp { from { y: 110; opacity: 0.4; } to { y: var(--y); opacity: 1; } }
        .chart-dot {
            position: absolute; width: 16px; height: 16px; border: 0; padding: 0; border-radius: 999px;
            background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15), inset 0 1px 3px rgba(255,255,255,.4);
            transform: translate(-50%, -50%); cursor: pointer; transition: all .2s ease; flex-shrink: 0;
        }
        .chart-dot--success { background: linear-gradient(135deg, #10b981, #059669); }
        .chart-dot:hover, .chart-dot:focus-visible {
            transform: translate(-50%, -50%) scale(1.2); box-shadow: 0 0 0 5px rgba(5, 150, 105, 0.2), inset 0 1px 3px rgba(255,255,255,.4); outline: none;
        }
        .chart-dot__tip {
            position: absolute; left: 50%; top: -12px; transform: translate(-50%, -100%); min-width: 96px; padding: 10px 12px;
            border-radius: 12px; background: linear-gradient(135deg, rgba(17, 24, 39, 0.98), rgba(31, 41, 55, 0.98));
            color: #fff; font-size: 12px; font-weight: 600; display: flex; flex-direction: column; gap: 4px;
            opacity: 0; pointer-events: none; transition: all .2s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 16px 40px rgba(17, 24, 39, 0.3), 0 0 1px rgba(255,255,255,.1);
        }
        .chart-dot__tip strong { font-weight: 700; font-size: 13px; }
        .chart-dot__tip span { font-weight: 500; opacity: 0.85; }
        .chart-dot:hover .chart-dot__tip, .chart-dot:focus-visible .chart-dot__tip {
            opacity: 1; transform: translate(-50%, calc(-100% - 10px));
        }
        .chart-card__labels { display: flex; justify-content: space-between; font-size: 12px; font-weight: 500; color: #9ca3af; }
        .stat-card__label { font-size: 13px; color: var(--muted); font-weight: 600; margin-bottom: 8px; }
        .stat-card__value { font-size: 30px; font-weight: 800; line-height: 1; }
        .stat-card__hint { margin-top: 8px; font-size: 12px; color: var(--muted); }
        .stat-card--green .stat-card__value { color: var(--good); }
        .stat-card--blue .stat-card__value { color: var(--brand); }
        .stat-card--amber .stat-card__value { color: var(--warn); }
        .panel {
            background: var(--panel); border: 1px solid var(--line); border-radius: 18px;
            box-shadow: 0 8px 24px rgba(17,24,39,.04); overflow: auto; margin-bottom: 24px; max-width: 100%; min-width: 0;
        }
        .panel__head { padding: 18px 20px; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; gap: 12px; }
        .panel__head h2 { margin: 0; font-size: 18px; }
        .panel__head p { margin: 4px 0 0; color: var(--muted); font-size: 13px; }
        table { width: 100%; min-width: 960px; border-collapse: collapse; table-layout: auto; }
        th, td { padding: 14px 18px; border-bottom: 1px solid var(--line); text-align: left; font-size: 14px; vertical-align: middle; }
        th { background: #f9fafb; font-size: 12px; text-transform: uppercase; letter-spacing: .04em; color: var(--muted); }
        tr:last-child td { border-bottom: 0; }
        .badge {
            display: inline-flex; align-items: center; padding: 5px 10px; border-radius: 999px;
            font-size: 12px; font-weight: 700;
        }
        .badge--paid { background: var(--good-soft); color: var(--good); }
        .badge--pending { background: var(--warn-soft); color: var(--warn); }
        .badge--delivered { background: var(--good-soft); color: var(--good); }
        .badge--delivery-pending { background: var(--warn-soft); color: var(--warn); }
        .badge--rejected { background: #fef2f2; color: var(--danger); }
        .badge--refunded { background: #f3e8ff; color: #7c3aed; }
        .badge--draft { background: #f3f4f6; color: #6b7280; }
        .badge--published { background: var(--brand-soft); color: var(--brand); }
        .badge--soldout { background: #fef2f2; color: var(--danger); }
        .progress { height: 8px; background: #eef2f7; border-radius: 999px; overflow: hidden; min-width: 90px; }
        .progress span { display: block; height: 100%; background: linear-gradient(90deg, #2563eb, #059669); border-radius: 999px; }
        label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 11px 12px; border: 1px solid var(--line); border-radius: 12px; font: inherit; background: #fff; }
        input[type="date"], input[type="time"] {
            min-height: 44px;
            cursor: pointer;
            color-scheme: light;
        }
        html[data-theme="dark"] input[type="date"],
        html[data-theme="dark"] input[type="time"] {
            color-scheme: dark;
            background: #111827;
            color: #f3f4f6;
        }
        select { cursor: pointer; }
        .field { margin-bottom: 14px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .check { display: flex; align-items: center; gap: 8px; }
        .check input { width: auto; }
        .form-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; padding: 22px; }
        .actions { display: flex; gap: 10px; margin-top: 18px; }
        .muted { color: var(--muted); }
        .link { color: var(--brand); font-weight: 600; }
        .pagination { padding: 16px 18px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .pagination a, .pagination span {
            display: inline-flex; padding: 8px 12px; border-radius: 10px; border: 1px solid var(--line); font-size: 13px;
        }
        .pagination .current { background: var(--brand); color: #fff; border-color: var(--brand); }
        @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 900px) {
            .admin-shell { grid-template-columns: 1fr; }
            .admin-sidebar {
                grid-column: 1;
                grid-row: 1;
                width: 100%;
                min-height: auto;
            }
            .admin-main {
                grid-column: 1;
                grid-row: 2;
                min-height: 0;
            }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('partials.toasts')
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                GOALPASS
                <span>World Cup Admin</span>
            </div>

            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.matches.index') }}" class="{{ request()->routeIs('admin.matches.*') ? 'is-active' : '' }}">Matches</a>
                <a href="{{ route('admin.tickets.index') }}" class="{{ request()->routeIs('admin.tickets.*') ? 'is-active' : '' }}">Tickets</a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">Users</a>
                <a href="{{ route('admin.matches.create') }}">Add match</a>
            </nav>

            <div class="admin-side-actions">
                <a href="/" target="_blank">View public site</a>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" data-loading-text="Signing out...">Logout</button>
                </form>
            </div>
        </aside>

        <div class="admin-main @yield('main_class')">
            @include('partials.theme-topbar')
            @yield('content')
        </div>
    </div>
    @include('partials.submit-loader')
</body>
</html>
