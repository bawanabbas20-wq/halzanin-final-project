<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Ministry of Electricity — Halzanîn Portal</title>
<meta name="description" content="Ministry of Electricity of the Kurdistan Region: new connection applications, meter transfers, fault reports, and billing enquiries."/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<style>
/* ── Reset & base ───────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;font-size:16px}
body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);line-height:1.6;min-height:100dvh}

/* ── Ministry tokens ────────────────────────────────────────── */
:root{
  --m:#D97706;
  --m-dark:#4a2900;
  --m-mid:#b45309;
  --m-light:rgba(217,119,6,0.1);
  --m-border:rgba(217,119,6,0.22);

  --bg:#faf8f4;
  --surface:#ffffff;
  --surface2:#f5f2eb;
  --card:#ffffff;
  --text:#1c1408;
  --text-sub:#4a3a1c;
  --text-muted:#8a7256;
  --border:rgba(0,0,0,0.08);
  --shadow:0 2px 16px rgba(0,0,0,0.07);
  --shadow-lg:0 8px 40px rgba(0,0,0,0.11);
  --nav-bg:rgba(250,248,244,0.93);
  --nav-border:rgba(0,0,0,0.09);
  --radius:14px;
  --radius-sm:8px;
}
html.dark{
  --m:#f59e0b;
  --m-dark:#1a0e00;
  --m-light:rgba(245,158,11,0.15);
  --m-border:rgba(245,158,11,0.3);

  --bg:#120d04;
  --surface:#1c1508;
  --surface2:#221a0a;
  --card:#1e1608;
  --text:#f0e8d0;
  --text-sub:#c0a870;
  --text-muted:#7a6040;
  --border:rgba(255,255,255,0.07);
  --shadow:0 2px 16px rgba(0,0,0,0.45);
  --shadow-lg:0 8px 40px rgba(0,0,0,0.55);
  --nav-bg:rgba(18,13,4,0.95);
  --nav-border:rgba(255,255,255,0.07);
}

