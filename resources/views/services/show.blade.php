<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html-root">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $service->name }} — Halzanîn Portal</title>
    <meta name="description" content="{{ $service->description ? Str::limit($service->description, 155) : $service->name . ' — Kurdistan Government Services Portal' }}">
    <link rel="icon" type="image/png" href="{{ asset('images/halzanin-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        (function() {
            const t = localStorage.getItem('halzanin-theme');
            const p = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (t === 'dark' || (!t && p)) document.documentElement.classList.add('dark');
            if ((localStorage.getItem('halzanin-lang') || localStorage.getItem('lang')) === 'ku') {
                document.documentElement.dir = 'rtl';
                document.documentElement.lang = 'ckb';
            }
        })();
    </script>
    <style>
        /* ── Reset ─────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }
        body { font-family: 'Inter', system-ui, sans-serif; line-height: 1.6; min-height: 100dvh; display: flex; flex-direction: column; }

        /* ── Tokens ─────────────────────────────────────────── */
        :root {
            --brand: {{ $service->ministry->color }};
            --brand-rgb: {{ implode(',', sscanf($service->ministry->color, '#%02x%02x%02x') ?: [27,79,138]) }};
            --bg: #f4f5f7;
            --surface: #ffffff;
            --surface2: #eef0f3;
            --card: #ffffff;
            --text: #131525;
            --text-sub: #404258;
            --text-muted: #7a7d96;
            --border: rgba(0,0,0,0.09);
            --shadow: 0 2px 16px rgba(0,0,0,0.07);
            --shadow-lg: 0 8px 40px rgba(0,0,0,0.11);
            --nav-bg: rgba(244,245,247,0.93);
            --radius: 14px;
            --max: 920px;
        }
        html.dark {
            --bg: #0d0e14;
            --surface: #14151e;
            --surface2: #1a1b26;
            --card: #161720;
            --text: #e8e9f5;
            --text-sub: #a0a3c0;
            --text-muted: #606280;
            --border: rgba(255,255,255,0.07);
            --shadow: 0 2px 16px rgba(0,0,0,0.4);
            --shadow-lg: 0 8px 40px rgba(0,0,0,0.5);
            --nav-bg: rgba(13,14,20,0.95);
        }
        body { background: var(--bg); color: var(--text); }

        /* ── Navbar ─────────────────────────────────────────── */
        .mn-bar{position:sticky;top:0;z-index:200;background:var(--nav-bg);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border-bottom:1px solid var(--border);}
        .mn-nav{display:flex;align-items:center;height:68px;gap:20px;width:min(var(--max),calc(100% - 48px));margin:0 auto;}
        .mn-brand{display:inline-flex;align-items:center;gap:12px;flex-shrink:0;text-decoration:none;color:inherit;}
        .mn-brand img{height:44px;width:auto;}
        .mn-brand-text strong{display:block;font-size:17px;font-weight:800;letter-spacing:-.3px;color:var(--text);}
        .mn-brand-text small{display:block;font-size:10px;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;}
        .mn-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text-muted);font-weight:500;}
        .mn-breadcrumb a{color:var(--text-muted);transition:color .15s;text-decoration:none;}
        .mn-breadcrumb a:hover{color:var(--brand);}
        .mn-breadcrumb-sep{opacity:.4;font-size:11px;}
        .mn-breadcrumb-current{color:var(--brand);font-weight:700;}
        .mn-nav-right{margin-left:auto;display:flex;align-items:center;gap:10px;}
        html[dir="rtl"] .mn-nav-right{margin-left:unset;margin-right:auto;}
        .mn-toggles{display:flex;align-items:center;gap:4px;background:var(--surface);border:1.5px solid var(--border);border-radius:999px;padding:4px 5px;}
        .mn-theme-btn{width:32px;height:32px;border-radius:50%;background:none;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);transition:background .18s,color .18s;}
        .mn-theme-btn:hover{background:rgba(var(--brand-rgb),.08);color:var(--brand);}
        .mn-theme-btn svg{width:16px;height:16px;}
        .mn-divider{width:1px;height:18px;background:var(--border);margin:0 2px;}
        .mn-lang{display:flex;align-items:center;background:rgba(var(--brand-rgb),.07);border-radius:999px;padding:3px;gap:2px;}
        .mn-lang-btn{border:none;cursor:pointer;border-radius:999px;padding:4px 10px;font-size:11.5px;font-weight:700;transition:all .2s;color:var(--text-muted);background:none;line-height:1;}
        .mn-lang-btn.active{background:var(--brand);color:#fff;box-shadow:0 2px 8px rgba(var(--brand-rgb),.35);}
        .mn-navbtn{border-radius:999px;padding:9px 20px;font-family:'Inter',sans-serif;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:all .2s;border:1.5px solid transparent;white-space:nowrap;text-decoration:none;}
        .mn-navbtn-primary{background:var(--brand);color:#fff;border-color:var(--brand);box-shadow:0 4px 14px rgba(var(--brand-rgb),.3);}
        .mn-navbtn-primary:hover{opacity:.9;transform:translateY(-1px);}
        .mn-navbtn-outline{background:var(--surface);border-color:var(--border);color:var(--text);}
        .mn-navbtn-outline:hover{border-color:var(--brand);color:var(--brand);}
        @media(max-width:820px){.mn-breadcrumb,.mn-navbtn{display:none;}}

        /* ── Hero banner ────────────────────────────────────── */
        .sv-hero {
            background: var(--brand);
            position: relative; overflow: hidden;
            padding: clamp(2.5rem,5vw,3.5rem) 0 clamp(2rem,4vw,3rem);
        }
        .sv-hero::after {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle at 85% 30%, rgba(255,255,255,0.08) 0%, transparent 55%);
        }
        .sv-hero-inner {
            position: relative; z-index: 1;
            width: min(var(--max), calc(100% - 2.5rem)); margin: 0 auto;
        }
        .sv-back {
            display: inline-flex; align-items: center; gap: .4rem;
            font-size: .78rem; font-weight: 600; color: rgba(255,255,255,0.7);
            text-decoration: none; margin-bottom: 1.25rem;
            transition: color .2s;
        }
        .sv-back:hover { color: #fff; }
        .sv-ministry-label {
            font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em;
            color: rgba(255,255,255,0.65); margin-bottom: .6rem;
        }
        .sv-name { font-size: clamp(1.5rem,3.5vw,2.2rem); font-weight: 800; color: #fff; letter-spacing: -.02em; line-height: 1.2; margin-bottom: .4rem; }
        .sv-name-ku { font-family: 'Noto Naskh Arabic', serif; direction: rtl; font-size: 1.15rem; color: rgba(255,255,255,0.8); margin-bottom: 1rem; }
        .sv-hero-badges { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1.5rem; }
        .sv-badge {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .28rem .8rem; border-radius: 20px; font-size: .72rem; font-weight: 700;
        }
        .sv-badge-active { background: rgba(255,255,255,0.18); color: #fff; border: 1px solid rgba(255,255,255,0.35); }
        .sv-badge-soon { background: rgba(0,0,0,0.18); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.2); }
        .sv-badge-days { background: rgba(255,255,255,0.14); color: rgba(255,255,255,0.9); border: 1px solid rgba(255,255,255,0.25); }
        .sv-badge-free { background: rgba(52,211,153,0.22); color: #6ee7b7; border: 1px solid rgba(52,211,153,0.4); }
        .sv-hero-meta { display: flex; flex-wrap: wrap; gap: 1.5rem; }
        .sv-meta-item { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: rgba(255,255,255,0.72); }
        .sv-meta-ico { font-size: .95rem; }

        /* ── Wrap ───────────────────────────────────────────── */
        .sv-wrap { width: min(var(--max), calc(100% - 2.5rem)); margin: 0 auto; padding: 2.5rem 0 5rem; flex: 1; }

        /* ── Description card ───────────────────────────────── */
        .sv-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 1.75rem; margin-bottom: 1.25rem;
            box-shadow: var(--shadow);
        }
        .sv-card-title {
            font-size: .68rem; font-weight: 800; text-transform: uppercase; letter-spacing: .1em;
            color: var(--text-muted); margin-bottom: 1rem;
            display: flex; align-items: center; gap: .5rem;
        }
        .sv-card-title-ico { color: var(--brand); font-size: .9rem; }
        .sv-desc-text { font-size: .95rem; color: var(--text-sub); line-height: 1.78; }

        /* ── Two-col grid ───────────────────────────────────── */
        .sv-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
        @media (max-width: 680px) { .sv-grid2 { grid-template-columns: 1fr; } }

        /* ── Steps ──────────────────────────────────────────── */
        .sv-steps { display: flex; flex-direction: column; gap: .75rem; }
        .sv-step { display: flex; align-items: flex-start; gap: 1rem; }
        .sv-step-num {
            width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
            background: var(--brand); color: #fff;
            font-size: .75rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
        }
        .sv-step-body { flex: 1; padding-top: .35rem; }
        .sv-step-lbl { font-size: .88rem; font-weight: 700; color: var(--text); line-height: 1.3; margin-bottom: .2rem; }
        .sv-step-sub { font-size: .8rem; color: var(--text-muted); line-height: 1.5; }

        /* ── Docs list ──────────────────────────────────────── */
        .sv-doc-list { list-style: none; display: flex; flex-direction: column; gap: .6rem; }
        .sv-doc-item {
            display: flex; align-items: flex-start; gap: .75rem;
            font-size: .88rem; color: var(--text-sub); line-height: 1.55;
        }
        .sv-doc-dot {
            width: 20px; height: 20px; border-radius: 50%; flex-shrink: 0; margin-top: .18em;
            background: rgba(var(--brand-rgb), 0.1);
            border: 1.5px solid rgba(var(--brand-rgb), 0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: .6rem; color: var(--brand); font-weight: 800;
        }

        /* ── Workflow statuses ───────────────────────────────── */
        .sv-flow { display: flex; flex-direction: column; gap: 0; }
        .sv-flow-item {
            display: flex; align-items: flex-start; gap: .85rem;
            padding: .6rem 0; position: relative;
        }
        .sv-flow-item:not(:last-child)::after {
            content: ''; position: absolute;
            left: 11px; top: 30px; bottom: -8px; width: 2px;
            background: var(--border);
        }
        .sv-flow-dot {
            width: 24px; height: 24px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: .65rem; font-weight: 800; position: relative; z-index: 1;
        }
        .sv-flow-dot-pending { background: var(--surface2); border: 2px solid var(--border); color: var(--text-muted); }
        .sv-flow-dot-start { background: var(--brand); border: 2px solid var(--brand); color: #fff; }
        .sv-flow-dot-end { background: rgba(5,150,105,0.15); border: 2px solid rgba(5,150,105,0.4); color: #059669; }
        .sv-flow-lbl { font-size: .85rem; font-weight: 600; color: var(--text-sub); padding-top: .18rem; }

        /* ── Online vs in-person ─────────────────────────────── */
        .sv-method-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 540px) { .sv-method-grid { grid-template-columns: 1fr; } }
        .sv-method-card {
            border-radius: 10px; padding: 1.1rem;
            border: 1px solid var(--border);
        }
        .sv-method-card.online { background: rgba(var(--brand-rgb), 0.06); border-color: rgba(var(--brand-rgb), 0.18); }
        .sv-method-card.inperson { background: var(--surface2); }
        .sv-method-head { display: flex; align-items: center; gap: .5rem; margin-bottom: .6rem; }
        .sv-method-ico { font-size: 1.1rem; }
        .sv-method-lbl { font-size: .82rem; font-weight: 700; color: var(--text); }
        .sv-method-badge {
            margin-left: auto; font-size: .65rem; font-weight: 700; padding: .18rem .55rem;
            border-radius: 10px; background: var(--brand); color: #fff;
        }
        .sv-method-items { list-style: none; display: flex; flex-direction: column; gap: .4rem; }
        .sv-method-items li { font-size: .8rem; color: var(--text-sub); display: flex; align-items: baseline; gap: .4rem; }
        .sv-method-items li::before { content: '✓'; font-size: .7rem; color: var(--brand); font-weight: 800; flex-shrink: 0; }

        /* ── Timeline ────────────────────────────────────────── */
        .sv-timeline { display: flex; align-items: stretch; gap: 0; }
        .sv-timeline-phase {
            flex: 1; text-align: center; padding: .9rem .5rem;
            position: relative;
        }
        .sv-timeline-phase:not(:last-child)::after {
            content: '→'; position: absolute; right: -8px; top: 50%; transform: translateY(-50%);
            font-size: .9rem; color: var(--text-muted); z-index: 1;
        }
        .sv-tl-num {
            font-size: 1.4rem; font-weight: 800; color: var(--brand); line-height: 1;
            margin-bottom: .25rem;
        }
        .sv-tl-unit { font-size: .65rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .04em; }
        .sv-tl-desc { font-size: .7rem; color: var(--text-muted); margin-top: .3rem; line-height: 1.4; }
        @media (max-width: 500px) { .sv-timeline { flex-direction: column; gap: .5rem; } .sv-timeline-phase::after { display: none; } }

        /* ── FAQ ─────────────────────────────────────────────── */
        .sv-faq { display: flex; flex-direction: column; gap: 0; }
        .sv-faq-item { border-bottom: 1px solid var(--border); }
        .sv-faq-item:first-child { border-top: 1px solid var(--border); }
        .sv-faq-q {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            gap: .75rem; padding: .9rem 0; text-align: left;
            background: none; border: none; cursor: pointer; color: var(--text);
            font-size: .9rem; font-weight: 600; font-family: 'Inter', sans-serif;
            transition: color .2s;
        }
        .sv-faq-q:hover { color: var(--brand); }
        .sv-faq-ico { font-size: 1rem; color: var(--text-muted); transition: transform .25s; flex-shrink: 0; }
        .sv-faq-item.open .sv-faq-ico { transform: rotate(45deg); }
        .sv-faq-a { max-height: 0; overflow: hidden; transition: max-height .3s ease; }
        .sv-faq-a-inner { padding: 0 0 .9rem; font-size: .88rem; color: var(--text-sub); line-height: 1.7; }

        /* ── CTA section ─────────────────────────────────────── */
        .sv-cta-box {
            background: var(--card); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 2rem;
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;
            gap: 1.25rem; box-shadow: var(--shadow);
            border-top: 3px solid var(--brand);
        }
        .sv-cta-text-main { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: .25rem; }
        .sv-cta-text-sub { font-size: .82rem; color: var(--text-muted); }
        .sv-cta-btns { display: flex; flex-wrap: wrap; gap: .65rem; align-items: center; }
        .sv-btn {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .7rem 1.4rem; border-radius: 9px;
            font-size: .88rem; font-weight: 700; text-decoration: none;
            transition: transform .2s, box-shadow .2s, background .2s, color .2s;
            cursor: pointer; border: none;
        }
        .sv-btn:hover { transform: translateY(-1px); }
        .sv-btn-primary { background: var(--brand); color: #fff; box-shadow: 0 4px 18px rgba(var(--brand-rgb),0.28); }
        .sv-btn-primary:hover { opacity: .9; box-shadow: 0 6px 24px rgba(var(--brand-rgb),0.38); }
        .sv-btn-outline { background: transparent; border: 1.5px solid var(--border); color: var(--text); }
        .sv-btn-outline:hover { border-color: var(--brand); color: var(--brand); }
        .sv-btn-disabled { background: var(--surface2); color: var(--text-muted); cursor: not-allowed; }
        .sv-login-note { font-size: .78rem; color: var(--text-muted); }

        /* ── Footer ──────────────────────────────────────────── */
        .sp-footer { background: var(--surface); border-top: 1px solid var(--border); padding: 1.75rem 0; margin-top: auto; }
        .sp-foot-inner { width: min(var(--max), calc(100% - 2.5rem)); margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: .75rem; }
        .sp-foot-links { display: flex; flex-wrap: wrap; gap: 1rem; }
        .sp-foot-links a { font-size: .78rem; color: var(--text-muted); text-decoration: none; transition: color .2s; }
        .sp-foot-links a:hover { color: var(--text); }
        .sp-foot-copy { font-size: .72rem; color: var(--text-muted); }

        /* ── A11y ─────────────────────────────────────────────── */
        *:focus-visible { outline: 2px solid var(--brand); outline-offset: 3px; border-radius: 4px; }
        .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { transition-duration: .01ms !important; } }
        .icon-sun{display:block}.icon-moon{display:none}
        html.dark .icon-sun{display:none}html.dark .icon-moon{display:block}
    </style>
</head>
<body>

{{-- ── Navbar ── --}}
<header class="mn-bar">
    <div class="mn-nav">
        <a href="{{ url('/') }}" class="mn-brand" aria-label="Back to Halzanîn portal">
            <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn">
            <span class="mn-brand-text">
                <strong>Halzanîn</strong>
                <small>Kurdistan Government Portal</small>
            </span>
        </a>

        <nav class="mn-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="mn-breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ url('/ministry/' . $service->ministry->slug) }}">{{ $service->ministry->name }}</a>
            <span class="mn-breadcrumb-sep" aria-hidden="true">›</span>
            <span class="mn-breadcrumb-current">{{ $service->name }}</span>
        </nav>

        <div class="mn-nav-right">
            <div class="mn-toggles">
                <button id="theme-toggle" class="mn-theme-btn" aria-label="Toggle dark mode">
                    <svg class="icon-sun" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                    <svg class="icon-moon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                </button>
                <div class="mn-divider" aria-hidden="true"></div>
                <div class="mn-lang" role="group" aria-label="Language selection">
                    <button id="lang-ku-btn" class="mn-lang-btn" onclick="setLang('ku')" style="font-family:'Noto Naskh Arabic',serif;" aria-label="Switch to Kurdish">کوردی</button>
                    <button id="lang-en-btn" class="mn-lang-btn" onclick="setLang('en')" aria-label="Switch to English">EN</button>
                </div>
            </div>
            @auth
                <a href="{{ url('/dashboard') }}" class="mn-navbtn mn-navbtn-outline">My Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="mn-navbtn mn-navbtn-primary">Sign In</a>
            @endauth
        </div>
    </div>
</header>

{{-- ── Hero ── --}}
<section class="sv-hero" aria-label="Service overview">
    <div class="sv-hero-inner">
        <a href="{{ url('/') }}#ministries" class="sv-back" aria-label="Back to portal">
            ← Back to Portal
        </a>
        <p class="sv-ministry-label">{{ $service->ministry->name }} &mdash; {{ $service->ministry->name_ku ?? '' }}</p>
        <h1 class="sv-name">{{ $service->name }}</h1>
        @if($service->name_ku)
            <p class="sv-name-ku">{{ $service->name_ku }}</p>
        @endif
        <div class="sv-hero-badges" role="list" aria-label="Service status">
            @if($service->is_active)
                <span class="sv-badge sv-badge-active" role="listitem">
                    <span aria-hidden="true"><svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg></span> Now Available
                </span>
            @else
                <span class="sv-badge sv-badge-soon" role="listitem">Coming Soon</span>
            @endif
            <span class="sv-badge sv-badge-days" role="listitem">
                <span aria-hidden="true"><svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg></span> Est. {{ $service->estimated_days }} days
            </span>
            <span class="sv-badge sv-badge-free" role="listitem">
                <span aria-hidden="true"><svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg></span> Free
            </span>
        </div>
        <div class="sv-hero-meta" role="list" aria-label="Service highlights">
            <span class="sv-meta-item" role="listitem"><span class="sv-meta-ico" aria-hidden="true"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.15em"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 10v11M12 10v11M16 10v11"/></svg></span> {{ $service->ministry->name }}</span>
            <span class="sv-meta-item" role="listitem"><span class="sv-meta-ico" aria-hidden="true"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.15em"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span> Kurdistan Region</span>
            <span class="sv-meta-item" role="listitem"><span class="sv-meta-ico" aria-hidden="true"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.15em"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/></svg></span> Online Application</span>
        </div>
    </div>
</section>

{{-- ── Content ── --}}
<main>
<div class="sv-wrap">

    {{-- Description --}}
    @if($service->description)
    <div class="sv-card" id="about">
        <p class="sv-card-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4M12 8h.01"/></svg></span> About this service</p>
        <p class="sv-desc-text">{{ $service->description }}</p>
    </div>
    @endif

    {{-- Who needs this service --}}
    <div class="sv-card">
        <p class="sv-card-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span> Who needs this service</p>
        <ul class="sv-doc-list" aria-label="Eligibility criteria">
            @if($service->ministry->slug === 'civil-registry')
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Any Kurdistan Region resident needing a new or renewed {{ strtolower($service->name) }}.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Citizens applying for the first time or replacing a lost or damaged document.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Families registering a newborn or updating existing records.</li>
            @elseif($service->ministry->slug === 'traffic-police')
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Residents applying for or renewing a driving licence or vehicle registration.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Vehicle owners transferring ownership or resolving outstanding traffic fines.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Businesses needing special road use or transport permits.</li>
            @elseif($service->ministry->slug === 'electricity')
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Property owners and developers requesting a new electricity connection.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Households reporting faults, leaks, or billing discrepancies.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Businesses transferring a meter to new ownership.</li>
            @elseif($service->ministry->slug === 'water')
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Property owners connecting a new building to the water network.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Residents reporting leaks, low pressure, or water quality concerns.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Households requesting meter reading checks or ownership transfers.</li>
            @else
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>All residents of the Kurdistan Region who require this government service.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Individuals with a valid National ID and permanent or temporary residence in the region.</li>
                <li class="sv-doc-item"><span class="sv-doc-dot" aria-hidden="true">✓</span>Legal representatives acting on behalf of a citizen with the appropriate authorisation.</li>
            @endif
        </ul>
    </div>

    {{-- Docs + Workflow grid --}}
    <div class="sv-grid2" id="documents">

        {{-- Required Documents --}}
        <div class="sv-card" style="margin-bottom:0;" aria-labelledby="docs-title">
            <p class="sv-card-title" id="docs-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></span> Documents required</p>
            @if(!empty($service->required_documents))
                <ul class="sv-doc-list" aria-label="Required documents">
                    @foreach($service->required_documents as $i => $doc)
                        <li class="sv-doc-item">
                            <span class="sv-doc-dot" aria-hidden="true">{{ $i + 1 }}</span>
                            {{ $doc }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="font-size:.85rem;color:var(--text-muted);">Document list will be available when this service launches.</p>
            @endif
        </div>

        {{-- Application Workflow --}}
        <div class="sv-card" style="margin-bottom:0;" aria-labelledby="workflow-title">
            <p class="sv-card-title" id="workflow-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></span> Application workflow</p>
            @if(!empty($service->statuses))
                <div class="sv-flow" role="list" aria-label="Application stages">
                    @foreach($service->statuses as $i => $status)
                        <div class="sv-flow-item" role="listitem">
                            <div class="sv-flow-dot {{ $i === 0 ? 'sv-flow-dot-start' : ($i === count($service->statuses) - 1 ? 'sv-flow-dot-end' : 'sv-flow-dot-pending') }}" aria-hidden="true">
                                {{ $i === count($service->statuses) - 1 ? '✓' : ($i + 1) }}
                            </div>
                            <span class="sv-flow-lbl">{{ ucwords(str_replace('_', ' ', $status)) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- Step-by-step process --}}
    <div class="sv-card" id="how-to-apply">
        <p class="sv-card-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></span> How to apply — step by step</p>
        <div class="sv-steps" role="list" aria-label="Application steps">
            <div class="sv-step" role="listitem">
                <div class="sv-step-num" aria-label="Step 1">1</div>
                <div class="sv-step-body">
                    <p class="sv-step-lbl">Create or sign in to your Halzanîn account</p>
                    <p class="sv-step-sub">Registration is free and takes under 2 minutes. You need a valid email address and a mobile number for OTP verification.</p>
                </div>
            </div>
            <div class="sv-step" role="listitem">
                <div class="sv-step-num" aria-label="Step 2">2</div>
                <div class="sv-step-body">
                    <p class="sv-step-lbl">Complete the online application form</p>
                    <p class="sv-step-sub">Fill in your personal details and any service-specific information. All fields with a red asterisk are required.</p>
                </div>
            </div>
            <div class="sv-step" role="listitem">
                <div class="sv-step-num" aria-label="Step 3">3</div>
                <div class="sv-step-body">
                    <p class="sv-step-lbl">Book your appointment slot</p>
                    <p class="sv-step-sub">Choose a date and time to visit the {{ $service->ministry->name }} service centre for document verification. Slots are available Sunday through Thursday.</p>
                </div>
            </div>
            <div class="sv-step" role="listitem">
                <div class="sv-step-num" aria-label="Step 4">4</div>
                <div class="sv-step-body">
                    <p class="sv-step-lbl">Upload your supporting documents</p>
                    <p class="sv-step-sub">Upload scanned copies or clear photographs of all required documents. Accepted formats: JPG, PNG, PDF — max 5 MB each.</p>
                </div>
            </div>
            <div class="sv-step" role="listitem">
                <div class="sv-step-num" aria-label="Step 5">5</div>
                <div class="sv-step-body">
                    <p class="sv-step-lbl">Attend your appointment and collect your document</p>
                    <p class="sv-step-sub">Bring originals of all documents on your appointment day. Your QR receipt will be sent by email and is available in your dashboard. Collection is usually at the same visit.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Online vs in-person --}}
    <div class="sv-card">
        <p class="sv-card-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><path stroke-linecap="round" stroke-linejoin="round" d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6"/></svg></span> Online vs. in-person</p>
        <div class="sv-method-grid">
            <div class="sv-method-card online">
                <div class="sv-method-head">
                    <span class="sv-method-ico" aria-hidden="true"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.2em"><rect x="2" y="3" width="20" height="14" rx="2"/><path stroke-linecap="round" d="M8 21h8M12 17v4"/></svg></span>
                    <span class="sv-method-lbl">Apply Online (Recommended)</span>
                    <span class="sv-method-badge">Faster</span>
                </div>
                <ul class="sv-method-items" aria-label="Benefits of applying online">
                    <li>Apply from home at any time</li>
                    <li>Skip the queue at the service centre</li>
                    <li>Real-time status tracking in your dashboard</li>
                    <li>Instant QR confirmation by email</li>
                </ul>
            </div>
            <div class="sv-method-card inperson">
                <div class="sv-method-head">
                    <span class="sv-method-ico" aria-hidden="true"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.2em"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-1 8v-4a1 1 0 00-1-1h-4a1 1 0 00-1 1v4"/></svg></span>
                    <span class="sv-method-lbl">Walk-in (In-Person)</span>
                </div>
                <ul class="sv-method-items" aria-label="In-person application details">
                    <li>Visit the ministry service centre directly</li>
                    <li>Open Sunday–Thursday, 8:00–15:00</li>
                    <li>Longer wait times without a prior booking</li>
                    <li>Bring originals of all documents</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Timeline --}}
    <div class="sv-card" id="timeline">
        <p class="sv-card-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg></span> Processing timeline</p>
        <div class="sv-timeline" role="list" aria-label="Processing timeline">
            <div class="sv-timeline-phase" role="listitem">
                <div class="sv-tl-num">Same</div>
                <div class="sv-tl-unit">day</div>
                <div class="sv-tl-desc">Application submitted &amp; confirmation sent</div>
            </div>
            <div class="sv-timeline-phase" role="listitem">
                <div class="sv-tl-num">1–2</div>
                <div class="sv-tl-unit">days</div>
                <div class="sv-tl-desc">Documents verified, appointment confirmed</div>
            </div>
            <div class="sv-timeline-phase" role="listitem">
                <div class="sv-tl-num">{{ max(1, intval($service->estimated_days / 2)) }}–{{ $service->estimated_days }}</div>
                <div class="sv-tl-unit">days</div>
                <div class="sv-tl-desc">Processing &amp; internal review</div>
            </div>
            <div class="sv-timeline-phase" role="listitem">
                <div class="sv-tl-num">Ready</div>
                <div class="sv-tl-unit">to collect</div>
                <div class="sv-tl-desc">Notification sent when ready</div>
            </div>
        </div>
        <p style="font-size:.78rem;color:var(--text-muted);margin-top:1rem;padding-top:.85rem;border-top:1px solid var(--border);">
            Estimated total: <strong style="color:var(--text);">{{ $service->estimated_days }} working days</strong> from appointment date.
            Timelines may vary during peak periods. Track your application status in your dashboard.
        </p>
    </div>

    {{-- Cost ─ free ── --}}
    <div class="sv-card" style="background: rgba(var(--brand-rgb), 0.05); border-color: rgba(var(--brand-rgb), 0.18);">
        <p class="sv-card-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><path stroke-linecap="round" stroke-linejoin="round" d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg></span> Cost</p>
        <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
            <div>
                <p style="font-size:1.6rem;font-weight:800;color:var(--brand);line-height:1;">Free</p>
                <p style="font-size:.8rem;color:var(--text-muted);margin-top:.2rem;">No payment required</p>
            </div>
            <p style="font-size:.88rem;color:var(--text-sub);line-height:1.65;max-width:480px;">
                This service is provided free of charge by the Kurdistan Regional Government. No fees, no hidden charges.
                You will never be asked for payment to submit or collect this application.
            </p>
        </div>
    </div>

    {{-- FAQ ── --}}
    <div class="sv-card" id="faq">
        <p class="sv-card-title"><span class="sv-card-title-ico" aria-hidden="true"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.1em"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 9a3 3 0 015.12 2.12C14 12.27 12.6 13 12 13m0 4h.01"/></svg></span> Frequently asked questions</p>
        <div class="sv-faq" role="list">

            <div class="sv-faq-item" role="listitem">
                <button class="sv-faq-q" aria-expanded="false" onclick="toggleFaq(this)">
                    Do I need to create an account to apply?
                    <span class="sv-faq-ico" aria-hidden="true">+</span>
                </button>
                <div class="sv-faq-a" role="region" aria-hidden="true">
                    <p class="sv-faq-a-inner">Yes — you need a free Halzanîn account to submit and track your application. Registration takes under 2 minutes and requires only an email address and a mobile phone for OTP verification.</p>
                </div>
            </div>

            <div class="sv-faq-item" role="listitem">
                <button class="sv-faq-q" aria-expanded="false" onclick="toggleFaq(this)">
                    Can I save my application and return to it later?
                    <span class="sv-faq-ico" aria-hidden="true">+</span>
                </button>
                <div class="sv-faq-a" role="region" aria-hidden="true">
                    <p class="sv-faq-a-inner">Applications are submitted in one session. We recommend preparing all your documents and information before starting the form. The form typically takes 5–10 minutes to complete.</p>
                </div>
            </div>

            <div class="sv-faq-item" role="listitem">
                <button class="sv-faq-q" aria-expanded="false" onclick="toggleFaq(this)">
                    What file formats are accepted for document uploads?
                    <span class="sv-faq-ico" aria-hidden="true">+</span>
                </button>
                <div class="sv-faq-a" role="region" aria-hidden="true">
                    <p class="sv-faq-a-inner">We accept JPG, JPEG, PNG, and PDF files. Each file must be under 5 MB. Make sure photographs are clear, in focus, and all text is legible. Blurry or incomplete documents will cause delays.</p>
                </div>
            </div>

            <div class="sv-faq-item" role="listitem">
                <button class="sv-faq-q" aria-expanded="false" onclick="toggleFaq(this)">
                    How do I track my application status?
                    <span class="sv-faq-ico" aria-hidden="true">+</span>
                </button>
                <div class="sv-faq-a" role="region" aria-hidden="true">
                    <p class="sv-faq-a-inner">After submission you will receive a unique reference code by email. You can use this code on the <a href="{{ route('track') }}" style="color:var(--brand);text-decoration:none;font-weight:600;">Track Application</a> page at any time, or sign in to your dashboard for full status details and notifications.</p>
                </div>
            </div>

            <div class="sv-faq-item" role="listitem">
                <button class="sv-faq-q" aria-expanded="false" onclick="toggleFaq(this)">
                    Can I reschedule or cancel my appointment?
                    <span class="sv-faq-ico" aria-hidden="true">+</span>
                </button>
                <div class="sv-faq-a" role="region" aria-hidden="true">
                    <p class="sv-faq-a-inner">Yes. You can cancel an upcoming appointment from your citizen dashboard up to 24 hours before the scheduled time. Rescheduling requires cancelling the existing appointment and selecting a new slot through the appointment booking page.</p>
                </div>
            </div>

            <div class="sv-faq-item" role="listitem">
                <button class="sv-faq-q" aria-expanded="false" onclick="toggleFaq(this)">
                    What happens if my application is rejected?
                    <span class="sv-faq-ico" aria-hidden="true">+</span>
                </button>
                <div class="sv-faq-a" role="region" aria-hidden="true">
                    <p class="sv-faq-a-inner">If your application is rejected, a staff member will leave notes explaining the reason. You will be notified by email and via the portal. You can address the issue and resubmit without starting over from scratch in most cases.</p>
                </div>
            </div>

        </div>
    </div>

    {{-- CTA ── --}}
    <div class="sv-cta-box" id="apply" role="region" aria-labelledby="cta-title">
        <div>
            <p class="sv-cta-text-main" id="cta-title">
                @if($service->is_active) Ready to apply? @else Service coming soon @endif
            </p>
            <p class="sv-cta-text-sub">
                @if($service->is_active)
                    Free, online, takes 5–10 minutes. Have your documents ready.
                @else
                    This service is not yet available online. Check back soon or visit the ministry in person.
                @endif
            </p>
        </div>
        <div class="sv-cta-btns">
            @if($service->is_active)
                @auth
                    @if(auth()->user()->role === 'citizen')
                        <a href="{{ route('services.apply', $service->slug) }}" class="sv-btn sv-btn-primary">
                            Apply Now →
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="sv-btn sv-btn-primary">
                        Sign In to Apply
                    </a>
                    <span class="sv-login-note">Free account — 2 minutes to register</span>
                @endauth
            @else
                <span class="sv-btn sv-btn-disabled">Coming Soon</span>
            @endif
            <a href="{{ route('track') }}" class="sv-btn sv-btn-outline">Track Application</a>
        </div>
    </div>

