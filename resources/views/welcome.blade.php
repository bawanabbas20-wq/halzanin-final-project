<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Halzanin | Passport Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Noto+Naskh+Arabic:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Apply theme & language before first paint to prevent flash --}}
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
            --bg:          #EFEDE8;
            --card:        #ffffff;
            --text:        #111111;
            --muted:       #6B6860;
            --brand:       #1B4F8A;
            --brand-dark:  #163F6E;
            --brand-light: #4A82C4;
            --line:        #DDD9D0;
            --brand-glow:  rgba(27,79,138,0.30);
        }
        html.dark {
            --bg:          #141414;
            --card:        #1F1F1F;
            --text:        #F0EEE9;
            --muted:       #9E9B94;
            --brand:       #4A82C4;
            --brand-dark:  #3A6BA8;
            --brand-light: #6B9FD4;
            --line:        #2E2E2E;
            --brand-glow:  rgba(74,130,196,0.30);
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

        /* ─── Layout container ─── */
        .w-container { width: min(1200px, calc(100% - 48px)); margin: 0 auto; }

        /* ─── Topbar ─── */
        .w-topbar {
            position: sticky; top: 0; z-index: 40;
            background: rgba(239,237,232,0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--line);
            transition: background 0.2s, border-color 0.2s;
        }
        html.dark .w-topbar { background: rgba(20,20,20,0.92); }

        .w-nav {
            min-height: 72px;
            display: flex; align-items: center; gap: 24px;
        }

        /* Brand */
        .w-brand { display: inline-flex; align-items: center; gap: 14px; text-decoration: none; flex-shrink: 0; }
        .w-brand img { height: 48px; width: auto; transition: transform 0.2s; }
        .w-brand:hover img { transform: scale(1.04); }
        .w-brand-text { font-family: "Outfit", sans-serif; line-height: 1.15; }
        .w-brand-text strong { display: block; font-size: 22px; font-weight: 800; letter-spacing: -0.01em; color: var(--text); }
        .w-brand-text small { display: block; font-size: 11px; color: var(--muted); font-weight: 600; }

        /* Nav links */
        .w-menu { display: flex; gap: 28px; align-items: center; font-size: 14px; font-weight: 700; }
        .w-menu a { color: var(--muted); text-decoration: none; transition: color .15s; }
        .w-menu a:hover { color: var(--brand); }

        /* Right side */
        .w-nav-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }

        /* ─── Toggles ─── */
        .w-toggles {
            display: flex; align-items: center; gap: 4px;
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 999px;
            padding: 4px 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
            transition: background 0.2s, border-color 0.2s;
        }

        /* Dark-mode toggle button */
        .w-theme-btn {
            width: 34px; height: 34px; border-radius: 50%;
            background: none; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
            transition: background 0.18s, color 0.18s;
            flex-shrink: 0;
        }
        .w-theme-btn:hover { background: rgba(27,79,138,0.1); color: #1B4F8A; }
        html.dark .w-theme-btn:hover { background: rgba(74,130,196,0.15); color: #4A82C4; }
        html.dark .w-theme-btn { color: #9E9B94; }
        .w-theme-btn svg { width: 17px; height: 17px; }

        /* Divider */
        .w-divider { width: 1px; height: 20px; background: var(--line); margin: 0 2px; flex-shrink: 0; }

        /* Language segmented control */
        .w-lang-seg {
            display: flex; align-items: center;
            background: rgba(27,79,138,0.06);
            border-radius: 999px; padding: 3px; gap: 2px;
        }
        html.dark .w-lang-seg { background: rgba(74,130,196,0.1); }

        .w-lang-opt {
            border: none; cursor: pointer; border-radius: 999px;
            padding: 5px 11px; font-size: 12px; font-weight: 700;
            transition: all 0.2s; color: var(--muted); background: none;
            line-height: 1; white-space: nowrap;
        }
        .w-lang-opt.w-lang-active {
            background: #1B4F8A; color: #fff;
            box-shadow: 0 2px 8px rgba(27,79,138,0.35);
        }
        html.dark .w-lang-opt.w-lang-active { background: #4A82C4; box-shadow: 0 2px 8px rgba(74,130,196,0.35); }
        .w-lang-opt:not(.w-lang-active):hover { color: #1B4F8A; background: rgba(27,79,138,0.08); }
        html.dark .w-lang-opt:not(.w-lang-active):hover { color: #4A82C4; background: rgba(74,130,196,0.1); }

        /* Action buttons */
        .w-btn {
            border-radius: 999px; padding: 10px 22px;
            font-family: "Outfit", sans-serif; font-size: 14px; font-weight: 700;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
            cursor: pointer; transition: all .2s ease; border: none;
        }
        .w-btn-outline {
            background: var(--card); border: 1.5px solid var(--line); color: var(--text);
        }
        .w-btn-outline:hover { border-color: var(--brand); color: var(--brand); }
        .w-btn-primary {
            background: #1B4F8A; color: #fff;
            box-shadow: 0 6px 18px rgba(27,79,138,0.32);
        }
        html.dark .w-btn-primary { background: #4A82C4; box-shadow: 0 6px 18px rgba(74,130,196,0.32); }
        .w-btn-primary:hover { background: #163F6E; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(27,79,138,0.40); }
        html.dark .w-btn-primary:hover { background: #3A6BA8; }

        /* ─── Hero ─── */
        .w-hero-wrap { padding: 48px 0 40px; }

        .w-hero {
            position: relative;
            border-radius: 28px;
            background: var(--card);
            border: 1px solid var(--line);
            overflow: hidden;
            box-shadow: 0 4px 32px rgba(0,0,0,0.05);
        }
        html.dark .w-hero { box-shadow: 0 4px 32px rgba(0,0,0,0.3); }

        /* Subtle dot pattern */
        .w-hero::before {
            content: "";
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(27,79,138,0.65) 1px, transparent 1px);
            background-size: 28px 28px;
            opacity: 0.06;
            pointer-events: none;
        }

        /* Split layout */
        .w-hero-grid {
            display: grid;
            grid-template-columns: 1fr 420px;
            align-items: center;
            min-height: 500px;
        }

        /* Left: text */
        .w-hero-text { padding: 68px 60px 60px; position: relative; z-index: 2; }

        /* Right: passport visual */
        .w-hero-visual {
            position: relative;
            display: flex; align-items: center; justify-content: center;
            min-height: 500px;
            padding: 40px;
            overflow: hidden;
        }
        /* Background glow behind passports */
        .w-hero-visual::before {
            content: "";
            position: absolute;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(27,79,138,0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        html.dark .w-hero-visual::before { background: radial-gradient(circle, rgba(74,130,196,0.15) 0%, transparent 70%); }

        /* Passport showcase */
        .w-passport-stage { position: relative; width: 290px; height: 390px; }

        .w-passport-img {
            position: absolute;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 20px 56px rgba(0,0,0,0.28), 0 4px 12px rgba(0,0,0,0.12);
            transition: transform 0.3s ease;
        }
        /* Blue (main) — center, front */
        .w-passport-blue {
            width: 188px; height: 265px;
            top: 62px; left: 51px; z-index: 3;
        }
        /* Dark — left, rotated back */
        .w-passport-dark {
            width: 152px; height: 215px;
            top: 108px; left: -12px; z-index: 2;
            transform: rotate(-11deg);
            opacity: 0.85;
        }
        /* Red — right, rotated back */
        .w-passport-red {
            width: 152px; height: 215px;
            top: 95px; right: -14px; z-index: 2;
            transform: rotate(10deg);
            opacity: 0.85;
        }
        .w-passport-stage:hover .w-passport-dark { transform: rotate(-14deg) translateX(-6px); }
        .w-passport-stage:hover .w-passport-red  { transform: rotate(13deg)  translateX(6px);  }
        .w-passport-stage:hover .w-passport-blue { transform: translateY(-4px); }

        /* Badge */
        .w-kicker {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(27,79,138,0.08); border: 1px solid rgba(27,79,138,0.18);
            border-radius: 999px; padding: 6px 14px;
            font-size: 12px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase;
            color: #1B4F8A; margin-bottom: 20px;
        }
        html.dark .w-kicker { color: #4A82C4; background: rgba(74,130,196,0.1); border-color: rgba(74,130,196,0.25); }
        .w-kicker-dot { width: 6px; height: 6px; border-radius: 50%; background: #1B4F8A; animation: kickerPulse 2s ease-in-out infinite; flex-shrink: 0; }
        html.dark .w-kicker-dot { background: #4A82C4; }
        @keyframes kickerPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.35;transform:scale(1.6)} }

        /* Hero heading */
        .w-h1 {
            font-size: clamp(36px, 4.2vw, 58px);
            font-weight: 800; line-height: 1.06; letter-spacing: -0.025em;
            color: var(--text); max-width: 14ch; margin-bottom: 20px;
        }
        .w-h1 .accent { color: #1B4F8A; }
        html.dark .w-h1 .accent { color: #4A82C4; }

        .w-subtitle { font-size: 16px; line-height: 1.78; color: var(--muted); max-width: 50ch; }

        .w-cta { margin-top: 32px; display: flex; flex-wrap: wrap; gap: 12px; }

        /* Stats strip */
        .w-stats {
            margin-top: 44px;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; max-width: 440px;
        }
        .w-stat {
            background: var(--bg); border: 1px solid var(--line);
            border-radius: 14px; padding: 16px 18px;
        }
        .w-stat strong { display: block; font-size: 22px; font-weight: 800; color: #1B4F8A; margin-bottom: 3px; }
        html.dark .w-stat strong { color: #4A82C4; }
        .w-stat span { font-size: 12px; color: var(--muted); font-weight: 600; }

        /* ─── Sections ─── */
        .w-section { padding: 64px 0; }
        .w-section h2 { font-size: clamp(26px, 3vw, 38px); font-weight: 800; letter-spacing: -0.025em; color: var(--text); margin-bottom: 10px; }
        .w-section-sub { color: var(--muted); max-width: 62ch; line-height: 1.75; font-size: 16px; margin-bottom: 40px; }

        /* ─── Service cards ─── */
        .w-card-grid { display: grid; gap: 16px; grid-template-columns: repeat(3, 1fr); }
        .w-card {
            background: var(--card); border: 1px solid var(--line);
            border-radius: 20px; padding: 28px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: box-shadow .2s, transform .2s;
        }
        .w-card:hover { box-shadow: 0 10px 32px rgba(27,79,138,0.12); transform: translateY(-3px); }
        html.dark .w-card:hover { box-shadow: 0 10px 32px rgba(74,130,196,0.15); }
        .w-card-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(27,79,138,0.08);
            display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
        }
        html.dark .w-card-icon { background: rgba(74,130,196,0.12); }
        .w-card-icon svg { width: 22px; height: 22px; stroke: #1B4F8A; }
        html.dark .w-card-icon svg { stroke: #4A82C4; }
        .w-tag {
            display: inline-block;
            background: rgba(27,79,138,0.08); color: #163F6E;
            border-radius: 999px; padding: 3px 10px;
            font-size: 11px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase;
            margin-bottom: 12px;
        }
        html.dark .w-tag { color: #6B9FD4; background: rgba(74,130,196,0.1); }
        .w-card h3 { font-size: 18px; font-weight: 700; color: var(--text); letter-spacing: -0.01em; margin-bottom: 10px; }
        .w-card p  { color: var(--muted); line-height: 1.75; font-size: 14px; }

        /* ─── Alt section (How It Works) ─── */
        .w-alt-bg {
            background: var(--card);
            border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
        }

        /* Timeline */
        .w-timeline { display: flex; flex-direction: column; max-width: 680px; }
        .w-timeline-item { display: flex; gap: 28px; padding-bottom: 36px; }
        .w-timeline-item:last-child { padding-bottom: 0; }
        .w-timeline-left { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; width: 52px; }
        .w-timeline-num {
            width: 52px; height: 52px; border-radius: 50%;
            background: #1B4F8A; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 800;
            box-shadow: 0 4px 14px rgba(27,79,138,0.35);
            flex-shrink: 0; position: relative; z-index: 1;
        }
        html.dark .w-timeline-num { background: #4A82C4; box-shadow: 0 4px 14px rgba(74,130,196,0.35); }
        .w-timeline-line { width: 2px; flex: 1; min-height: 24px; margin-top: 6px; background: linear-gradient(to bottom, rgba(27,79,138,0.4), rgba(27,79,138,0.04)); }
        html.dark .w-timeline-line { background: linear-gradient(to bottom, rgba(74,130,196,0.4), rgba(74,130,196,0.04)); }
        .w-timeline-item:last-child .w-timeline-line { display: none; }
        .w-timeline-content { flex: 1; padding-top: 12px; }
        .w-timeline-content h3 { font-size: 18px; font-weight: 700; color: var(--text); letter-spacing: -0.01em; margin-bottom: 6px; }
        .w-timeline-content p  { color: var(--muted); line-height: 1.75; font-size: 15px; }

        /* ─── Updates / News ─── */
        .w-news-grid { display: grid; gap: 16px; grid-template-columns: repeat(3, 1fr); }
        .w-news { background: var(--card); border-radius: 20px; overflow: hidden; border: 1px solid var(--line); }
        .w-news-media {
            height: 140px;
            background: linear-gradient(145deg, rgba(27,79,138,0.08), rgba(27,79,138,0.02));
            display: flex; align-items: center; justify-content: center;
        }
        html.dark .w-news-media { background: linear-gradient(145deg, rgba(74,130,196,0.1), rgba(74,130,196,0.02)); }
        .w-news-icon { width: 52px; height: 52px; border-radius: 14px; background: rgba(27,79,138,0.1); display: flex; align-items: center; justify-content: center; }
        html.dark .w-news-icon { background: rgba(74,130,196,0.12); }
        .w-news-icon svg { width: 26px; height: 26px; stroke: #1B4F8A; }
        html.dark .w-news-icon svg { stroke: #4A82C4; }
        .w-news-body { padding: 18px 20px 22px; }
        .w-news h4 { font-size: 17px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .w-news p  { color: var(--muted); line-height: 1.65; font-size: 13px; }

        /* ─── Footer ─── */
        .w-footer { border-top: 1px solid var(--line); padding: 28px 0 44px; }
        .w-foot { display: flex; justify-content: space-between; gap: 18px; flex-wrap: wrap; }
        .w-foot span { font-size: 13px; color: var(--muted); }

        /* ─── Page-out transition overlay ─── */
        #page-out {
            position: fixed; inset: 0; background: var(--bg);
            opacity: 0; pointer-events: none;
            z-index: 9999; transition: opacity 0.22s ease;
        }
        #page-out.active { opacity: 1; pointer-events: all; }

        /* ─── Chatbot (same as app layout) ─── */
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
        html.dark .chat-msg-ai { background:#334155; color:#f1f5f9; }
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
            .w-card-grid, .w-news-grid { grid-template-columns: 1fr 1fr; }
            .w-hero-grid { grid-template-columns: 1fr; min-height: unset; }
            .w-hero-visual { display: none; }
            .w-hero-text { padding: 48px 40px 44px; }
            .w-stats { max-width: 500px; }
        }
        @media (max-width: 760px) {
            .w-container { width: min(1200px, calc(100% - 28px)); }
            .w-nav { min-height: 68px; }
            /* Hide ONLY navbar action buttons, never the hero CTA buttons */
            .w-nav-right .w-btn { display: none; }
            .w-h1 { font-size: 32px; }
            /* 3 equal columns so no orphaned stat */
            .w-stats { grid-template-columns: repeat(3, 1fr); max-width: none; gap: 8px; }
            .w-stat { padding: 12px 10px; }
            .w-stat strong { font-size: 18px; }
            .w-stat span { font-size: 11px; }
            .w-card-grid, .w-news-grid { grid-template-columns: 1fr; }
            .w-timeline-item { gap: 18px; }
            .w-hero-text { padding: 36px 20px 32px; }
            .w-cta { gap: 10px; }
            .w-cta .w-btn { padding: 10px 18px; font-size: 13px; }
        }
    </style>
</head>
<body>

    {{-- Page transition overlay --}}
    <div id="page-out"></div>

    {{-- ── Navbar ── --}}
    <header class="w-topbar">
        <div class="w-container w-nav">

            <a href="{{ url('/') }}" class="w-brand">
                <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn">
                <span class="w-brand-text">
                    <strong>Halzanin</strong>
                    <small data-i18n="Kurdistan Passport Directorate">Kurdistan Passport Directorate</small>
                </span>
            </a>

            <nav class="w-menu">
                <a href="#services" data-i18n="Services">Services</a>
                <a href="#process"  data-i18n="Process">Process</a>
                <a href="#updates"  data-i18n="Updates">Updates</a>
            </nav>

            <div class="w-nav-right">
                {{-- Dark mode + language toggles --}}
                <div class="w-toggles">

                    {{-- Dark mode: icon button --}}
                    <button id="theme-toggle" class="w-theme-btn" title="Toggle dark mode">
                        {{-- Sun = shown when currently in dark mode (click → go light) --}}
                        <svg id="theme-icon-sun" style="display:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </svg>
                        {{-- Moon = shown when currently in light mode (click → go dark) --}}
                        <svg id="theme-icon-moon" style="display:none;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                        </svg>
                    </button>

                    <div class="w-divider"></div>

                    {{-- Language: segmented control --}}
                    <div class="w-lang-seg">
                        <button id="lang-en-btn" class="w-lang-opt" onclick="setLang('en')">EN</button>
                        <button id="lang-ku-btn" class="w-lang-opt" onclick="setLang('ku')" style="font-family:'Noto Naskh Arabic',serif;">کوردی</button>
                    </div>

                </div>

                @auth
                    <a href="{{ url('/dashboard') }}" class="w-btn w-btn-outline" data-i18n="Dashboard">Dashboard</a>
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
        <section class="w-hero-wrap">
            <div class="w-container">
                <div class="w-hero">
                    <div class="w-hero-grid">

                        {{-- Left: text --}}
                        <div class="w-hero-text">
                            <div class="w-kicker">
                                <span class="w-kicker-dot"></span>
                                <span data-i18n="Public Service Portal">Public Service Portal</span>
                            </div>

                            <h1 class="w-h1">
                                <span data-i18n="Digital Passport Services for the Kurdistan Region">Digital Passport<br><span class="accent">Services</span> for the<br>Kurdistan Region</span>
                            </h1>

                            <p class="w-subtitle" data-i18n="Submit applications, upload required documents, and track your request status in one place. Designed to reduce waiting time and make government service access clear, secure, and fast.">
                                Submit applications, upload required documents, and track your request status in one place.
                                Designed to reduce waiting time and make government service access clear, secure, and fast.
                            </p>

                            <div class="w-cta">
                                @auth
                                    <a class="w-btn w-btn-primary" href="{{ url('/dashboard') }}" data-i18n="Go To Dashboard">
                                        <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        Go To Dashboard
                                    </a>
                                @else
                                    @if (Route::has('login'))
                                        <a class="w-btn w-btn-primary" href="{{ route('login') }}" data-i18n="Start Application">Start Application</a>
                                    @endif
                                    @if (Route::has('register'))
                                        <a class="w-btn w-btn-outline" href="{{ route('register') }}" data-i18n="Register Account">Register Account</a>
                                    @endif
                                @endauth
                                @if (Route::has('track'))
                                    <a class="w-btn w-btn-outline" href="{{ route('track') }}" data-i18n="Track Application">Track Application</a>
                                @endif
                            </div>

                            <div class="w-stats">
                                <div class="w-stat">
                                    <strong>24/7</strong>
                                    <span data-i18n="Tracking Access">Tracking Access</span>
                                </div>
                                <div class="w-stat">
                                    <strong>1 Portal</strong>
                                    <span data-i18n="For Citizens And Staff">Citizens & Staff</span>
                                </div>
                                <div class="w-stat">
                                    <strong data-i18n="Fast">Fast</strong>
                                    <span data-i18n="Digital Document Review">Digital Review</span>
                                </div>
                            </div>
                        </div>

                        {{-- Right: passport photo showcase --}}
                        <div class="w-hero-visual">
                            <div class="w-passport-stage">
                                <img src="{{ asset('images/passport-dark.png') }}"
                                     alt="Iraqi Passport"
                                     class="w-passport-img w-passport-dark">
                                <img src="{{ asset('images/passport-blue.png') }}"
                                     alt="Iraqi Passport 2023"
                                     class="w-passport-img w-passport-blue">
                                <img src="{{ asset('images/passport-red.png') }}"
                                     alt="Service Passport"
                                     class="w-passport-img w-passport-red">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- ── Services ── --}}
        <section class="w-section" id="services">
            <div class="w-container">
                <h2 data-i18n="Main Services">Main Services</h2>
                <p class="w-section-sub" data-i18n="Halzanin is built around practical citizen workflows. From scheduling appointments to document upload and status tracking, each step is structured for clarity.">
                    Halzanin is built around practical citizen workflows. From scheduling appointments to document upload
                    and status tracking, each step is structured for clarity.
                </p>
                <div class="w-card-grid">
                    <article class="w-card">
                        <div class="w-card-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="w-tag" data-i18n="Appointments">Appointments</span>
                        <h3 data-i18n="Book With Calendar Slots">Book With Calendar Slots</h3>
                        <p data-i18n="Choose available dates and times, submit requests, and manage appointments through your citizen dashboard.">Choose available dates and times, submit requests, and manage appointments through your citizen dashboard.</p>
                    </article>
                    <article class="w-card">
                        <div class="w-card-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="w-tag" data-i18n="Tracking">Tracking</span>
                        <h3 data-i18n="Follow Progress By Code">Follow Progress By Code</h3>
                        <p data-i18n="Use your tracking code to check each status update from submission through review and final decision.">Use your tracking code to check each status update from submission through review and final decision.</p>
                    </article>
                    <article class="w-card">
                        <div class="w-card-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <span class="w-tag" data-i18n="Document Vault">Document Vault</span>
                        <h3 data-i18n="Secure Upload And Storage">Secure Upload And Storage</h3>
                        <p data-i18n="Store required files in your vault and reuse them in supported application workflows.">Store required files in your vault and reuse them in supported application workflows.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ── How It Works ── --}}
        <section class="w-section w-alt-bg" id="process">
            <div class="w-container">
                <h2 data-i18n="How It Works">How It Works</h2>
                <p class="w-section-sub" data-i18n="Three simple steps to complete your passport application digitally.">
                    Three simple steps to complete your passport application digitally.
                </p>
                <div class="w-timeline">
                    <div class="w-timeline-item">
                        <div class="w-timeline-left">
                            <div class="w-timeline-num">1</div>
                            <div class="w-timeline-line"></div>
                        </div>
                        <div class="w-timeline-content">
                            <h3 data-i18n="Create Your Account">Create Your Account</h3>
                            <p data-i18n="Register once, then access your dashboard to begin passport-related submissions and updates.">Register once, then access your dashboard to begin passport-related submissions and updates.</p>
                        </div>
                    </div>
                    <div class="w-timeline-item">
                        <div class="w-timeline-left">
                            <div class="w-timeline-num">2</div>
                            <div class="w-timeline-line"></div>
                        </div>
                        <div class="w-timeline-content">
                            <h3 data-i18n="Submit Application">Submit Application</h3>
                            <p data-i18n="Complete appointment details, attach required documents, and confirm your request.">Complete appointment details, attach required documents, and confirm your request.</p>
                        </div>
                    </div>
                    <div class="w-timeline-item">
                        <div class="w-timeline-left">
                            <div class="w-timeline-num">3</div>
                            <div class="w-timeline-line"></div>
                        </div>
                        <div class="w-timeline-content">
                            <h3 data-i18n="Track And Receive Updates">Track And Receive Updates</h3>
                            <p data-i18n="Monitor application status changes from staff review through final processing outcomes.">Monitor application status changes from staff review through final processing outcomes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Latest Updates ── --}}
        <section class="w-section" id="updates">
            <div class="w-container">
                <h2 data-i18n="Latest Updates">Latest Updates</h2>
                <div class="w-news-grid" style="margin-top:40px;">
                    <article class="w-news">
                        <div class="w-news-media">
                            <div class="w-news-icon">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <div class="w-news-body">
                            <h4 data-i18n="Service Availability">Service Availability</h4>
                            <p data-i18n="Citizen portal is available daily for account access, application tracking, and profile updates.">Citizen portal is available daily for account access, application tracking, and profile updates.</p>
                        </div>
                    </article>
                    <article class="w-news">
                        <div class="w-news-media">
                            <div class="w-news-icon">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                        </div>
                        <div class="w-news-body">
                            <h4 data-i18n="Staff Review Queue">Staff Review Queue</h4>
                            <p data-i18n="Applications are reviewed according to queue status and required documents submitted by citizens.">Applications are reviewed according to queue status and required documents submitted by citizens.</p>
                        </div>
                    </article>
                    <article class="w-news">
                        <div class="w-news-media">
                            <div class="w-news-icon">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                            </div>
                        </div>
                        <div class="w-news-body">
                            <h4 data-i18n="Digital Workflow">Digital Workflow</h4>
                            <p data-i18n="Ongoing improvements continue to reduce manual handling and speed up passport-related processing.">Ongoing improvements continue to reduce manual handling and speed up passport-related processing.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

    </main>

    <footer class="w-footer">
        <div class="w-container w-foot">
            <span data-i18n="Halzanin | Kurdistan Passport Directorate">Halzanin | Kurdistan Passport Directorate</span>
            <span data-i18n="Built for transparent and efficient public service delivery">Built for transparent and efficient public service delivery</span>
        </div>
    </footer>

    {{-- ── Chatbot widget (visible to all; guests get a login prompt) ── --}}
    <div id="chatbot-wrapper" style="position:fixed;bottom:88px;right:20px;z-index:10000;display:flex;flex-direction:column;align-items:flex-end;gap:12px;">

        <div id="chatbot-window"
             style="display:none;width:340px;max-width:90vw;height:480px;background:#ffffff;border-radius:16px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);flex-direction:column;overflow:hidden;border:1px solid rgba(0,0,0,0.06);">
            <div style="background:#1B4F8A;padding:14px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0;">
                <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/></svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p style="color:#fff;font-weight:700;font-size:14px;margin:0;font-family:Outfit,sans-serif;" data-i18n="chat.assistant">Halzanin Assistant</p>
                    <div style="display:flex;align-items:center;gap:5px;margin-top:2px;">
                        <div style="width:7px;height:7px;background:#4ade80;border-radius:50%;"></div>
                        <span style="color:rgba(255,255,255,0.8);font-size:11px;font-weight:600;" data-i18n="chat.online">Online</span>
                    </div>
                </div>
                <button onclick="toggleChat()" style="background:rgba(255,255,255,0.15);border:none;width:28px;height:28px;border-radius:50%;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
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
                              onfocus="this.style.borderColor='#1B4F8A'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                    <button onclick="sendChatMessage()" id="chatbot-send"
                            style="width:40px;height:40px;border-radius:10px;background:#1B4F8A;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:transform 0.15s,opacity 0.15s;"
                            onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div style="position:relative;">
            <div id="chatbot-pulse" style="position:absolute;inset:-6px;border-radius:50%;background:rgba(27,79,138,0.3);animation:chatPulse 2s ease-in-out infinite;pointer-events:none;"></div>
            <button id="chatbot-btn" onclick="toggleChat()"
                    style="width:56px;height:56px;border-radius:50%;background:#1B4F8A;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 25px -5px rgba(27,79,138,0.5);transition:transform 0.2s,box-shadow 0.2s;position:relative;z-index:1;"
                    onmouseover="this.style.transform='scale(1.08)';this.style.boxShadow='0 15px 30px -5px rgba(27,79,138,0.6)'"
                    onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 10px 25px -5px rgba(27,79,138,0.5)'">
                <svg id="chatbot-icon-open" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <svg id="chatbot-icon-close" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                <div id="chatbot-badge" style="position:absolute;top:-2px;right:-2px;width:14px;height:14px;background:#ef4444;border-radius:50%;border:2px solid #fff;display:none;"></div>
            </button>
        </div>
    </div>

    {{-- ── Scripts ── --}}
    <script>
        /* ── Theme toggle ── */
        (function() {
            var sunIcon  = document.getElementById('theme-icon-sun');
            var moonIcon = document.getElementById('theme-icon-moon');
            var btn      = document.getElementById('theme-toggle');
            if (!btn) return;

            function applyIcon() {
                var isDark = document.documentElement.classList.contains('dark');
                sunIcon.style.display  = isDark  ? 'block' : 'none';
                moonIcon.style.display = isDark  ? 'none'  : 'block';
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
        /* Apply active state on page load */
        (function() {
            var saved = localStorage.lang || 'en';
            var enBtn = document.getElementById('lang-en-btn');
            var kuBtn = document.getElementById('lang-ku-btn');
            if (!enBtn || !kuBtn) return;
            if (saved === 'ku') {
                kuBtn.classList.add('w-lang-active');
            } else {
                enBtn.classList.add('w-lang-active');
            }
        })();

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
                try { var u = new URL(href, location.origin); if (u.origin !== location.origin) return; } catch(e) { return; }
                overlay.classList.add('active');
            });
            window.addEventListener('pageshow', function(e) { if (e.persisted) overlay.classList.remove('active'); });
        })();

        /* ── Chatbot ── */
        var chatOpened = false;
        var IS_GUEST   = {{ auth()->check() ? 'false' : 'true' }};

        var WELCOME_MSG = function() {
            if (IS_GUEST) return "Hello! I'm the Halzanin Assistant. Please sign in to ask questions about your application.";
            return window.i18n ? i18n('chat.welcome') : "Hello! I'm your Halzanin Assistant. Ask me anything about your documents or application process!";
        };

        function getCurrentUiLang() { return document.documentElement.lang === 'ku' ? 'ku' : 'en'; }

        window.updateChatQuickPrompts = function(lang) {
            lang = lang || getCurrentUiLang();
            document.querySelectorAll('#chatbot-quick-questions .chat-quick-btn').forEach(function(btn) {
                btn.textContent = lang === 'ku' ? btn.dataset.ku : btn.dataset.en;
            });
        };

        function sendQuickQuestion(button) {
            if (IS_GUEST) { openLoginPrompt(); return; }
            var lang = getCurrentUiLang();
            var q    = lang === 'ku' ? button.dataset.ku : button.dataset.en;
            if (!q) return;
            var inp = document.getElementById('chatbot-input');
            inp.value = q; inp.dispatchEvent(new Event('input'));
            sendChatMessage();
        }

        function openLoginPrompt() {
            appendMsg('ai', 'Please sign in to chat with the Halzanin Assistant. Click "Log In" in the top right corner.');
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
            var el = document.createElement('div');
            el.className = 'chat-msg-ai'; el.id = 'chatbot-typing';
            el.style.cssText = 'display:flex;gap:4px;align-items:center;padding:10px 14px;';
            el.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
            msgs.appendChild(el); msgs.scrollTop = msgs.scrollHeight;
        }
        function removeTyping() { var el = document.getElementById('chatbot-typing'); if (el) el.remove(); }

        async function sendChatMessage() {
            if (IS_GUEST) { openLoginPrompt(); return; }
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
                if (res.status === 401) {
                    removeTyping();
                    appendMsg('ai', 'Please sign in to use the Halzanin Assistant.');
                    return;
                }
                var data = await res.json();
                removeTyping();
                appendMsg('ai', data.reply || 'Sorry, something went wrong.');
                if (!chatOpened) document.getElementById('chatbot-badge').style.display = 'block';
            } catch(e) {
                removeTyping();
                appendMsg('ai', 'Connection error. Please try again.');
            } finally {
                sendBtn.disabled = false; sendBtn.style.opacity = '1';
            }
        }

        window.updateChatQuickPrompts(getCurrentUiLang());
    </script>

    <script src="{{ asset('js/translations.js') }}"></script>
</body>
</html>