/* ── Typography helpers ──────────────────────────────────────*/
.ku{font-family:'Noto Naskh Arabic','Segoe UI',Arial,sans-serif;direction:rtl;unicode-bidi:isolate}
[data-en]{display:block}
[data-ku]{display:none}
.lang-ku [data-en]{display:none}
.lang-ku [data-ku]{display:block}

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
.mn-lang-btn.active{background:var(--m);color:#1c1408;box-shadow:0 2px 8px rgba(217,119,6,.35);}
.mn-navbtn{border-radius:999px;padding:9px 20px;font-family:'Inter',sans-serif;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:all .2s;border:1.5px solid transparent;white-space:nowrap;text-decoration:none;}
.mn-navbtn-primary{background:var(--m);color:#1c1408;border-color:var(--m);box-shadow:0 4px 14px rgba(217,119,6,.3);}
.mn-navbtn-primary:hover{background:var(--m-mid);color:#fff;transform:translateY(-1px);}
.mn-navbtn-outline{background:var(--surface);border-color:var(--border);color:var(--text);}
.mn-navbtn-outline:hover{border-color:var(--m);color:var(--m);}
@media(max-width:820px){.mn-breadcrumb,.mn-navbtn{display:none;}}

/* ── Hero ────────────────────────────────────────────────────*/
.mn-hero{
  position:relative;overflow:hidden;
  min-height:480px;
  background:linear-gradient(148deg,#4a2900,#D97706,#b45309);
  display:flex;align-items:flex-end;
  padding-bottom:3rem;
}
.mn-hero-photo{position:absolute;inset:0;z-index:1;}
.mn-hero-photo img{width:100%;height:100%;object-fit:cover;opacity:.18;display:block;}
html.dark .mn-hero-photo img{opacity:.11;}
/* electric grid pattern */
.mn-hero-pattern{
  position:absolute;inset:0;z-index:2;pointer-events:none;
  background-image:
    linear-gradient(rgba(255,255,255,0.05) 1px,transparent 1px),
    linear-gradient(90deg,rgba(255,255,255,0.05) 1px,transparent 1px);
  background-size:40px 40px;
}
.mn-hero-glow{
  position:absolute;top:-60px;right:-80px;z-index:2;
  width:500px;height:500px;
  background:radial-gradient(ellipse,rgba(253,230,138,0.3) 0%,transparent 68%);
  pointer-events:none;
}
.mn-hero-fade{
  position:absolute;bottom:0;left:0;right:0;height:220px;z-index:3;
  background:linear-gradient(to top,rgba(180,83,9,0.65) 0%,transparent 100%);
  pointer-events:none;
}
html.dark .mn-hero-fade{
  background:linear-gradient(to top,rgba(18,13,4,0.85) 0%,transparent 100%);
}
.mn-hero-inner{
  position:relative;z-index:4;
  width:100%;max-width:1200px;margin:0 auto;
  padding:0 clamp(1.25rem,5vw,3rem);
}
.mn-hero-badge{
  display:inline-flex;align-items:center;gap:.5rem;
  background:rgba(253,230,138,0.18);
  border:1px solid rgba(253,230,138,0.45);
  color:#fde68a;
  border-radius:20px;padding:.3rem .9rem;
  font-size:.75rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;
  margin-bottom:1.1rem;
}
.mn-hero-badge-dot{
  width:7px;height:7px;border-radius:50%;
  background:#fbbf24;
  animation:badge-glow 2.5s infinite;
}
@keyframes badge-glow{0%,100%{box-shadow:0 0 0 3px rgba(251,191,36,0.25)}50%{box-shadow:0 0 0 7px rgba(251,191,36,0.1)}}
.mn-hero-ku{
  font-family:'Noto Naskh Arabic',serif;direction:rtl;
  font-size:clamp(1.5rem,4vw,2.6rem);font-weight:700;
  color:#fff;line-height:1.25;margin-bottom:.35rem;
}
.mn-hero-en{
  font-size:clamp(1.1rem,2.8vw,1.85rem);font-weight:700;
  color:rgba(255,255,255,0.9);letter-spacing:-.01em;margin-bottom:.75rem;
}
.mn-hero-tagline{font-size:.95rem;color:rgba(255,255,255,0.68);margin-bottom:1.75rem;max-width:520px}
.mn-hero-ctas{display:flex;flex-wrap:wrap;gap:.75rem;align-items:center}
.mn-btn{
  display:inline-flex;align-items:center;gap:.45rem;
  padding:.7rem 1.5rem;border-radius:9px;
  font-size:.88rem;font-weight:600;text-decoration:none;
  transition:transform .2s,box-shadow .2s,background .2s;cursor:pointer;border:none;
}
.mn-btn:hover{transform:translateY(-2px)}
.mn-btn-primary{
  background:#fbbf24;color:#1c1408;
  box-shadow:0 4px 20px rgba(251,191,36,0.35);
}
.mn-btn-primary:hover{background:#f59e0b;box-shadow:0 6px 28px rgba(251,191,36,0.5)}
.mn-btn-ghost{
  background:rgba(255,255,255,0.12);
  border:1px solid rgba(255,255,255,0.3);color:#fff;
}
.mn-btn-ghost:hover{background:rgba(255,255,255,0.22)}
.mn-hero-stats{
  display:flex;flex-wrap:wrap;gap:1.75rem;
  margin-top:2.25rem;padding-top:1.75rem;
  border-top:1px solid rgba(255,255,255,0.15);
}
.mn-hero-stat-val{font-size:1.4rem;font-weight:800;color:#fff;line-height:1}
.mn-hero-stat-lbl{font-size:.72rem;color:rgba(255,255,255,0.6);margin-top:.3rem}

/* ── Section shells ──────────────────────────────────────────*/
.mn-section{padding:clamp(2.5rem,6vw,4.5rem) clamp(1.25rem,5vw,3rem)}
.mn-section-inner{max-width:1200px;margin:0 auto}
.mn-section-label{
  font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:var(--m);margin-bottom:.55rem;
}
.mn-section-title{
  font-size:clamp(1.3rem,2.8vw,1.9rem);font-weight:800;
  color:var(--text);letter-spacing:-.02em;margin-bottom:.5rem;
}
.mn-section-title-ku{
  font-family:'Noto Naskh Arabic',serif;direction:rtl;
  font-size:clamp(1.2rem,2.6vw,1.75rem);font-weight:700;
  color:var(--text);margin-bottom:.5rem;
}
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
.mn-news-card{
  background:var(--card);border-radius:var(--radius);
  overflow:hidden;box-shadow:var(--shadow);border:1px solid var(--border);
  transition:box-shadow .3s,transform .28s;
}
.mn-news-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-4px)}
.mn-news-thumb{width:100%;height:170px;object-fit:cover;display:block}
.mn-news-content{padding:1.1rem 1.2rem 1.3rem}
.mn-news-date{font-size:.72rem;color:var(--text-muted);margin-bottom:.4rem;letter-spacing:.03em}
.mn-news-ttl{font-size:.92rem;font-weight:700;color:var(--text);margin-bottom:.45rem;line-height:1.4}
.mn-news-ttl-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:.95rem;font-weight:700;color:var(--text);margin-bottom:.45rem;line-height:1.5}
.mn-news-excerpt{font-size:.82rem;color:var(--text-muted);line-height:1.55}
.mn-news-more{
  display:inline-flex;align-items:center;gap:.3rem;
  margin-top:.75rem;font-size:.8rem;font-weight:600;color:var(--m);
  text-decoration:none;transition:gap .2s;
}
.mn-news-more:hover{gap:.55rem}

/* ── Services ─────────────────────────────────────────────────*/
.mn-services-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem;margin-top:2rem}
@media(max-width:700px){.mn-services-grid{grid-template-columns:1fr}}
.mn-svc-card{
  background:var(--card);border-radius:var(--radius);
  border:1px solid var(--border);padding:1.5rem;
  display:flex;flex-direction:column;gap:1rem;
  box-shadow:var(--shadow);transition:box-shadow .3s,transform .28s;
}
.mn-svc-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-3px)}
.mn-svc-head{display:flex;align-items:flex-start;gap:1rem}
.mn-svc-icon-wrap{
  width:46px;height:46px;border-radius:10px;flex-shrink:0;
  background:var(--m-light);border:1px solid var(--m-border);
  display:flex;align-items:center;justify-content:center;font-size:1.35rem;
}
.mn-svc-names{flex:1}
.mn-svc-en{font-size:.97rem;font-weight:700;color:var(--text)}
.mn-svc-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:.92rem;color:var(--text-sub);margin-top:.15rem}
.mn-svc-docs{list-style:none;padding:0;display:flex;flex-direction:column;gap:.35rem}
.mn-svc-docs li{font-size:.8rem;color:var(--text-sub);display:flex;align-items:baseline;gap:.45rem}
.mn-svc-docs li::before{content:'';width:5px;height:5px;border-radius:50%;background:var(--m);flex-shrink:0;margin-top:.32em}
.mn-svc-footer{
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:.5rem;
  padding-top:.85rem;border-top:1px solid var(--border);margin-top:auto;
}
.mn-svc-badges{display:flex;flex-wrap:wrap;gap:.4rem}
.mn-svc-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:20px;font-size:.7rem;font-weight:600}
.mn-badge-days{background:var(--m-light);color:var(--m);border:1px solid var(--m-border)}
.mn-badge-free{background:rgba(5,150,105,0.1);color:#059669;border:1px solid rgba(5,150,105,0.25)}
.mn-svc-apply{
  display:inline-flex;align-items:center;gap:.35rem;
  padding:.42rem 1rem;border-radius:7px;
  background:var(--m);color:#1c1408;
  font-size:.78rem;font-weight:700;text-decoration:none;
  transition:background .2s,transform .2s;border:none;cursor:pointer;
}
.mn-svc-apply:hover{background:var(--m-mid);color:#fff;transform:translateY(-1px)}
.mn-svc-soon{font-size:.78rem;color:var(--text-muted);font-style:italic}

/* ── Track ────────────────────────────────────────────────────*/
.mn-track-bg{
  background:linear-gradient(148deg,#4a2900,#D97706);
  position:relative;overflow:hidden;
}
.mn-track-bg::before{
  content:'';position:absolute;inset:0;pointer-events:none;
  background-image:linear-gradient(rgba(255,255,255,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.04) 1px,transparent 1px);
  background-size:40px 40px;
}
.mn-track-inner{
  position:relative;z-index:1;
  max-width:620px;margin:0 auto;text-align:center;
  padding:clamp(2.5rem,6vw,4.5rem) clamp(1.25rem,5vw,3rem);
}
.mn-track-icon{
  width:56px;height:56px;border-radius:14px;
  background:rgba(253,230,138,0.2);border:1px solid rgba(253,230,138,0.4);
  display:flex;align-items:center;justify-content:center;
  font-size:1.5rem;margin:0 auto 1.25rem;
}
.mn-track-title{font-size:1.5rem;font-weight:800;color:#fff;margin-bottom:.5rem}
.mn-track-title-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:.5rem}
.mn-track-sub{font-size:.9rem;color:rgba(255,255,255,0.65);margin-bottom:1.75rem}
.mn-track-form{display:flex;gap:.65rem;max-width:420px;margin:0 auto;flex-wrap:wrap}
.mn-track-input{
  flex:1;min-width:200px;padding:.7rem 1rem;
  border-radius:9px;border:1px solid rgba(255,255,255,0.2);
  background:rgba(255,255,255,0.1);color:#fff;
  font-size:.88rem;outline:none;transition:border-color .2s,background .2s;
}
.mn-track-input::placeholder{color:rgba(255,255,255,0.45)}
.mn-track-input:focus{border-color:rgba(253,230,138,0.7);background:rgba(255,255,255,0.15)}
.mn-track-submit{
  padding:.7rem 1.4rem;border-radius:9px;
  background:#fbbf24;color:#1c1408;border:none;
  font-size:.88rem;font-weight:700;cursor:pointer;
  transition:background .2s,transform .2s;white-space:nowrap;
}
.mn-track-submit:hover{background:#f59e0b;transform:translateY(-1px)}

/* ── Contact / Offices ────────────────────────────────────────*/
.mn-offices-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:2rem;}
@media(max-width:820px){.mn-offices-grid{grid-template-columns:1fr;}}
.mn-office-card{background:var(--card);border-radius:var(--radius);border:1px solid var(--border);padding:1.5rem;box-shadow:var(--shadow);transition:box-shadow .3s,transform .28s;}
.mn-office-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-3px)}
.mn-office-head{display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;margin-bottom:1rem;}
.mn-office-badge{font-size:10px;font-weight:700;padding:3px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:.04em;flex-shrink:0;white-space:nowrap;}
.mn-office-hq{background:var(--m);color:#1c1408;}
.mn-office-branch{background:var(--m-light);color:var(--m);border:1px solid var(--m-border);}
.mn-office-row{display:flex;align-items:flex-start;gap:.7rem;padding:.55rem 0;border-bottom:1px solid var(--border);}
.mn-office-row:last-child{border-bottom:none;}
.mn-office-ico{width:30px;height:30px;border-radius:7px;flex-shrink:0;background:var(--m-light);border:1px solid var(--m-border);display:flex;align-items:center;justify-content:center;}
.mn-office-lbl{font-size:.68rem;font-weight:600;color:var(--text-muted);letter-spacing:.04em;text-transform:uppercase;margin-bottom:.15rem;}
.mn-office-val{font-size:.84rem;color:var(--text);line-height:1.45;}
.mn-offices-note{margin-top:1.5rem;padding:1rem 1.25rem;background:var(--m-light);border:1px solid var(--m-border);border-radius:var(--radius-sm);font-size:.83rem;color:var(--text-sub);}

/* ── Footer ───────────────────────────────────────────────────*/
.mn-footer{border-top:1px solid var(--border);padding:40px 0 28px;background:var(--surface);}
.mn-foot-inner{max-width:1200px;margin:0 auto;padding:0 clamp(1.25rem,5vw,3rem);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;}
.mn-foot-brand{display:flex;align-items:center;gap:10px;}
.mn-foot-brand img{height:34px;}
.mn-foot-brand-text strong{display:block;font-size:14px;font-weight:800;color:var(--text);}
.mn-foot-brand-text small{font-size:11px;color:var(--text-muted);}
.mn-foot-links{display:flex;gap:6px;flex-wrap:wrap;}
.mn-foot-links a{font-size:13px;color:var(--text-muted);padding:4px 10px;border-radius:6px;transition:color .15s,background .15s;}
.mn-foot-links a:hover{color:var(--m);background:var(--m-light);}
.mn-foot-copy{width:100%;border-top:1px solid var(--border);margin-top:16px;padding-top:18px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;}
.mn-foot-copy span{font-size:12px;color:var(--text-muted);}
@media(max-width:600px){.mn-foot-inner{flex-direction:column;align-items:flex-start;}}

/* ── A11y ─────────────────────────────────────────────────────*/
*:focus-visible{outline:2px solid var(--m);outline-offset:3px;border-radius:4px}
.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition-duration:.01ms!important}}
.icon-sun{display:block}.icon-moon{display:none}
html.dark .icon-sun{display:none}html.dark .icon-moon{display:block}
</style>
</head>
<body>

