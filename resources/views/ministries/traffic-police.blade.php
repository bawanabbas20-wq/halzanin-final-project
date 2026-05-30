<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Traffic Police Directorate — Halzanîn Portal</title>
<meta name="description" content="Traffic Police Directorate of the Kurdistan Region: driving licences, vehicle registration, fine payments, and road permits."/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<style>
/* ── Reset & base ───────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;font-size:16px}
body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);line-height:1.6;min-height:100dvh}

/* ── Ministry tokens ──────────────────────────────────────────
   --m       = primary brand colour
   --m-dark  = darkened variant (hero gradient)
   --m-mid   = midpoint for gradients
   --m-light = tinted surface (cards, badges)
   --m-border= subtle border tint
   --m-red   = red accent for traffic police
   --m-red-light = red tint
───────────────────────────────────────────────────────────── */
:root{
  --m:#2C2C3E;
  --m-dark:#111118;
  --m-mid:#252535;
  --m-light:rgba(44,44,62,0.08);
  --m-border:rgba(44,44,62,0.18);
  --m-red:#dc2626;
  --m-red-light:rgba(220,38,38,0.1);
  --m-red-border:rgba(220,38,38,0.25);

  --bg:#f4f5f7;
  --surface:#ffffff;
  --surface2:#f0f1f4;
  --card:#ffffff;
  --text:#1a1a2e;
  --text-sub:#4a4a5e;
  --text-muted:#7a7a8e;
  --border:rgba(0,0,0,0.09);
  --shadow:0 2px 16px rgba(0,0,0,0.08);
  --shadow-lg:0 8px 40px rgba(0,0,0,0.13);
  --nav-bg:rgba(244,245,247,0.92);
  --nav-border:rgba(0,0,0,0.1);
  --radius:14px;
  --radius-sm:8px;
}
html.dark{
  --m:#3e3e58;
  --m-dark:#0a0a10;
  --m-light:rgba(80,80,120,0.18);
  --m-border:rgba(100,100,160,0.28);
  --m-red-light:rgba(220,38,38,0.15);
  --m-red-border:rgba(220,38,38,0.35);

  --bg:#0d0d14;
  --surface:#16161f;
  --surface2:#1e1e2a;
  --card:#1a1a26;
  --text:#e8e8f5;
  --text-sub:#a0a0c0;
  --text-muted:#6a6a8a;
  --border:rgba(255,255,255,0.07);
  --shadow:0 2px 16px rgba(0,0,0,0.4);
  --shadow-lg:0 8px 40px rgba(0,0,0,0.5);
  --nav-bg:rgba(13,13,20,0.94);
  --nav-border:rgba(255,255,255,0.07);
}

/* ── Typography helpers ───────────────────────────────────────*/
.ku{font-family:'Noto Naskh Arabic','Segoe UI',Arial,sans-serif;direction:rtl;unicode-bidi:isolate}
[data-en]{display:block}
[data-ku]{display:none}
.lang-ku [data-en]{display:none}
.lang-ku [data-ku]{display:block}
.lang-ku .ku-inline{display:inline}
.lang-ku .en-inline{display:none}

