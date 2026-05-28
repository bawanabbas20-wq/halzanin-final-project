<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تۆماری مەدەنی — Civil Registry | Halzanîn Kurdistan Portal</title>
    <meta name="description" content="Apply online for passports, national ID cards, birth certificates, and marriage registration through the Kurdistan Region Civil Registry.">
    <link rel="icon" type="image/png" href="{{ asset('images/halzanin-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Noto+Naskh+Arabic:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        (function(){
            if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark');}
            if(localStorage.lang==='ku'){document.documentElement.dir='rtl';document.documentElement.lang='ku';}
        })();
    </script>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        :root{
            --bg:#EFEDE8;--card:#ffffff;--text:#111111;--muted:#6B6860;
            --line:#DDD9D0;--card-shadow:0 2px 16px rgba(0,0,0,0.05);
            --m:#1A3A5C;--m-dark:#0f2540;--m-mid:#1d4268;--m-light:rgba(26,58,92,0.09);
            --m-border:rgba(26,58,92,0.2);
        }
        html.dark{
            --bg:#131416;--card:#1c1e22;--text:#F0EEE9;--muted:#9A9790;
            --line:#2a2d32;--card-shadow:0 2px 16px rgba(0,0,0,0.35);
            --m:#3a6fa8;--m-dark:#1A3A5C;--m-mid:#2e5a8a;--m-light:rgba(58,111,168,0.12);
            --m-border:rgba(58,111,168,0.28);
        }
        html{scroll-behavior:smooth;}
        body{background:var(--bg);color:var(--text);font-family:"Outfit",sans-serif;line-height:1.6;min-height:100dvh;display:flex;flex-direction:column;}
        html[dir="rtl"] body,html[lang="ku"] body{font-family:"Noto Naskh Arabic",serif;}
        .mn-container{width:min(1200px,calc(100% - 48px));margin:0 auto;}
        .mn-container-sm{width:min(860px,calc(100% - 48px));margin:0 auto;}
        a{color:inherit;text-decoration:none;}

        /* ── Navbar ── */
        .mn-bar{position:sticky;top:0;z-index:50;background:rgba(239,237,232,0.93);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-bottom:1px solid var(--line);transition:background .2s;}
        html.dark .mn-bar{background:rgba(19,20,22,0.93);}
        .mn-nav{display:flex;align-items:center;height:68px;gap:20px;}
        .mn-brand{display:inline-flex;align-items:center;gap:12px;flex-shrink:0;}
        .mn-brand img{height:44px;width:auto;}
        .mn-brand-text strong{display:block;font-size:17px;font-weight:800;letter-spacing:-.3px;color:var(--text);}
        .mn-brand-text small{display:block;font-size:10px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;}
        .mn-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted);font-weight:500;}
        .mn-breadcrumb a{color:var(--muted);transition:color .15s;}
        .mn-breadcrumb a:hover{color:var(--m);}
        .mn-breadcrumb-sep{opacity:.4;font-size:11px;}
        .mn-breadcrumb-current{color:var(--m);font-weight:700;}
        .mn-nav-right{margin-left:auto;display:flex;align-items:center;gap:10px;}
        html[dir="rtl"] .mn-nav-right{margin-left:unset;margin-right:auto;}
        .mn-toggles{display:flex;align-items:center;gap:4px;background:var(--card);border:1.5px solid var(--line);border-radius:999px;padding:4px 5px;}
        .mn-theme-btn{width:32px;height:32px;border-radius:50%;background:none;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--muted);transition:background .18s,color .18s;}
        .mn-theme-btn:hover,.mn-theme-btn:focus-visible{background:var(--m-light);color:var(--m);outline:2px solid var(--m);outline-offset:1px;}
        .mn-theme-btn svg{width:16px;height:16px;}
        .mn-divider{width:1px;height:18px;background:var(--line);margin:0 2px;}
        .mn-lang{display:flex;align-items:center;background:var(--m-light);border-radius:999px;padding:3px;gap:2px;}
        .mn-lang-btn{border:none;cursor:pointer;border-radius:999px;padding:4px 10px;font-size:11.5px;font-weight:700;transition:all .2s;color:var(--muted);background:none;line-height:1;}
        .mn-lang-btn.active{background:var(--m);color:#fff;box-shadow:0 2px 8px rgba(26,58,92,0.35);}
        html.dark .mn-lang-btn.active{box-shadow:0 2px 8px rgba(58,111,168,0.35);}
        .mn-btn{border-radius:999px;padding:9px 20px;font-family:"Outfit",sans-serif;font-size:13.5px;font-weight:700;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:all .2s;border:1.5px solid transparent;white-space:nowrap;text-decoration:none;}
        .mn-btn-primary{background:var(--m);color:#fff;border-color:var(--m);box-shadow:0 4px 14px rgba(26,58,92,0.3);}
        .mn-btn-primary:hover{background:var(--m-dark);transform:translateY(-1px);box-shadow:0 6px 20px rgba(26,58,92,0.38);}
        .mn-btn-outline{background:var(--card);border-color:var(--line);color:var(--text);}
        .mn-btn-outline:hover{border-color:var(--m);color:var(--m);}
        @media(max-width:820px){.mn-breadcrumb,.mn-btn{display:none;}}

        /* ── Hero ── */
        .mn-hero{position:relative;overflow:hidden;min-height:480px;display:flex;align-items:flex-end;padding:0;}
        .mn-hero-bg{position:absolute;inset:0;background:linear-gradient(148deg,#07192e 0%,#1A3A5C 52%,#1e4876 100%);z-index:0;}
        .mn-hero-photo{position:absolute;inset:0;z-index:1;}
        .mn-hero-photo img{width:100%;height:100%;object-fit:cover;opacity:.18;display:block;}
        html.dark .mn-hero-photo img{opacity:.11;}
        .mn-hero-pattern{position:absolute;inset:0;z-index:2;background-image:radial-gradient(circle,rgba(255,255,255,0.055) 1px,transparent 1px);background-size:22px 22px;pointer-events:none;}
        .mn-hero-fade{position:absolute;bottom:0;left:0;right:0;height:200px;z-index:3;background:linear-gradient(to top,rgba(7,25,46,0.85) 0%,transparent 100%);pointer-events:none;}
        .mn-hero-content{position:relative;z-index:4;padding:80px 0 56px;width:min(1200px,calc(100% - 48px));margin:0 auto;}
        .mn-hero-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,0.13);border:1px solid rgba(255,255,255,0.22);border-radius:999px;padding:6px 14px;font-size:11.5px;font-weight:700;color:rgba(255,255,255,0.88);letter-spacing:.03em;margin-bottom:20px;backdrop-filter:blur(4px);}
        .mn-hero-badge svg{width:13px;height:13px;stroke:rgba(255,255,255,0.8);}
        .mn-hero-ku{font-family:"Noto Naskh Arabic",serif;font-size:clamp(28px,4vw,48px);font-weight:700;color:rgba(255,255,255,0.9);line-height:1.25;margin-bottom:6px;}
        .mn-hero-en{font-size:clamp(18px,2.5vw,30px);font-weight:700;color:rgba(255,255,255,0.62);letter-spacing:-.01em;margin-bottom:16px;}
        .mn-hero-tagline{font-size:clamp(14px,1.8vw,17px);color:rgba(255,255,255,0.72);max-width:52ch;line-height:1.75;margin-bottom:32px;}
        html[lang="ku"] .mn-hero-tagline{font-family:"Noto Naskh Arabic",serif;}
        .mn-hero-ctas{display:flex;flex-wrap:wrap;gap:10px;}
        .mn-hero-stat-row{display:flex;flex-wrap:wrap;gap:20px;margin-top:36px;padding-top:28px;border-top:1px solid rgba(255,255,255,0.14);}
        .mn-hero-stat{display:flex;flex-direction:column;gap:2px;}
        .mn-hero-stat strong{font-size:22px;font-weight:800;color:#fff;}
        .mn-hero-stat span{font-size:11px;color:rgba(255,255,255,0.6);font-weight:600;text-transform:uppercase;letter-spacing:.04em;}
        @media(max-width:640px){.mn-hero-ctas{flex-direction:column;}.mn-btn{width:100%;justify-content:center;}}

        /* ── Sections ── */
        .mn-section{padding:72px 0;}
        .mn-section-sm{padding:52px 0;}
        .mn-alt{background:var(--card);border-top:1px solid var(--line);border-bottom:1px solid var(--line);}
        .mn-kicker{display:inline-flex;align-items:center;gap:7px;background:var(--m-light);border:1px solid var(--m-border);border-radius:999px;padding:5px 13px;font-size:11.5px;font-weight:700;letter-spacing:.03em;color:var(--m);margin-bottom:14px;}
        html.dark .mn-kicker{color:#6da4d8;}
        .mn-kicker svg{width:13px;height:13px;stroke:currentColor;flex-shrink:0;}
        .mn-sh{font-size:clamp(24px,2.8vw,36px);font-weight:800;letter-spacing:-.025em;color:var(--text);margin-bottom:10px;text-wrap:balance;}
        .mn-sub{color:var(--muted);font-size:15px;line-height:1.8;max-width:62ch;margin-bottom:40px;}

        /* ── About ── */
        .mn-about-grid{display:grid;grid-template-columns:1fr 420px;gap:60px;align-items:center;}
        .mn-about-body p{font-size:15px;color:var(--muted);line-height:1.85;margin-bottom:16px;max-width:60ch;}
        .mn-about-body p:last-child{margin-bottom:0;}
        .mn-about-body strong{color:var(--text);font-weight:700;}
        .mn-about-visual{border-radius:24px;overflow:hidden;background:var(--m-light);border:1px solid var(--m-border);aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;position:relative;}
        .mn-about-visual img{width:100%;height:100%;object-fit:cover;display:block;}
        .mn-about-visual-fallback{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;color:var(--m);padding:40px;}
        .mn-about-visual-fallback svg{width:64px;height:64px;opacity:.45;}
        .mn-about-visual-fallback p{font-size:13px;color:var(--muted);text-align:center;line-height:1.6;}
        @media(max-width:900px){.mn-about-grid{grid-template-columns:1fr;}.mn-about-visual{aspect-ratio:16/7;}}

        /* ── News ── */
        .mn-news-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
        .mn-news-card{background:var(--card);border:1px solid var(--line);border-radius:18px;overflow:hidden;box-shadow:var(--card-shadow);transition:box-shadow .25s,transform .25s;}
        .mn-news-card:hover{box-shadow:0 12px 36px rgba(0,0,0,0.1);transform:translateY(-3px);}
        html.dark .mn-news-card:hover{box-shadow:0 12px 36px rgba(0,0,0,0.45);}
        .mn-news-img{height:168px;overflow:hidden;background:var(--m-light);}
        .mn-news-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s ease;}
        .mn-news-card:hover .mn-news-img img{transform:scale(1.04);}
        .mn-news-body{padding:20px 20px 18px;}
        .mn-news-date{font-size:11px;font-weight:700;color:var(--m);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;}
        html.dark .mn-news-date{color:#6da4d8;}
        .mn-news-title{font-size:15px;font-weight:700;color:var(--text);line-height:1.4;margin-bottom:8px;letter-spacing:-.01em;}
        .mn-news-excerpt{font-size:13px;color:var(--muted);line-height:1.7;margin-bottom:14px;}
        .mn-news-link{font-size:12px;font-weight:700;color:var(--m);display:inline-flex;align-items:center;gap:4px;transition:gap .15s;}
        html.dark .mn-news-link{color:#6da4d8;}
        .mn-news-link svg{width:13px;height:13px;}
        .mn-news-card:hover .mn-news-link{gap:7px;}
        @media(max-width:820px){.mn-news-grid{grid-template-columns:1fr 1fr;}}
        @media(max-width:560px){.mn-news-grid{grid-template-columns:1fr;}}

        /* ── Services ── */
        .mn-svc-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;}
        .mn-svc-card{background:var(--card);border:1px solid var(--line);border-radius:20px;overflow:hidden;box-shadow:var(--card-shadow);display:flex;flex-direction:column;transition:box-shadow .25s,transform .25s;}
        .mn-svc-card:hover{box-shadow:0 10px 32px rgba(0,0,0,0.09);transform:translateY(-2px);}
        html.dark .mn-svc-card:hover{box-shadow:0 10px 32px rgba(0,0,0,0.4);}
        .mn-svc-head{padding:22px 22px 16px;display:flex;align-items:flex-start;gap:14px;border-bottom:1px solid var(--line);}
        .mn-svc-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:var(--m-light);border:1px solid var(--m-border);}
        .mn-svc-icon svg{width:22px;height:22px;stroke:var(--m);}
        .mn-svc-info h3{font-size:15px;font-weight:700;color:var(--text);letter-spacing:-.01em;line-height:1.3;margin-bottom:3px;}
        .mn-svc-info-ku{font-size:12.5px;color:var(--muted);font-family:"Noto Naskh Arabic",serif;}
        .mn-svc-body{padding:16px 22px 14px;flex:1;display:flex;flex-direction:column;gap:12px;}
        .mn-svc-docs{display:flex;flex-direction:column;gap:6px;}
        .mn-svc-doc{display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--muted);line-height:1.4;}
        .mn-svc-doc::before{content:"";width:5px;height:5px;border-radius:50%;background:var(--m);flex-shrink:0;margin-top:6px;}
        .mn-svc-meta{display:flex;flex-wrap:wrap;gap:6px;align-items:center;}
        .mn-svc-pill{display:inline-flex;align-items:center;gap:4px;border-radius:7px;padding:3px 10px;font-size:11px;font-weight:700;}
        .mn-svc-pill-days{background:var(--m-light);color:var(--m);border:1px solid var(--m-border);}
        html.dark .mn-svc-pill-days{color:#6da4d8;border-color:rgba(58,111,168,0.3);}
        .mn-svc-pill-free{background:rgba(5,150,105,0.08);color:#059669;border:1px solid rgba(5,150,105,0.2);}
        .mn-svc-pill-soon{background:rgba(107,104,96,0.07);color:var(--muted);border:1px solid var(--line);}
        .mn-svc-footer{padding:14px 22px;border-top:1px solid var(--line);background:var(--bg);}
        .mn-apply-btn{display:inline-flex;align-items:center;gap:6px;background:var(--m);color:#fff;border:none;border-radius:999px;padding:10px 20px;font-family:"Outfit",sans-serif;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;transition:all .2s;box-shadow:0 3px 10px rgba(26,58,92,0.28);}
        .mn-apply-btn:hover{background:var(--m-dark);transform:translateY(-1px);box-shadow:0 5px 16px rgba(26,58,92,0.38);}
        .mn-soon-label{font-size:13px;color:var(--muted);font-weight:600;}
        @media(max-width:720px){.mn-svc-grid{grid-template-columns:1fr;}}

        /* ── Track ── */
        .mn-track-box{max-width:620px;margin:0 auto;background:var(--card);border:1px solid var(--line);border-radius:22px;padding:44px 44px;box-shadow:var(--card-shadow);text-align:center;}
        .mn-track-icon{width:60px;height:60px;border-radius:50%;background:var(--m-light);border:1px solid var(--m-border);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;}
        .mn-track-icon svg{width:26px;height:26px;stroke:var(--m);}
        .mn-track-box h2{font-size:24px;font-weight:800;letter-spacing:-.02em;margin-bottom:8px;}
        .mn-track-box p{font-size:14.5px;color:var(--muted);margin-bottom:26px;line-height:1.7;}
        .mn-track-form{display:flex;gap:9px;}
        .mn-track-input{flex:1;height:48px;padding:0 16px;border:1.5px solid var(--line);border-radius:12px;background:var(--bg);color:var(--text);font-family:"Outfit",sans-serif;font-size:14px;font-weight:500;transition:border-color .2s,box-shadow .2s;outline:none;}
        .mn-track-input:focus{border-color:var(--m);box-shadow:0 0 0 3px var(--m-light);}
        .mn-track-input::placeholder{color:var(--muted);}
        .mn-track-btn{height:48px;padding:0 22px;background:var(--m);color:#fff;border:none;border-radius:12px;font-family:"Outfit",sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;transition:all .2s;white-space:nowrap;flex-shrink:0;}
        .mn-track-btn:hover{background:var(--m-dark);transform:translateY(-1px);box-shadow:0 5px 16px rgba(26,58,92,0.35);}
        .mn-track-note{margin-top:12px;font-size:12px;color:var(--muted);}
        @media(max-width:560px){.mn-track-box{padding:28px 20px;}.mn-track-form{flex-direction:column;}.mn-track-btn{height:46px;}}

        /* ── Contact ── */
        .mn-offices-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;}
        .mn-contact-card{background:var(--card);border:1px solid var(--line);border-radius:20px;overflow:hidden;box-shadow:var(--card-shadow);}
        .mn-contact-header{padding:16px 20px;border-bottom:1px solid var(--line);display:flex;align-items:center;gap:11px;background:var(--m-light);}
        .mn-contact-header h3{font-size:14px;font-weight:700;color:var(--m);}
        html.dark .mn-contact-header h3{color:#6da4d8;}
        .mn-office-badge{margin-left:auto;font-size:10px;font-weight:700;padding:3px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:.04em;flex-shrink:0;white-space:nowrap;}
        .mn-office-hq{background:var(--m);color:#fff;}
        .mn-office-branch{background:rgba(26,58,92,0.07);color:var(--m);border:1px solid var(--m-border);}
        html.dark .mn-office-branch{color:#6da4d8;background:rgba(58,111,168,0.12);}
        .mn-contact-body{padding:16px 20px;display:flex;flex-direction:column;gap:12px;}
        .mn-contact-row{display:flex;align-items:flex-start;gap:11px;}
        .mn-contact-row svg{width:15px;height:15px;stroke:var(--m);flex-shrink:0;margin-top:3px;}
        html.dark .mn-contact-row svg{stroke:#6da4d8;}
        .mn-contact-text strong{display:block;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);margin-bottom:2px;}
        .mn-contact-text span{font-size:13px;color:var(--text);}
        .mn-offices-note{margin-top:20px;font-size:13px;color:var(--muted);display:flex;align-items:center;gap:7px;}
        .mn-offices-note svg{flex-shrink:0;}
        @media(max-width:820px){.mn-offices-grid{grid-template-columns:1fr;}}

        /* ── Footer ── */
        .mn-footer{border-top:1px solid var(--line);padding:40px 0 28px;background:var(--card);margin-top:auto;}
        .mn-foot-inner{width:min(1200px,calc(100% - 48px));margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;}
        .mn-foot-brand{display:flex;align-items:center;gap:10px;}
        .mn-foot-brand img{height:34px;}
        .mn-foot-brand-text strong{display:block;font-size:14px;font-weight:800;color:var(--text);}
        .mn-foot-brand-text small{font-size:11px;color:var(--muted);}
        .mn-foot-links{display:flex;gap:6px;flex-wrap:wrap;}
        .mn-foot-links a{font-size:13px;color:var(--muted);padding:4px 10px;border-radius:6px;transition:color .15s,background .15s;}
        .mn-foot-links a:hover{color:var(--m);background:var(--m-light);}
        .mn-foot-copy{width:100%;border-top:1px solid var(--line);padding-top:18px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;}
        .mn-foot-copy span{font-size:12px;color:var(--muted);}
        @media(max-width:600px){.mn-foot-inner{flex-direction:column;align-items:flex-start;}}
    </style>
</head>
<body>

    {{-- ── Navbar ── --}}
    <header class="mn-bar">
        <div class="mn-container mn-nav">
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
                <a href="{{ url('/') }}#ministries">Ministries</a>
                <span class="mn-breadcrumb-sep" aria-hidden="true">›</span>
                <span class="mn-breadcrumb-current">Civil Registry</span>
            </nav>

            <div class="mn-nav-right">
                <div class="mn-toggles">
                    <button id="theme-toggle" class="mn-theme-btn" aria-label="Toggle dark mode">
                        <svg id="ti-sun" style="display:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                        <svg id="ti-moon" style="display:none;" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                    </button>
                    <div class="mn-divider" aria-hidden="true"></div>
                    <div class="mn-lang" role="group" aria-label="Language selection">
                        <button id="lang-ku-btn" class="mn-lang-btn" onclick="setLang('ku')" style="font-family:'Noto Naskh Arabic',serif;" aria-label="Switch to Kurdish">کوردی</button>
                        <button id="lang-en-btn" class="mn-lang-btn" onclick="setLang('en')" aria-label="Switch to English">EN</button>
                    </div>
                </div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="mn-btn mn-btn-outline">My Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="mn-btn mn-btn-primary">Sign In</a>
                @endauth
            </div>
        </div>
    </header>

    <main>

        {{-- ── Hero ── --}}
        <section class="mn-hero" aria-label="Civil Registry ministry overview">
            <div class="mn-hero-bg"></div>
            <div class="mn-hero-photo" aria-hidden="true">
                <img src="{{ asset('images/civil-registry/hero.jpeg') }}" alt="" loading="eager">
            </div>
            <div class="mn-hero-pattern" aria-hidden="true"></div>
            <div class="mn-hero-fade" aria-hidden="true"></div>
            <div class="mn-hero-content">
                <div class="mn-hero-badge">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                    Kurdistan Region Government Portal
                </div>
                <h1>
                    <div class="mn-hero-ku" data-ku="تۆماری مەدەنی" data-en="Civil Registry">تۆماری مەدەنی</div>
                    <div class="mn-hero-en" data-ku="Civil Registry" data-en="وەزارەتی ناوخۆ">Civil Registry Directorate</div>
                </h1>
                <p class="mn-hero-tagline" data-i18n="civil.hero.tagline">
                    Your official source for national identity documents, birth records, marriage certificates, and passport services in the Kurdistan Region.
                </p>
                <div class="mn-hero-ctas">
                    <a href="#services" class="mn-btn mn-btn-primary">
                        <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        View Available Services
                    </a>
                    <a href="#track" class="mn-btn" style="background:rgba(255,255,255,0.15);color:#fff;border-color:rgba(255,255,255,0.28);backdrop-filter:blur(4px);">
                        Track My Application
                    </a>
                </div>
                <div class="mn-hero-stat-row" aria-label="Ministry statistics">
                    <div class="mn-hero-stat"><strong>4</strong><span>Services</span></div>
                    <div class="mn-hero-stat"><strong>Sun–Thu</strong><span>Office Hours</span></div>
                    <div class="mn-hero-stat"><strong>Free</strong><span>All Services</span></div>
                    <div class="mn-hero-stat"><strong>7–21 days</strong><span>Avg. Processing</span></div>
                </div>
            </div>
        </section>

        {{-- ── About ── --}}
        <section class="mn-section" aria-labelledby="about-heading">
            <div class="mn-container">
                <div class="mn-about-grid">
                    <div class="mn-about-body">
                        <div class="mn-kicker">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            About this ministry
                        </div>
                        <h2 id="about-heading" class="mn-sh">Identity documentation for every citizen</h2>
                        <p>The <strong>Civil Registry Directorate</strong> is the government body responsible for all official identity documentation in the Kurdistan Region. It maintains the civil records of all citizens and issues the documents that verify your identity, family status, and legal existence as a person.</p>
                        <p>If you are a <strong>Kurdistan Region citizen turning 15</strong>, renewing an expired document, reporting a birth or marriage, or applying for a passport, this is the ministry you work with. Foreign nationals who have acquired residency and need civil registration also use this directorate.</p>
                        <p>Through the Halzanîn portal, you can <strong>submit your application online</strong>, upload required documents digitally, and book a single appointment for final verification — instead of multiple in-person visits with no clear timeline.</p>
                    </div>
                    <div class="mn-about-visual" aria-hidden="true">
                        <img src="{{ asset('images/civil-registry/about.jpeg') }}" alt="Civil Registry office" loading="lazy"
                             onerror="this.parentElement.querySelector('.mn-about-visual-fallback').style.display='flex';this.style.display='none';">
                        <div class="mn-about-visual-fallback" style="display:none;position:absolute;inset:0;">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c0 1.306.834 2.417 2 2.83M19 17c-1.166-.413-2-1.524-2-2.83"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Latest News ── --}}
        <section class="mn-section mn-alt" aria-labelledby="news-heading">
            <div class="mn-container">
                <div class="mn-kicker">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Latest news
                </div>
                <h2 id="news-heading" class="mn-sh">Announcements from Civil Registry</h2>
                <div class="mn-news-grid">

                    <article class="mn-news-card">
                        <div class="mn-news-img">
                            <img src="{{ asset('images/civil-registry/news-id.jpeg') }}" alt="National ID renewal campaign" loading="lazy">
                        </div>
                        <div class="mn-news-body">
                            <div class="mn-news-date">14 May 2025</div>
                            <h3 class="mn-news-title">National ID renewal deadline extended to December 2025</h3>
                            <p class="mn-news-excerpt">Citizens with ID cards issued before 2018 now have until 31 December 2025 to renew via the Halzanîn portal or at any Civil Registry office.</p>
                            <span class="mn-news-link">Read more <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></span>
                        </div>
                    </article>

                    <article class="mn-news-card">
                        <div class="mn-news-img">
                            <img src="{{ asset('images/civil-registry/news-birth.jpeg') }}" alt="Online birth registration" loading="lazy">
                        </div>
                        <div class="mn-news-body">
                            <div class="mn-news-date">2 Apr 2025</div>
                            <h3 class="mn-news-title">Birth registration now fully available online</h3>
                            <p class="mn-news-excerpt">Parents can now register a newborn's birth entirely online through the Halzanîn portal within 60 days of birth. Physical office visit remains required for the original certificate pickup.</p>
                            <span class="mn-news-link">Read more <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></span>
                        </div>
                    </article>

                    <article class="mn-news-card">
                        <div class="mn-news-img">
                            <img src="{{ asset('images/civil-registry/news-passport.jpeg') }}" alt="Passport processing update" loading="lazy">
                        </div>
                        <div class="mn-news-body">
                            <div class="mn-news-date">18 Mar 2025</div>
                            <h3 class="mn-news-title">Passport processing time reduced to 14 working days</h3>
                            <p class="mn-news-excerpt">Following investment in new biometric equipment, standard passport applications are now processed within 14 working days from the date of the appointment.</p>
                            <span class="mn-news-link">Read more <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></span>
                        </div>
                    </article>

                </div>
            </div>
        </section>

        {{-- ── Services ── --}}
        <section class="mn-section" id="services" aria-labelledby="services-heading">
            <div class="mn-container">
                <div class="mn-kicker">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Available services
                </div>
                <h2 id="services-heading" class="mn-sh">Civil Registry services</h2>
                <p class="mn-sub">Each service below can be applied for online. Click "Apply" to begin or view full requirements on the service detail page.</p>

                <div class="mn-svc-grid">

                    {{-- National ID --}}
                    <div class="mn-svc-card">
                        <div class="mn-svc-head">
                            <div class="mn-svc-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 10a2 2 0 11-4 0 2 2 0 014 0zm-6 5s.5-3 4-3 4 3 4 3"/></svg>
                            </div>
                            <div class="mn-svc-info">
                                <h3>National ID Card</h3>
                                <div class="mn-svc-info-ku">کارتی ناسنامەی نیشتمانی</div>
                            </div>
                        </div>
                        <div class="mn-svc-body">
                            <div class="mn-svc-docs">
                                <div class="mn-svc-doc">Existing ID card (if renewal) or birth certificate (if new)</div>
                                <div class="mn-svc-doc">Recent passport-size photograph</div>
                                <div class="mn-svc-doc">Proof of residence (utility bill or letter)</div>
                                <div class="mn-svc-doc">Parent/guardian ID if applicant is under 18</div>
                            </div>
                            <div class="mn-svc-meta">
                                <span class="mn-svc-pill mn-svc-pill-days">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/></svg>
                                    7–10 working days
                                </span>
                                <span class="mn-svc-pill mn-svc-pill-free">Free</span>
                            </div>
                        </div>
                        <div class="mn-svc-footer">
                            @if(!empty(\App\Models\Service::where('slug','national-id')->where('is_active',true)->first()))
                                <a href="{{ route('services.show', 'national-id') }}" class="mn-apply-btn">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Apply now
                                </a>
                            @else
                                <span class="mn-soon-label">Launching soon</span>
                            @endif
                        </div>
                    </div>

                    {{-- Passport --}}
                    <div class="mn-svc-card">
                        <div class="mn-svc-head">
                            <div class="mn-svc-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div class="mn-svc-info">
                                <h3>Passport Application</h3>
                                <div class="mn-svc-info-ku">داواکاری پاسپۆرت</div>
                            </div>
                        </div>
                        <div class="mn-svc-body">
                            <div class="mn-svc-docs">
                                <div class="mn-svc-doc">Valid National ID Card (original)</div>
                                <div class="mn-svc-doc">Birth certificate (original and copy)</div>
                                <div class="mn-svc-doc">Recent biometric passport photos (2)</div>
                                <div class="mn-svc-doc">Previous passport if renewing</div>
                            </div>
                            <div class="mn-svc-meta">
                                <span class="mn-svc-pill mn-svc-pill-days">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/></svg>
                                    14–21 working days
                                </span>
                                <span class="mn-svc-pill mn-svc-pill-free">Free</span>
                            </div>
                        </div>
                        <div class="mn-svc-footer">
                            <span class="mn-soon-label">Launching soon</span>
                        </div>
                    </div>

                    {{-- Birth Certificate --}}
                    <div class="mn-svc-card">
                        <div class="mn-svc-head">
                            <div class="mn-svc-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="mn-svc-info">
                                <h3>Birth Certificate</h3>
                                <div class="mn-svc-info-ku">بڕوانامەی لەدایکبوون</div>
                            </div>
                        </div>
                        <div class="mn-svc-body">
                            <div class="mn-svc-docs">
                                <div class="mn-svc-doc">Hospital birth record or midwife letter</div>
                                <div class="mn-svc-doc">Both parents' National ID cards</div>
                                <div class="mn-svc-doc">Marriage certificate of parents</div>
                            </div>
                            <div class="mn-svc-meta">
                                <span class="mn-svc-pill mn-svc-pill-days">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/></svg>
                                    5–7 working days
                                </span>
                                <span class="mn-svc-pill mn-svc-pill-free">Free</span>
                            </div>
                        </div>
                        <div class="mn-svc-footer">
                            @if(!empty(\App\Models\Service::where('slug','birth-certificate')->where('is_active',true)->first()))
                                <a href="{{ route('services.show', 'birth-certificate') }}" class="mn-apply-btn">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Apply now
                                </a>
                            @else
                                <span class="mn-soon-label">Launching soon</span>
                            @endif
                        </div>
                    </div>

                    {{-- Marriage Certificate --}}
                    <div class="mn-svc-card">
                        <div class="mn-svc-head">
                            <div class="mn-svc-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                            <div class="mn-svc-info">
                                <h3>Marriage Certificate</h3>
                                <div class="mn-svc-info-ku">بڕوانامەی زەوجیت</div>
                            </div>
                        </div>
                        <div class="mn-svc-body">
                            <div class="mn-svc-docs">
                                <div class="mn-svc-doc">Both spouses' National ID cards</div>
                                <div class="mn-svc-doc">Court or religious ceremony official record</div>
                                <div class="mn-svc-doc">Witness IDs (2 witnesses required)</div>
                                <div class="mn-svc-doc">Medical fitness certificates (both spouses)</div>
                            </div>
                            <div class="mn-svc-meta">
                                <span class="mn-svc-pill mn-svc-pill-days">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/></svg>
                                    7–14 working days
                                </span>
                                <span class="mn-svc-pill mn-svc-pill-free">Free</span>
                            </div>
                        </div>
                        <div class="mn-svc-footer">
                            <span class="mn-soon-label">Launching soon</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ── Track Application ── --}}
        <section class="mn-section-sm mn-alt" id="track" aria-labelledby="track-heading">
            <div class="mn-container">
                <div class="mn-track-box">
                    <div class="mn-track-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h2 id="track-heading">Track your Civil Registry application</h2>
                    <p>Enter the tracking code from your submission confirmation email to check your application status in real time.</p>
                    <form class="mn-track-form" onsubmit="handleTrack(event)" role="search">
                        <label for="track-input" class="sr-only">Tracking code</label>
                        <input type="text" id="track-input" class="mn-track-input" placeholder="e.g. HZ-CR-XXXXXXXX" autocomplete="off" spellcheck="false" aria-label="Enter tracking code">
                        <button type="submit" class="mn-track-btn">Track</button>
                    </form>
                    <p class="mn-track-note">Your code was sent by email when you submitted your application. <a href="{{ url('/') }}#track" style="color:var(--m);font-weight:600;">Use the main tracker</a> if you prefer.</p>
                </div>
            </div>
        </section>

        {{-- ── Contact ── --}}
        <section class="mn-section" id="contact" aria-labelledby="contact-heading">
            <div class="mn-container">
                <div class="mn-kicker">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Visit us
                </div>
                <h2 id="contact-heading" class="mn-sh" style="margin-bottom:8px;">Civil Registry offices across Kurdistan</h2>
                <p class="mn-sub">Visit any of our offices across the Kurdistan Region. Physical visits are only required for biometric capture and final document pickup — all paperwork is submitted online first.</p>
                <div class="mn-offices-grid">

                    {{-- Erbil --}}
                    <div class="mn-contact-card">
                        <div class="mn-contact-header">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m5-4h1m4 0h1M9 7h1m4 0h1"/></svg>
                            <h3>Erbil — Hewlêr</h3>
                            <span class="mn-office-badge mn-office-hq">Main Office</span>
                        </div>
                        <div class="mn-contact-body">
                            <div class="mn-contact-row">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div class="mn-contact-text"><strong>Address</strong><span>Gulan Street, Civil Registry Directorate Building, Erbil</span></div>
                            </div>
                            <div class="mn-contact-row">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <div class="mn-contact-text"><strong>Phone</strong><span>+964 66 216 1234</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- Sulaymaniyah --}}
                    <div class="mn-contact-card">
                        <div class="mn-contact-header">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m5-4h1m4 0h1M9 7h1m4 0h1"/></svg>
                            <h3>Sulaymaniyah — Silêmanî</h3>
                            <span class="mn-office-badge mn-office-branch">Branch</span>
                        </div>
                        <div class="mn-contact-body">
                            <div class="mn-contact-row">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div class="mn-contact-text"><strong>Address</strong><span>Salim Street, Civil Registry Building, Sulaymaniyah</span></div>
                            </div>
                            <div class="mn-contact-row">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <div class="mn-contact-text"><strong>Phone</strong><span>+964 53 311 2345</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- Duhok --}}
                    <div class="mn-contact-card">
                        <div class="mn-contact-header">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m5-4h1m4 0h1M9 7h1m4 0h1"/></svg>
                            <h3>Duhok</h3>
                            <span class="mn-office-badge mn-office-branch">Branch</span>
                        </div>
                        <div class="mn-contact-body">
                            <div class="mn-contact-row">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div class="mn-contact-text"><strong>Address</strong><span>Zakho Road, Civil Registry Building, Duhok</span></div>
                            </div>
                            <div class="mn-contact-row">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <div class="mn-contact-text"><strong>Phone</strong><span>+964 62 722 3456</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- Halabja --}}
                    <div class="mn-contact-card">
                        <div class="mn-contact-header">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m5-4h1m4 0h1M9 7h1m4 0h1"/></svg>
                            <h3>Halabja</h3>
                            <span class="mn-office-badge mn-office-branch">Branch</span>
                        </div>
                        <div class="mn-contact-body">
                            <div class="mn-contact-row">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div class="mn-contact-text"><strong>Address</strong><span>Freedom Square, Civil Registry Office, Halabja</span></div>
                            </div>
                            <div class="mn-contact-row">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <div class="mn-contact-text"><strong>Phone</strong><span>+964 53 325 4567</span></div>
                            </div>
                        </div>
                    </div>

                </div>
                <p class="mn-offices-note">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                    All offices are open Sunday – Thursday, 8:00 AM – 3:00 PM. Closed Friday, Saturday, and public holidays.
                </p>
            </div>
        </section>

    </main>

    {{-- ── Footer ── --}}
    <footer class="mn-footer" aria-label="Page footer">
        <div class="mn-foot-inner">
            <div class="mn-foot-brand">
                <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn">
                <div class="mn-foot-brand-text">
                    <strong>Halzanîn</strong>
                    <small>Kurdistan Government Portal</small>
                </div>
            </div>
            <nav class="mn-foot-links" aria-label="Footer navigation">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/') }}#ministries">All Ministries</a>
                <a href="#services">Services</a>
                <a href="#track">Track Application</a>
                <a href="#contact">Contact</a>
                @if(Route::has('login'))<a href="{{ route('login') }}">Sign In</a>@endif
                @if(Route::has('register'))<a href="{{ route('register') }}">Register</a>@endif
            </nav>
            <div class="mn-foot-copy">
                <span>&copy; {{ date('Y') }} Halzanîn — Kurdistan Government Services Portal</span>
                <span>Civil Registry Directorate — Kurdistan Region</span>
            </div>
        </div>
    </footer>

    <style>.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0;}</style>

    <script>
        // Theme
        (function(){
            var sun=document.getElementById('ti-sun'),moon=document.getElementById('ti-moon'),btn=document.getElementById('theme-toggle');
            function sync(){var d=document.documentElement.classList.contains('dark');sun.style.display=d?'block':'none';moon.style.display=d?'none':'block';}
            sync();
            btn.addEventListener('click',function(){var d=document.documentElement.classList.toggle('dark');localStorage.theme=d?'dark':'light';sync();});
        })();

        // Language
        function setLang(lang){
            document.documentElement.dir=lang==='ku'?'rtl':'ltr';
            document.documentElement.lang=lang;
            localStorage.lang=lang;
            document.getElementById('lang-en-btn').classList.toggle('active',lang==='en');
            document.getElementById('lang-ku-btn').classList.toggle('active',lang==='ku');
            document.querySelectorAll('[data-ku]').forEach(function(el){
                if(lang==='ku'&&el.dataset.ku){el.textContent=el.dataset.ku;}
                else if(lang==='en'&&el.dataset.en){el.textContent=el.dataset.en;}
            });
        }
        (function(){
            var saved=localStorage.lang||'en';
            document.getElementById('lang-en-btn').classList.toggle('active',saved==='en');
            document.getElementById('lang-ku-btn').classList.toggle('active',saved==='ku');
            if(saved==='ku'){
                document.querySelectorAll('[data-ku]').forEach(function(el){if(el.dataset.ku)el.textContent=el.dataset.ku;});
            }
        })();

        // Track
        function handleTrack(e){
            e.preventDefault();
            var code=document.getElementById('track-input').value.trim();
            if(!code){document.getElementById('track-input').focus();return;}
            window.location.href='{{ url("/track") }}/'+encodeURIComponent(code);
        }
    </script>
    <script src="{{ asset('js/translations.js') }}"></script>
</body>
</html>