<!-- NAV -->
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
      <a href="{{ url('/') }}"><span data-en>Home</span><span data-ku class="ku">سەرەکی</span></a>
      <span class="mn-breadcrumb-sep">›</span>
      <span class="mn-breadcrumb-current"><span data-en>Electricity</span><span data-ku class="ku">کارەبا</span></span>
    </nav>
    <div class="mn-nav-right">
      <div class="mn-toggles">
        <button class="mn-theme-btn" onclick="toggleDark()" aria-label="Toggle dark mode" id="theme-btn">
          <svg class="icon-sun" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
          <svg class="icon-moon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
        </button>
        <span class="mn-divider" aria-hidden="true"></span>
        <div class="mn-lang" role="group" aria-label="Language selector">
          <button class="mn-lang-btn" id="lang-en-btn" onclick="setLang('en')" aria-label="English">EN</button>
          <button class="mn-lang-btn" id="lang-ku-btn" onclick="setLang('ku')" aria-label="Kurdish">کوردی</button>
        </div>
      </div>
      @auth
        <a href="{{ route('dashboard') }}" class="mn-navbtn mn-navbtn-outline">
          <span data-en>Dashboard</span><span data-ku class="ku">داشبۆرد</span>
        </a>
      @else
        <a href="{{ route('login') }}" class="mn-navbtn mn-navbtn-primary">
          <span data-en>Sign In</span><span data-ku class="ku">چوونەژوورەوە</span>
        </a>
      @endauth
    </div>
  </div>
