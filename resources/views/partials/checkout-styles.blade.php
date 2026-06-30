<style>
    .checkout-page { min-height: 100vh; background: #0e0e0f; }
    .checkout-page__hero {
        position: relative; overflow: hidden;
        background:
            radial-gradient(ellipse 80% 60% at 50% 0%, rgba(37, 99, 235, .35), transparent 55%),
            radial-gradient(ellipse 50% 40% at 90% 20%, rgba(16, 185, 129, .2), transparent 50%),
            linear-gradient(165deg, #0f172a 0%, #111827 45%, #0e0e0f 100%);
        border-bottom: 1px solid rgba(255,255,255,.08);
        padding: 0 0 48px;
    }
    .checkout-page__hero::before {
        content: ""; position: absolute; inset: 0; opacity: .07; pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .checkout-page__hero--final {
        background:
            radial-gradient(ellipse 70% 55% at 50% 0%, rgba(245, 158, 11, .35), transparent 55%),
            linear-gradient(165deg, #1c1917 0%, #292524 50%, #0e0e0f 100%);
    }
    .checkout-page__hero--knockout {
        background:
            radial-gradient(ellipse 70% 55% at 50% 0%, rgba(139, 92, 246, .3), transparent 55%),
            linear-gradient(165deg, #1e1b4b 0%, #111827 50%, #0e0e0f 100%);
    }
    .checkout-shell { max-width: 1080px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 1; }
    .checkout-nav {
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
        padding: 16px 0 28px; font-size: 13px; font-weight: 600;
    }
    .checkout-nav a { color: rgba(255,255,255,.7); transition: color .15s ease; }
    .checkout-nav a:hover { color: #fff; }
    .checkout-nav__brand { font-weight: 900; letter-spacing: .06em; color: #fff; font-size: 15px; }
    .checkout-stage {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 7px 14px; border-radius: 999px; margin-bottom: 20px;
        background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.14);
        color: #93c5fd; font-size: 11px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase;
    }
    .checkout-matchup {
        display: flex; align-items: center; justify-content: center; gap: 20px 28px; flex-wrap: wrap;
        text-align: center; margin-bottom: 28px;
    }
    .checkout-team { display: flex; flex-direction: column; align-items: center; gap: 12px; min-width: 110px; }
    .checkout-team__flag {
        width: 72px; height: 72px; border-radius: 18px; overflow: hidden;
        border: 3px solid rgba(255,255,255,.2); box-shadow: 0 12px 32px rgba(0,0,0,.35);
        background: rgba(255,255,255,.08);
    }
    .checkout-team__flag img { width: 100%; height: 100%; object-fit: cover; }
    .checkout-team__name { font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -.01em; }
    .checkout-vs {
        font-size: 13px; font-weight: 800; color: rgba(255,255,255,.45);
        letter-spacing: .12em; padding: 10px 14px; border-radius: 12px;
        background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
    }
    .checkout-venue-card {
        max-width: 640px; margin: 0 auto; text-align: center;
        padding: 20px 24px; border-radius: 16px;
        background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
        backdrop-filter: blur(8px);
    }
    .checkout-venue-card h1 { margin: 0 0 6px; font-size: clamp(22px, 3vw, 28px); font-weight: 800; color: #fff; letter-spacing: -.02em; }
    .checkout-venue-card p { margin: 0; color: rgba(255,255,255,.65); font-size: 15px; font-weight: 500; }
    .checkout-details {
        display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-top: 18px;
    }
    .checkout-detail {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 999px;
        background: rgba(0,0,0,.25); border: 1px solid rgba(255,255,255,.1);
        color: #e5e7eb; font-size: 13px; font-weight: 600;
    }
    .checkout-detail__icon { opacity: .7; font-size: 14px; }

    .checkout-body { margin-top: -24px; padding-bottom: 48px; position: relative; z-index: 2; }
    .checkout-grid { display: grid; grid-template-columns: 1fr 1.05fr; gap: 20px; align-items: start; }
    .checkout-panel {
        background: #fff; border-radius: 20px; border: 1px solid #e8e8e8;
        box-shadow: 0 20px 50px rgba(15,23,42,.12); overflow: hidden;
    }
    .checkout-panel__head {
        padding: 18px 22px; border-bottom: 1px solid #f0f0f0;
        font-size: 13px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: #676767;
    }
    .checkout-panel__body { padding: 22px; }
    .checkout-summary-row {
        display: flex; justify-content: space-between; align-items: center; gap: 12px;
        padding: 12px 0; border-bottom: 1px dashed #eee; font-size: 14px;
    }
    .checkout-summary-row:last-child { border-bottom: 0; }
    .checkout-summary-row strong { font-weight: 700; }
    .checkout-summary-row span { color: #676767; }
    .checkout-summary-total {
        display: flex; justify-content: space-between; align-items: baseline; gap: 12px;
        margin-top: 8px; padding-top: 16px; border-top: 2px solid #111;
    }
    .checkout-summary-total small { display: block; color: #676767; font-size: 12px; font-weight: 600; margin-top: 2px; }
    .checkout-summary-total strong { font-size: 28px; font-weight: 900; letter-spacing: -.03em; }

    .checkout-form label {
        display: block; font-size: 13px; font-weight: 800; margin-bottom: 10px; color: #181818;
    }
    .checkout-qty {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(72px, 1fr)); gap: 8px; margin-bottom: 18px;
    }
    .checkout-qty input { position: absolute; opacity: 0; pointer-events: none; }
    .checkout-qty label {
        display: grid; place-items: center; padding: 12px 8px; margin: 0; border-radius: 12px;
        border: 2px solid #e8e8e8; background: #fafafa; cursor: pointer; font-size: 13px; font-weight: 700;
        transition: all .15s ease; text-align: center; line-height: 1.3;
    }
    .checkout-qty label small { display: block; font-size: 11px; color: #676767; font-weight: 600; margin-top: 2px; }
    .checkout-qty input:checked + label {
        border-color: #2563eb; background: #eff6ff; color: #1d4ed8; box-shadow: 0 0 0 3px rgba(37,99,235,.15);
    }
    .checkout-qty input:checked + label small { color: #3b82f6; }

    .checkout-pay-btn {
        width: 100%; border: 0; border-radius: 14px; padding: 16px 20px; margin-top: 6px;
        background: linear-gradient(135deg, #111827 0%, #2563eb 100%);
        color: #fff; font-weight: 800; font-size: 16px; cursor: pointer;
        box-shadow: 0 10px 28px rgba(37,99,235,.35); transition: transform .15s ease, box-shadow .15s ease;
    }
    .checkout-pay-btn:hover { transform: translateY(-1px); box-shadow: 0 14px 36px rgba(37,99,235,.4); }
    .checkout-secure {
        display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap;
        margin-top: 16px; font-size: 12px; color: #676767; font-weight: 600;
    }
    .checkout-secure span {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 999px;
        background: #f5f5f5; border: 1px solid #eee;
    }
    .checkout-trust {
        display: grid; gap: 12px;
    }
    .checkout-trust-item {
        display: flex; gap: 14px; align-items: flex-start; padding: 14px; border-radius: 14px; background: #f9fafb;
    }
    .checkout-trust-item strong { display: block; font-size: 14px; margin-bottom: 4px; }
    .checkout-trust-item span { font-size: 13px; color: #676767; line-height: 1.5; }
    .checkout-trust-item__icon {
        width: 40px; height: 40px; border-radius: 12px; flex-shrink: 0;
        display: grid; place-items: center; font-size: 18px;
        background: #ecfdf5; color: #059669;
    }
    .checkout-alert {
        margin-bottom: 20px; padding: 12px 16px; border-radius: 12px;
        background: #fef2f2; color: #b91c1c; font-size: 14px; font-weight: 600;
    }
    .checkout-stock { font-size: 13px; color: #d97706; font-weight: 700; margin-bottom: 14px; }

    @media (max-width: 860px) {
        .checkout-grid { grid-template-columns: 1fr; }
        .checkout-body { margin-top: 0; padding-top: 20px; }
        .checkout-matchup { gap: 16px; }
        .checkout-team__flag { width: 60px; height: 60px; }
    }
</style>
