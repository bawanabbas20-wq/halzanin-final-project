<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Water Authority — Halzanîn Portal</title>
<meta name="description" content="Kurdistan Region Water Authority: new water connections, meter readings, leak reports, and water quality enquiries."/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;font-size:16px}
body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);line-height:1.6;min-height:100dvh}

:root{
  --m:#0E7C5A;
  --m-dark:#032a1e;
  --m-mid:#0a6a4d;
  --m-light:rgba(14,124,90,0.1);
  --m-border:rgba(14,124,90,0.2);

  --bg:#f0f8f6;
  --surface:#ffffff;
  --surface2:#e8f5f1;
  --card:#ffffff;
  --text:#071e17;
  --text-sub:#1f4a3c;
  --text-muted:#5a8a78;
  --border:rgba(0,0,0,0.08);
  --shadow:0 2px 16px rgba(0,0,0,0.07);
  --shadow-lg:0 8px 40px rgba(0,0,0,0.11);
  --nav-bg:rgba(240,248,246,0.93);
  --nav-border:rgba(0,0,0,0.08);
  --radius:14px;
}
html.dark{
  --m:#10b981;
  --m-dark:#020f09;
  --m-light:rgba(16,185,129,0.14);
  --m-border:rgba(16,185,129,0.28);

  --bg:#040f0c;
  --surface:#0a1f18;
  --surface2:#0e2820;
  --card:#0c1e16;
  --text:#d0f0e8;
  --text-sub:#80c8aa;
  --text-muted:#3a7a62;
  --border:rgba(255,255,255,0.07);
  --shadow:0 2px 16px rgba(0,0,0,0.45);
  --shadow-lg:0 8px 40px rgba(0,0,0,0.55);
  --nav-bg:rgba(4,15,12,0.95);
  --nav-border:rgba(255,255,255,0.07);
}

.ku{font-family:'Noto Naskh Arabic','Segoe UI',Arial,sans-serif;direction:rtl;unicode-bidi:isolate}
[data-en]{display:block}[data-ku]{display:none}
.lang-ku [data-en]{display:none}.lang-ku [data-ku]{display:block}