</header>

<!-- HERO -->
<section class="mn-hero" aria-label="Ministry hero">
  <div class="mn-hero-photo" aria-hidden="true">
    <img src="{{ asset('images/electricity/hero.jpeg') }}" alt="" loading="eager">
  </div>
  <div class="mn-hero-pattern" aria-hidden="true"></div>
  <div class="mn-hero-glow" aria-hidden="true"></div>
  <div class="mn-hero-fade" aria-hidden="true"></div>
  <div class="mn-hero-inner">
    <div class="mn-hero-badge">
      <span class="mn-hero-badge-dot" aria-hidden="true"></span>
      <span data-en>Kurdistan Regional Government</span>
      <span data-ku class="ku">حکومەتی هەرێمی کوردستان</span>
    </div>
    <h1>
      <span data-ku class="mn-hero-ku">وەزارەتی کارەبا</span>
      <span data-en class="mn-hero-en">Ministry of Electricity</span>
    </h1>
    <p class="mn-hero-tagline">
      <span data-en>New connections, meter transfers, fault reports, and billing services — powering Kurdistan's future.</span>
      <span data-ku class="ku">پەیوەندییە نوێیەکان، گواستنەوەی مێتەر، ڕاپۆرتی خراپی، و خزمەتگوزارییە پارەدانییەکان — هێزدانی ئایندەی کوردستان.</span>
    </p>
    <div class="mn-hero-ctas">
      <a href="#services" class="mn-btn mn-btn-primary">
        <span data-en>View Services</span><span data-ku class="ku">خزمەتگوزاریەکان</span>
      </a>
      <a href="#track" class="mn-btn mn-btn-ghost">
        <span data-en>Track Application</span><span data-ku class="ku">شوێنکەوتنەوەی داواکاری</span>
      </a>
    </div>
    <div class="mn-hero-stats" role="list" aria-label="Ministry statistics">
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
        <div class="mn-hero-stat-val"><span data-en>7 – 21</span><span data-ku class="ku">٧ – ٢١</span></div>
        <div class="mn-hero-stat-lbl"><span data-en>Processing days</span><span data-ku class="ku">ڕۆژانی پرۆسەکردن</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="mn-section" id="about" aria-labelledby="about-title">
  <div class="mn-section-inner">
    <div class="mn-about-grid">
      <div>
        <p class="mn-section-label"><span data-en>About</span><span data-ku class="ku">دەربارە</span></p>
        <h2 id="about-title">
          <span data-en class="mn-section-title">Ministry of Electricity</span>
          <span data-ku class="mn-section-title-ku">وەزارەتی کارەبا</span>
        </h2>
        <div class="mn-about-body">
          <p>
            <span data-en>The Ministry of Electricity is responsible for planning, implementing, and supervising electricity generation, transmission, and distribution across the Kurdistan Region. We oversee the development of power infrastructure to meet the growing energy needs of our citizens and industries.</span>
            <span data-ku class="ku">وەزارەتی کارەبا بەرپرسیارێتی پلانکردن، جێبەجێکردن، و چاودێریی بەرهەمهێنانی کارەبا، گواستنەوە، و دابەشکردن لە سەرانسەری هەرێمی کوردستان. ئێمە سەرپەرشتی گەشەپێدانی بنەرەتی هێزی کارەبا دەکەین.</span>
          </p>
          <p>
            <span data-en>Through the Halzanîn digital portal, citizens and businesses can apply for new electricity connections, request meter transfers, report faults, and manage billing enquiries without visiting our offices.</span>
            <span data-ku class="ku">لە ڕێگەی پۆرتاڵی دیجیتاڵی هەڵژانین، هاووڵاتیان و کاروباری دەتوانن بۆ پەیوەندییە نوێی کارەبا داوا بکەن، گواستنەوەی مێتەر داوا بکەن، خراپی ڕاپۆرت بکەن، و پرسیاری پارەدانی بەڕێوەببەن بەبێ سەردانی ئۆفیسەکانمان.</span>
          </p>
          <p>
            <span data-en>Emergency fault reports are available 24 hours a day. Our field teams respond to critical infrastructure faults within four hours across all governorates of the Kurdistan Region.</span>
            <span data-ku class="ku">ڕاپۆرتی خراپی فریاگوزاری ٢٤ کاتژمێر لە ڕۆژدا بەردەستە. تیمەکانی مەیدانمان لە ماوەی چوار کاتژمێردا وەڵامی خراپییە کریتیکییەکانی بنەرەتی دەدەنەوە لە هەموو پارێزگاکانی هەرێمی کوردستان.</span>
          </p>
        </div>
      </div>
      <img
        src="{{ asset('images/electricity/about.jpeg') }}"
        alt="Electricity infrastructure and power lines in Kurdistan Region"
        class="mn-about-img" loading="lazy"
      />
    </div>
  </div>
