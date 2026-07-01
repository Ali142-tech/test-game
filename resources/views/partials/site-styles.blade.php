<style>
:root {
    --bg: #ffffff;
    --text: #181818;
    --muted: #676767;
    --line: #e8e8e8;
    --dark: #0e0e0f;
    --dark-2: #1a1a1b;
    --pill: #3b3a3a;
    --accent: #ff5b49;
}

* { box-sizing: border-box; }
html { scroll-behavior: smooth; }
html, body { margin: 0; min-height: 100%; }
body {
    font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    background: var(--bg);
    color: var(--text);
    line-height: 1.5;
}
a { color: inherit; text-decoration: none; }
img { display: block; max-width: 100%; }

#popular-teams, #all-teams, #schedule, #host-cities { scroll-margin-top: 76px; }

.shell { max-width: 1180px; margin: 0 auto; padding: 0 24px; }

/* Header */
.site-header {
    position: sticky; top: 0; z-index: 100;
    background: rgba(14,14,15,.97);
    border-bottom: 1px solid rgba(255,255,255,.08);
    backdrop-filter: blur(10px);
}
.site-header__inner {
    max-width: 1180px; margin: 0 auto; padding: 12px 24px;
    display: flex; align-items: center; gap: 18px; flex-wrap: wrap;
}
.site-header__brand { font-size: 17px; font-weight: 900; letter-spacing: .06em; color: #fff; }
.site-header__search {
    display: flex; align-items: center; gap: 10px; flex: 1; min-width: 180px; max-width: 420px;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.1);
    border-radius: 999px; padding: 9px 14px; color: rgba(255,255,255,.62); font-size: 14px;
    text-decoration: none; cursor: pointer;
}
.site-header__actions { display: flex; align-items: center; gap: 14px; margin-inline-start: auto; font-size: 13px; color: rgba(255,255,255,.85); }
.site-header__signin {
    padding: 8px 14px; border-radius: 999px; background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.16); font-weight: 700; color: #fff;
}
.lang-dropdown { position: relative; }
.lang-dropdown__trigger {
    display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 8px;
    border: 0; background: transparent; color: inherit; font: inherit; font-size: 13px; font-weight: 600;
    cursor: pointer; transition: background .15s ease;
}
.lang-dropdown__trigger:hover { background: rgba(255,255,255,.08); }
.lang-dropdown__sep { opacity: .45; }
.lang-dropdown__caret { font-size: 10px; opacity: .7; margin-inline-start: 2px; }
.lang-dropdown__menu {
    position: absolute; top: calc(100% + 8px); inset-inline-end: 0; min-width: 140px;
    background: #1a1a1b; border: 1px solid rgba(255,255,255,.12); border-radius: 12px;
    box-shadow: 0 12px 32px rgba(0,0,0,.35); padding: 6px; z-index: 200;
}
.lang-dropdown__option {
    display: block; padding: 9px 12px; border-radius: 8px; color: #f5f5f5; font-size: 13px; font-weight: 600;
}
.lang-dropdown__option:hover { background: rgba(255,255,255,.08); }
.lang-dropdown__option.is-active { background: rgba(255,255,255,.12); color: #fff; }

/* Dark shell */
.site-dark {
    background:
        radial-gradient(circle at 15% 0%, rgba(255,255,255,.05), transparent 35%),
        linear-gradient(180deg, #121212 0%, #0e0e0f 100%);
    color: #fff;
}

/* White content sheet */
.site-light {
    background: #fff;
    border-radius: 28px 28px 0 0;
    margin-top: -20px;
    position: relative;
    z-index: 2;
    padding-top: 8px;
}

/* Hero */
.wc-hero {
    display: grid; grid-template-columns: 1.05fr .95fr; gap: 28px; align-items: center;
    padding: 36px 0 20px;
}
.wc-hero h1 { margin: 0 0 8px; font-size: clamp(34px, 4.5vw, 56px); line-height: 1.02; font-weight: 800; }
.wc-hero__subtitle { margin: 0 0 16px; color: rgba(255,255,255,.62); font-size: 16px; }
.wc-hero__badge {
    display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 999px;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); font-size: 13px; font-weight: 600;
}
.wc-hero__art {
    border-radius: 16px; overflow: hidden; aspect-ratio: 1; max-width: 360px; margin-left: auto;
    background: linear-gradient(135deg, #2d1b69, #11998e 45%, #ff6a00);
    display: flex; align-items: center; justify-content: center; position: relative;
}
.wc-hero__art-text { font-size: 30px; font-weight: 900; text-align: center; z-index: 1; padding: 20px; }

/* Section heads */
.section { padding: 32px 0; }
.section--dark { padding: 24px 0 32px; }
.section-head { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 14px; }
.section-head h2 { margin: 0; font-size: 22px; font-weight: 800; }
.section-head--light h2 { color: var(--text); }
.section-title { margin: 0 0 20px; font-size: 28px; font-weight: 800; }
.view-all { font-size: 14px; font-weight: 700; color: #fff; }
.view-all:hover { text-decoration: underline; }

/* Popular teams */
.popular-row { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
.team-pill {
    display: flex; align-items: center; gap: 14px; padding: 12px 14px; border-radius: 16px;
    background: var(--pill); color: #fff; border: 1px solid rgba(255,255,255,.05); min-width: 0;
}
.team-pill:hover { background: #454444; }
.team-pill__flag { width: 38px; height: 38px; border-radius: 10px; overflow: hidden; flex: 0 0 auto; background: rgba(255,255,255,.08); }
.team-pill__flag img { width: 100%; height: 100%; object-fit: cover; }
.team-pill__copy { min-width: 0; display: flex; flex-direction: column; gap: 2px; }
.team-pill__copy strong { font-size: 15px; }
.team-pill__copy span { color: rgba(255,255,255,.68); font-size: 13px; }
.team-pill__arrow { margin-left: auto; color: rgba(255,255,255,.4); font-size: 22px; }

/* Stages (light section) */
.stages-section { padding-top: 28px; padding-bottom: 8px; }
.stages-nav { display: flex; gap: 8px; }
.stages-nav__btn {
    width: 36px; height: 36px; border-radius: 999px; border: 1px solid var(--line);
    background: #fff; color: var(--muted); font-size: 22px; line-height: 1; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center;
}
.stages-nav__btn:hover { background: #f5f5f5; color: var(--text); }
.stages-row {
    display: flex; gap: 16px; overflow-x: auto; padding-bottom: 8px; scroll-behavior: smooth;
    scrollbar-width: none;
}
.stages-row::-webkit-scrollbar { display: none; }
.stage-card {
    flex: 0 0 220px; text-align: left; background: transparent; border: 0; padding: 0;
    cursor: pointer; color: var(--text);
}
.stage-card__art {
    position: relative; border-radius: 16px; overflow: hidden; aspect-ratio: 1.35;
    display: flex; align-items: center; justify-content: center; margin-bottom: 12px;
}
.stage-card__heart {
    position: absolute; top: 10px; right: 10px; width: 28px; height: 28px;
    border-radius: 999px; background: rgba(255,255,255,.92); color: #0f8f8f;
    display: inline-flex; align-items: center; justify-content: center; font-size: 14px;
}
.stage-card__banner {
    font-size: 22px; font-weight: 900; letter-spacing: .02em; text-align: center;
    line-height: 1.1; padding: 0 12px; color: #181818;
}
.stage-card__title { display: block; font-size: 15px; font-weight: 700; margin-bottom: 4px; }
.stage-card__count { display: block; font-size: 14px; color: var(--muted); }
.stage-card.is-active .stage-card__art { outline: 2px solid #181818; outline-offset: 2px; }

/* Schedule */
.schedule-section { padding-top: 16px; }
.schedule-filters {
    display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 18px;
}
.filter-select {
    width: 100%; padding: 12px 14px; border: 1px solid var(--line); border-radius: 12px;
    font: inherit; background: #fff; color: var(--text);
}
.match-list { display: grid; gap: 12px; }
.match-card {
    display: grid; grid-template-columns: 180px 1fr auto; gap: 20px; align-items: center;
    padding: 18px 20px; border: 1px solid var(--line); border-radius: 18px; background: #fff;
    box-shadow: 0 4px 16px rgba(0,0,0,.04);
}
.match-card__left { display: flex; align-items: center; gap: 16px; }
.match-card__flags { position: relative; width: 58px; height: 42px; flex: 0 0 auto; }
.match-card__flag { width: 34px; height: 34px; border-radius: 999px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,.12); position: absolute; }
.match-card__flag--back { left: 0; top: 4px; z-index: 1; }
.match-card__flag--front { left: 22px; top: 0; z-index: 2; }
.match-card__datebox strong { display: block; font-size: 18px; line-height: 1.1; }
.match-card__datebox span { display: block; color: var(--muted); font-size: 13px; margin-top: 4px; }
.match-card__stage { display: block; font-size: 12px; font-weight: 700; letter-spacing: .04em; color: var(--muted); margin-bottom: 6px; }
.match-card__title { display: block; font-size: 20px; line-height: 1.2; margin-bottom: 6px; }
.match-card__venue { display: block; color: var(--muted); font-size: 14px; }
.match-card__btn {
    display: inline-flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px;
    min-width: 118px; padding: 11px 16px; border-radius: 999px; background: #181818; color: #fff;
    font-weight: 800; white-space: nowrap; line-height: 1.15; text-align: center;
}
.match-card__btn-label { font-size: 14px; letter-spacing: .02em; }
.match-card__btn-price { font-size: 11px; font-weight: 600; color: rgba(255,255,255,.75); }
.match-card__btn:hover { background: #333; }
.match-card__btn--disabled { background: #d0d0d0; color: #666; pointer-events: none; }
.matches-empty {
    padding: 40px 24px; text-align: center; color: var(--muted); border: 1px dashed var(--line); border-radius: 16px;
}
.show-more-wrap { text-align: center; margin-top: 18px; }
.show-more {
    display: inline-flex; padding: 12px 22px; border-radius: 999px; border: 1px solid var(--line);
    background: #fff; font-weight: 700; cursor: pointer;
}

/* Cities */
.cities-row {
    display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px;
}
.city-pill {
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
    padding: 14px 16px; border-radius: 14px; border: 1px solid var(--line); background: #fff; font-weight: 600;
}
.city-pill:hover { background: #fafafa; }
.city-pill__arrow { color: var(--muted); font-size: 20px; }

/* Trust banner */
.trust-banner {
    padding: 28px 0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
    background: #fafafa;
}
.trust-banner__eyebrow { margin: 0 0 16px; text-align: center; color: var(--muted); font-size: 14px; font-weight: 600; }
.trust-banner__grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; max-width: 900px; margin: 0 auto; text-align: center; }
.trust-banner__item strong { display: block; font-size: 18px; margin-bottom: 6px; }
.trust-banner__item span { color: var(--muted); font-size: 14px; }

/* Teams grid */
.teams-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 4px 20px; }
.team-grid-item { display: flex; align-items: center; gap: 12px; padding: 10px 4px; border-radius: 10px; }
.team-grid-item:hover { background: rgba(0,0,0,.04); }
.team-grid-item__flag { width: 32px; height: 32px; border-radius: 8px; overflow: hidden; flex: 0 0 auto; }
.team-grid-item__flag img { width: 100%; height: 100%; object-fit: cover; }
.team-grid-item__name { font-size: 15px; font-weight: 500; }

/* Content / FAQ */
.content-block { max-width: 820px; }
.content-block h2 { font-size: 28px; margin: 0 0 14px; }
.content-block h3 { font-size: 20px; margin: 28px 0 10px; }
.content-block p, .content-block li { color: #333; line-height: 1.7; }
.content-block ul { padding-left: 20px; }
.faq-list { border-top: 1px solid var(--line); margin-top: 24px; }
.faq-item { border-bottom: 1px solid var(--line); }
.faq-item__question {
    list-style: none; cursor: pointer; padding: 18px 0; font-size: 17px; font-weight: 700;
    display: flex; justify-content: space-between; align-items: center;
}
.faq-item__question::-webkit-details-marker { display: none; }
.faq-item__question::after { content: '+'; color: var(--muted); font-size: 22px; }
.faq-item[open] .faq-item__question::after { content: '−'; }
.faq-item__answer { padding: 0 0 18px; color: var(--muted); line-height: 1.65; }

/* Stadium table */
.data-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
.data-table th, .data-table td { padding: 12px 14px; border-bottom: 1px solid var(--line); text-align: left; font-size: 14px; }
.data-table th { color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: .04em; }

/* Footer */
.site-footer { background: #0e0e0f; color: rgba(255,255,255,.75); padding: 32px 0; margin-top: 24px; }
.site-footer__inner { max-width: 1180px; margin: 0 auto; padding: 0 24px; }
.site-footer__brand { font-weight: 900; letter-spacing: .06em; color: #fff; margin-bottom: 12px; }
.site-footer__links { display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 14px; font-size: 14px; }
.site-footer__copy { margin: 0; font-size: 13px; color: rgba(255,255,255,.5); }

@media (max-width: 1040px) {
    .wc-hero { grid-template-columns: 1fr; }
    .wc-hero__art { margin: 0 auto 0 0; max-width: 280px; }
    .popular-row, .cities-row, .teams-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .match-card { grid-template-columns: 1fr; gap: 14px; }
    .trust-banner__grid { grid-template-columns: 1fr; }
}
@media (max-width: 720px) {
    .shell, .site-header__inner { padding-left: 16px; padding-right: 16px; }
    .popular-row, .cities-row, .teams-grid, .schedule-filters { grid-template-columns: 1fr; }
    .site-header__actions .site-header__link { display: none; }
}

html[dir="rtl"] body { font-family: "Segoe UI", Tahoma, Arial, sans-serif; }
html[dir="rtl"] .team-pill__arrow,
html[dir="rtl"] .stages-nav__btn { transform: scaleX(-1); }
html[dir="rtl"] .data-table th,
html[dir="rtl"] .data-table td { text-align: right; }
html[dir="rtl"] .section-head { flex-direction: row-reverse; }
html[dir="rtl"] .match-card { direction: rtl; }
</style>
