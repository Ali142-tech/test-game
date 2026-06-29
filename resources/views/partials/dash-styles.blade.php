<style>
    .admin-main--dash, .user-main--dash { padding: 20px 22px 24px; }

    .dash { display: grid; gap: 16px; }
    .dash-head {
        display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;
        padding: 18px 22px; border-radius: 16px; color: #fff;
        box-shadow: 0 12px 32px rgba(37, 99, 235, .22);
    }
    .dash-head--admin { background: linear-gradient(120deg, #0f172a 0%, #1e3a8a 55%, #2563eb 100%); }
    .dash-head--user { background: linear-gradient(120deg, #0e0e0f 0%, #1e1b4b 50%, #4338ca 100%); box-shadow: 0 12px 32px rgba(67, 56, 202, .25); }
    .dash-head h1 { margin: 0 0 4px; font-size: 22px; font-weight: 800; letter-spacing: -.02em; }
    .dash-head p { margin: 0; font-size: 13px; color: rgba(255,255,255,.75); font-weight: 500; }
    .dash-head__tag {
        display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
        color: #93c5fd; margin-bottom: 6px;
    }
    .dash-head--user .dash-head__tag { color: #c4b5fd; }
    .dash-head__actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .dash-head__actions .btn { padding: 9px 14px; font-size: 13px; border-radius: 10px; background: #fff; color: #1d4ed8; }
    .dash-head__actions .btn--ghost { background: rgba(255,255,255,.1); color: #fff; border: 1px solid rgba(255,255,255,.2); }
    .dash-head--user .dash-head__actions .btn { color: #4338ca; }

    .dash-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }
    .dash-stat {
        background: var(--panel); border: 1px solid var(--line); border-radius: 14px; padding: 14px 16px;
        display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 16px rgba(15,23,42,.04);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .dash-stat:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(15,23,42,.08); }
    .dash-stat__icon {
        width: 38px; height: 38px; border-radius: 11px; display: grid; place-items: center; flex-shrink: 0;
        font-size: 10px; font-weight: 800; letter-spacing: .03em;
    }
    .dash-stat__icon--green { background: #ecfdf5; color: #059669; }
    .dash-stat__icon--blue { background: #eff6ff; color: #2563eb; }
    .dash-stat__icon--violet { background: #f5f3ff; color: #7c3aed; }
    .dash-stat__icon--amber { background: #fffbeb; color: #d97706; }
    .dash-stat__icon--rose { background: #fff1f2; color: #e11d48; }
    .dash-stat__label { font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
    .dash-stat__value { font-size: 22px; font-weight: 800; line-height: 1.1; letter-spacing: -.02em; margin-top: 2px; }
    .dash-stat__hint { font-size: 11px; color: var(--muted); margin-top: 2px; font-weight: 500; }

    .dash-mid { display: grid; grid-template-columns: 1.35fr .75fr .9fr; gap: 12px; align-items: stretch; }
    .dash-card {
        background: var(--panel); border: 1px solid var(--line); border-radius: 14px;
        box-shadow: 0 4px 16px rgba(15,23,42,.04); overflow: hidden; min-width: 0;
    }
    .dash-card__head {
        padding: 14px 16px 0; display: flex; justify-content: space-between; align-items: baseline; gap: 8px;
    }
    .dash-card__head h2 { margin: 0; font-size: 14px; font-weight: 800; letter-spacing: -.01em; }
    .dash-card__head span { font-size: 11px; color: var(--muted); font-weight: 600; }
    .dash-card__body { padding: 10px 16px 14px; }

    .dash-chart-wrap { width: 100%; }
    .dash-chart { width: 100%; height: 130px; display: block; }
    .dash-chart--bars { overflow: visible; }
    .dash-chart__axis { stroke: var(--line); stroke-width: 1; }
    .dash-chart__bar { opacity: .95; transition: opacity .15s ease; }
    .dash-chart__bar:hover { opacity: 1; }
    .dash-chart__empty { fill: var(--muted); font-size: 12px; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif; }
    .dash-labels { display: flex; justify-content: space-between; gap: 4px; font-size: 10px; font-weight: 600; color: var(--muted); margin-top: 6px; padding: 0 4px; }
    .dash-labels span { flex: 1; text-align: center; }

    .dash-donut-box { display: flex; align-items: center; justify-content: center; gap: 16px; flex-wrap: wrap; padding: 4px 0; }
    .dash-donut { width: 100px; height: 100px; flex-shrink: 0; }
    .dash-donut .track { fill: none; stroke: var(--line); stroke-width: 12; }
    .dash-donut .track--empty { stroke: var(--line); opacity: .5; }
    .dash-donut .paid { fill: none; stroke: #10b981; stroke-width: 12; stroke-linecap: round; }
    .dash-donut .pending { fill: none; stroke: #f59e0b; stroke-width: 12; stroke-linecap: round; }
    .dash-donut__center { fill: var(--text); font-size: 14px; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; }
    .dash-legend { display: grid; gap: 8px; font-size: 12px; font-weight: 600; }
    .dash-legend div { display: flex; align-items: center; gap: 7px; }
    .dash-legend i { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; font-style: normal; }
    .dash-legend small { display: block; color: var(--muted); font-size: 10px; font-weight: 500; margin-top: 1px; }

    .dash-bars { display: grid; gap: 10px; }
    .dash-bar { display: grid; grid-template-columns: 1fr auto; gap: 6px 10px; align-items: center; }
    .dash-bar__name { font-size: 12px; font-weight: 700; line-height: 1.25; grid-column: 1 / -1; }
    .dash-bar__name span { color: var(--muted); font-weight: 600; font-size: 10px; margin-left: 6px; }
    .dash-bar__track { height: 6px; background: #eef2f7; border-radius: 999px; overflow: hidden; }
    html[data-theme="dark"] .dash-bar__track { background: #374151; }
    .dash-bar__fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #3b82f6, #22d3ee); min-width: 3px; }
    .dash-bar__fill--user { background: linear-gradient(90deg, #6366f1, #a78bfa); }
    .dash-bar__val { font-size: 12px; font-weight: 800; color: var(--brand); }

    .dash-bottom { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .dash-table-wrap { overflow: auto; max-height: 280px; }
    .dash-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .dash-table th, .dash-table td { padding: 10px 14px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: middle; }
    .dash-table th {
        position: sticky; top: 0; z-index: 1; background: var(--panel);
        font-size: 10px; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); font-weight: 700;
    }
    .dash-table tr:last-child td { border-bottom: 0; }
    .dash-table tbody tr:hover { background: rgba(37,99,235,.03); }
    .dash-table strong { font-weight: 700; }
    .dash-table .muted { color: var(--muted); font-size: 11px; }
    .dash-table .fill { display: flex; align-items: center; gap: 6px; min-width: 90px; }
    .dash-table .fill .progress { flex: 1; height: 5px; background: #eef2f7; border-radius: 999px; overflow: hidden; }
    .dash-table .fill .progress span { display: block; height: 100%; background: linear-gradient(90deg, #2563eb, #059669); border-radius: 999px; }
    .dash-buyer { display: flex; align-items: center; gap: 8px; }
    .dash-buyer__av {
        width: 28px; height: 28px; border-radius: 8px; display: grid; place-items: center;
        font-size: 10px; font-weight: 800; color: #fff; background: linear-gradient(135deg, #6366f1, #8b5cf6);
    }
    .dash-card__foot { padding: 10px 16px; border-top: 1px solid var(--line); text-align: right; }
    .dash-card__foot a { font-size: 12px; font-weight: 700; color: var(--brand); }

    .dash-tickets { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; padding: 14px 16px 16px; max-height: 340px; overflow-y: auto; }
    .dash-ticket {
        display: grid; grid-template-columns: 4px 1fr auto; gap: 0 12px; align-items: stretch;
        border: 1px solid var(--line); border-radius: 14px; overflow: hidden; background: var(--panel);
        transition: box-shadow .15s ease, transform .15s ease;
    }
    .dash-ticket:hover { box-shadow: 0 8px 24px rgba(15,23,42,.08); transform: translateY(-1px); }
    .dash-ticket__stripe { background: linear-gradient(180deg, #6366f1, #2563eb); }
    .dash-ticket__stripe--pending { background: linear-gradient(180deg, #f59e0b, #d97706); }
    .dash-ticket__body { padding: 14px 0; min-width: 0; }
    .dash-ticket__stage { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); margin-bottom: 4px; }
    .dash-ticket__title { font-size: 14px; font-weight: 800; line-height: 1.25; margin-bottom: 6px; letter-spacing: -.01em; }
    .dash-ticket__meta { font-size: 11px; color: var(--muted); line-height: 1.5; font-weight: 500; }
    .dash-ticket__side { padding: 14px 14px 14px 0; text-align: right; display: flex; flex-direction: column; justify-content: center; align-items: flex-end; gap: 4px; }
    .dash-ticket__price { font-size: 16px; font-weight: 800; letter-spacing: -.02em; }
    .dash-ticket__qty { font-size: 11px; color: var(--muted); font-weight: 600; }

    .dash-empty {
        padding: 36px 24px; text-align: center; margin: 14px 16px 16px;
        border: 1px dashed var(--line); border-radius: 14px; background: rgba(99,102,241,.04);
    }
    .dash-empty strong { display: block; font-size: 16px; font-weight: 800; margin-bottom: 6px; }
    .dash-empty p { margin: 0 0 14px; font-size: 13px; color: var(--muted); }
    .dash-empty .btn { font-size: 13px; }

    .muted { color: var(--muted); }

    @media (max-width: 1200px) {
        .dash-mid { grid-template-columns: 1fr 1fr; }
        .dash-mid .dash-card:last-child { grid-column: 1 / -1; }
        .dash-tickets { grid-template-columns: 1fr; }
    }
    @media (max-width: 900px) {
        .dash-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .dash-mid, .dash-bottom { grid-template-columns: 1fr; }
    }
</style>