</section>

<!-- NEWS -->
<section class="mn-section mn-news-bg" id="news" aria-labelledby="news-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Latest</span><span data-ku class="ku">دوایین</span></p>
    <h2 id="news-title">
      <span data-en class="mn-section-title">News &amp; Announcements</span>
      <span data-ku class="mn-section-title-ku">هەواڵ و ڕاگەیاندنەکان</span>
    </h2>
    <div class="mn-news-grid" role="list">
      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/electricity/news-plant.jpeg') }}" alt="New power plant announcement" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-05-18">18 May 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">New 500 MW gas turbine plant breaks ground in Erbil</span>
            <span data-ku class="mn-news-ttl-ku">بنیادنانی نیرەگەی گازی ٥٠٠ میگاوات لە هەولێر</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>Construction begins on a new gas turbine station that will add 500 MW to the Kurdistan Region grid by 2028.</span>
            <span data-ku class="ku">دروستکردنی نیرەگەی گازی نوێ دەستپێدەکات کە ٥٠٠ میگاوات زیادەکاتەوە بۆ تۆڕی کوردستان تا ٢٠٢٨.</span>
          </p>
          <a href="#" class="mn-news-more"><span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span></a>
        </div>
      </article>
      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/electricity/news-meter.jpeg') }}" alt="Smart meter rollout" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-05-04">4 May 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">Smart meter rollout reaches 200,000 households</span>
            <span data-ku class="mn-news-ttl-ku">مێتەری زیرەک بۆ ٢٠٠،٠٠٠ خانووبەرە دەگات</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>The smart meter programme has now reached 200,000 households across Erbil and Duhok governorates.</span>
            <span data-ku class="ku">پرۆگرامی مێتەری زیرەک ئێستا بۆ ٢٠٠،٠٠٠ خانووبەرە لە پارێزگاکانی هەولێر و دهۆک دەگات.</span>
          </p>
          <a href="#" class="mn-news-more"><span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span></a>
        </div>
      </article>
      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/electricity/news-solar.jpeg') }}" alt="Solar energy project" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-04-21">21 April 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">Solar farm pilot produces first power in Sulaymaniyah</span>
            <span data-ku class="mn-news-ttl-ku">فەرمگەی خۆر لە سلێمانی یەکەم کارەبا دەبەرهێنێت</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>The 50 MW solar pilot project near Sulaymaniyah has successfully connected to the national grid, producing first power.</span>
            <span data-ku class="ku">پرۆژەی پایلەتی خۆری ٥٠ میگاوات لە نزیک سلێمانی بەسەرکەوتوویانە پەیوەندی بە تۆڕی نیشتمانی کرد.</span>
          </p>
          <a href="#" class="mn-news-more"><span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span></a>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="mn-section" id="services" aria-labelledby="services-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Services</span><span data-ku class="ku">خزمەتگوزاریەکان</span></p>
    <h2 id="services-title">
      <span data-en class="mn-section-title">Available Services</span>
      <span data-ku class="mn-section-title-ku">خزمەتگوزاری بەردەستەکان</span>
    </h2>
    <p class="mn-section-sub">
      <span data-en>Apply online and schedule your appointment. Bring all listed documents.</span>
      <span data-ku class="ku">ئۆنلاین داوا بکە و ئاواندەکەت دیاربکە. هەموو بەڵگەنامەکانی لیستکراو بهێنە.</span>
    </p>
    <div class="mn-services-grid" role="list">

      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-nc-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-nc-title"><span data-en>New Connection Request</span><span data-ku class="ku" style="display:none">داوای پەیوەندیی نوێ</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">داوای پەیوەندیی نوێ</span><span data-ku class="ku">New Connection Request</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required documents for new connection">
          <li><span data-en>Property ownership deed</span><span data-ku class="ku">سەند خاوەندارایەتی موڵک</span></li>
          <li><span data-en>Approved building permit</span><span data-ku class="ku">مۆڵەتی بینا پەسەندکراو</span></li>
          <li><span data-en>National ID of applicant</span><span data-ku class="ku">ناسنامەی نەتەوەیی داواکار</span></li>
          <li><span data-en>Site location sketch / map</span><span data-ku class="ku">نەخشەی شوێنی پرۆژە</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>14 – 21 days</span><span data-ku class="ku">١٤ – ٢١ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc = \App\Models\Service::where('slug','new-electricity-connection')->where('is_active',true)->first(); @endphp
          @if($svc)
            <a href="{{ url('/services/new-electricity-connection') }}" class="mn-svc-apply">
              <span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span>
            </a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-mt-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-mt-title"><span data-en>Meter Transfer</span><span data-ku class="ku" style="display:none">گواستنەوەی مێتەر</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">گواستنەوەی مێتەر</span><span data-ku class="ku">Meter Transfer</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required documents for meter transfer">
          <li><span data-en>Current subscriber certificate</span><span data-ku class="ku">بەڵگەنامەی بەشداربووی ئێستا</span></li>
          <li><span data-en>New owner's National ID</span><span data-ku class="ku">ناسنامەی نەتەوەیی خاوەنی نوێ</span></li>
          <li><span data-en>Proof of property transfer</span><span data-ku class="ku">بەڵگەنامەی گواستنەوەی موڵک</span></li>
          <li><span data-en>Cleared billing statement</span><span data-ku class="ku">ڕاپۆرتی پارەدانی پاکیکراو</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>7 – 14 days</span><span data-ku class="ku">٧ – ١٤ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc2 = \App\Models\Service::where('slug','meter-transfer')->where('is_active',true)->first(); @endphp
          @if($svc2)
            <a href="{{ url('/services/meter-transfer') }}" class="mn-svc-apply">
              <span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span>
            </a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-fr-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-fr-title"><span data-en>Fault Report</span><span data-ku class="ku" style="display:none">ڕاپۆرتی خراپی</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">ڕاپۆرتی خراپی</span><span data-ku class="ku">Fault Report</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required for fault report">
          <li><span data-en>Subscriber account number</span><span data-ku class="ku">ژمارەی حسابی بەشداربوو</span></li>
          <li><span data-en>National ID</span><span data-ku class="ku">ناسنامەی نەتەوەیی</span></li>
          <li><span data-en>Address + description of fault</span><span data-ku class="ku">ناونیشان + وەسفی خراپی</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>Within 24 hrs</span><span data-ku class="ku">لە ٢٤ کاتژمێر</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc3 = \App\Models\Service::where('slug','electricity-fault-report')->where('is_active',true)->first(); @endphp
          @if($svc3)
            <a href="{{ url('/services/electricity-fault-report') }}" class="mn-svc-apply">
              <span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span>
            </a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-bi-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-bi-title"><span data-en>Billing Enquiry</span><span data-ku class="ku" style="display:none">پرسیاری بڕگە</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">پرسیاری بڕگە</span><span data-ku class="ku">Billing Enquiry</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required for billing enquiry">
          <li><span data-en>Subscriber account number</span><span data-ku class="ku">ژمارەی حسابی بەشداربوو</span></li>
          <li><span data-en>National ID</span><span data-ku class="ku">ناسنامەی نەتەوەیی</span></li>
          <li><span data-en>Previous billing statement (if available)</span><span data-ku class="ku">بڕگەی پێشوو (ئەگەر بەردەستە)</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>1 – 3 days</span><span data-ku class="ku">١ – ٣ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc4 = \App\Models\Service::where('slug','billing-enquiry')->where('is_active',true)->first(); @endphp
          @if($svc4)
            <a href="{{ url('/services/billing-enquiry') }}" class="mn-svc-apply">
              <span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span>
            </a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

    </div>
  </div>