</div>
</main>

{{-- ── Footer ── --}}
<footer class="sp-footer" role="contentinfo">
    <div class="sp-foot-inner">
        <nav class="sp-foot-links" aria-label="Footer navigation">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/') }}#ministries">All Services</a>
            <a href="{{ route('track') }}">Track Application</a>
            @if(Route::has('login'))<a href="{{ route('login') }}">Log In</a>@endif
            @if(Route::has('register'))<a href="{{ route('register') }}">Register</a>@endif
        </nav>
        <span class="sp-foot-copy">&copy; {{ date('Y') }} Kurdistan Regional Government &mdash; Halzanîn Portal</span>
    </div>
</footer>

<script src="{{ asset('js/translations.js') }}"></script>
<script>
(function() {
    // ── Theme ──────────────────────────────────────────
    const html = document.documentElement;
    const btn  = document.getElementById('theme-toggle');
    if (btn) btn.addEventListener('click', function() {
        const dark = html.classList.toggle('dark');
        localStorage.setItem('halzanin-theme', dark ? 'dark' : 'light');
    });

    // ── Language ───────────────────────────────────────
    function setLang(lang) {
        localStorage.setItem('halzanin-lang', lang);
        localStorage.setItem('lang', lang);
        html.dir  = lang === 'ku' ? 'rtl' : 'ltr';
        html.lang = lang === 'ku' ? 'ckb' : 'en';
        document.getElementById('lang-en-btn').classList.toggle('active', lang === 'en');
        document.getElementById('lang-ku-btn').classList.toggle('active', lang === 'ku');
    }
    window.setLang = setLang;
    const initLang = localStorage.getItem('halzanin-lang') || localStorage.getItem('lang') || 'en';
    document.getElementById('lang-en-btn').classList.toggle('active', initLang === 'en');
    document.getElementById('lang-ku-btn').classList.toggle('active', initLang === 'ku');

    // ── FAQ accordion ──────────────────────────────────
    window.toggleFaq = function(btn) {
        const item   = btn.closest('.sv-faq-item');
        const answer = item.querySelector('.sv-faq-a');
        const isOpen = item.classList.contains('open');
        // close all
        document.querySelectorAll('.sv-faq-item.open').forEach(function(el) {
            el.classList.remove('open');
            el.querySelector('.sv-faq-a').style.maxHeight = '0';
            el.querySelector('.sv-faq-q').setAttribute('aria-expanded', 'false');
            el.querySelector('.sv-faq-a').setAttribute('aria-hidden', 'true');
        });
        if (!isOpen) {
            item.classList.add('open');
            answer.style.maxHeight = answer.scrollHeight + 'px';
            btn.setAttribute('aria-expanded', 'true');
            answer.setAttribute('aria-hidden', 'false');
        }
    };
})();
</script>
</body>
</html>
