<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Halzanîn — Kurdistan Government Services Portal. Submit applications, book appointments, and track your status for all government services online.">
    <title>Halzanîn | Kurdistan Government Services Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('images/halzanin-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Noto+Naskh+Arabic:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Apply theme & language before first paint --}}
    <script>
        (function() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
            if (localStorage.lang === 'ku') {
                document.documentElement.dir  = 'rtl';
                document.documentElement.lang = 'ku';
            }
        })();
    </script>

    <style>
        /* ─── Reset & base ─── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:           #EFEDE8;
            --card:         #ffffff;
            --text:         #111111;
            --muted:        #6B6860;
            --brand:        #1B4F8A;
            --brand-dark:   #163F6E;
            --brand-light:  #4A82C4;
            --line:         #DDD9D0;
            --brand-glow:   rgba(27,79,138,0.28);
            --card-shadow:  0 2px 16px rgba(0,0,0,0.05);
        }
        html.dark {
            --bg:           #141414;
            --card:         #1F1F1F;
            --text:         #F0EEE9;
            --muted:        #9E9B94;
            --brand:        #4A82C4;
            --brand-dark:   #3A6BA8;
            --brand-light:  #6B9FD4;
            --line:         #2E2E2E;
            --brand-glow:   rgba(74,130,196,0.28);
            --card-shadow:  0 2px 16px rgba(0,0,0,0.3);
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: "Outfit", sans-serif;
            line-height: 1.6;
            transition: background 0.2s, color 0.2s;
        }
        html[lang="ku"] body, html[dir="rtl"] body { font-family: "Noto Naskh Arabic", serif; }

        /* ─── Layout ─── */
        .w-container { width: min(1200px, calc(100% - 48px)); margin: 0 auto; }

        /* ─── Topbar ─── */
        .w-topbar {
            position: sticky; top: 0; z-index: 40;
            background: rgba(239,237,232,0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--line);
            transition: background 0.2s, border-color 0.2s;
        }
        html.dark .w-topbar { background: rgba(20,20,20,0.92); }

        .w-nav { min-height: 72px; display: flex; align-items: center; gap: 24px; }

        .w-brand { display: inline-flex; align-items: center; gap: 14px; text-decoration: none; flex-shrink: 0; }
        .w-brand img { height: 48px; width: auto; transition: transform 0.2s; }
        .w-brand:hover img { transform: scale(1.04); }
        .w-brand-text { font-family: "Outfit", sans-serif; line-height: 1.15; }
        .w-brand-text strong { display: block; font-size: 22px; font-weight: 800; letter-spacing: -0.01em; color: var(--text); }
        .w-brand-text small { display: block; font-size: 11px; color: var(--muted); font-weight: 600; letter-spacing: 0.02em; }

        .w-menu { display: flex; gap: 28px; align-items: center; font-size: 14px; font-weight: 600; }
        .w-menu a { color: var(--muted); text-decoration: none; transition: color .15s; }
        .w-menu a:hover { color: var(--brand); }

        .w-nav-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }
        html[dir="rtl"] .w-nav-right { margin-left: unset; margin-right: auto; }

        /* ─── Toggles ─── */
        .w-toggles {
            display: flex; align-items: center; gap: 4px;
            background: var(--card); border: 1.5px solid var(--line);
            border-radius: 999px; padding: 4px 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
            transition: background 0.2s, border-color 0.2s;
        }
        .w-theme-btn {
            width: 34px; height: 34px; border-radius: 50%;
            background: none; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); transition: background 0.18s, color 0.18s; flex-shrink: 0;
        }
        .w-theme-btn:hover { background: rgba(27,79,138,0.1); color: #1B4F8A; }
        html.dark .w-theme-btn:hover { background: rgba(74,130,196,0.15); color: #4A82C4; }
        .w-theme-btn svg { width: 17px; height: 17px; }

        .w-divider { width: 1px; height: 20px; background: var(--line); margin: 0 2px; flex-shrink: 0; }

        .w-lang-seg { display: flex; align-items: center; background: rgba(27,79,138,0.06); border-radius: 999px; padding: 3px; gap: 2px; }
        html.dark .w-lang-seg { background: rgba(74,130,196,0.1); }
        .w-lang-opt { border: none; cursor: pointer; border-radius: 999px; padding: 5px 11px; font-size: 12px; font-weight: 700; transition: all 0.2s; color: var(--muted); background: none; line-height: 1; white-space: nowrap; }
        .w-lang-opt.w-lang-active { background: #1B4F8A; color: #fff; box-shadow: 0 2px 8px rgba(27,79,138,0.35); }
        html.dark .w-lang-opt.w-lang-active { background: #4A82C4; box-shadow: 0 2px 8px rgba(74,130,196,0.35); }
        .w-lang-opt:not(.w-lang-active):hover { color: #1B4F8A; background: rgba(27,79,138,0.08); }
        html.dark .w-lang-opt:not(.w-lang-active):hover { color: #4A82C4; background: rgba(74,130,196,0.1); }

        .w-btn {
            border-radius: 999px; padding: 10px 22px;
            font-family: "Outfit", sans-serif; font-size: 14px; font-weight: 700;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
            cursor: pointer; transition: all .2s ease; border: none; white-space: nowrap;
        }
        .w-btn-outline { background: var(--card); border: 1.5px solid var(--line); color: var(--text); }
        .w-btn-outline:hover { border-color: var(--brand); color: var(--brand); }
        .w-btn-primary { background: #1B4F8A; color: #fff; box-shadow: 0 6px 18px rgba(27,79,138,0.32); }
        html.dark .w-btn-primary { background: #4A82C4; box-shadow: 0 6px 18px rgba(74,130,196,0.32); }
        .w-btn-primary:hover { background: #163F6E; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(27,79,138,0.40); }
        html.dark .w-btn-primary:hover { background: #3A6BA8; }

        /* ─── Section base ─── */
        .w-section { padding: 72px 0; }
        .w-section-sm { padding: 56px 0; }
        .w-section-head { margin-bottom: 48px; }
        .w-section-head h2 { font-size: clamp(26px, 3vw, 38px); font-weight: 800; letter-spacing: -0.025em; color: var(--text); margin-bottom: 10px; }
        .w-section-sub { color: var(--muted); max-width: 60ch; line-height: 1.8; font-size: 16px; }
        .w-alt-bg { background: var(--card); border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }

        .w-kicker {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(27,79,138,0.08); border: 1px solid rgba(27,79,138,0.18);
            border-radius: 999px; padding: 6px 14px;
            font-size: 12px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase;
            color: #1B4F8A; margin-bottom: 18px;
        }
        html.dark .w-kicker { color: #4A82C4; background: rgba(74,130,196,0.1); border-color: rgba(74,130,196,0.25); }
        .w-kicker-icon { flex-shrink: 0; color: #1B4F8A; display: block; }
        html.dark .w-kicker-icon { color: #4A82C4; }

        /* ─── Announcement bar ─── */
        .w-announce {
            background: #1B4F8A; color: rgba(255,255,255,0.93);
            padding: 10px 52px; text-align: center; font-size: 12.5px; font-weight: 600;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            position: relative; line-height: 1.45; letter-spacing: 0.01em;
        }
        html.dark .w-announce { background: #122f52; }
        .w-announce-dismiss {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: rgba(255,255,255,0.6); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            width: 26px; height: 26px; border-radius: 50%;
            transition: background 0.15s, color 0.15s;
        }
        .w-announce-dismiss:hover { background: rgba(255,255,255,0.18); color: #fff; }
        @media (max-width: 640px) { .w-announce { padding-left: 14px; font-size: 11.5px; } }

        /* ─── Hero ─── */
        .w-hero-wrap { padding: 44px 0 36px; }
        .w-hero {
            position: relative; border-radius: 28px;
            background: var(--card); border: 1px solid var(--line); overflow: hidden;
            box-shadow: 0 4px 40px rgba(0,0,0,0.06);
        }
        html.dark .w-hero { box-shadow: 0 4px 40px rgba(0,0,0,0.35); }
        .w-hero::before {
            content: ""; position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(27,79,138,0.6) 1px, transparent 1px);
            background-size: 28px 28px; opacity: 0.055; pointer-events: none;
        }
        .w-hero-grid { display: grid; grid-template-columns: 1fr 460px; align-items: center; min-height: 520px; }
        .w-hero-text { padding: 68px 60px 60px; position: relative; z-index: 2; }

        /* Hero image panel */
        .w-hero-visual {
            position: relative; min-height: 520px; overflow: hidden;
            background: linear-gradient(155deg, #0B2545 0%, #1B4F8A 52%, #0d3a6e 100%);
        }
        .w-hero-visual::before {
            content: ""; position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
            background-size: 22px 22px; pointer-events: none; z-index: 0;
        }
        .w-hero-img-wrap { position: absolute; inset: 0; z-index: 1; }
        .w-hero-img {
            width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;
            opacity: 0.4;
        }
        html.dark .w-hero-img { opacity: 0.24; }
        .w-hero-img-fade {
            position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(to right, var(--card) 0%, transparent 44%),
                        linear-gradient(to top, rgba(11,37,69,0.52) 0%, transparent 38%);
        }
        html.dark .w-hero-img-fade {
            background: linear-gradient(to right, #1F1F1F 0%, transparent 44%),
                        linear-gradient(to top, rgba(5,16,32,0.72) 0%, transparent 38%);
        }
        .w-hero-img-badge {
            position: absolute; bottom: 22px; right: 22px; z-index: 3;
            background: rgba(255,255,255,0.11); backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2); border-radius: 999px;
            padding: 7px 14px; display: flex; align-items: center; gap: 7px;
            color: rgba(255,255,255,0.88); font-size: 11.5px; font-weight: 600; pointer-events: none;
        }

        /* ─── Trust strip ─── */
        .w-trust-strip {
            border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
            background: var(--card);
        }
        .w-trust-items { display: flex; align-items: stretch; justify-content: center; }
        .w-trust-item {
            display: flex; align-items: center; gap: 10px;
            padding: 15px 36px; font-size: 13px; font-weight: 600; color: var(--muted);
            white-space: nowrap;
        }
        .w-trust-item svg { flex-shrink: 0; color: #1B4F8A; }
        html.dark .w-trust-item svg { color: #4A82C4; }
        .w-trust-item strong { color: var(--text); font-weight: 700; margin-right: 2px; }
        .w-trust-sep { width: 1px; background: var(--line); margin: 10px 0; flex-shrink: 0; }

        /* Hero typography */
        .w-h1 { font-size: clamp(34px, 4vw, 56px); font-weight: 800; line-height: 1.06; letter-spacing: -0.025em; color: var(--text); max-width: 16ch; margin-bottom: 18px; }
        .w-h1 .accent { color: #1B4F8A; }
        html.dark .w-h1 .accent { color: #4A82C4; }
        .w-subtitle { font-size: 16px; line-height: 1.8; color: var(--muted); max-width: 48ch; }
        .w-cta { margin-top: 28px; display: flex; flex-wrap: wrap; gap: 10px; }

        /* Hero stats */
        .w-stats { margin-top: 40px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .w-stat { background: var(--bg); border: 1px solid var(--line); border-radius: 14px; padding: 14px 16px; }
        .w-stat strong { display: block; font-size: 20px; font-weight: 800; color: #1B4F8A; margin-bottom: 3px; }
        html.dark .w-stat strong { color: #4A82C4; }
        .w-stat span { font-size: 11px; color: var(--muted); font-weight: 600; line-height: 1.3; display: block; }

        /* ─── Ministries ─── */
        .w-min-grid { display: grid; gap: 20px; grid-template-columns: repeat(3, 1fr); }
        .w-min-card {
            background: var(--card); border: 1px solid var(--line); border-radius: 20px;
            overflow: hidden; box-shadow: var(--card-shadow);
            transition: box-shadow .25s, transform .25s;
        }
        .w-min-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.1); transform: translateY(-3px); }
        html.dark .w-min-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.4); }
        .w-min-header {
            padding: 22px 22px 16px;
            border-bottom: 1px solid var(--line);
            display: flex; align-items: flex-start; gap: 14px;
        }
        .w-min-icon {
            width: 46px; height: 46px; border-radius: 13px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .w-min-icon svg { width: 22px; height: 22px; }
        .w-min-title { flex: 1; min-width: 0; }
        .w-min-title h3 { font-size: 16px; font-weight: 700; color: var(--text); letter-spacing: -0.01em; line-height: 1.3; }
        .w-min-title span { font-size: 12px; color: var(--muted); font-weight: 500; font-family: "Noto Naskh Arabic", serif; }
        .w-min-services { padding: 16px 22px 20px; display: flex; flex-direction: column; gap: 8px; }
        .w-svc-row { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 6px 0; border-bottom: 1px solid var(--line); }
        .w-svc-row:last-child { border-bottom: none; }
        .w-svc-name { font-size: 13px; color: var(--text); font-weight: 500; flex: 1; min-width: 0; }
        .w-soon-pill {
            display: inline-flex; align-items: center; gap: 4px;
            background: rgba(107,104,96,0.08); border: 1px solid var(--line);
            border-radius: 999px; padding: 3px 9px;
            font-size: 10px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase;
            color: var(--muted); flex-shrink: 0; white-space: nowrap;
        }
        html.dark .w-soon-pill { background: rgba(255,255,255,0.05); }
        .w-apply-link {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11px; font-weight: 700; letter-spacing: .3px;
            color: #1B4F8A; background: rgba(27,79,138,0.07); border: 1px solid rgba(27,79,138,0.2);
            border-radius: 999px; padding: 3px 11px;
            text-decoration: none; transition: background .15s, color .15s, border-color .15s;
            flex-shrink: 0; white-space: nowrap;
        }
        .w-apply-link:hover { background: #1B4F8A; color: #fff; border-color: #1B4F8A; }
        html.dark .w-apply-link { color: #93b8e8; background: rgba(147,184,232,0.08); border-color: rgba(147,184,232,0.2); }
        html.dark .w-apply-link:hover { background: #1B4F8A; color: #fff; border-color: #1B4F8A; }
        .w-min-footer { padding: 14px 22px; background: var(--bg); border-top: 1px solid var(--line); }
        .w-min-count { font-size: 12px; color: var(--muted); font-weight: 600; }

        /* ─── How It Works ─── */
        .w-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; position: relative; }
        .w-steps::before {
            content: ""; position: absolute; top: 26px; left: 52px; right: 52px; height: 2px;
            background: linear-gradient(to right, rgba(27,79,138,0.25), rgba(27,79,138,0.05));
            pointer-events: none;
        }
        html[dir="rtl"] .w-steps::before { background: linear-gradient(to left, rgba(27,79,138,0.25), rgba(27,79,138,0.05)); }
        html.dark .w-steps::before { background: linear-gradient(to right, rgba(74,130,196,0.25), rgba(74,130,196,0.05)); }
        .w-step { text-align: center; position: relative; }
        .w-step-num {
            width: 52px; height: 52px; border-radius: 50%;
            background: #1B4F8A; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 800;
            box-shadow: 0 4px 16px rgba(27,79,138,0.35);
            margin: 0 auto 16px; position: relative; z-index: 1;
        }
        html.dark .w-step-num { background: #4A82C4; box-shadow: 0 4px 16px rgba(74,130,196,0.35); }
        .w-step h3 { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .w-step p  { font-size: 13px; color: var(--muted); line-height: 1.7; }

        /* ─── Features ─── */
        .w-feat-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .w-feat-card {
            background: var(--card); border: 1px solid var(--line); border-radius: 20px;
            padding: 28px 26px; box-shadow: var(--card-shadow);
            transition: box-shadow .2s, transform .2s;
        }
        .w-feat-card:hover { box-shadow: 0 10px 32px rgba(27,79,138,0.1); transform: translateY(-2px); }
        html.dark .w-feat-card:hover { box-shadow: 0 10px 32px rgba(74,130,196,0.12); }
        .w-feat-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: rgba(27,79,138,0.08);
            display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
        }
        html.dark .w-feat-icon { background: rgba(74,130,196,0.12); }
        .w-feat-icon svg { width: 24px; height: 24px; stroke: #1B4F8A; }
        html.dark .w-feat-icon svg { stroke: #4A82C4; }
        .w-feat-card h3 { font-size: 18px; font-weight: 700; color: var(--text); letter-spacing: -0.01em; margin-bottom: 8px; }
        .w-feat-card p  { color: var(--muted); line-height: 1.75; font-size: 14px; }

        /* ─── Track widget ─── */
        .w-track-panel {
            max-width: 640px; margin: 0 auto; background: var(--card);
            border: 1px solid var(--line); border-radius: 24px; padding: 44px 48px;
            box-shadow: var(--card-shadow); text-align: center;
        }
        .w-track-icon-wrap {
            width: 64px; height: 64px; border-radius: 50%;
            background: rgba(27,79,138,0.08); border: 1px solid rgba(27,79,138,0.14);
            display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;
        }
        html.dark .w-track-icon-wrap { background: rgba(74,130,196,0.1); border-color: rgba(74,130,196,0.2); }
        .w-track-icon-wrap svg { width: 28px; height: 28px; stroke: #1B4F8A; }
        html.dark .w-track-icon-wrap svg { stroke: #4A82C4; }
        .w-track-panel h2 { font-size: 26px; font-weight: 800; letter-spacing: -0.02em; color: var(--text); margin-bottom: 8px; }
        .w-track-panel p  { font-size: 15px; color: var(--muted); margin-bottom: 28px; line-height: 1.7; }
        .w-track-form { display: flex; gap: 10px; }
        .w-track-input {
            flex: 1; height: 50px; padding: 0 18px;
            border: 1.5px solid var(--line); border-radius: 12px;
            background: var(--bg); color: var(--text);
            font-family: "Outfit", sans-serif; font-size: 14px; font-weight: 500;
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        .w-track-input:focus { border-color: #1B4F8A; box-shadow: 0 0 0 3px rgba(27,79,138,0.12); }
        html.dark .w-track-input:focus { border-color: #4A82C4; box-shadow: 0 0 0 3px rgba(74,130,196,0.15); }
        .w-track-input::placeholder { color: var(--muted); }
        .w-track-btn {
            height: 50px; padding: 0 24px; border-radius: 12px;
            background: #1B4F8A; color: #fff; border: none;
            font-family: "Outfit", sans-serif; font-size: 14px; font-weight: 700;
            cursor: pointer; transition: all .2s; white-space: nowrap; flex-shrink: 0;
        }
        html.dark .w-track-btn { background: #4A82C4; }
        .w-track-btn:hover { background: #163F6E; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(27,79,138,0.35); }
        html.dark .w-track-btn:hover { background: #3A6BA8; }
        .w-track-note { margin-top: 14px; font-size: 12px; color: var(--muted); }

        /* ─── FAQ ─── */
        .w-faq-list { display: flex; flex-direction: column; gap: 10px; max-width: 800px; }
        details.w-faq-item {
            background: var(--card); border: 1px solid var(--line); border-radius: 16px;
            overflow: hidden; transition: box-shadow 0.2s;
        }
        details.w-faq-item[open] { box-shadow: 0 4px 20px rgba(27,79,138,0.08); }
        html.dark details.w-faq-item[open] { box-shadow: 0 4px 20px rgba(74,130,196,0.1); }
        details.w-faq-item summary {
            padding: 20px 24px; font-size: 15px; font-weight: 700; color: var(--text);
            cursor: pointer; list-style: none; display: flex; align-items: center;
            justify-content: space-between; gap: 16px; user-select: none;
            transition: color 0.15s;
        }
        details.w-faq-item summary::-webkit-details-marker { display: none; }
        details.w-faq-item[open] summary { color: #1B4F8A; border-bottom: 1px solid var(--line); }
        html.dark details.w-faq-item[open] summary { color: #4A82C4; }
        .w-faq-arrow {
            width: 28px; height: 28px; border-radius: 50%; border: 1.5px solid var(--line);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            transition: transform 0.25s, background 0.2s, border-color 0.2s;
        }
        details.w-faq-item[open] .w-faq-arrow { transform: rotate(180deg); background: rgba(27,79,138,0.08); border-color: rgba(27,79,138,0.2); }
        html.dark details.w-faq-item[open] .w-faq-arrow { background: rgba(74,130,196,0.1); border-color: rgba(74,130,196,0.25); }
        .w-faq-arrow svg { width: 14px; height: 14px; stroke: var(--muted); }
        details.w-faq-item[open] .w-faq-arrow svg { stroke: #1B4F8A; }
        html.dark details.w-faq-item[open] .w-faq-arrow svg { stroke: #4A82C4; }
        .w-faq-body { padding: 20px 24px; font-size: 14px; color: var(--muted); line-height: 1.8; }
        .w-faq-body strong { color: var(--text); font-weight: 600; }

        /* ─── Footer ─── */
        .w-footer { border-top: 1px solid var(--line); padding: 56px 0 36px; }
        .w-foot-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 48px; margin-bottom: 40px; }
        .w-foot-brand img { height: 42px; margin-bottom: 14px; }
        .w-foot-brand p { font-size: 13px; color: var(--muted); line-height: 1.75; max-width: 36ch; }
        .w-foot-col h4 { font-size: 13px; font-weight: 800; color: var(--text); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 16px; }
        .w-foot-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .w-foot-col ul li a { font-size: 13px; color: var(--muted); text-decoration: none; transition: color .15s; }
        .w-foot-col ul li a:hover { color: var(--brand); }
        .w-foot-bottom { padding-top: 28px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .w-foot-bottom span { font-size: 12px; color: var(--muted); }

        /* ─── Page transition ─── */
        #page-out { position: fixed; inset: 0; background: var(--bg); opacity: 0; pointer-events: none; z-index: 9999; transition: opacity 0.22s ease; }
        #page-out.active { opacity: 1; pointer-events: all; }

        /* ─── Chatbot ─── */
        @keyframes chatPulse { 0%,100%{transform:scale(1);opacity:.7} 50%{transform:scale(1.3);opacity:0} }
        #chatbot-messages::-webkit-scrollbar { width: 4px; }
        #chatbot-messages::-webkit-scrollbar-track { background: transparent; }
        #chatbot-messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .chat-msg-user { align-self:flex-end; background:#1B4F8A; color:#fff; padding:9px 13px; border-radius:14px 14px 4px 14px; font-size:13px; max-width:80%; line-height:1.5; word-wrap:break-word; font-family:Outfit,sans-serif; }
        html.dark .chat-msg-user { background:#4A82C4; }
        .chat-msg-ai { align-self:flex-start; background:#f1f5f9; color:#1F1F1F; padding:9px 13px; border-radius:14px 14px 14px 4px; font-size:13px; max-width:85%; line-height:1.5; word-wrap:break-word; font-family:Outfit,sans-serif; }
        html.dark .chat-msg-ai { background:#334155; color:#f1f5f9; }
        .chat-quick-btn { border:1px solid #cbd5e1; background:#f8fafc; color:#334155; border-radius:9999px; padding:6px 10px; font-size:11px; font-weight:600; line-height:1.2; cursor:pointer; transition:all .15s; }
        .chat-quick-btn:hover { border-color:#1B4F8A; color:#163F6E; background:#EEF3FA; }
        html.dark #chatbot-window { background:#1F1F1F !important; }
        html.dark #chatbot-input  { background:#141414 !important; border-color:#2E2E2E !important; color:#f1f5f9 !important; }
        html.dark .chat-quick-btn { background:#141414; border-color:#334155; color:#cbd5e1; }
        html.dark .chat-quick-btn:hover { background:#1F1F1F; border-color:#4A82C4; color:#D6E4F5; }
        .typing-dot { width:7px;height:7px;background:#94a3b8;border-radius:50%;display:inline-block;animation:typingBounce 1.2s infinite ease-in-out; }
        .typing-dot:nth-child(2){animation-delay:.2s}.typing-dot:nth-child(3){animation-delay:.4s}
        @keyframes typingBounce{0%,80%,100%{transform:translateY(0)}40%{transform:translateY(-6px)}}
        @media (min-width:1024px) { #chatbot-wrapper { bottom:24px !important; } }

        /* ─── Responsive ─── */
        @media (max-width: 1050px) {
            .w-menu { display: none; }
            .w-hero-grid { grid-template-columns: 1fr; min-height: unset; }
            .w-hero-visual { display: none; }
            .w-hero-text { padding: 48px 40px 44px; }
            .w-stats { grid-template-columns: repeat(2, 1fr); }
            .w-min-grid { grid-template-columns: 1fr 1fr; }
            .w-steps { grid-template-columns: 1fr 1fr; gap: 32px; }
            .w-steps::before { display: none; }
            .w-feat-grid { grid-template-columns: 1fr 1fr; }
            .w-foot-grid { grid-template-columns: 1fr 1fr; }
            .w-foot-brand { grid-column: 1 / -1; }
        }
        @media (max-width: 760px) {
            .w-container { width: min(1200px, calc(100% - 28px)); }
            .w-nav { min-height: 64px; }
            .w-nav-right .w-btn { display: none; }
            .w-hero-text { padding: 36px 20px 32px; }
            .w-h1 { font-size: 30px; }
            .w-stats { grid-template-columns: repeat(2, 1fr); gap: 8px; }
            .w-stat { padding: 12px 12px; }
            .w-stat strong { font-size: 18px; }
            .w-min-grid { grid-template-columns: 1fr; }
            .w-steps { grid-template-columns: 1fr; }
            .w-feat-grid { grid-template-columns: 1fr; }
            .w-track-panel { padding: 28px 22px; }
            .w-track-form { flex-direction: column; }
            .w-track-btn { width: 100%; justify-content: center; height: 48px; }
            .w-foot-grid { grid-template-columns: 1fr; gap: 28px; }
            .w-foot-bottom { flex-direction: column; align-items: flex-start; gap: 6px; }
            .w-section { padding: 52px 0; }
            .w-section-sm { padding: 40px 0; }
            .w-trust-items { flex-wrap: wrap; }
            .w-trust-item { padding: 10px 16px; font-size: 12px; }
            .w-trust-sep { display: none; }
        }
        @media (max-width: 420px) {
            .w-brand-text strong { font-size: 18px; }
            .w-brand-text small { font-size: 10px; }
        }

        /* ─── Ministry Navigation Cards ─── */
        .w-min-nav-grid {
            display: grid;
            gap: 22px;
            grid-template-columns: repeat(3, 1fr);
        }
        .w-min-nav-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: box-shadow .3s ease, transform .28s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            color: inherit;
        }
        .w-min-nav-card:hover {
            box-shadow: 0 20px 56px rgba(0,0,0,0.13);
            transform: translateY(-5px);
        }
        html.dark .w-min-nav-card:hover { box-shadow: 0 20px 56px rgba(0,0,0,0.52); }
        .w-min-nav-hero {
            padding: 26px 24px 22px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 14px;
            min-height: 130px;
            justify-content: flex-end;
        }
        .w-min-nav-hero::before {
            content: "";
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 18px 18px;
            pointer-events: none;
        }
        .w-min-nav-icon-box {
            width: 50px; height: 50px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.22);
            flex-shrink: 0;
        }
        .w-min-nav-icon-box svg { width: 22px; height: 22px; stroke: #fff; }
        .w-min-nav-name-en {
            font-size: 19px; font-weight: 800; letter-spacing: -0.015em;
            color: #fff; line-height: 1.2;
            text-shadow: 0 1px 6px rgba(0,0,0,0.25);
        }
        .w-min-nav-name-ku {
            font-size: 13px; color: rgba(255,255,255,0.72);
            font-family: "Noto Naskh Arabic", serif; font-weight: 600;
            margin-top: 2px;
        }
        .w-min-nav-body {
            padding: 18px 24px 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .w-min-nav-desc {
            font-size: 13.5px; color: var(--muted); line-height: 1.72; flex: 1;
        }
        .w-min-nav-services { display: flex; flex-wrap: wrap; gap: 6px; }
        .w-min-nav-svc-tag {
            font-size: 11px; font-weight: 600;
            padding: 3px 10px; border-radius: 6px;
            background: var(--bg); border: 1px solid var(--line);
            color: var(--muted); white-space: nowrap;
        }
        .w-min-nav-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--line);
            background: var(--bg);
            display: flex; justify-content: space-between; align-items: center;
        }
        .w-min-nav-count { font-size: 12px; font-weight: 600; color: var(--muted); }
        .w-min-nav-link {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 13px; font-weight: 700;
            text-decoration: none;
        }
        .w-min-nav-link svg { width: 14px; height: 14px; transition: transform .18s ease; }
        .w-min-nav-card:hover .w-min-nav-link svg { transform: translateX(4px); }
        @media (max-width: 1050px) { .w-min-nav-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 600px)  { .w-min-nav-grid { grid-template-columns: 1fr; } }

        /* ─── Office Locator ─── */
        .w-office-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .w-office-card {
            background: var(--card); border: 1px solid var(--line); border-radius: 20px;
            overflow: hidden; box-shadow: var(--card-shadow);
            transition: box-shadow .25s, transform .25s;
        }
        .w-office-card:hover { box-shadow: 0 10px 36px rgba(0,0,0,0.09); transform: translateY(-2px); }
        html.dark .w-office-card:hover { box-shadow: 0 10px 36px rgba(0,0,0,0.35); }
        .w-office-header { padding: 18px 20px 14px; border-bottom: 1px solid var(--line); display: flex; align-items: center; gap: 12px; }
        .w-office-icon { width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .w-office-icon svg { width: 20px; height: 20px; }
        .w-office-name { flex: 1; min-width: 0; }
        .w-office-name h3 { font-size: 14px; font-weight: 700; color: var(--text); line-height: 1.3; }
        .w-office-name span { font-size: 11px; color: var(--muted); font-family: "Noto Naskh Arabic", serif; }
        .w-office-body { padding: 14px 20px 16px; display: flex; flex-direction: column; gap: 10px; }
        .w-office-row { display: flex; align-items: flex-start; gap: 9px; }
        .w-office-row svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 2px; }
        .w-office-info { font-size: 13px; color: var(--muted); line-height: 1.55; }
        .w-office-info strong { color: var(--text); font-weight: 700; display: block; font-size: 10.5px; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
        .w-office-footer { padding: 12px 20px; border-top: 1px solid var(--line); background: var(--bg); }
        .w-office-link { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 700; color: var(--brand); text-decoration: none; transition: gap .15s; }
        .w-office-link:hover { gap: 8px; }
        .w-office-link svg { width: 13px; height: 13px; }
        @media (max-width: 1050px) { .w-office-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 640px) { .w-office-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div id="page-out"></div>

    {{-- ── Announcement bar ── --}}
    <div id="announce-bar" class="w-announce" role="status" aria-label="Site announcement">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span data-i18n="announce.text">Official Kurdistan Region Government Portal &mdash; Digital services are being prepared and will launch soon. Register now to be among the first notified.</span>
        <button class="w-announce-dismiss" onclick="dismissAnnounce()" aria-label="Dismiss announcement">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- ── Navbar ── --}}
    <header class="w-topbar">
        <div class="w-container w-nav">

            <a href="{{ url('/') }}" class="w-brand">
                <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn">
                <span class="w-brand-text">
                    <strong>Halzanîn</strong>
                    <small data-i18n="Kurdistan Government Portal">Kurdistan Government Portal</small>
                </span>
            </a>

            <nav class="w-menu" aria-label="Main navigation">
                <a href="#ministries" data-i18n="Services">Services</a>
                <a href="#how-it-works" data-i18n="How It Works">How It Works</a>
                <a href="#track" data-i18n="Track Application">Track</a>
                <a href="#faq" data-i18n="FAQ">FAQ</a>
            </nav>

            <div class="w-nav-right">
                <div class="w-toggles">
                    <button id="theme-toggle" class="w-theme-btn" title="Toggle dark mode" aria-label="Toggle dark mode">
                        <svg id="theme-icon-sun" style="display:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </svg>
                        <svg id="theme-icon-moon" style="display:none;" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                        </svg>
                    </button>
                    <div class="w-divider" aria-hidden="true"></div>
                    <div class="w-lang-seg" role="group" aria-label="Language selection">
                        <button id="lang-en-btn" class="w-lang-opt" onclick="setLang('en')" aria-label="Switch to English">EN</button>
                        <button id="lang-ku-btn" class="w-lang-opt" onclick="setLang('ku')" style="font-family:'Noto Naskh Arabic',serif;" aria-label="Switch to Kurdish">کوردی</button>
                    </div>
                </div>

                @auth
                    <a href="{{ url('/dashboard') }}" class="w-btn w-btn-outline" data-i18n="My Dashboard">My Dashboard</a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="w-btn w-btn-outline" data-i18n="Log In">Log In</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-btn w-btn-primary" data-i18n="Create Account">Create Account</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main>

        {{-- ── Hero ── --}}
        <section class="w-hero-wrap" aria-label="Portal introduction">
            <div class="w-container">
                <div class="w-hero">
                    <div class="w-hero-grid">

                        <div class="w-hero-text">
                            <div class="w-kicker">
                                <svg class="w-kicker-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span data-i18n="Kurdistan Region e-Government Portal">Kurdistan Region e-Government Portal</span>
                            </div>

                            <h1 class="w-h1">
                                <span data-i18n="All Your Government Services, Online">
                                    All Your Government Services, Online
                                </span>
                            </h1>

                            <p class="w-subtitle" data-i18n="hero.subtitle">
                                Submit applications, upload documents, book appointments, and track your request — for any government service — from the comfort of your home. No queuing. No multiple visits.
                            </p>

                            <div class="w-cta">
                                @auth
                                    <a class="w-btn w-btn-primary" href="{{ url('/dashboard') }}" data-i18n="Go To Dashboard">
                                        <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        <span data-i18n="Go To Dashboard">Go To Dashboard</span>
                                    </a>
                                @else
                                    @if (Route::has('register'))
                                        <a class="w-btn w-btn-primary" href="{{ route('register') }}" data-i18n="Create Free Account">Create Free Account</a>
                                    @endif
                                    @if (Route::has('login'))
                                        <a class="w-btn w-btn-outline" href="{{ route('login') }}" data-i18n="Sign In">Sign In</a>
                                    @endif
                                @endauth
                                <a class="w-btn w-btn-outline" href="#track" data-i18n="Track Application">Track Application</a>
                            </div>

                            <div class="w-stats" role="list" aria-label="Portal statistics">
                                <div class="w-stat" role="listitem">
                                    <strong>{{ $portalStats['ministries'] ?? 5 }}</strong>
                                    <span data-i18n="Government Ministries">Government Ministries</span>
                                </div>
                                <div class="w-stat" role="listitem">
                                    <strong>{{ $portalStats['services'] ?? 15 }}+</strong>
                                    <span data-i18n="Services Available">Services Available</span>
                                </div>
                                <div class="w-stat" role="listitem">
                                    <strong>100%</strong>
                                    <span data-i18n="Digital Processing">Digital Processing</span>
                                </div>
                                <div class="w-stat" role="listitem">
                                    <strong>24/7</strong>
                                    <span data-i18n="System Availability">System Availability</span>
                                </div>
                            </div>
                        </div>

                        {{-- Hero image panel (desktop only) --}}
                        <div class="w-hero-visual" aria-hidden="true">
                            <div class="w-hero-img-wrap">
                                <img
                                    src="{{ asset('images/hero-building.png') }}"
                                    alt=""
                                    class="w-hero-img"
                                    onerror="this.style.display='none';"
                                >
                                <div class="w-hero-img-fade"></div>
                            </div>
                            <div class="w-hero-img-badge">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Kurdistan Region</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- ── Trust strip ── --}}
        <div class="w-trust-strip" aria-label="Platform trust indicators">
            <div class="w-container">
                <div class="w-trust-items">
                    <div class="w-trust-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <span><strong>OTP-Secured</strong> Accounts</span>
                    </div>
                    <div class="w-trust-sep" aria-hidden="true"></div>
                    <div class="w-trust-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span><strong>Official</strong> Government Portal</span>
                    </div>
                    <div class="w-trust-sep" aria-hidden="true"></div>
                    <div class="w-trust-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                        <span>Available <strong>24 / 7</strong></span>
                    </div>
                    <div class="w-trust-sep" aria-hidden="true"></div>
                    <div class="w-trust-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <span><strong>Free</strong> for All Citizens</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Ministries ── --}}
        <section class="w-section" id="ministries" aria-labelledby="ministries-heading">
            <div class="w-container">
                <div class="w-section-head">
                    <div class="w-kicker">
                        <svg class="w-kicker-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                        <span data-i18n="Government Ministries">Government Ministries</span>
                    </div>
                    <h2 id="ministries-heading" data-i18n="ministries.title">Select a ministry</h2>
                    <p class="w-section-sub" data-i18n="ministries.subtitle">
                        Each ministry has a dedicated page with full service descriptions, required documents, and guided applications. Select one to get started.
                    </p>
                </div>

                <div class="w-min-nav-grid">

                    {{-- Civil Registry --}}
                    <a href="{{ route('ministry.civil-registry') }}" class="w-min-nav-card" aria-label="Civil Registry — تۆماری مەدەنی">
                        <div class="w-min-nav-hero" style="background:linear-gradient(148deg,#0b1f38 0%,#1A3A5C 55%,#1e4876 100%);">
                            <div class="w-min-nav-icon-box">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c0 1.306.834 2.417 2 2.83M19 17c-1.166-.413-2-1.524-2-2.83"/></svg>
                            </div>
                            <div>
                                <div class="w-min-nav-name-en">Civil Registry</div>
                                <div class="w-min-nav-name-ku">تۆماری مەدەنی</div>
                            </div>
                        </div>
                        <div class="w-min-nav-body">
                            <p class="w-min-nav-desc" data-i18n="min.civil.desc">Passports, national ID cards, birth certificates, and marriage registration for all Kurdistan Region citizens.</p>
                            <div class="w-min-nav-services">
                                <span class="w-min-nav-svc-tag">Passport</span>
                                <span class="w-min-nav-svc-tag">National ID</span>
                                <span class="w-min-nav-svc-tag">Birth Certificate</span>
                            </div>
                        </div>
                        <div class="w-min-nav-footer">
                            <span class="w-min-nav-count">4 services</span>
                            <span class="w-min-nav-link" style="color:#1A3A5C;">
                                Explore services
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Traffic Police --}}
                    <a href="{{ route('ministry.traffic-police') }}" class="w-min-nav-card" aria-label="Traffic Police — پۆلیسی ترافیک">
                        <div class="w-min-nav-hero" style="background:linear-gradient(148deg,#111118 0%,#2C2C3E 55%,#3a1a1e 100%);">
                            <div class="w-min-nav-icon-box" style="background:rgba(220,38,38,0.28);border-color:rgba(220,38,38,0.4);">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.5.5M13 16H3m10 0l.5.5M13 6l3 5h4v5h-2.5"/></svg>
                            </div>
                            <div>
                                <div class="w-min-nav-name-en">Traffic Police</div>
                                <div class="w-min-nav-name-ku">پۆلیسی ترافیک</div>
                            </div>
                        </div>
                        <div class="w-min-nav-body">
                            <p class="w-min-nav-desc" data-i18n="min.traffic.desc">Driving licenses, vehicle registration, and traffic fine payments for motorists across the Kurdistan Region.</p>
                            <div class="w-min-nav-services">
                                <span class="w-min-nav-svc-tag">Driving License</span>
                                <span class="w-min-nav-svc-tag">Vehicle Reg.</span>
                                <span class="w-min-nav-svc-tag">Traffic Fines</span>
                            </div>
                        </div>
                        <div class="w-min-nav-footer">
                            <span class="w-min-nav-count">3 services</span>
                            <span class="w-min-nav-link" style="color:#2C2C3E;">
                                Explore services
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Electricity --}}
                    <a href="{{ route('ministry.electricity') }}" class="w-min-nav-card" aria-label="Electricity Directorate — بەرپرسایەتی کارەبا">
                        <div class="w-min-nav-hero" style="background:linear-gradient(148deg,#4a2900 0%,#D97706 55%,#b45309 100%);">
                            <div class="w-min-nav-icon-box">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <div class="w-min-nav-name-en">Electricity Directorate</div>
                                <div class="w-min-nav-name-ku">بەرپرسایەتی کارەبا</div>
                            </div>
                        </div>
                        <div class="w-min-nav-body">
                            <p class="w-min-nav-desc" data-i18n="min.electricity.desc">New electricity connections, service complaints, and meter-related requests for homes and businesses.</p>
                            <div class="w-min-nav-services">
                                <span class="w-min-nav-svc-tag">New Connection</span>
                                <span class="w-min-nav-svc-tag">Complaints</span>
                                <span class="w-min-nav-svc-tag">Meter Issues</span>
                            </div>
                        </div>
                        <div class="w-min-nav-footer">
                            <span class="w-min-nav-count">3 services</span>
                            <span class="w-min-nav-link" style="color:#D97706;">
                                Explore services
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Water Authority --}}
                    <a href="{{ route('ministry.water') }}" class="w-min-nav-card" aria-label="Water Authority — بەرپرسایەتی ئاو">
                        <div class="w-min-nav-hero" style="background:linear-gradient(148deg,#032a1e 0%,#0E7C5A 55%,#0a6a4d 100%);">
                            <div class="w-min-nav-icon-box">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                            </div>
                            <div>
                                <div class="w-min-nav-name-en">Water Authority</div>
                                <div class="w-min-nav-name-ku">بەرپرسایەتی ئاو</div>
                            </div>
                        </div>
                        <div class="w-min-nav-body">
                            <p class="w-min-nav-desc" data-i18n="min.water.desc">Water supply connections, maintenance requests, and complaint submissions for residential and commercial properties.</p>
                            <div class="w-min-nav-services">
                                <span class="w-min-nav-svc-tag">New Connection</span>
                                <span class="w-min-nav-svc-tag">Maintenance</span>
                                <span class="w-min-nav-svc-tag">Complaints</span>
                            </div>
                        </div>
                        <div class="w-min-nav-footer">
                            <span class="w-min-nav-count">2 services</span>
                            <span class="w-min-nav-link" style="color:#0E7C5A;">
                                Explore services
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Health Ministry --}}
                    <a href="{{ route('ministry.health') }}" class="w-min-nav-card" aria-label="Health Ministry — وەزارەتی تەندروستی">
                        <div class="w-min-nav-hero" style="background:linear-gradient(148deg,#072a1b 0%,#1A6B4A 55%,#155a3f 100%);">
                            <div class="w-min-nav-icon-box">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                            <div>
                                <div class="w-min-nav-name-en">Health Ministry</div>
                                <div class="w-min-nav-name-ku">وەزارەتی تەندروستی</div>
                            </div>
                        </div>
                        <div class="w-min-nav-body">
                            <p class="w-min-nav-desc" data-i18n="min.health.desc">Health cards, medical certificates, hospital referrals, and healthcare registrations for residents of the Kurdistan Region.</p>
                            <div class="w-min-nav-services">
                                <span class="w-min-nav-svc-tag">Health Card</span>
                                <span class="w-min-nav-svc-tag">Certificates</span>
                                <span class="w-min-nav-svc-tag">Referrals</span>
                            </div>
                        </div>
                        <div class="w-min-nav-footer">
                            <span class="w-min-nav-count">3 services</span>
                            <span class="w-min-nav-link" style="color:#1A6B4A;">
                                Explore services
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                </div>
            </div>
        </section>

        {{-- ── How It Works ── --}}
        <section class="w-section w-alt-bg" id="how-it-works" aria-labelledby="hiw-heading">
            <div class="w-container">
                <div class="w-section-head">
                    <div class="w-kicker">
                        <svg class="w-kicker-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span data-i18n="Simple Process">Simple Process</span>
                    </div>
                    <h2 id="hiw-heading" data-i18n="How It Works">How It Works</h2>
                    <p class="w-section-sub" data-i18n="hiw.subtitle">
                        Four steps is all it takes to submit any government service application — no queuing, no paper forms, no multiple office visits.
                    </p>
                </div>
                <div class="w-steps" role="list">
                    <div class="w-step" role="listitem">
                        <div class="w-step-num" aria-hidden="true">1</div>
                        <h3 data-i18n="Create Your Account">Create Your Account</h3>
                        <p data-i18n="hiw.step1">Register once with your email. Verify with a one-time code sent to your inbox to keep your account secure.</p>
                    </div>
                    <div class="w-step" role="listitem">
                        <div class="w-step-num" aria-hidden="true">2</div>
                        <h3 data-i18n="Choose a Service">Choose a Service</h3>
                        <p data-i18n="hiw.step2">Browse the ministries above and select the service you need. Each service page lists exactly what documents are required.</p>
                    </div>
                    <div class="w-step" role="listitem">
                        <div class="w-step-num" aria-hidden="true">3</div>
                        <h3 data-i18n="Submit & Book">Submit & Book</h3>
                        <p data-i18n="hiw.step3">Fill the form, upload your documents, and book an appointment — all in one flow. You receive a QR tracking code instantly.</p>
                    </div>
                    <div class="w-step" role="listitem">
                        <div class="w-step-num" aria-hidden="true">4</div>
                        <h3 data-i18n="Track Your Status">Track Your Status</h3>
                        <p data-i18n="hiw.step4">Monitor every status update from your dashboard or using your tracking code — no login required for tracking.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Platform Features ── --}}
        <section class="w-section" aria-labelledby="features-heading">
            <div class="w-container">
                <div class="w-section-head">
                    <div class="w-kicker">
                        <svg class="w-kicker-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span data-i18n="Platform Features">Platform Features</span>
                    </div>
                    <h2 id="features-heading" data-i18n="Built for Citizens">Built for Citizens</h2>
                    <p class="w-section-sub" data-i18n="features.subtitle">
                        Every feature is designed to make government services easier, faster, and more transparent for every citizen in the Kurdistan Region.
                    </p>
                </div>
                <div class="w-feat-grid">
                    <article class="w-feat-card">
                        <div class="w-feat-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 data-i18n="Smart Appointment Booking">Smart Appointment Booking</h3>
                        <p data-i18n="feature.appointments">Choose from available calendar slots for each ministry. Our system prevents double-booking and automatically sends you reminders before your appointment.</p>
                    </article>
                    <article class="w-feat-card">
                        <div class="w-feat-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3 data-i18n="Secure Document Vault">Secure Document Vault</h3>
                        <p data-i18n="feature.vault">Upload your documents once and reuse them across multiple applications. Your files are stored securely and are only accessible by you and the relevant ministry staff.</p>
                    </article>
                    <article class="w-feat-card">
                        <div class="w-feat-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 data-i18n="Live Application Tracking">Live Application Tracking</h3>
                        <p data-i18n="feature.tracking">Every application gets a unique QR tracking code. Check your status anytime — from the portal or by sharing your code — with no login required for public lookups.</p>
                    </article>
                    <article class="w-feat-card">
                        <div class="w-feat-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <h3 data-i18n="AI-Powered Assistant">AI-Powered Assistant</h3>
                        <p data-i18n="feature.chatbot">Not sure which service you need or what documents to prepare? Our AI assistant — available 24/7 — answers your questions in both English and Kurdish.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ── Track Application ── --}}
        <section class="w-section-sm w-alt-bg" id="track" aria-labelledby="track-heading">
            <div class="w-container">
                <div class="w-track-panel">
                    <div class="w-track-icon-wrap" aria-hidden="true">
                        <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h2 id="track-heading" data-i18n="Track Your Application">Track Your Application</h2>
                    <p data-i18n="track.subtitle">Enter your tracking code below to check your application status in real time. No login required.</p>
                    <form class="w-track-form" onsubmit="handleTrack(event)" role="search" aria-label="Application tracking">
                        <label for="track-code" class="sr-only" data-i18n="Tracking Code">Tracking Code</label>
                        <input
                            type="text"
                            id="track-code"
                            class="w-track-input"
                            placeholder="e.g. HZ-XXXXXXXX"
                            data-i18n-placeholder="track.placeholder"
                            autocomplete="off"
                            spellcheck="false"
                            aria-label="Enter tracking code"
                        >
                        <button type="submit" class="w-track-btn" data-i18n="Track Now">Track Now</button>
                    </form>
                    <p class="w-track-note" data-i18n="track.note">Your tracking code was provided when you submitted your application. Check your email or your dashboard.</p>
                </div>
            </div>
        </section>

        {{-- ── FAQ ── --}}
        <section class="w-section" id="faq" aria-labelledby="faq-heading">
            <div class="w-container">
                <div class="w-section-head">
                    <div class="w-kicker">
                        <svg class="w-kicker-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span data-i18n="FAQ">Frequently Asked Questions</span>
                    </div>
                    <h2 id="faq-heading" data-i18n="Common Questions">Common Questions</h2>
                    <p class="w-section-sub" data-i18n="faq.subtitle">Everything citizens need to know before using the portal. Can't find your answer? Use our AI assistant.</p>
                </div>

                <div class="w-faq-list" role="list">

                    <details class="w-faq-item" role="listitem">
                        <summary>
                            <span data-i18n="faq.q1">What is the Halzanîn portal?</span>
                            <span class="w-faq-arrow" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg></span>
                        </summary>
                        <div class="w-faq-body" data-i18n="faq.a1">
                            Halzanîn is the official digital government services portal for the Kurdistan Region. It allows citizens to apply for government services, upload required documents, book appointments at government offices, and track their application status — all from one place, without needing to queue at a physical office for the initial paperwork.
                        </div>
                    </details>

                    <details class="w-faq-item" role="listitem">
                        <summary>
                            <span data-i18n="faq.q2">Which government services are currently available?</span>
                            <span class="w-faq-arrow" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg></span>
                        </summary>
                        <div class="w-faq-body" data-i18n="faq.a2">
                            We are currently in the launch phase of the portal. Services from five ministries — <strong>Civil Registry, Traffic Police, Electricity Directorate, Water Directorate,</strong> and <strong>Business Registration</strong> — are being prepared and will be available very soon. Sign up now to be notified as each service goes live.
                        </div>
                    </details>

                    <details class="w-faq-item" role="listitem">
                        <summary>
                            <span data-i18n="faq.q3">Do I need to create an account to use the portal?</span>
                            <span class="w-faq-arrow" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg></span>
                        </summary>
                        <div class="w-faq-body" data-i18n="faq.a3">
                            You need an account to <strong>submit applications</strong>, upload documents, and book appointments. However, you can <strong>track any application</strong> by entering your tracking code on this page — no login required. Creating an account is free and only takes a few minutes.
                        </div>
                    </details>

                    <details class="w-faq-item" role="listitem">
                        <summary>
                            <span data-i18n="faq.q4">Will I still need to visit a government office?</span>
                            <span class="w-faq-arrow" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg></span>
                        </summary>
                        <div class="w-faq-body" data-i18n="faq.a4">
                            For most services, the portal <strong>significantly reduces</strong> the number of office visits required. You handle all paperwork, document submission, and scheduling online. A physical visit is still required in specific cases — for example, picking up a physical document like an ID card, or for services that require in-person verification such as driving tests. The portal tells you exactly when and why a visit is needed.
                        </div>
                    </details>

                    <details class="w-faq-item" role="listitem">
                        <summary>
                            <span data-i18n="faq.q5">How do I know what documents I need to prepare?</span>
                            <span class="w-faq-arrow" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg></span>
                        </summary>
                        <div class="w-faq-body" data-i18n="faq.a5">
                            Each service has a dedicated page that lists the <strong>exact documents required</strong> before you begin your application. Documents accepted include scanned copies as JPG, PNG, or PDF files up to 5MB each. You can also store your frequently used documents in your secure <strong>Document Vault</strong> and reuse them across multiple applications without re-uploading.
                        </div>
                    </details>

                    <details class="w-faq-item" role="listitem">
                        <summary>
                            <span data-i18n="faq.q6">How long does processing take?</span>
                            <span class="w-faq-arrow" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg></span>
                        </summary>
                        <div class="w-faq-body" data-i18n="faq.a6">
                            Processing time varies by service type and the completeness of your submitted documents. Each service page shows an estimated processing time. You will receive <strong>email notifications</strong> at every stage — when your documents are received, when they are under review, and when your application is approved or requires additional information.
                        </div>
                    </details>

                    <details class="w-faq-item" role="listitem">
                        <summary>
                            <span data-i18n="faq.q7">Is my personal information secure?</span>
                            <span class="w-faq-arrow" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg></span>
                        </summary>
                        <div class="w-faq-body" data-i18n="faq.a7">
                            Yes. Your account is protected by <strong>email OTP two-factor authentication</strong>. All documents are stored securely and only accessible by you and the assigned ministry staff handling your case. Staff from one ministry cannot access data submitted to a different ministry. We follow OWASP security standards throughout the platform.
                        </div>
                    </details>

                    <details class="w-faq-item" role="listitem">
                        <summary>
                            <span data-i18n="faq.q8">What do I do if my application is rejected?</span>
                            <span class="w-faq-arrow" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg></span>
                        </summary>
                        <div class="w-faq-body" data-i18n="faq.a8">
                            If your application is rejected, you will receive an <strong>email notification with the reason</strong> for the rejection. You can view the staff's notes directly in your dashboard, correct the issue (such as providing a clearer document scan or a missing file), and resubmit your application. Our AI assistant can also help you understand what went wrong.
                        </div>
                    </details>

                </div>
            </div>
        </section>

    </main>

    {{-- ── Footer ── --}}
    <footer class="w-footer" aria-label="Site footer">
        <div class="w-container">
            <div class="w-foot-grid">
                <div class="w-foot-brand">
                    <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn">
                    <p data-i18n="footer.about">Halzanîn is the Kurdistan Region's unified e-government portal — bringing all government services online so citizens can access them quickly, securely, and from anywhere.</p>
                </div>
                <div class="w-foot-col">
                    <h4 data-i18n="Quick Links">Quick Links</h4>
                    <ul>
                        <li><a href="#ministries" data-i18n="Browse Services">Browse Services</a></li>
                        <li><a href="#how-it-works" data-i18n="How It Works">How It Works</a></li>
                        <li><a href="#track" data-i18n="Track Application">Track Application</a></li>
                        <li><a href="#faq" data-i18n="FAQ">FAQ</a></li>
                        @if (Route::has('login'))
                            <li><a href="{{ route('login') }}" data-i18n="Log In">Log In</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" data-i18n="Create Account">Create Account</a></li>
                        @endif
                    </ul>
                </div>
                <div class="w-foot-col">
                    <h4 data-i18n="Ministries">Ministries</h4>
                    <ul>
                        <li><a href="{{ route('ministry.civil-registry') }}" data-i18n="Civil Registry">Civil Registry</a></li>
                        <li><a href="{{ route('ministry.traffic-police') }}" data-i18n="Traffic Police">Traffic Police</a></li>
                        <li><a href="{{ route('ministry.electricity') }}" data-i18n="Electricity Directorate">Electricity</a></li>
                        <li><a href="{{ route('ministry.water') }}" data-i18n="Water Directorate">Water Authority</a></li>
                        <li><a href="{{ route('ministry.health') }}" data-i18n="Health Ministry">Health Ministry</a></li>
                    </ul>
                </div>
            </div>
            <div class="w-foot-bottom">
                <span data-i18n="footer.copyright">© 2025 Halzanîn — Kurdistan Government Services Portal</span>
                <span data-i18n="footer.tagline">Built for transparent and efficient public service delivery</span>
            </div>
        </div>
    </footer>

    {{-- ── Chatbot widget (visible to guests; prompts login for chat) ── --}}
    <div id="chatbot-wrapper" style="position:fixed;bottom:88px;right:20px;z-index:10000;display:flex;flex-direction:column;align-items:flex-end;gap:12px;">

        <div id="chatbot-window"
             style="display:none;width:340px;max-width:90vw;height:480px;background:#ffffff;border-radius:16px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);flex-direction:column;overflow:hidden;border:1px solid rgba(0,0,0,0.06);">
            <div style="background:#1B4F8A;padding:14px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0;">
                <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/></svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p style="color:#fff;font-weight:700;font-size:14px;margin:0;font-family:Outfit,sans-serif;" data-i18n="chat.assistant">Halzanîn Assistant</p>
                    <div style="display:flex;align-items:center;gap:5px;margin-top:2px;">
                        <div style="width:7px;height:7px;background:#4ade80;border-radius:50%;"></div>
                        <span style="color:rgba(255,255,255,0.8);font-size:11px;font-weight:600;" data-i18n="chat.online">Online</span>
                    </div>
                </div>
                <button onclick="toggleChat()" style="background:rgba(255,255,255,0.15);border:none;width:28px;height:28px;border-radius:50%;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'" aria-label="Close chat">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="chatbot-messages" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;background:inherit;"></div>
            <div style="padding:12px;border-top:1px solid rgba(0,0,0,0.07);background:inherit;flex-shrink:0;">
                @php($chatQuickQuestions = config('chatbot.quick_questions', []))
                <div id="chatbot-quick-questions" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
                    @foreach($chatQuickQuestions as $question)
                        <button type="button" class="chat-quick-btn"
                                data-en="{{ $question['en'] ?? '' }}"
                                data-ku="{{ $question['ku'] ?? '' }}"
                                onclick="sendQuickQuestion(this)"></button>
                    @endforeach
                </div>
                <div style="display:flex;gap:8px;align-items:flex-end;">
                    <textarea id="chatbot-input"
                              placeholder="Ask me anything..."
                              data-i18n-placeholder="chat.placeholder"
                              rows="1"
                              onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendChatMessage();}"
                              oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,88)+'px';"
                              style="flex:1;resize:none;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 12px;font-size:13px;font-family:Outfit,sans-serif;outline:none;background:#f8fafc;color:#1F1F1F;max-height:88px;line-height:1.4;transition:border-color 0.2s;"
                              onfocus="this.style.borderColor='#1B4F8A'" onblur="this.style.borderColor='#e2e8f0'"
                              aria-label="Chat message input"></textarea>
                    <button onclick="sendChatMessage()" id="chatbot-send"
                            style="width:40px;height:40px;border-radius:10px;background:#1B4F8A;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:transform 0.15s,opacity 0.15s;"
                            onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                            aria-label="Send message">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div style="position:relative;">
            <div id="chatbot-pulse" style="position:absolute;inset:-6px;border-radius:50%;background:rgba(27,79,138,0.3);animation:chatPulse 2s ease-in-out infinite;pointer-events:none;" aria-hidden="true"></div>
            <button id="chatbot-btn" onclick="toggleChat()"
                    style="width:56px;height:56px;border-radius:50%;background:#1B4F8A;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 25px -5px rgba(27,79,138,0.5);transition:transform 0.2s,box-shadow 0.2s;position:relative;z-index:1;"
                    onmouseover="this.style.transform='scale(1.08)';this.style.boxShadow='0 15px 30px -5px rgba(27,79,138,0.6)'"
                    onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 10px 25px -5px rgba(27,79,138,0.5)'"
                    aria-label="Open AI assistant">
                <svg id="chatbot-icon-open" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <svg id="chatbot-icon-close" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                <div id="chatbot-badge" style="position:absolute;top:-2px;right:-2px;width:14px;height:14px;background:#ef4444;border-radius:50%;border:2px solid #fff;display:none;" aria-hidden="true"></div>
            </button>
        </div>
    </div>

    {{-- Screen-reader only helper --}}
    <style>.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0;}</style>

    {{-- ── Scripts ── --}}
    <script>
        /* ── Announcement bar ── */
        function dismissAnnounce() {
            var bar = document.getElementById('announce-bar');
            if (bar) { bar.style.display = 'none'; }
            try { sessionStorage.setItem('announceDismissed', '1'); } catch(e) {}
        }
        (function() {
            try { if (sessionStorage.getItem('announceDismissed') === '1') {
                var bar = document.getElementById('announce-bar');
                if (bar) bar.style.display = 'none';
            } } catch(e) {}
        })();

        /* ── Theme toggle ── */
        (function() {
            var sunIcon  = document.getElementById('theme-icon-sun');
            var moonIcon = document.getElementById('theme-icon-moon');
            var btn      = document.getElementById('theme-toggle');
            if (!btn) return;
            function applyIcon() {
                var isDark = document.documentElement.classList.contains('dark');
                sunIcon.style.display  = isDark ? 'block' : 'none';
                moonIcon.style.display = isDark ? 'none'  : 'block';
            }
            applyIcon();
            btn.addEventListener('click', function() {
                var isDark = document.documentElement.classList.contains('dark');
                document.documentElement.classList.toggle('dark', !isDark);
                localStorage.setItem('theme', isDark ? 'light' : 'dark');
                applyIcon();
            });
        })();

        /* ── Language segmented control ── */
        function setLang(lang) {
            var enBtn = document.getElementById('lang-en-btn');
            var kuBtn = document.getElementById('lang-ku-btn');
            if (lang === 'ku') {
                document.documentElement.dir  = 'rtl';
                document.documentElement.lang = 'ku';
                document.body.style.fontFamily = '"Noto Naskh Arabic", serif';
                kuBtn.classList.add('w-lang-active');
                enBtn.classList.remove('w-lang-active');
            } else {
                document.documentElement.dir  = 'ltr';
                document.documentElement.lang = 'en';
                document.body.style.fontFamily = '"Outfit", sans-serif';
                enBtn.classList.add('w-lang-active');
                kuBtn.classList.remove('w-lang-active');
            }
            localStorage.setItem('lang', lang);
            if (typeof applyTranslations === 'function') applyTranslations(lang);
            if (typeof window.updateChatQuickPrompts === 'function') window.updateChatQuickPrompts(lang);
        }
        (function() {
            var saved = localStorage.lang || 'en';
            var enBtn = document.getElementById('lang-en-btn');
            var kuBtn = document.getElementById('lang-ku-btn');
            if (!enBtn || !kuBtn) return;
            if (saved === 'ku') { kuBtn.classList.add('w-lang-active'); }
            else                { enBtn.classList.add('w-lang-active'); }
        })();

        /* ── Application tracker ── */
        function handleTrack(e) {
            e.preventDefault();
            var code = document.getElementById('track-code').value.trim();
            if (!code) {
                document.getElementById('track-code').focus();
                return;
            }
            window.location.href = '{{ url("/track") }}/' + encodeURIComponent(code);
        }

        /* ── Page transition ── */
        (function() {
            var overlay = document.getElementById('page-out');
            if (!overlay) return;
            document.addEventListener('click', function(e) {
                var a = e.target.closest('a[href]');
                if (!a || e.defaultPrevented || e.ctrlKey || e.metaKey || e.shiftKey) return;
                var href = a.getAttribute('href');
                if (!href || href === '#' || href[0] === '#' || href.startsWith('javascript') || href.startsWith('mailto') || href.startsWith('tel')) return;
                if (a.getAttribute('target') === '_blank') return;
                try { var u = new URL(href, location.origin); if (u.origin !== location.origin) return; } catch(err) { return; }
                overlay.classList.add('active');
            });
            window.addEventListener('pageshow', function(e) { if (e.persisted) overlay.classList.remove('active'); });
        })();

        /* ── Chatbot ── */
        var chatOpened = false;
        var IS_GUEST   = {{ auth()->check() ? 'false' : 'true' }};

        var WELCOME_MSG = function() {
            var lang = document.documentElement.lang === 'ku' ? 'ku' : 'en';
            if (IS_GUEST) {
                return lang === 'ku'
                    ? 'سڵاو! من یاریدەدەری هەڵزانینم. تکایە چوونەژوورەوە بکەرەوە بۆ ئەوەی پرسیارەکانت بدەیت.'
                    : "Hello! I'm the Halzanîn Assistant. Please sign in to ask questions about your applications or the portal's services.";
            }
            return window.i18n ? i18n('chat.welcome') : "Hello! I'm your Halzanîn Assistant. Ask me anything about government services, required documents, or how to use the portal!";
        };

        function getCurrentUiLang() { return document.documentElement.lang === 'ku' ? 'ku' : 'en'; }

        window.updateChatQuickPrompts = function(lang) {
            lang = lang || getCurrentUiLang();
            document.querySelectorAll('#chatbot-quick-questions .chat-quick-btn').forEach(function(btn) {
                btn.textContent = lang === 'ku' ? btn.dataset.ku : btn.dataset.en;
            });
        };

        function sendQuickQuestion(button) {
            if (IS_GUEST) { appendMsg('ai', WELCOME_MSG()); return; }
            var lang = getCurrentUiLang();
            var q    = lang === 'ku' ? button.dataset.ku : button.dataset.en;
            if (!q) return;
            var inp = document.getElementById('chatbot-input');
            inp.value = q; inp.dispatchEvent(new Event('input'));
            sendChatMessage();
        }

        function toggleChat() {
            var win   = document.getElementById('chatbot-window');
            var iconO = document.getElementById('chatbot-icon-open');
            var iconC = document.getElementById('chatbot-icon-close');
            var badge = document.getElementById('chatbot-badge');
            var pulse = document.getElementById('chatbot-pulse');
            chatOpened = !chatOpened;
            if (chatOpened) {
                win.style.display = 'flex';
                iconO.style.display = 'none'; iconC.style.display = 'block';
                badge.style.display = 'none';
                pulse.style.animation = 'none';
                var msgs = document.getElementById('chatbot-messages');
                if (msgs.children.length === 0) appendMsg('ai', WELCOME_MSG());
                window.updateChatQuickPrompts(getCurrentUiLang());
                if (!IS_GUEST) setTimeout(function() { document.getElementById('chatbot-input').focus(); }, 100);
            } else {
                win.style.display = 'none';
                iconO.style.display = 'block'; iconC.style.display = 'none';
                pulse.style.animation = 'chatPulse 2s ease-in-out infinite';
            }
        }

        function appendMsg(role, text) {
            var msgs = document.getElementById('chatbot-messages');
            var el   = document.createElement('div');
            el.className = role === 'user' ? 'chat-msg-user' : 'chat-msg-ai';
            el.textContent = text;
            msgs.appendChild(el);
            msgs.scrollTop = msgs.scrollHeight;
            return el;
        }

        function showTyping() {
            var msgs = document.getElementById('chatbot-messages');
            var el   = document.createElement('div');
            el.className = 'chat-msg-ai'; el.id = 'chatbot-typing';
            el.style.cssText = 'display:flex;gap:4px;align-items:center;padding:10px 14px;';
            el.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
            msgs.appendChild(el); msgs.scrollTop = msgs.scrollHeight;
        }
        function removeTyping() { var el = document.getElementById('chatbot-typing'); if (el) el.remove(); }

        async function sendChatMessage() {
            if (IS_GUEST) { appendMsg('ai', WELCOME_MSG()); return; }
            var input = document.getElementById('chatbot-input');
            var msg   = input.value.trim();
            if (!msg) return;
            input.value = ''; input.style.height = 'auto';
            appendMsg('user', msg); showTyping();
            var sendBtn = document.getElementById('chatbot-send');
            sendBtn.disabled = true; sendBtn.style.opacity = '0.5';
            try {
                var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var res  = await fetch('{{ url('/chatbot/chat') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ message: msg }),
                });
                if (res.status === 401) { removeTyping(); appendMsg('ai', WELCOME_MSG()); return; }
                var data = await res.json();
                removeTyping();
                appendMsg('ai', data.reply || 'Sorry, something went wrong. Please try again.');
                if (!chatOpened) document.getElementById('chatbot-badge').style.display = 'block';
            } catch(e) {
                removeTyping();
                appendMsg('ai', 'Connection error. Please check your internet and try again.');
            } finally {
                sendBtn.disabled = false; sendBtn.style.opacity = '1';
            }
        }

        window.updateChatQuickPrompts(getCurrentUiLang());
    </script>

    <script src="{{ asset('js/translations.js') }}"></script>
</body>
</html>