</section>

<!-- TRACK -->
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
      <input type="text" id="track-code" class="mn-track-input" placeholder="e.g. HLZ-2026-XXXXX" autocomplete="off" pattern="[A-Za-z0-9\-]+" maxlength="24"/>
      <button type="submit" class="mn-track-submit"><span data-en>Track</span><span data-ku class="ku">شوێنکەوتن</span></button>
    </form>
  </div>
</section>

<!-- CONTACT -->
<section class="mn-section" id="contact" aria-labelledby="contact-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Contact</span><span data-ku class="ku">پەیوەندی</span></p>
    <h2 id="contact-title">
      <span data-en class="mn-section-title">Find us</span>
      <span data-ku class="mn-section-title-ku">بماندۆزەوە</span>
    </h2>
    <div class="mn-offices-grid" role="list" aria-label="Ministry of Electricity offices across Kurdistan">

      <!-- Erbil — Main HQ -->
      <div class="mn-office-card" role="listitem">
        <div class="mn-office-head">
          <h3><span data-en>Erbil (Hewlêr)</span><span data-ku class="ku">هەولێر</span></h3>
          <span class="mn-office-badge mn-office-hq"><span data-en>Main HQ</span><span data-ku class="ku">چەوارەی سەرەکی</span></span>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Address</span><span data-ku class="ku">ناونیشان</span></p>
            <p class="mn-office-val"><span data-en>Ankawa Road, Erbil</span><span data-ku class="ku">ڕێگای عەنکاوە، هەولێر</span></p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Phone</span><span data-ku class="ku">تەلەفۆن</span></p>
            <p class="mn-office-val" dir="ltr">+964 66 333 7890</p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Hours</span><span data-ku class="ku">کاتی کار</span></p>
            <p class="mn-office-val"><span data-en>Sun – Thu, 8:00 – 15:00 · Faults: 24/7 (115)</span><span data-ku class="ku">یەکشەممە – پێنجشەممە، ٨:٠٠ – ١٥:٠٠ · خراپی: ٢٤/٧ (١١٥)</span></p>
          </div>
        </div>
      </div>

      <!-- Sulaymaniyah -->
      <div class="mn-office-card" role="listitem">
        <div class="mn-office-head">
          <h3><span data-en>Sulaymaniyah (Silêmanî)</span><span data-ku class="ku">سلێمانی</span></h3>
          <span class="mn-office-badge mn-office-branch"><span data-en>Branch</span><span data-ku class="ku">لق</span></span>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Address</span><span data-ku class="ku">ناونیشان</span></p>
            <p class="mn-office-val"><span data-en>Kirkuk Road, Sulaymaniyah</span><span data-ku class="ku">ڕێگای کەرکووک، سلێمانی</span></p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Phone</span><span data-ku class="ku">تەلەفۆن</span></p>
            <p class="mn-office-val" dir="ltr">+964 53 312 4567</p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Hours</span><span data-ku class="ku">کاتی کار</span></p>
            <p class="mn-office-val"><span data-en>Sun – Thu, 8:00 – 15:00</span><span data-ku class="ku">یەکشەممە – پێنجشەممە، ٨:٠٠ – ١٥:٠٠</span></p>
          </div>
        </div>
      </div>

      <!-- Duhok -->
      <div class="mn-office-card" role="listitem">
        <div class="mn-office-head">
          <h3><span data-en>Duhok</span><span data-ku class="ku">دهۆک</span></h3>
          <span class="mn-office-badge mn-office-branch"><span data-en>Branch</span><span data-ku class="ku">لق</span></span>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Address</span><span data-ku class="ku">ناونیشان</span></p>
            <p class="mn-office-val"><span data-en>Mosul Road, Duhok</span><span data-ku class="ku">ڕێگای موسڵ، دهۆک</span></p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Phone</span><span data-ku class="ku">تەلەفۆن</span></p>
            <p class="mn-office-val" dir="ltr">+964 62 721 3456</p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Hours</span><span data-ku class="ku">کاتی کار</span></p>
            <p class="mn-office-val"><span data-en>Sun – Thu, 8:00 – 15:00</span><span data-ku class="ku">یەکشەممە – پێنجشەممە، ٨:٠٠ – ١٥:٠٠</span></p>
          </div>
        </div>
      </div>

      <!-- Halabja -->
      <div class="mn-office-card" role="listitem">
        <div class="mn-office-head">
          <h3><span data-en>Halabja</span><span data-ku class="ku">هەڵەبجە</span></h3>
          <span class="mn-office-badge mn-office-branch"><span data-en>Branch</span><span data-ku class="ku">لق</span></span>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Address</span><span data-ku class="ku">ناونیشان</span></p>
            <p class="mn-office-val"><span data-en>Industrial Zone, Halabja</span><span data-ku class="ku">زۆنی پیشەسازی، هەڵەبجە</span></p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Phone</span><span data-ku class="ku">تەلەفۆن</span></p>
            <p class="mn-office-val" dir="ltr">+964 53 326 7890</p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Hours</span><span data-ku class="ku">کاتی کار</span></p>
            <p class="mn-office-val"><span data-en>Sun – Thu, 8:00 – 15:00</span><span data-ku class="ku">یەکشەممە – پێنجشەممە، ٨:٠٠ – ١٥:٠٠</span></p>
          </div>
        </div>
      </div>

    </div>
    <p class="mn-offices-note">
      <span data-en>All offices are open Sunday to Thursday, 8:00 AM – 3:00 PM. Emergency fault reports are available 24/7 — dial 115 from any line in the Kurdistan Region.</span>
      <span data-ku class="ku">هەموو ئۆفیسەکان لە یەکشەممە تا پێنجشەممە، لە کاتژمێر ٨:٠٠ بەیانی تا ٣:٠٠ دواتر کاردەکەن. ڕاپۆرتی خراپی فریاگوزاری ٢٤/٧ بەردەستە — ١١٥ بکەرەوە.</span>
    </p>
  </div>