/* ── Navbar ──────────────────────────────────────────────────*/
.mn-bar{position:sticky;top:0;z-index:200;background:var(--nav-bg);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border-bottom:1px solid var(--nav-border);}
.mn-nav{display:flex;align-items:center;height:68px;gap:20px;max-width:1200px;margin:0 auto;padding:0 clamp(1.25rem,5vw,3rem);}
.mn-brand{display:inline-flex;align-items:center;gap:12px;flex-shrink:0;text-decoration:none;color:inherit;}
.mn-brand img{height:44px;width:auto;}
.mn-brand-text strong{display:block;font-size:17px;font-weight:800;letter-spacing:-.3px;color:var(--text);}
.mn-brand-text small{display:block;font-size:10px;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;}
.mn-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text-muted);font-weight:500;}
.mn-breadcrumb a{color:var(--text-muted);transition:color .15s;text-decoration:none;}
.mn-breadcrumb a:hover{color:var(--m);}
.mn-breadcrumb-sep{opacity:.4;font-size:11px;}
.mn-breadcrumb-current{color:var(--m);font-weight:700;}
.mn-nav-right{margin-left:auto;display:flex;align-items:center;gap:10px;}
.mn-toggles{display:flex;align-items:center;gap:4px;background:var(--surface);border:1.5px solid var(--border);border-radius:999px;padding:4px 5px;}
.mn-theme-btn{width:32px;height:32px;border-radius:50%;background:none;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);transition:background .18s,color .18s;}
.mn-theme-btn:hover{background:var(--m-light);color:var(--m);}
.mn-theme-btn svg{width:16px;height:16px;}
.mn-divider{width:1px;height:18px;background:var(--border);margin:0 2px;}
.mn-lang{display:flex;align-items:center;background:var(--m-light);border-radius:999px;padding:3px;gap:2px;}
.mn-lang-btn{border:none;cursor:pointer;border-radius:999px;padding:4px 10px;font-size:11.5px;font-weight:700;transition:all .2s;color:var(--text-muted);background:none;line-height:1;}
.mn-lang-btn.active{background:var(--m);color:#fff;box-shadow:0 2px 8px rgba(14,124,90,.35);}
.mn-navbtn{border-radius:999px;padding:9px 20px;font-family:'Inter',sans-serif;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:all .2s;border:1.5px solid transparent;white-space:nowrap;text-decoration:none;}
.mn-navbtn-primary{background:var(--m);color:#fff;border-color:var(--m);box-shadow:0 4px 14px rgba(14,124,90,.3);}
.mn-navbtn-primary:hover{background:var(--m-mid);transform:translateY(-1px);}
.mn-navbtn-outline{background:var(--surface);border-color:var(--border);color:var(--text);}
.mn-navbtn-outline:hover{border-color:var(--m);color:var(--m);}
@media(max-width:820px){.mn-breadcrumb,.mn-navbtn{display:none;}}

/* ── Hero ────────────────────────────────────────────────────*/
.mn-hero{
  position:relative;overflow:hidden;
  min-height:480px;
  background:linear-gradient(148deg,#032a1e,#0E7C5A,#0a6a4d);
  display:flex;align-items:flex-end;padding-bottom:3rem;
}
.mn-hero-photo{position:absolute;inset:0;z-index:1;}
.mn-hero-photo img{width:100%;height:100%;object-fit:cover;opacity:.18;display:block;}
html.dark .mn-hero-photo img{opacity:.11;}
/* ripple / water-ring pattern */
.mn-hero-pattern{
  position:absolute;inset:0;z-index:2;pointer-events:none;
  background-image:
    radial-gradient(ellipse 80% 40% at 60% 110%,rgba(52,211,153,0.12) 0%,transparent 65%),
    radial-gradient(ellipse 50% 30% at 80% 120%,rgba(52,211,153,0.08) 0%,transparent 60%);
}
.mn-hero-fade{
  position:absolute;bottom:0;left:0;right:0;height:220px;z-index:3;
  background:linear-gradient(to top,rgba(10,106,77,0.7) 0%,transparent 100%);
  pointer-events:none;
}
html.dark .mn-hero-fade{
  background:linear-gradient(to top,rgba(4,15,12,0.88) 0%,transparent 100%);
}
.mn-hero-inner{
  position:relative;z-index:4;
  width:100%;max-width:1200px;margin:0 auto;
  padding:0 clamp(1.25rem,5vw,3rem);
}
.mn-hero-badge{
  display:inline-flex;align-items:center;gap:.5rem;
  background:rgba(52,211,153,0.15);border:1px solid rgba(52,211,153,0.4);
  color:#6ee7b7;border-radius:20px;padding:.3rem .9rem;
  font-size:.75rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;margin-bottom:1.1rem;
}
.mn-hero-badge-dot{width:7px;height:7px;border-radius:50%;background:#34d399;animation:badge-wave 2.8s infinite}
@keyframes badge-wave{0%,100%{transform:scale(1)}50%{transform:scale(1.4)}}
.mn-hero-ku{
  font-family:'Noto Naskh Arabic',serif;direction:rtl;
  font-size:clamp(1.5rem,4vw,2.6rem);font-weight:700;color:#fff;line-height:1.25;margin-bottom:.35rem;
}
.mn-hero-en{
  font-size:clamp(1.1rem,2.8vw,1.85rem);font-weight:700;
  color:rgba(255,255,255,0.9);letter-spacing:-.01em;margin-bottom:.75rem;
}
.mn-hero-tagline{font-size:.95rem;color:rgba(255,255,255,0.68);margin-bottom:1.75rem;max-width:520px}
.mn-hero-ctas{display:flex;flex-wrap:wrap;gap:.75rem;align-items:center}
.mn-btn{
  display:inline-flex;align-items:center;gap:.45rem;
  padding:.7rem 1.5rem;border-radius:9px;font-size:.88rem;font-weight:600;
  text-decoration:none;transition:transform .2s,box-shadow .2s,background .2s;cursor:pointer;border:none;
}
.mn-btn:hover{transform:translateY(-2px)}
.mn-btn-primary{background:#34d399;color:#071e17;box-shadow:0 4px 20px rgba(52,211,153,0.3)}
.mn-btn-primary:hover{background:#10b981;box-shadow:0 6px 28px rgba(52,211,153,0.45)}
.mn-btn-ghost{background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.3);color:#fff}
.mn-btn-ghost:hover{background:rgba(255,255,255,0.22)}
.mn-hero-stats{
  display:flex;flex-wrap:wrap;gap:1.75rem;
  margin-top:2.25rem;padding-top:1.75rem;border-top:1px solid rgba(255,255,255,0.15);
}
.mn-hero-stat-val{font-size:1.4rem;font-weight:800;color:#fff;line-height:1}
.mn-hero-stat-lbl{font-size:.72rem;color:rgba(255,255,255,0.6);margin-top:.3rem}

/* ── Section shells ──────────────────────────────────────────*/
.mn-section{padding:clamp(2.5rem,6vw,4.5rem) clamp(1.25rem,5vw,3rem)}
.mn-section-inner{max-width:1200px;margin:0 auto}
.mn-section-label{font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--m);margin-bottom:.55rem}
.mn-section-title{font-size:clamp(1.3rem,2.8vw,1.9rem);font-weight:800;color:var(--text);letter-spacing:-.02em;margin-bottom:.5rem}
.mn-section-title-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:clamp(1.2rem,2.6vw,1.75rem);font-weight:700;color:var(--text);margin-bottom:.5rem}
.mn-section-sub{font-size:.95rem;color:var(--text-sub);max-width:600px;line-height:1.65}

/* ── About ────────────────────────────────────────────────────*/
.mn-about-grid{display:grid;grid-template-columns:1fr 420px;gap:3.5rem;align-items:center}
.mn-about-body p{font-size:.95rem;color:var(--text-sub);line-height:1.75;margin-bottom:1rem}
.mn-about-body p:last-child{margin-bottom:0}
.mn-about-img{width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:var(--radius);box-shadow:var(--shadow-lg)}
@media(max-width:860px){.mn-about-grid{grid-template-columns:1fr}.mn-about-img{max-height:260px}}

/* ── News ─────────────────────────────────────────────────────*/
.mn-news-bg{background:var(--surface2)}
html.dark .mn-news-bg{background:var(--surface)}
.mn-news-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-top:2rem}
@media(max-width:800px){.mn-news-grid{grid-template-columns:1fr}}
.mn-news-card{background:var(--card);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);border:1px solid var(--border);transition:box-shadow .3s,transform .28s}
.mn-news-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-4px)}
.mn-news-thumb{width:100%;height:170px;object-fit:cover;display:block}
.mn-news-content{padding:1.1rem 1.2rem 1.3rem}
.mn-news-date{font-size:.72rem;color:var(--text-muted);margin-bottom:.4rem;letter-spacing:.03em}
.mn-news-ttl{font-size:.92rem;font-weight:700;color:var(--text);margin-bottom:.45rem;line-height:1.4}
.mn-news-ttl-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:.95rem;font-weight:700;color:var(--text);margin-bottom:.45rem;line-height:1.5}
.mn-news-excerpt{font-size:.82rem;color:var(--text-muted);line-height:1.55}
.mn-news-more{display:inline-flex;align-items:center;gap:.3rem;margin-top:.75rem;font-size:.8rem;font-weight:600;color:var(--m);text-decoration:none;transition:gap .2s}
.mn-news-more:hover{gap:.55rem}