/* ── Navbar ───────────────────────────────────────────────────*/
.mn-bar{position:sticky;top:0;z-index:200;background:var(--nav-bg);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border-bottom:1px solid var(--nav-border);}
.mn-nav{display:flex;align-items:center;height:68px;gap:20px;max-width:1200px;margin:0 auto;padding:0 clamp(1.25rem,5vw,3rem);}
.mn-brand{display:inline-flex;align-items:center;gap:12px;flex-shrink:0;text-decoration:none;color:inherit;}
.mn-brand img{height:44px;width:auto;}
.mn-brand-text strong{display:block;font-size:17px;font-weight:800;letter-spacing:-.3px;color:var(--text);}
.mn-brand-text small{display:block;font-size:10px;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;}
.mn-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text-muted);font-weight:500;}
.mn-breadcrumb a{color:var(--text-muted);transition:color .15s;text-decoration:none;}
.mn-breadcrumb a:hover{color:var(--m-red);}
.mn-breadcrumb-sep{opacity:.4;font-size:11px;}
.mn-breadcrumb-current{color:var(--m-red);font-weight:700;}
.mn-nav-right{margin-left:auto;display:flex;align-items:center;gap:10px;}
.mn-toggles{display:flex;align-items:center;gap:4px;background:var(--surface);border:1.5px solid var(--border);border-radius:999px;padding:4px 5px;}
.mn-theme-btn{width:32px;height:32px;border-radius:50%;background:none;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);transition:background .18s,color .18s;}
.mn-theme-btn:hover{background:var(--m-red-light);color:var(--m-red);}
.mn-theme-btn svg{width:16px;height:16px;}
.mn-divider{width:1px;height:18px;background:var(--border);margin:0 2px;}
.mn-lang{display:flex;align-items:center;background:var(--m-red-light);border-radius:999px;padding:3px;gap:2px;}
.mn-lang-btn{border:none;cursor:pointer;border-radius:999px;padding:4px 10px;font-size:11.5px;font-weight:700;transition:all .2s;color:var(--text-muted);background:none;line-height:1;}
.mn-lang-btn.active{background:var(--m-red);color:#fff;box-shadow:0 2px 8px rgba(220,38,38,.35);}
.mn-navbtn{border-radius:999px;padding:9px 20px;font-family:'Inter',sans-serif;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:all .2s;border:1.5px solid transparent;white-space:nowrap;text-decoration:none;}
.mn-navbtn-primary{background:var(--m-red);color:#fff;border-color:var(--m-red);box-shadow:0 4px 14px rgba(220,38,38,.3);}
.mn-navbtn-primary:hover{background:#b91c1c;transform:translateY(-1px);}
.mn-navbtn-outline{background:var(--surface);border-color:var(--border);color:var(--text);}
.mn-navbtn-outline:hover{border-color:var(--m-red);color:var(--m-red);}
@media(max-width:820px){.mn-breadcrumb,.mn-navbtn{display:none;}}

/* ── Hero ─────────────────────────────────────────────────────*/
.mn-hero{
  position:relative;overflow:hidden;
  min-height:480px;
  background:linear-gradient(148deg,#111118,#2C2C3E,#3a1a1e);
  display:flex;align-items:flex-end;
  padding-bottom:3rem;
}
.mn-hero-photo{position:absolute;inset:0;z-index:1;}
.mn-hero-photo img{width:100%;height:100%;object-fit:cover;opacity:.18;display:block;}
html.dark .mn-hero-photo img{opacity:.11;}
/* diagonal stripe pattern — traffic-police identity */
.mn-hero-pattern{
  position:absolute;inset:0;z-index:2;
  background-image:repeating-linear-gradient(
    -55deg,
    rgba(220,38,38,0.07) 0px,
    rgba(220,38,38,0.07) 2px,
    transparent 2px,
    transparent 22px
  );
  pointer-events:none;
}
.mn-hero-fade{
  position:absolute;bottom:0;left:0;right:0;height:220px;z-index:3;
  background:linear-gradient(to top,rgba(44,44,62,0.7) 0%,transparent 100%);
  pointer-events:none;
}
html.dark .mn-hero-fade{
  background:linear-gradient(to top,rgba(13,13,20,0.82) 0%,transparent 100%);
}
.mn-hero-inner{
  position:relative;z-index:4;
  width:100%;max-width:1200px;margin:0 auto;
  padding:0 clamp(1.25rem,5vw,3rem);
}
.mn-hero-badge{
  display:inline-flex;align-items:center;gap:.5rem;
  background:rgba(220,38,38,0.22);
  border:1px solid rgba(220,38,38,0.45);
  color:#fca5a5;
  border-radius:20px;padding:.3rem .9rem;
  font-size:.75rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;
  margin-bottom:1.1rem;
}
.mn-hero-badge-dot{
  width:7px;height:7px;border-radius:50%;
  background:#dc2626;box-shadow:0 0 0 3px rgba(220,38,38,0.3);
  animation:badge-pulse 2s infinite;
}
@keyframes badge-pulse{0%,100%{box-shadow:0 0 0 3px rgba(220,38,38,0.3)}50%{box-shadow:0 0 0 6px rgba(220,38,38,0.1)}}
.mn-hero-ku{
  font-family:'Noto Naskh Arabic',serif;direction:rtl;
  font-size:clamp(1.5rem,4vw,2.6rem);font-weight:700;
  color:#fff;line-height:1.25;margin-bottom:.35rem;
}
.mn-hero-en{
  font-size:clamp(1.1rem,2.8vw,1.85rem);font-weight:700;
  color:rgba(255,255,255,0.88);letter-spacing:-.01em;margin-bottom:.75rem;
}
.mn-hero-tagline{
  font-size:.95rem;color:rgba(255,255,255,0.65);margin-bottom:1.75rem;max-width:520px;
}
.mn-hero-ctas{display:flex;flex-wrap:wrap;gap:.75rem;align-items:center}
.mn-btn{
  display:inline-flex;align-items:center;gap:.45rem;
  padding:.7rem 1.5rem;border-radius:9px;
  font-size:.88rem;font-weight:600;text-decoration:none;
  transition:transform .2s,box-shadow .2s,background .2s;cursor:pointer;border:none;
}
.mn-btn:hover{transform:translateY(-2px)}
.mn-btn-primary{
  background:#dc2626;color:#fff;
  box-shadow:0 4px 20px rgba(220,38,38,0.4);
}
.mn-btn-primary:hover{background:#b91c1c;box-shadow:0 6px 28px rgba(220,38,38,0.5)}
.mn-btn-ghost{
  background:rgba(255,255,255,0.12);
  border:1px solid rgba(255,255,255,0.28);color:#fff;
}
.mn-btn-ghost:hover{background:rgba(255,255,255,0.22)}
.mn-hero-stats{
  display:flex;flex-wrap:wrap;gap:1.75rem;
  margin-top:2.25rem;padding-top:1.75rem;
  border-top:1px solid rgba(255,255,255,0.14);
}
.mn-hero-stat-val{font-size:1.4rem;font-weight:800;color:#fff;line-height:1}
.mn-hero-stat-lbl{font-size:.72rem;color:rgba(255,255,255,0.6);margin-top:.3rem}

/* ── Section shells ───────────────────────────────────────────*/
.mn-section{padding:clamp(2.5rem,6vw,4.5rem) clamp(1.25rem,5vw,3rem)}
.mn-section-inner{max-width:1200px;margin:0 auto}
.mn-section-label{
  font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:var(--m-red);margin-bottom:.55rem;
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

/* ── About ─────────────────────────────────────────────────────*/
.mn-about-grid{
  display:grid;grid-template-columns:1fr 420px;gap:3.5rem;align-items:center;
}
.mn-about-body p{font-size:.95rem;color:var(--text-sub);line-height:1.75;margin-bottom:1rem}
.mn-about-body p:last-child{margin-bottom:0}
.mn-about-img{
  width:100%;aspect-ratio:4/3;object-fit:cover;
  border-radius:var(--radius);
  box-shadow:var(--shadow-lg);
}
@media(max-width:860px){
  .mn-about-grid{grid-template-columns:1fr}
  .mn-about-img{max-height:260px}
}

/* ── News ──────────────────────────────────────────────────────*/
.mn-news-bg{background:var(--surface2)}
html.dark .mn-news-bg{background:var(--surface)}
.mn-news-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-top:2rem}
@media(max-width:800px){.mn-news-grid{grid-template-columns:1fr}}
.mn-news-card{
  background:var(--card);border-radius:var(--radius);
  overflow:hidden;box-shadow:var(--shadow);
  border:1px solid var(--border);
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
  margin-top:.75rem;font-size:.8rem;font-weight:600;color:var(--m-red);
  text-decoration:none;transition:gap .2s;
}
.mn-news-more:hover{gap:.55rem}

/* ── Services grid ─────────────────────────────────────────────*/
.mn-services-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem;margin-top:2rem}
@media(max-width:700px){.mn-services-grid{grid-template-columns:1fr}}
.mn-svc-card{
  background:var(--card);border-radius:var(--radius);
  border:1px solid var(--border);
  padding:1.5rem;display:flex;flex-direction:column;gap:1rem;
  box-shadow:var(--shadow);transition:box-shadow .3s,transform .28s;
}
.mn-svc-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-3px)}
.mn-svc-head{display:flex;align-items:flex-start;gap:1rem}
.mn-svc-icon-wrap{
  width:46px;height:46px;border-radius:10px;flex-shrink:0;
  background:var(--m-red-light);
  border:1px solid var(--m-red-border);
  display:flex;align-items:center;justify-content:center;font-size:1.35rem;
}
.mn-svc-names{flex:1}
.mn-svc-en{font-size:.97rem;font-weight:700;color:var(--text)}
.mn-svc-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:.92rem;color:var(--text-sub);margin-top:.15rem}
.mn-svc-docs{list-style:none;padding:0;display:flex;flex-direction:column;gap:.35rem}
.mn-svc-docs li{
  font-size:.8rem;color:var(--text-sub);
  display:flex;align-items:baseline;gap:.45rem;padding-left:.1rem;
}
.mn-svc-docs li::before{
  content:'';width:5px;height:5px;border-radius:50%;
  background:var(--m-red);flex-shrink:0;margin-top:.32em;
}
.mn-svc-footer{
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:.5rem;
  padding-top:.85rem;border-top:1px solid var(--border);
  margin-top:auto;
}
.mn-svc-badges{display:flex;flex-wrap:wrap;gap:.4rem}
.mn-svc-badge{
  display:inline-flex;align-items:center;gap:.3rem;
  padding:.22rem .65rem;border-radius:20px;font-size:.7rem;font-weight:600;
}
.mn-badge-days{background:var(--m-light);color:var(--m-red);border:1px solid var(--m-border)}
html.dark .mn-badge-days{background:var(--m-light);color:#c084fc}
.mn-badge-free{background:rgba(5,150,105,0.1);color:#059669;border:1px solid rgba(5,150,105,0.25)}
.mn-svc-apply{
  display:inline-flex;align-items:center;gap:.35rem;
  padding:.42rem 1rem;border-radius:7px;
  background:var(--m-red);color:#fff;
  font-size:.78rem;font-weight:600;text-decoration:none;
  transition:background .2s,transform .2s;border:none;cursor:pointer;
}
.mn-svc-apply:hover{background:#b91c1c;transform:translateY(-1px)}
.mn-svc-soon{font-size:.78rem;color:var(--text-muted);font-style:italic}

/* ── Track section ─────────────────────────────────────────────*/
.mn-track-bg{
  background:linear-gradient(148deg,#111118,#2C2C3E);
  position:relative;overflow:hidden;
}
.mn-track-bg::before{
  content:'';position:absolute;inset:0;
  background-image:repeating-linear-gradient(
    -55deg,rgba(220,38,38,0.05) 0px,rgba(220,38,38,0.05) 2px,transparent 2px,transparent 22px
  );
  pointer-events:none;
}
.mn-track-inner{
  position:relative;z-index:1;
  max-width:620px;margin:0 auto;text-align:center;
  padding:clamp(2.5rem,6vw,4.5rem) clamp(1.25rem,5vw,3rem);
}
.mn-track-icon{
  width:56px;height:56px;border-radius:14px;
  background:rgba(220,38,38,0.2);border:1px solid rgba(220,38,38,0.4);
  display:flex;align-items:center;justify-content:center;
  font-size:1.5rem;margin:0 auto 1.25rem;
}
.mn-track-title{font-size:1.5rem;font-weight:800;color:#fff;margin-bottom:.5rem}
.mn-track-title-ku{font-family:'Noto Naskh Arabic',serif;direction:rtl;font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:.5rem}
.mn-track-sub{font-size:.9rem;color:rgba(255,255,255,0.6);margin-bottom:1.75rem}
.mn-track-form{display:flex;gap:.65rem;max-width:420px;margin:0 auto;flex-wrap:wrap}
.mn-track-input{
  flex:1;min-width:200px;padding:.7rem 1rem;
  border-radius:9px;border:1px solid rgba(255,255,255,0.18);
  background:rgba(255,255,255,0.08);color:#fff;
  font-size:.88rem;outline:none;
  transition:border-color .2s,background .2s;
}
.mn-track-input::placeholder{color:rgba(255,255,255,0.4)}
.mn-track-input:focus{border-color:rgba(220,38,38,0.6);background:rgba(255,255,255,0.12)}
.mn-track-submit{
  padding:.7rem 1.4rem;border-radius:9px;
  background:#dc2626;color:#fff;border:none;
  font-size:.88rem;font-weight:600;cursor:pointer;
  transition:background .2s,transform .2s;white-space:nowrap;
}
.mn-track-submit:hover{background:#b91c1c;transform:translateY(-1px)}

/* ── Contact / Offices ─────────────────────────────────────────*/
.mn-offices-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:2rem;}
@media(max-width:820px){.mn-offices-grid{grid-template-columns:1fr;}}
.mn-office-card{background:var(--card);border-radius:var(--radius);border:1px solid var(--border);padding:1.5rem;box-shadow:var(--shadow);transition:box-shadow .3s,transform .28s;}
.mn-office-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-3px)}
.mn-office-head{display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;margin-bottom:1rem;}
.mn-office-badge{font-size:10px;font-weight:700;padding:3px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:.04em;flex-shrink:0;white-space:nowrap;}
.mn-office-hq{background:var(--m-red);color:#fff;}
.mn-office-branch{background:var(--m-red-light);color:var(--m-red);border:1px solid var(--m-red-border);}
.mn-office-row{display:flex;align-items:flex-start;gap:.7rem;padding:.55rem 0;border-bottom:1px solid var(--border);}
.mn-office-row:last-child{border-bottom:none;}
.mn-office-ico{width:30px;height:30px;border-radius:7px;flex-shrink:0;background:var(--m-red-light);border:1px solid var(--m-red-border);display:flex;align-items:center;justify-content:center;}
.mn-office-lbl{font-size:.68rem;font-weight:600;color:var(--text-muted);letter-spacing:.04em;text-transform:uppercase;margin-bottom:.15rem;}
.mn-office-val{font-size:.84rem;color:var(--text);line-height:1.45;}
.mn-offices-note{margin-top:1.5rem;padding:1rem 1.25rem;background:var(--m-red-light);border:1px solid var(--m-red-border);border-radius:var(--radius-sm);font-size:.83rem;color:var(--text-sub);}

/* ── Footer ────────────────────────────────────────────────────*/
.mn-footer{border-top:1px solid var(--border);padding:40px 0 28px;background:var(--surface);}
.mn-foot-inner{max-width:1200px;margin:0 auto;padding:0 clamp(1.25rem,5vw,3rem);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;}
.mn-foot-brand{display:flex;align-items:center;gap:10px;}
.mn-foot-brand img{height:34px;}
.mn-foot-brand-text strong{display:block;font-size:14px;font-weight:800;color:var(--text);}
.mn-foot-brand-text small{font-size:11px;color:var(--text-muted);}
.mn-foot-links{display:flex;gap:6px;flex-wrap:wrap;}
.mn-foot-links a{font-size:13px;color:var(--text-muted);padding:4px 10px;border-radius:6px;transition:color .15s,background .15s;}
.mn-foot-links a:hover{color:var(--m-red);background:var(--m-red-light);}
.mn-foot-copy{width:100%;border-top:1px solid var(--border);margin-top:16px;padding-top:18px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;}
.mn-foot-copy span{font-size:12px;color:var(--text-muted);}
@media(max-width:600px){.mn-foot-inner{flex-direction:column;align-items:flex-start;}}

/* ── Accessibility & Focus ─────────────────────────────────────*/
*:focus-visible{outline:2px solid var(--m-red);outline-offset:3px;border-radius:4px}
@media(prefers-reduced-motion:reduce){
  *{animation:none!important;transition-duration:.01ms!important}
}
.icon-sun{display:block}.icon-moon{display:none}
html.dark .icon-sun{display:none}html.dark .icon-moon{display:block}
</style>
</head>
<body>

<!-- ═══════════════════════════════════════════════════════════
     NAV
═══════════════════════════════════════════════════════════ -->
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
      <span class="mn-breadcrumb-current"><span data-en>Traffic Police</span><span data-ku class="ku">پۆلیسی ترافیک</span></span>
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

<!-- ═══════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════ -->
<section class="mn-hero" aria-label="Ministry hero">
  <div class="mn-hero-photo" aria-hidden="true">
    <img src="{{ asset('images/traffic-police/hero.jpeg') }}" alt="" loading="eager">
  </div>
  <div class="mn-hero-pattern" aria-hidden="true"></div>
  <div class="mn-hero-fade" aria-hidden="true"></div>
  <div class="mn-hero-inner">
    <div class="mn-hero-badge" aria-label="Ministry of Interior">
      <span class="mn-hero-badge-dot" aria-hidden="true"></span>
      <span data-en>Ministry of Interior — Kurdistan Region</span>
      <span data-ku class="ku">وەزارەتی ناوخۆ — هەرێمی کوردستان</span>
    </div>
    <h1>
      <span data-ku class="mn-hero-ku">بەرێوەبەرایەتی پۆلیسی ترافیک</span>
      <span data-en class="mn-hero-en">Traffic Police Directorate</span>
    </h1>
    <p class="mn-hero-tagline">
      <span data-en>Driving licences, vehicle registration, traffic fines, and road permits — online and at our centres.</span>
      <span data-ku class="ku">مۆڵەتی شۆفێری، تۆمارکردنی ئۆتۆمبێل، جریمەی ترافیک و مۆڵەتی ڕێگا.</span>
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
        <div class="mn-hero-stat-val">5</div>
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
        <div class="mn-hero-stat-val"><span data-en>5 – 14</span><span data-ku class="ku">٥ – ١٤</span></div>
        <div class="mn-hero-stat-lbl"><span data-en>Processing days</span><span data-ku class="ku">ڕۆژانی پرۆسەکردن</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     ABOUT
═══════════════════════════════════════════════════════════ -->
<section class="mn-section" id="about" aria-labelledby="about-title">
  <div class="mn-section-inner">
    <div class="mn-about-grid">
      <div>
        <p class="mn-section-label" aria-hidden="true"><span data-en>About</span><span data-ku class="ku">دەربارە</span></p>
        <h2 id="about-title">
          <span data-en class="mn-section-title">Traffic Police Directorate</span>
          <span data-ku class="mn-section-title-ku">بەرێوەبەرایەتی پۆلیسی ترافیک</span>
        </h2>
        <div class="mn-about-body">
          <p>
            <span data-en>The Traffic Police Directorate is responsible for road safety enforcement across the Kurdistan Region. Our officers manage traffic flow, investigate accidents, and ensure compliance with traffic regulations on all major roads and highways.</span>
            <span data-ku class="ku">بەرێوەبەرایەتی پۆلیسی ترافیک بەرپرسیارێتی پاراستنی سەلامەتی ڕێگا لە سەرانسەری هەرێمی کوردستانە. ئۆفیسەرەکانمان گەرمای ترافیک بەڕێوە دەبەن، ڕووداوەکان لێکدەدەنەوە، و دڵنیابوون لە پابەندبوون بە ڕێسا ترافیکییەکان دەکەن.</span>
          </p>
          <p>
            <span data-en>We provide digital services to help citizens obtain driving licences, register vehicles, clear traffic fines, and apply for special road permits from the comfort of their homes.</span>
            <span data-ku class="ku">خزمەتگوزاری دیجیتاڵمان دابین دەکەین بۆ هاووڵاتیان بۆ وەرگرتنی مۆڵەتی شۆفێری، تۆمارکردنی ئۆتۆمبێل، پاکیکردنەوەی جریمەی ترافیک و داوادانی مۆڵەتی ڕێگای تایبەت لە ماڵەوە.</span>
          </p>
          <p>
            <span data-en>Our service centres are located at main Traffic Police headquarters in Erbil, Sulaymaniyah, and Duhok. Online pre-registration is available for all services to reduce in-person wait times.</span>
            <span data-ku class="ku">ناوەندەکانی خزمەتگوزارییمان لە چەواری سەرەکیی پۆلیسی ترافیک لە هەولێر، سلێمانی، و دهۆک دایەزراون. تۆمارکردنی پێشووی ئۆنلاین بۆ هەموو خزمەتگوزارییەکان بەردەستە.</span>
          </p>
        </div>
      </div>
      <img
        src="{{ asset('images/traffic-police/about.jpeg') }}"
        alt="Traffic Police officers at duty in the Kurdistan Region"
        class="mn-about-img"
        loading="lazy"
      />
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     NEWS
═══════════════════════════════════════════════════════════ -->
<section class="mn-section mn-news-bg" id="news" aria-labelledby="news-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Latest</span><span data-ku class="ku">دوایین</span></p>
    <h2 id="news-title">
      <span data-en class="mn-section-title">News &amp; Announcements</span>
      <span data-ku class="mn-section-title-ku">هەواڵ و ڕاگەیاندنەکان</span>
    </h2>
    <div class="mn-news-grid" role="list" aria-label="Latest news">

      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/traffic-police/news-licence.jpeg') }}" alt="New digital driving licence system" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-05-12">12 May 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">New digital driving licence system launched</span>
            <span data-ku class="mn-news-ttl-ku">سیستەمی دیجیتاڵی مۆڵەتی شۆفێری دامەزراوە</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>Citizens can now apply for and renew driving licences entirely online through the Halzanîn portal.</span>
            <span data-ku class="ku">هاووڵاتیان ئێستا دەتوانن مۆڵەتی شۆفێری بەتەواوی ئۆنلاین لە پۆرتاڵی هەڵژانین داوا بکەن.</span>
          </p>
          <a href="#" class="mn-news-more" aria-label="Read more about digital driving licence system">
            <span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span>
          </a>
        </div>
      </article>

      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/traffic-police/news-fines.jpeg') }}" alt="Online fine payment system" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-04-28">28 April 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">Online fine payment now available 24/7</span>
            <span data-ku class="mn-news-ttl-ku">پارەدانی جریمەی ئۆنلاین ٢٤/٧ بەردەستە</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>Traffic fines can now be paid online at any time. Unpaid fines over 60 days incur a 10% surcharge.</span>
            <span data-ku class="ku">جریمەی ترافیک ئێستا دەتوانرێت لە هەر کاتێکدا ئۆنلاین بدرێت. جریمەی نەدراوی زیاتر لە ٦٠ ڕۆژ ١٠٪ زیادە دەبێت.</span>
          </p>
          <a href="#" class="mn-news-more" aria-label="Read more about online fine payments">
            <span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span>
          </a>
        </div>
      </article>

      <article class="mn-news-card" role="listitem">
        <img src="{{ asset('images/traffic-police/news-safety.jpeg') }}" alt="Road safety campaign" class="mn-news-thumb" loading="lazy"/>
        <div class="mn-news-content">
          <time class="mn-news-date" datetime="2026-04-10">10 April 2026</time>
          <h3>
            <span data-en class="mn-news-ttl">Road safety campaign reduces accidents by 18%</span>
            <span data-ku class="mn-news-ttl-ku">کامپانیای سەلامەتی ڕێگا ڕووداوەکان ١٨٪ کەمکردەوە</span>
          </h3>
          <p class="mn-news-excerpt">
            <span data-en>The spring road safety campaign across Erbil governorate has seen significant results in reducing road accidents.</span>
            <span data-ku class="ku">کامپانیای سەلامەتی ڕێگای بەهار لە پارێزگای هەولێر ئەنجامی بەرچاوی دیتووە.</span>
          </p>
          <a href="#" class="mn-news-more" aria-label="Read more about road safety campaign">
            <span data-en>Read more →</span><span data-ku class="ku">زیاتر بخوێنەوە ←</span>
          </a>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     SERVICES
═══════════════════════════════════════════════════════════ -->
<section class="mn-section" id="services" aria-labelledby="services-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Services</span><span data-ku class="ku">خزمەتگوزاریەکان</span></p>
    <h2 id="services-title">
      <span data-en class="mn-section-title">Available Services</span>
      <span data-ku class="mn-section-title-ku">خزمەتگوزاری بەردەستەکان</span>
    </h2>
    <p class="mn-section-sub">
      <span data-en>Apply online and attend your appointment. Bring all listed documents.</span>
      <span data-ku class="ku">ئۆنلاین داوا بکە و بچۆ بۆ ئاواندەکەت. هەموو بەڵگەنامەکانی لیستکراو بهێنە.</span>
    </p>
    <div class="mn-services-grid" role="list" aria-label="Traffic Police services">

      <!-- Driving Licence -->
      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-dl-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="8" cy="12" r="2"/><path stroke-linecap="round" d="M12 10h6M12 14h4"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-dl-title"><span data-en>Driving Licence</span><span data-ku class="ku" style="display:none">مۆڵەتی شۆفێری</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">مۆڵەتی شۆفێری</span><span data-ku class="ku">Driving Licence</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required documents for driving licence">
          <li><span data-en>National ID (original + copy)</span><span data-ku class="ku">ناسنامەی نەتەوەیی (ئەسڵ + کۆپی)</span></li>
          <li><span data-en>Medical fitness certificate</span><span data-ku class="ku">بەڵگەنامەی تەندروستی</span></li>
          <li><span data-en>2 passport-sized photos</span><span data-ku class="ku">٢ وێنەی پاسپۆرتی</span></li>
          <li><span data-en>Theory test pass certificate</span><span data-ku class="ku">بەڵگەی دەرچوون لە تاقیکردنەوەی تیۆری</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>7 – 14 days</span><span data-ku class="ku">٧ – ١٤ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc = \App\Models\Service::where('slug','driving-license')->where('is_active',true)->first(); @endphp
          @if($svc)
            <a href="{{ url('/services/driving-license') }}" class="mn-svc-apply" aria-label="Apply for Driving Licence">
              <span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span>
            </a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <!-- Vehicle Registration -->
      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-vr-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 17H3v-5l2-5h14l2 5v5h-2m-2 0H7m10 0a2 2 0 11-4 0m-4 0a2 2 0 11-4 0"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-vr-title"><span data-en>Vehicle Registration</span><span data-ku class="ku" style="display:none">تۆمارکردنی ئۆتۆمبێل</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">تۆمارکردنی ئۆتۆمبێل</span><span data-ku class="ku">Vehicle Registration</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required documents for vehicle registration">
          <li><span data-en>Ownership document (original)</span><span data-ku class="ku">بەڵگەنامەی خاوەندارایەتی (ئەسڵ)</span></li>
          <li><span data-en>Customs clearance certificate</span><span data-ku class="ku">بەڵگەنامەی گومرگی</span></li>
          <li><span data-en>Valid insurance policy</span><span data-ku class="ku">پۆڵیسی بیمەی مەعتەبەر</span></li>
          <li><span data-en>National ID of owner</span><span data-ku class="ku">ناسنامەی نەتەوەیی خاوەن</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>5 – 10 days</span><span data-ku class="ku">٥ – ١٠ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc2 = \App\Models\Service::where('slug','vehicle-registration')->where('is_active',true)->first(); @endphp
          @if($svc2)
            <a href="{{ url('/services/vehicle-registration') }}" class="mn-svc-apply" aria-label="Apply for Vehicle Registration">
              <span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span>
            </a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <!-- Traffic Fine Payment -->
      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-fine-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path stroke-linecap="round" d="M2 10h20"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-fine-title"><span data-en>Traffic Fine Payment</span><span data-ku class="ku" style="display:none">پارەدانی جریمەی ترافیک</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">پارەدانی جریمەی ترافیک</span><span data-ku class="ku">Traffic Fine Payment</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required for traffic fine payment">
          <li><span data-en>Vehicle plate number</span><span data-ku class="ku">ژمارەی پلەیتی ئۆتۆمبێل</span></li>
          <li><span data-en>National ID of owner</span><span data-ku class="ku">ناسنامەی نەتەوەیی خاوەن</span></li>
          <li><span data-en>Fine reference number (if known)</span><span data-ku class="ku">ژمارەی چاوپێکەوتنی جریمە (ئەگەر دیارە)</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>Same day</span><span data-ku class="ku">ئەو ڕۆژەی خۆی</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc3 = \App\Models\Service::where('slug','traffic-fine-payment')->where('is_active',true)->first(); @endphp
          @if($svc3)
            <a href="{{ url('/services/traffic-fine-payment') }}" class="mn-svc-apply" aria-label="Apply for Traffic Fine Payment">
              <span data-en>Apply →</span><span data-ku class="ku">داوا بکە ←</span>
            </a>
          @else
            <span class="mn-svc-soon"><span data-en>Launching soon</span><span data-ku class="ku">بەزووی دەکرێتەوە</span></span>
          @endif
        </div>
      </article>

      <!-- Road Permit -->
      <article class="mn-svc-card" role="listitem" aria-labelledby="svc-rp-title">
        <div class="mn-svc-head">
          <div class="mn-svc-icon-wrap" aria-hidden="true"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
          <div class="mn-svc-names">
            <h3 class="mn-svc-en" id="svc-rp-title"><span data-en>Special Road Permit</span><span data-ku class="ku" style="display:none">مۆڵەتی ڕێگای تایبەت</span></h3>
            <p class="mn-svc-ku"><span data-en aria-hidden="true">مۆڵەتی ڕێگای تایبەت</span><span data-ku class="ku">Special Road Permit</span></p>
          </div>
        </div>
        <ul class="mn-svc-docs" aria-label="Required for special road permit">
          <li><span data-en>Vehicle registration certificate</span><span data-ku class="ku">بەڵگەنامەی تۆمارکردنی ئۆتۆمبێل</span></li>
          <li><span data-en>Driver's valid licence</span><span data-ku class="ku">مۆڵەتی شۆفێری مەعتەبەر</span></li>
          <li><span data-en>Route plan / cargo manifest</span><span data-ku class="ku">پلانی ڕێگا / لیستی بار</span></li>
          <li><span data-en>Company authorisation letter</span><span data-ku class="ku">نامەی مۆڵەتی کۆمپانیا</span></li>
        </ul>
        <div class="mn-svc-footer">
          <div class="mn-svc-badges">
            <span class="mn-svc-badge mn-badge-days"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span data-en>3 – 7 days</span><span data-ku class="ku">٣ – ٧ ڕۆژ</span></span>
            <span class="mn-svc-badge mn-badge-free"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="vertical-align:-.05em" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg><span data-en>Free</span><span data-ku class="ku">بەخۆڕایی</span></span>
          </div>
          @php $svc4 = \App\Models\Service::where('slug','road-permit')->where('is_active',true)->first(); @endphp
          @if($svc4)
            <a href="{{ url('/services/road-permit') }}" class="mn-svc-apply" aria-label="Apply for Special Road Permit">
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

<!-- ═══════════════════════════════════════════════════════════
     TRACK
═══════════════════════════════════════════════════════════ -->
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
      <label for="track-code" class="sr-only">
        <span data-en>Application reference code</span>
        <span data-ku class="ku">کۆدی چاوپێکەوتنی داواکاری</span>
      </label>
      <input
        type="text" id="track-code"
        class="mn-track-input"
        placeholder="e.g. HLZ-2026-XXXXX"
        aria-label="Application reference code"
        autocomplete="off"
        pattern="[A-Za-z0-9\-]+"
        maxlength="24"
      />
      <button type="submit" class="mn-track-submit">
        <span data-en>Track</span><span data-ku class="ku">شوێنکەوتن</span>
      </button>
    </form>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     CONTACT
═══════════════════════════════════════════════════════════ -->
<section class="mn-section" id="contact" aria-labelledby="contact-title">
  <div class="mn-section-inner">
    <p class="mn-section-label"><span data-en>Contact</span><span data-ku class="ku">پەیوەندی</span></p>
    <h2 id="contact-title">
      <span data-en class="mn-section-title">Find us</span>
      <span data-ku class="mn-section-title-ku">بماندۆزەوە</span>
    </h2>
    <div class="mn-offices-grid" role="list" aria-label="Traffic Police offices across Kurdistan">

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
            <p class="mn-office-val"><span data-en>100 Meter Road, Erbil</span><span data-ku class="ku">ڕێگای ١٠٠ مەتری، هەولێر</span></p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Phone</span><span data-ku class="ku">تەلەفۆن</span></p>
            <p class="mn-office-val" dir="ltr">+964 66 222 5678</p>
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
            <p class="mn-office-val"><span data-en>Mawlawi Street, Sulaymaniyah</span><span data-ku class="ku">شەقامی مەولەوی، سلێمانی</span></p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Phone</span><span data-ku class="ku">تەلەفۆن</span></p>
            <p class="mn-office-val" dir="ltr">+964 53 311 6789</p>
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
            <p class="mn-office-val"><span data-en>Zakho Road, Duhok</span><span data-ku class="ku">ڕێگای زاخۆ، دهۆک</span></p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Phone</span><span data-ku class="ku">تەلەفۆن</span></p>
            <p class="mn-office-val" dir="ltr">+964 62 722 4567</p>
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
            <p class="mn-office-val"><span data-en>Freedom Square, Halabja</span><span data-ku class="ku">مەیدانی ئازادی، هەڵەبجە</span></p>
          </div>
        </div>
        <div class="mn-office-row">
          <div class="mn-office-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
          <div>
            <p class="mn-office-lbl"><span data-en>Phone</span><span data-ku class="ku">تەلەفۆن</span></p>
            <p class="mn-office-val" dir="ltr">+964 53 325 8901</p>
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
      <span data-en>All offices are open Sunday to Thursday, 8:00 AM – 3:00 PM. Online pre-registration is available for all services to reduce in-person wait times.</span>
      <span data-ku class="ku">هەموو ئۆفیسەکان لە یەکشەممە تا پێنجشەممە، لە کاتژمێر ٨:٠٠ بەیانی تا ٣:٠٠ دواتر کاردەکەن. تۆمارکردنی پێشووی ئۆنلاین بۆ هەموو خزمەتگوزارییەکان بەردەستە.</span>
    </p>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════════ -->
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
      <span><span data-en>Traffic Police Directorate — Kurdistan Region</span><span data-ku class="ku">بەرێوەبەرایەتی پۆلیسی ترافیک — هەرێمی کوردستان</span></span>
    </div>
  </div>
</footer>

<!-- sr-only helper -->
<style>.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}</style>

<script>
(function(){
  // ── Theme ────────────────────────────────────────────
  const html = document.getElementById('html-root');
  const themeBtn = document.getElementById('theme-btn');
  function applyTheme(dark){
    html.classList.toggle('dark', dark);
  }
  const saved = localStorage.getItem('halzanin-theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  applyTheme(saved ? saved === 'dark' : prefersDark);
  window.toggleDark = function(){
    const isDark = html.classList.toggle('dark');
    localStorage.setItem('halzanin-theme', isDark ? 'dark' : 'light');
  };

  // ── Language ─────────────────────────────────────────
  const langKuBtn = document.getElementById('lang-ku-btn');
  const langEnBtn = document.getElementById('lang-en-btn');
  window.setLang = function(lang){
    document.body.classList.toggle('lang-ku', lang === 'ku');
    html.setAttribute('lang', lang === 'ku' ? 'ckb' : 'en');
    html.setAttribute('dir', lang === 'ku' ? 'rtl' : 'ltr');
    localStorage.setItem('halzanin-lang', lang);
    if(langKuBtn) langKuBtn.classList.toggle('active', lang === 'ku');
    if(langEnBtn) langEnBtn.classList.toggle('active', lang === 'en');
  };
  const savedLang = localStorage.getItem('halzanin-lang') || 'en';
  setLang(savedLang);

  // ── Track ────────────────────────────────────────────
  window.handleTrack = function(e){
    e.preventDefault();
    const code = document.getElementById('track-code').value.trim();
    if(code) window.location.href = '{{ url("/track") }}/' + encodeURIComponent(code);
  };
})();
</script>
</body>
</html>