</section>

<!-- FOOTER -->
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
      <a href="{{ url('/') }}#ministries"><span data-en>All Ministries</span><span data-ku class="ku">هەموو وەزارەتەکان</span></a>
      <a href="{{ route('track') }}"><span data-en>Track Application</span><span data-ku class="ku">شوێنکەوتنەوەی داواکاری</span></a>
      @auth
        <a href="{{ route('dashboard') }}"><span data-en>Dashboard</span><span data-ku class="ku">داشبۆرد</span></a>
      @else
        <a href="{{ route('login') }}"><span data-en>Sign In</span><span data-ku class="ku">چوونەژوورەوە</span></a>
        @if(Route::has('register'))<a href="{{ route('register') }}"><span data-en>Register</span><span data-ku class="ku">تۆمارکردن</span></a>@endif
      @endauth
    </nav>
    <div class="mn-foot-copy">
      <span><span data-en>&copy; {{ date('Y') }} Halzanîn — Kurdistan Government Services Portal</span><span data-ku class="ku">© {{ date('Y') }} هەڵژانین — پۆرتاڵی خزمەتگوزاریی حکومەتی کوردستان</span></span>
      <span><span data-en>Ministry of Electricity — Kurdistan Region</span><span data-ku class="ku">وەزارەتی کارەبا — هەرێمی کوردستان</span></span>
    </div>
  </div>