/* ── Services ─────────────────────────────────────────────────*/
.mn-services-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem;margin-top:2rem}
@media(max-width:700px){.mn-services-grid{grid-template-columns:1fr}}
.mn-svc-card{background:var(--card);border-radius:var(--radius);border:1px solid var(--border);padding:1.5rem;display:flex;flex-direction:column;gap:1rem;box-shadow:var(--shadow);transition:box-shadow .3s,transform .28s}
.mn-svc-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-3px)}
.mn-svc-head{display:flex;align-items:flex-start;gap:1rem}
.mn-svc-icon-wrap{width:46px;height:46px;border-radius:10px;flex-shrink:0;background:var(--m-light);border:1px solid var(--m-border);display:flex;align-items:center;justify-content:center;font-size:1.35rem}
.mn-svc-names{flex:1}
.mn-svc-en{font-size:.97rem;font-weight:700;color:var(--text)}
.mn-svc-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:.92rem;color:var(--text-sub);margin-top:.15rem}
.mn-svc-docs{list-style:none;padding:0;display:flex;flex-direction:column;gap:.35rem}
.mn-svc-docs li{font-size:.8rem;color:var(--text-sub);display:flex;align-items:baseline;gap:.45rem}
.mn-svc-docs li::before{content:'';width:5px;height:5px;border-radius:50%;background:var(--m);flex-shrink:0;margin-top:.32em}
.mn-svc-footer{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;padding-top:.85rem;border-top:1px solid var(--border);margin-top:auto}
.mn-svc-badges{display:flex;flex-wrap:wrap;gap:.4rem}
.mn-svc-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:20px;font-size:.7rem;font-weight:600}
.mn-badge-days{background:var(--m-light);color:var(--m);border:1px solid var(--m-border)}
.mn-badge-free{background:rgba(5,150,105,0.1);color:#059669;border:1px solid rgba(5,150,105,0.25)}
.mn-svc-apply{display:inline-flex;align-items:center;gap:.35rem;padding:.42rem 1rem;border-radius:7px;background:var(--m);color:#fff;font-size:.78rem;font-weight:600;text-decoration:none;transition:background .2s,transform .2s;border:none;cursor:pointer}
.mn-svc-apply:hover{background:var(--m-mid);transform:translateY(-1px)}
.mn-svc-soon{font-size:.78rem;color:var(--text-muted);font-style:italic}

/* ── Track ────────────────────────────────────────────────────*/
.mn-track-bg{background:linear-gradient(148deg,#032a1e,#0E7C5A);position:relative;overflow:hidden}
.mn-track-bg::before{
  content:'';position:absolute;inset:0;pointer-events:none;
  background:radial-gradient(ellipse 60% 50% at 80% 110%,rgba(52,211,153,0.1) 0%,transparent 65%);
}
.mn-track-inner{position:relative;z-index:1;max-width:620px;margin:0 auto;text-align:center;padding:clamp(2.5rem,6vw,4.5rem) clamp(1.25rem,5vw,3rem)}
.mn-track-icon{width:56px;height:56px;border-radius:14px;background:rgba(52,211,153,0.18);border:1px solid rgba(52,211,153,0.38);display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 1.25rem}
.mn-track-title{font-size:1.5rem;font-weight:800;color:#fff;margin-bottom:.5rem}
.mn-track-title-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:.5rem}
.mn-track-sub{font-size:.9rem;color:rgba(255,255,255,0.65);margin-bottom:1.75rem}
.mn-track-form{display:flex;gap:.65rem;max-width:420px;margin:0 auto;flex-wrap:wrap}
.mn-track-input{flex:1;min-width:200px;padding:.7rem 1rem;border-radius:9px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.1);color:#fff;font-size:.88rem;outline:none;transition:border-color .2s,background .2s}
.mn-track-input::placeholder{color:rgba(255,255,255,0.45)}
.mn-track-input:focus{border-color:rgba(52,211,153,0.6);background:rgba(255,255,255,0.15)}
.mn-track-submit{padding:.7rem 1.4rem;border-radius:9px;background:#34d399;color:#071e17;border:none;font-size:.88rem;font-weight:700;cursor:pointer;transition:background .2s,transform .2s;white-space:nowrap}
.mn-track-submit:hover{background:#10b981;transform:translateY(-1px)}

/* ── Contact ──────────────────────────────────────────────────*/
.mn-offices-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:2rem}
@media(max-width:820px){.mn-offices-grid{grid-template-columns:1fr}}
.mn-office-card{border-radius:var(--radius);padding:1.5rem;box-shadow:var(--shadow);transition:box-shadow .3s,transform .28s}
.mn-office-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-3px)}
.mn-office-hq{background:var(--m);color:#fff}
.mn-office-branch{background:var(--surface);color:var(--text);border:1px solid var(--border)}
html.dark .mn-office-branch{background:var(--surface2)}
.mn-office-badge{display:inline-block;font-size:.65rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:.2rem .6rem;border-radius:20px;margin-bottom:.75rem}
.mn-office-hq .mn-office-badge{background:rgba(255,255,255,.2);color:#fff}
.mn-office-branch .mn-office-badge{background:var(--m-light);color:var(--m);border:1px solid var(--m-border)}
.mn-office-name{font-size:1rem;font-weight:700;margin-bottom:.85rem;line-height:1.3}
.mn-office-hq .mn-office-name{color:#fff}
.mn-office-branch .mn-office-name{color:var(--text)}
.mn-office-detail{display:flex;align-items:flex-start;gap:.6rem;font-size:.82rem;margin-bottom:.55rem;line-height:1.45}
.mn-office-detail:last-child{margin-bottom:0}
.mn-office-hq .mn-office-detail{color:rgba(255,255,255,.85)}
.mn-office-branch .mn-office-detail{color:var(--text-sub)}
.mn-office-ico{flex-shrink:0;opacity:.75;margin-top:.1rem}
.mn-offices-note{margin-top:1.5rem;padding:1rem 1.25rem;background:var(--m-light);border:1px solid var(--m-border);border-radius:10px;font-size:.82rem;color:var(--text-sub);line-height:1.55}

/* ── Footer ───────────────────────────────────────────────────*/
.mn-footer{background:var(--surface);border-top:1px solid var(--border)}
.mn-foot-inner{max-width:1200px;margin:0 auto;padding:2rem clamp(1.25rem,5vw,3rem);display:flex;flex-wrap:wrap;align-items:flex-start;gap:2rem;justify-content:space-between}
.mn-foot-brand{display:flex;align-items:center;gap:12px;flex-shrink:0}
.mn-foot-brand img{height:42px;width:auto}
.mn-foot-brand-text strong{display:block;font-size:15px;font-weight:800;color:var(--text)}
.mn-foot-brand-text small{display:block;font-size:11px;color:var(--text-muted);font-weight:500}
.mn-foot-links{display:flex;flex-wrap:wrap;gap:.5rem 1.5rem}
.mn-foot-links a{font-size:.82rem;color:var(--text-muted);text-decoration:none;transition:color .2s}
.mn-foot-links a:hover{color:var(--m)}
.mn-foot-copy{width:100%;padding-top:1.25rem;border-top:1px solid var(--border);display:flex;flex-wrap:wrap;gap:.5rem;justify-content:space-between;font-size:.75rem;color:var(--text-muted)}

*:focus-visible{outline:2px solid var(--m);outline-offset:3px;border-radius:4px}
.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition-duration:.01ms!important}}
.icon-sun{display:block}.icon-moon{display:none}
html.dark .icon-sun{display:none}html.dark .icon-moon{display:block}
</style>
<script>if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark');}</script>
</head>
<body>

<header class="mn-bar" role="banner">
  <div class="mn-nav">
    <a href="{{ url('/') }}" class="mn-brand" aria-label="Halzanîn Portal Home">
      <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn Logo" width="44" height="44">
      <div class="mn-brand-text">
        <strong>Halzanîn</strong>
        <small>Kurdistan Government Portal</small>
      </div>
    </a>
    <nav class="mn-breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">Home / سەرەکی</a>
      <span class="mn-breadcrumb-sep">›</span>
      <span class="mn-breadcrumb-current"><span data-en>Water Authority</span><span data-ku class="ku">دەزگای ئاو</span></span>
    </nav>
    <div class="mn-nav-right">
      <div class="mn-toggles">
        <button class="mn-theme-btn" onclick="toggleDark()" id="theme-btn" aria-label="Toggle dark mode">
          <svg class="icon-sun" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
          <svg class="icon-moon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
        </button>
        <span class="mn-divider" aria-hidden="true"></span>
        <div class="mn-lang" role="group" aria-label="Language selection">
          <button class="mn-lang-btn" id="lang-en-btn" onclick="setLang('en')" aria-label="Switch to English">EN</button>
          <button class="mn-lang-btn" id="lang-ku-btn" onclick="setLang('ku')" aria-label="Switch to Kurdish">کوردی</button>
        </div>
      </div>
      @auth
        <a href="{{ url('/dashboard') }}" class="mn-navbtn mn-navbtn-primary">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          <span data-en>Dashboard</span><span data-ku class="ku">داشبۆرد</span>
        </a>
      @else
        <a href="{{ route('login') }}" class="mn-navbtn mn-navbtn-primary">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
          <span data-en>Sign In</span><span data-ku class="ku">چوونەژوورەوە</span>
        </a>
      @endauth
    </div>
  </div>
</header>

<section class="mn-hero" aria-label="Ministry hero">
  <div class="mn-hero-photo" aria-hidden="true">
    <img src="{{ asset('images/water/hero.jpeg') }}" alt="" loading="eager">
  </div>
  <div class="mn-hero-pattern" aria-hidden="true"></div>
  <div class="mn-hero-fade" aria-hidden="true"></div>
  <div class="mn-hero-inner">
    <div class="mn-hero-badge">
      <span class="mn-hero-badge-dot" aria-hidden="true"></span>
      <span data-en>Kurdistan Regional Government</span>
      <span data-ku class="ku">حکومەتی هەرێمی کوردستان</span>
    </div>
    <h1>
      <span data-ku class="mn-hero-ku">دەزگای ئاو</span>
      <span data-en class="mn-hero-en">Water Authority</span>
    </h1>
    <p class="mn-hero-tagline">
      <span data-en>New connections, meter readings, leak reports, and water quality enquiries — clean water for every home.</span>
      <span data-ku class="ku">پەیوەندییە نوێیەکان، خوێندنەوەی مێتەر، ڕاپۆرتی لیک، و پرسیاری کوالێتی ئاو — ئاوی پاک بۆ هەموو ماڵێک.</span>
    </p>
    <div class="mn-hero-ctas">
      <a href="#services" class="mn-btn mn-btn-primary"><span data-en>View Services</span><span data-ku class="ku">خزمەتگوزاریەکان</span></a>
      <a href="#track" class="mn-btn mn-btn-ghost"><span data-en>Track Application</span><span data-ku class="ku">شوێنکەوتنەوەی داواکاری</span></a>
    </div>
    <div class="mn-hero-stats" role="list" aria-label="Authority statistics">
      <div role="listitem">
        <div class="mn-hero-stat-val">4</div>
        <div class="mn-hero-stat-lbl"><span data-en>Services</span><span data-ku class="ku">خزمەتگوزاری</span></div>
      </div>
      <div role="listitem">
        <div class="mn-hero-stat-val"><span data-en>Sun – Thu</span><span data-ku class="ku">یەک — پێنج</span></div>
        <div class="mn-hero-stat-lbl"><span data-en>Opening days</span><span data-ku class="ku">ڕۆژانی کارکردن</span></div>
      </div>
      <div role="listitem">
        <div class="mn-hero-stat-val"><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></div>
        <div class="mn-hero-stat-lbl"><span data-en>Most services</span><span data-ku class="ku">زۆرینەی خزمەتگوزاری</span></div>
      </div>
      <div role="listitem">
        <div class="mn-hero-stat-val"><span data-en>3 – 14</span><span data-ku class="ku">٣ – ١٤</span></div>
        <div class="mn-hero-stat-lbl"><span data-en>Processing days</span><span data-ku class="ku">ڕۆژانی پرۆسەکردن</span></div>
      </div>
    </div>
  </div>
</section>

<section class="mn-section" id="about" aria-labelledby="about-title">
  <div class="mn-section-inner">
    <div class="mn-about-grid">
      <div>
        <p class="mn-section-label"><span data-en>About</span><span data-ku class="ku">دەربارە</span></p>
        <h2 id="about-title">
          <span data-en class="mn-section-title">Kurdistan Region Water Authority</span>
          <span data-ku class="mn-section-title-ku">دەزگای ئاوی هەرێمی کوردستان</span>
        </h2>
        <div class="mn-about-body">
          <p>
            <span data-en>The Kurdistan Region Water Authority is responsible for the supply, treatment, and distribution of clean drinking water across all governorates. We manage an extensive network of treatment plants, pumping stations, and distribution pipelines serving millions of citizens.</span>
            <span data-ku class="ku">دەزگای ئاوی هەرێمی کوردستان بەرپرسیارێتی دابینکردن، ئامادەکردن، و دابەشکردنی ئاوی خواردنەوەی پاک لە هەموو پارێزگاکاندا. ئێمە تۆڕێکی فراوانی کارگەی ئامادەکردن، ئیستگەی پەمپ، و بۆریی دابەشکردن بەڕێوە دەبەین.</span>
          </p>
          <p>
            <span data-en>Through the Halzanîn portal, citizens and property developers can apply for new water connections, request meter replacements, report leaks, and submit water quality complaints — without visiting our service centres.</span>
            <span data-ku class="ku">لە ڕێگەی پۆرتاڵی هەڵژانین، هاووڵاتیان و ئامادەکەرانی موڵک دەتوانن بۆ پەیوەندییە نوێی ئاو داوا بکەن، گۆڕینی مێتەر داوا بکەن، لیک ڕاپۆرت بکەن، و گیلۆپەی کوالێتی ئاو پێشکەش بکەن.</span>
          </p>
          <p>
            <span data-en>Leak reports and water safety incidents are treated as emergencies and responded to within 6 hours. Our 24-hour call centre is available for urgent matters at all times.</span>
            <span data-ku class="ku">ڕاپۆرتی لیک و ڕووداوەکانی سەلامەتی ئاو وەک بۆرا دامەزراون و لە ماوەی ٦ کاتژمێردا وەڵامی دەدرێتەوە. ناوەندی پەیوەندیمانی ٢٤ کاتژمێر بۆ بواری فریاگوزاری بەردەستە.</span>
          </p>
        </div>
      </div>
      <img
        src="{{ asset('images/water/about.jpeg') }}"
        alt="Clean water infrastructure and treatment facilities in Kurdistan"
        class="mn-about-img" loading="lazy"
      />
    </div>
  </div>
</section>

<section class="mn-section mn-news-bg" id="news" aria-labelledby="news-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Latest</span><span data-ku class="ku">دوایین</span></p>
    <h2 id="news-title">
      <span data-en class="mn-section-title">News &amp; Announcements</span>
      <span data-ku class="mn-section-title-ku">هەواڵ و ڕاگەیاندنەکان</span>
    </h2>
    <div class="mn-news-grid" role="list">
      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/water/news-plant.jpeg') }}" alt="New water treatment plant" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-05-20">20 May 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">New treatment plant serves 180,000 in east Erbil</span>
            <span data-ku class="mn-news-ttl-ku">کارگەی ئامادەکردنی نوێ خزمەت دەکات بە ١٨٠،٠٠٠ کەس لە ڕۆژهەڵاتی هەولێر</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>The new 60,000 m³/day treatment plant in eastern Erbil has entered full operation, benefiting over 180,000 residents.</span>
            <span data-ku class="ku">کارگەی ئامادەکردنی نوێی ٦٠،٠٠٠ مەتری کوپیک لە ڕۆژەدا لە ڕۆژهەڵاتی هەولێر کارکردنی تەواوی دەستپێکرد.</span>
          </p>
          <a href="#" class="mn-news-more"><span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span></a>
        </div>
      </article>
      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/water/news-pipeline.jpeg') }}" alt="Pipeline renewal project" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-05-07">7 May 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">200 km of aging pipelines renewed in Duhok</span>
            <span data-ku class="mn-news-ttl-ku">٢٠٠ کیلۆمەتر بۆریی کۆن نوێکرایەوە لە دهۆک</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>The Duhok pipeline renewal project has completed phase 2, replacing 200 km of aging distribution pipes across the governorate.</span>
            <span data-ku class="ku">پرۆژەی نوێکردنەوەی بۆریی دهۆک قۆناغی ٢ تەواو کرد و ٢٠٠ کیلۆمەتر بۆریی دابەشکردنی کۆن گۆڕا.</span>
          </p>
          <a href="#" class="mn-news-more"><span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span></a>
        </div>
      </article>
      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/water/news-quality.jpeg') }}" alt="Water quality report" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-04-15">15 April 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">Annual water quality report: all stations meet WHO standards</span>
            <span data-ku class="mn-news-ttl-ku">ڕاپۆرتی ساڵانەی کوالێتی ئاو: هەموو ئیستگەکان پێواناکانی WHO پارێزدەن</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>This year's annual quality audit confirms all treatment stations across the Kurdistan Region meet WHO drinking water standards.</span>
            <span data-ku class="ku">پشکنینی ساڵانەی کوالێتی ئەمساڵ دڵنیاکردەوەی هەموو ئیستگەکانی ئامادەکردن لە هەرێمی کوردستان پێواناکانی WHO دەپارێزن.</span>
          </p>
          <a href="#" class="mn-news-more"><span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span></a>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="mn-section" id="services" aria-labelledby="services-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Services</span><span data-ku class="ku">خزمەتگوزاریەکان</span></p>
    <h2 id="services-title">
      <span data-en class="mn-section-title">Available Services</span>
      <span data-ku class="mn-section-title-ku">خزمەتگوزاری بەردەستەکان</span>
    </h2>
    <p class="mn-section-sub">
      <span data-en>Apply online, schedule your appointment, and bring all listed documents.</span>
      <span data-ku class="ku">ئۆنلاین داوا بکە، ئاواندەکەت دیاربکە، و هەموو بەڵگەنامەکانی لیستکراو بهێنە.</span>
    </p>
    <div class="mn-services-grid" role="list">

      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-wc-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-4 5-6 8-6 11a6 6 0 0012 0c0-3-2-6-6-11z"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-wc-title"><span data-en>New Water Connection</span><span data-ku class="ku" style="display:none">پەیوەندیی نوێی ئاو</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">پەیوەندیی نوێی ئاو</span><span data-ku class="ku">New Water Connection</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required documents">
          <li><span data-en>Property ownership deed</span><span data-ku class="ku">سەند خاوەندارایەتی موڵک</span></li>
          <li><span data-en>Building permit (approved)</span><span data-ku class="ku">مۆڵەتی بینا (پەسەندکراو)</span></li>
          <li><span data-en>Applicant's National ID</span><span data-ku class="ku">ناسنامەی نەتەوەیی داواکار</span></li>
          <li><span data-en>Plumbing plan / site sketch</span><span data-ku class="ku">پلانی بۆری / نەخشەی شوێن</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>10 – 14 days</span><span data-ku class="ku">١٠ – ١٤ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc = \App\Models\Service::where('slug','water-connection')->where('is_active',true)->first(); @endphp
          @if($svc)
            <a href="{{ url('/services/water-connection') }}" class="mn-svc-apply"><span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span></a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-mr-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-mr-title"><span data-en>Meter Reading Request</span><span data-ku class="ku" style="display:none">داوای خوێندنەوەی مێتەر</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">داوای خوێندنەوەی مێتەر</span><span data-ku class="ku">Meter Reading Request</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required for meter reading">
          <li><span data-en>Subscriber account number</span><span data-ku class="ku">ژمارەی حسابی بەشداربوو</span></li>
          <li><span data-en>National ID</span><span data-ku class="ku">ناسنامەی نەتەوەیی</span></li>
          <li><span data-en>Property address</span><span data-ku class="ku">ناونیشانی موڵک</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>3 – 5 days</span><span data-ku class="ku">٣ – ٥ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc2 = \App\Models\Service::where('slug','meter-reading')->where('is_active',true)->first(); @endphp
          @if($svc2)
            <a href="{{ url('/services/meter-reading') }}" class="mn-svc-apply"><span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span></a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-lr-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-lr-title"><span data-en>Leak Report</span><span data-ku class="ku" style="display:none">ڕاپۆرتی لیک</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">ڕاپۆرتی لیک</span><span data-ku class="ku">Leak Report</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required for leak report">
          <li><span data-en>Address of leak location</span><span data-ku class="ku">ناونیشانی شوێنی لیک</span></li>
          <li><span data-en>Description of the leak</span><span data-ku class="ku">وەسفی لیک</span></li>
          <li><span data-en>Contact phone number</span><span data-ku class="ku">ژمارەی تەلەفۆنی پەیوەندی</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>Within 6 hrs</span><span data-ku class="ku">لە ٦ کاتژمێر</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc3 = \App\Models\Service::where('slug','water-leak-report')->where('is_active',true)->first(); @endphp
          @if($svc3)
            <a href="{{ url('/services/water-leak-report') }}" class="mn-svc-apply"><span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span></a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-wq-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M19.8 15a2.25 2.25 0 01.52 1.408v.216a2.25 2.25 0 01-2.25 2.25h-11.1a2.25 2.25 0 01-2.25-2.25v-.216c0-.52.18-1.003.52-1.408L5 14.5"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-wq-title"><span data-en>Water Quality Complaint</span><span data-ku class="ku" style="display:none">گیلۆپەی کوالێتی ئاو</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">گیلۆپەی کوالێتی ئاو</span><span data-ku class="ku">Water Quality Complaint</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required for water quality complaint">
          <li><span data-en>Subscriber account number</span><span data-ku class="ku">ژمارەی حسابی بەشداربوو</span></li>
          <li><span data-en>Address and description of issue</span><span data-ku class="ku">ناونیشان و وەسفی کێشە</span></li>
          <li><span data-en>Date and time issue first noticed</span><span data-ku class="ku">ڕۆژ و کاتی سەرەتا دیاریکردنی کێشە</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>1 – 3 days</span><span data-ku class="ku">١ – ٣ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc4 = \App\Models\Service::where('slug','water-quality-complaint')->where('is_active',true)->first(); @endphp
          @if($svc4)
            <a href="{{ url('/services/water-quality-complaint') }}" class="mn-svc-apply"><span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span></a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

    </div>
  </div>
</section>

<section class="mn-track-bg" id="track" aria-labelledby="track-title">
  <div class="mn-track-inner">
    <div class="mn-track-icon" aria-hidden="true"><svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg></div>
    <h2 id="track-title">
      <span data-en class="mn-track-title">Track your application</span>
      <span data-ku class="mn-track-title-ku">داواکارییەکەت شوێن بکەوە</span>
    </h2>
    <p class="mn-track-sub">
      <span data-en>Enter your reference code to check the status of your application.</span>
      <span data-ku class="ku">کۆدی چاوپێکەوتنەکەت بنووسە بۆ پشکنینی دۆخی داواکارییەکەت.</span>
    </p>
    <form class="mn-track-form" onsubmit="handleTrack(event)" role="search" aria-label="Application tracker">
      <label for="track-code" class="sr-only"><span data-en>Application reference code</span><span data-ku class="ku">کۆدی چاوپێکەوتنی داواکاری</span></label>
      <input type="text" id="track-code" class="mn-track-input" placeholder="e.g. HLZ-2026-XXXXX" autocomplete="off" maxlength="24"/>
      <button type="submit" class="mn-track-submit"><span data-en>Track</span><span data-ku class="ku">شوێنکەوتن</span></button>
    </form>
  </div>
</section>

<section class="mn-section" id="contact" aria-labelledby="contact-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Contact</span><span data-ku class="ku">پەیوەندی</span></p>
    <h2 id="contact-title">
      <span data-en class="mn-section-title">Find us</span>
      <span data-ku class="mn-section-title-ku">بماندۆزەوە</span>
    </h2>
    <div class="mn-offices-grid">

      <!-- Erbil HQ -->
      <div class="mn-office-card mn-office-hq">
        <span class="mn-office-badge">Headquarters / چەواری سەرەکی</span>
        <p class="mn-office-name">
          <span data-en>Erbil — Water Authority HQ</span>
          <span data-ku class="ku">هەولێر — چەواری سەرەکیی دەزگای ئاو</span>
        </p>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          <span><span data-en>Dream City Road, Erbil</span><span data-ku class="ku">ڕێگای دریم سیتی، هەولێر</span></span>
        </div>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          <span dir="ltr">+964 66 444 1230</span>
        </div>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
          <span><span data-en>Sun – Thu, 8:00 – 15:00 · Emergency: 116 (24/7)</span><span data-ku class="ku">یەک – پێنج، ٨:٠٠ – ١٥:٠٠ · فریاگوزاری: ١١٦ (٢٤/٧)</span></span>
        </div>
      </div>

      <!-- Sulaymaniyah Branch -->
      <div class="mn-office-card mn-office-branch">
        <span class="mn-office-badge"><span data-en>Branch Office</span><span data-ku class="ku">شوبەی لق</span></span>
        <p class="mn-office-name">
          <span data-en>Sulaymaniyah Branch</span>
          <span data-ku class="ku">لقی سلێمانی</span>
        </p>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          <span><span data-en>Salim Street, Sulaymaniyah</span><span data-ku class="ku">شەقامی سالم، سلێمانی</span></span>
        </div>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          <span dir="ltr">+964 53 314 2345</span>
        </div>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
          <span><span data-en>Sun – Thu, 8:00 – 15:00</span><span data-ku class="ku">یەک – پێنج، ٨:٠٠ – ١٥:٠٠</span></span>
        </div>
      </div>

      <!-- Duhok Branch -->
      <div class="mn-office-card mn-office-branch">
        <span class="mn-office-badge"><span data-en>Branch Office</span><span data-ku class="ku">شوبەی لق</span></span>
        <p class="mn-office-name">
          <span data-en>Duhok Branch</span>
          <span data-ku class="ku">لقی دهۆک</span>
        </p>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          <span><span data-en>Semel Road, Duhok</span><span data-ku class="ku">ڕێگای سیمێل، دهۆک</span></span>
        </div>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          <span dir="ltr">+964 62 724 5678</span>
        </div>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
          <span><span data-en>Sun – Thu, 8:00 – 15:00</span><span data-ku class="ku">یەک – پێنج، ٨:٠٠ – ١٥:٠٠</span></span>
        </div>
      </div>

      <!-- Halabja Branch -->
      <div class="mn-office-card mn-office-branch">
        <span class="mn-office-badge"><span data-en>Branch Office</span><span data-ku class="ku">شوبەی لق</span></span>
        <p class="mn-office-name">
          <span data-en>Halabja Branch</span>
          <span data-ku class="ku">لقی هەڵەبجە</span>
        </p>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          <span><span data-en>Shahidan Square, Halabja</span><span data-ku class="ku">مەیدانی شەهیدان، هەڵەبجە</span></span>
        </div>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          <span dir="ltr">+964 53 328 9012</span>
        </div>
        <div class="mn-office-detail">
          <svg class="mn-office-ico" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
          <span><span data-en>Sun – Thu, 8:00 – 15:00</span><span data-ku class="ku">یەک – پێنج، ٨:٠٠ – ١٥:٠٠</span></span>
        </div>
      </div>

    </div>
    <div class="mn-offices-note">
      <span data-en>For water leak emergencies, call <strong>116</strong> (available 24/7 from any line). The Halzanîn portal handles administrative services only — for urgent water supply issues please call your nearest office directly.</span>
      <span data-ku class="ku">بۆ فریاگوزاری لیکی ئاو، پەیوەندی بکە بە <strong>١١٦</strong> (بەردەستە ٢٤/٧ لە هەر هێڵێک). پۆرتاڵی هەڵژانین تەنها خزمەتگوزاری کارگێڕیی بەڕێوە دەبات — بۆ کێشەی فریاگوزاری ئاو, پەیوەندی ڕاستەوخۆ بکە بە نزیکترین نوسینگە.</span>
    </div>
  </div>
</section>

<footer class="mn-footer" role="contentinfo">
  <div class="mn-foot-inner">
    <div class="mn-foot-brand">
      <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn">
      <div class="mn-foot-brand-text">
        <strong>Halzanîn</strong>
        <small>Kurdistan Government Portal</small>
      </div>
    </div>
    <nav class="mn-foot-links" aria-label="Footer navigation">
      <a href="{{ url('/') }}"><span data-en>Home</span><span data-ku class="ku">سەرەکی</span></a>
      <a href="{{ route('track') }}"><span data-en>Track Application</span><span data-ku class="ku">شوێنکەوتنەوەی داواکاری</span></a>
      @auth
        <a href="{{ url('/dashboard') }}"><span data-en>Dashboard</span><span data-ku class="ku">داشبۆرد</span></a>
      @else
        <a href="{{ route('login') }}"><span data-en>Sign In</span><span data-ku class="ku">چوونەژوورەوە</span></a>
      @endauth
      <a href="{{ route('ministry.civil-registry') }}"><span data-en>Civil Registry</span><span data-ku class="ku">تۆماری مەدەنی</span></a>
    </nav>
    <div class="mn-foot-copy">
      <span>© {{ date('Y') }} Halzanîn — Kurdistan Government Services Portal</span>
      <span><span data-en>Water Authority — Kurdistan Region</span><span data-ku class="ku">دەزگای ئاو — هەرێمی کوردستان</span></span>
    </div>
  </div>
</footer>

<script>
(function(){
  const html=document.getElementById('html-root'),themeBtn=document.getElementById('theme-btn');
  function applyTheme(d){html.classList.toggle('dark',d)}
  const s=localStorage.theme || localStorage.getItem('halzanin-theme'),p=window.matchMedia('(prefers-color-scheme: dark)').matches;
  applyTheme(s?s==='dark':p);
  window.toggleDark=function(){const d=html.classList.toggle('dark');localStorage.theme=d?'dark':'light';localStorage.setItem('halzanin-theme',d?'dark':'light')};
  const langKuBtn=document.getElementById('lang-ku-btn'),langEnBtn=document.getElementById('lang-en-btn');
  window.setLang=function(l){
    document.body.classList.toggle('lang-ku',l==='ku');
    html.setAttribute('lang',l==='ku'?'ckb':'en');
    html.setAttribute('dir',l==='ku'?'rtl':'ltr');
    localStorage.setItem('halzanin-lang',l);
    localStorage.setItem('lang',l);
    if(langKuBtn)langKuBtn.classList.toggle('active',l==='ku');
    if(langEnBtn)langEnBtn.classList.toggle('active',l==='en');
  };
  setLang(localStorage.getItem('halzanin-lang')||localStorage.getItem('lang')||'en');
  window.handleTrack=function(e){e.preventDefault();const c=document.getElementById('track-code').value.trim();if(c)window.location.href='{{ url("/track") }}/'+encodeURIComponent(c)};
})();
</script>
</body>
</html>