</footer>

<script>
(function(){
  const html = document.getElementById('html-root');
  const themeBtn = document.getElementById('theme-btn');
  function applyTheme(dark){
    html.classList.toggle('dark',dark);
  }
  const saved = localStorage.getItem('halzanin-theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  applyTheme(saved ? saved==='dark' : prefersDark);
  window.toggleDark = function(){
    const isDark = html.classList.toggle('dark');
    localStorage.setItem('halzanin-theme', isDark ? 'dark' : 'light');
  };
  const langKuBtn = document.getElementById('lang-ku-btn');
  const langEnBtn = document.getElementById('lang-en-btn');
  window.setLang = function(lang){
    document.body.classList.toggle('lang-ku', lang==='ku');
    html.setAttribute('lang', lang==='ku' ? 'ckb' : 'en');
    html.setAttribute('dir', lang==='ku' ? 'rtl' : 'ltr');
    localStorage.setItem('halzanin-lang', lang);
    localStorage.setItem('lang', lang);
    if(langKuBtn) langKuBtn.classList.toggle('active', lang==='ku');
    if(langEnBtn) langEnBtn.classList.toggle('active', lang==='en');
  };
  setLang(localStorage.getItem('halzanin-lang') || localStorage.getItem('lang') || 'en');
  window.handleTrack = function(e){
    e.preventDefault();
    const code = document.getElementById('track-code').value.trim();
    if(code) window.location.href = '{{ url("/track") }}/' + encodeURIComponent(code);
  };
})();
</script>
</body>
</html>
