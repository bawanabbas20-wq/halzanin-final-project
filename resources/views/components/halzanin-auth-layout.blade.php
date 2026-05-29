<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-outfit">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Halzanîn') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/halzanin-logo.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            if (localStorage.lang === 'ku') {
                document.documentElement.dir = 'rtl';
                document.documentElement.lang = 'ku';
                document.documentElement.classList.remove('font-outfit');
                document.documentElement.classList.add('font-arabic');
            } else {
                document.documentElement.dir = 'ltr';
                document.documentElement.lang = 'en';
                document.documentElement.classList.add('font-outfit');
                document.documentElement.classList.remove('font-arabic');
            }
        </script>

        <style>
            *, *::before, *::after { box-sizing: border-box; }
            body { margin: 0; }

            /* ══════════════════════════════════════════
               MOBILE FIRST  (< 701px)
            ══════════════════════════════════════════ */
            .al-wrap {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            /* Left branded panel — hidden on mobile */
            .al-left { display: none; }

            /* Top bar: navy branded header on mobile */
            .al-top-bar {
                background: linear-gradient(155deg, #1B4F8A 0%, #163F6E 100%);
                position: relative;
                overflow: hidden;
                padding: 52px 22px 48px;   /* bottom padding leaves room for card overlap */
                display: flex;
                flex-direction: column;
                gap: 0;
            }
            /* Dot texture */
            .al-top-bar::before {
                content: '';
                position: absolute; inset: 0; pointer-events: none;
                background-image: radial-gradient(circle, rgba(255,255,255,0.13) 1px, transparent 1px);
                background-size: 26px 26px;
            }
            /* Glow blob */
            .al-top-bar::after {
                content: '';
                position: absolute; top: -60px; right: -60px;
                width: 200px; height: 200px;
                background: rgba(255,255,255,0.06);
                border-radius: 50%; pointer-events: none;
            }

            /* Branding inside top bar */
            .al-mobile-brand {
                display: flex;
                align-items: center;
                gap: 14px;
                position: relative; z-index: 1;
            }
            .al-mobile-logo {
                height: 42px;
                width: auto;
                flex-shrink: 0;
                filter: brightness(0) invert(1);
            }
            .al-mobile-region {
                font-size: 9.5px;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: rgba(255,255,255,0.55);
                font-weight: 600;
                margin: 0 0 3px;
            }
            .al-mobile-title {
                color: #fff;
                font-size: 14.5px;
                font-weight: 700;
                line-height: 1.3;
                margin: 0;
            }

            /* Toggles — absolutely positioned in the top-right of top bar */
            .al-toggles {
                position: absolute;
                top: 14px;
                right: 14px;
                display: flex;
                align-items: center;
                gap: 6px;
                z-index: 2;
            }
            html[dir="rtl"] .al-toggles { right: auto; left: 14px; }

            /* Theme button — white-on-navy on mobile */
            .al-theme-btn {
                width: 34px; height: 34px;
                border-radius: 50%;
                background: rgba(255,255,255,0.18);
                border: 1.5px solid rgba(255,255,255,0.3);
                cursor: pointer;
                display: flex; align-items: center; justify-content: center;
                color: #fff;
                transition: all 0.2s;
            }
            .al-theme-btn:hover { background: rgba(255,255,255,0.28); }

            /* Language segmented control — white-on-navy on mobile */
            .al-lang-seg {
                display: flex;
                background: rgba(255,255,255,0.15);
                border-radius: 999px;
                padding: 3px;
                gap: 2px;
            }
            .al-lang-opt {
                border: none; cursor: pointer;
                border-radius: 999px;
                padding: 4px 10px;
                font-size: 11px; font-weight: 700;
                background: transparent;
                color: rgba(255,255,255,0.7);
                transition: all 0.2s;
                font-family: inherit;
            }
            .al-lang-opt.al-active {
                background: rgba(255,255,255,0.9);
                color: #1B4F8A;
                box-shadow: 0 1px 6px rgba(0,0,0,0.2);
            }

            /* Right panel — takes full width on mobile */
            .al-right {
                flex: 1;
                display: flex;
                flex-direction: column;
                background: #EFEDE8;
                min-width: 0;
            }
            html.dark .al-right { background: #141414; }

            /* Form area — no flex centering on mobile, just scroll */
            .al-form-area {
                display: block;
                padding: 0;
                flex: 1;
            }

            /* Card — sheet style on mobile: rounded top, full width, overlaps header */
            .al-card {
                background: #fff;
                border-radius: 22px 22px 0 0;
                box-shadow: 0 -6px 24px rgba(0,0,0,0.10);
                border: none;
                padding: 28px 22px 36px;
                margin-top: -22px;      /* slides over the navy header */
                min-height: calc(100vh - 130px); /* fills remaining screen */
                width: 100%;
                animation: al-slide-up 0.36s ease both;
            }
            html.dark .al-card {
                background: #1F1F1F;
                box-shadow: 0 -6px 24px rgba(0,0,0,0.35);
            }

            @keyframes al-slide-up {
                from { opacity: 0; transform: translateY(14px); }
                to   { opacity: 1; transform: translateY(0); }
            }


            /* ══════════════════════════════════════════
               DESKTOP  (≥ 701px)  — override mobile defaults
            ══════════════════════════════════════════ */
            @media (min-width: 701px) {
                /* Switch to side-by-side */
                .al-wrap { flex-direction: row; }

                /* Show left branded panel */
                .al-left {
                    display: flex;
                    flex-direction: column;
                    width: 400px;
                    flex-shrink: 0;
                    background: linear-gradient(160deg, #1B4F8A 0%, #163F6E 100%);
                    padding: 44px 38px 32px;
                    position: relative;
                    overflow: hidden;
                }

                .al-left-dots {
                    position: absolute; inset: 0; pointer-events: none;
                    background-image: radial-gradient(circle, rgba(255,255,255,0.14) 1px, transparent 1px);
                    background-size: 28px 28px;
                }
                .al-left-blob1 {
                    position: absolute; top: -80px; right: -80px;
                    width: 260px; height: 260px;
                    background: rgba(255,255,255,0.05);
                    border-radius: 50%;
                }
                .al-left-blob2 {
                    position: absolute; bottom: -60px; left: -60px;
                    width: 200px; height: 200px;
                    background: rgba(255,255,255,0.04);
                    border-radius: 50%;
                }
                .al-left-inner {
                    position: relative; z-index: 1;
                    display: flex; flex-direction: column; height: 100%;
                }

                .al-logo { height: 50px; margin-bottom: 22px; filter: brightness(0) invert(1); }
                .al-region { font-size: 10.5px; letter-spacing: 0.13em; text-transform: uppercase; color: rgba(255,255,255,0.5); font-weight: 600; margin-bottom: 6px; }
                .al-title  { color: #fff; font-size: 21px; font-weight: 700; line-height: 1.35; margin: 0 0 16px; }
                .al-divider { width: 38px; height: 3px; background: rgba(255,255,255,0.35); border-radius: 2px; margin-bottom: 32px; }

                .al-features { flex: 1; }
                .al-feat { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px; }
                .al-feat-icon {
                    width: 38px; height: 38px; flex-shrink: 0;
                    background: rgba(255,255,255,0.13);
                    border-radius: 10px;
                    display: flex; align-items: center; justify-content: center;
                }
                .al-feat-title { display: block; color: #fff; font-size: 13.5px; font-weight: 600; margin-bottom: 2px; }
                .al-feat-sub   { display: block; color: rgba(255,255,255,0.58); font-size: 11.5px; }

                .al-ministry-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 24px; }
                .al-min-tile {
                    background: rgba(255,255,255,0.09);
                    border: 1px solid rgba(255,255,255,0.13);
                    border-radius: 11px;
                    padding: 12px 6px 10px;
                    display: flex; flex-direction: column; align-items: center; gap: 7px;
                    text-align: center;
                    transition: background 0.2s, border-color 0.2s;
                    cursor: default;
                }
                .al-min-tile:hover { background: rgba(255,255,255,0.16); border-color: rgba(255,255,255,0.25); }
                .al-min-tile svg { width: 20px; height: 20px; stroke: rgba(255,255,255,0.88); flex-shrink: 0; }
                .al-min-name { font-size: 9px; font-weight: 700; color: rgba(255,255,255,0.65); letter-spacing: 0.03em; line-height: 1.35; text-transform: uppercase; }

                .al-left-footer { border-top: 1px solid rgba(255,255,255,0.14); padding-top: 14px; text-align: center; color: rgba(255,255,255,0.38); font-size: 11px; }

                /* Top bar becomes a simple toggles row (no navy background) */
                .al-top-bar {
                    background: transparent;
                    padding: 16px 24px;
                    flex-direction: row;
                    justify-content: flex-end;
                    align-items: center;
                    gap: 8px;
                    overflow: visible;
                }
                html.dark .al-top-bar { background: transparent; }
                .al-top-bar::before, .al-top-bar::after { display: none; }
                html[dir="rtl"] .al-top-bar { justify-content: flex-start; }

                /* Hide the mobile branding text in the top bar on desktop */
                .al-mobile-brand { display: none; }

                /* Toggles: static positioning on desktop */
                .al-toggles {
                    position: static;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }

                /* Theme button — light on desktop (neutral bg) */
                .al-theme-btn {
                    width: 36px; height: 36px;
                    background: rgba(255,255,255,0.85);
                    border: 1.5px solid #DDD9D0;
                    color: #1B4F8A;
                }
                .al-theme-btn:hover { box-shadow: 0 0 0 3px rgba(27,79,138,0.15); background: rgba(255,255,255,0.85); }
                html.dark .al-theme-btn {
                    background: rgba(31,31,31,0.85);
                    border-color: #2E2E2E;
                    color: #4A82C4;
                }

                /* Language toggle — neutral on desktop */
                .al-lang-seg { background: rgba(27,79,138,0.07); }
                html.dark .al-lang-seg { background: rgba(74,130,196,0.09); }
                .al-lang-opt { color: #6B6860; padding: 5px 12px; font-size: 12px; }
                .al-lang-opt.al-active { background: #1B4F8A; color: #fff; box-shadow: 0 2px 8px rgba(27,79,138,0.32); }
                html.dark .al-lang-opt { color: #9E9B94; }
                html.dark .al-lang-opt.al-active { background: #4A82C4; }

                /* Form area — centered on desktop */
                .al-form-area {
                    flex: 1;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 16px 24px 40px;
                }

                /* Card — floating on desktop */
                .al-card {
                    border-radius: 20px;
                    box-shadow: 0 4px 40px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
                    border: 1px solid #DDD9D0;
                    padding: 36px 40px;
                    margin-top: 0;
                    min-height: auto;
                    max-width: 420px;
                    width: 100%;
                }
                html.dark .al-card {
                    background: #1F1F1F;
                    border-color: #2E2E2E;
                    box-shadow: 0 4px 40px rgba(0,0,0,0.35);
                }
            }

            @media (min-width: 701px) and (max-width: 960px) {
                .al-left { width: 330px; padding: 36px 28px 28px; }
            }
        </style>
    </head>
    <body class="antialiased">

    <div class="al-wrap">

        <!-- ── Left branded panel (desktop only) ── -->
        <div class="al-left">
            <div class="al-left-dots"></div>
            <div class="al-left-blob1"></div>
            <div class="al-left-blob2"></div>

            <div class="al-left-inner">
                <div>
                    <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn" class="al-logo">
                    <p class="al-region">حکومەتی هەرێمی کوردستان — Kurdistan Region</p>
                    <h1 class="al-title">Kurdistan Government<br>Services Portal</h1>
                    <div class="al-divider"></div>
                </div>

                <div class="al-features">
                    <div class="al-feat">
                        <div class="al-feat-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 10v11M12 10v11M16 10v11"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="al-feat-title">6 Directorates</strong>
                            <span class="al-feat-sub">One portal for all government services</span>
                        </div>
                    </div>
                    <div class="al-feat">
                        <div class="al-feat-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="al-feat-title">Online Applications</strong>
                            <span class="al-feat-sub">Apply from anywhere, any device</span>
                        </div>
                    </div>
                    <div class="al-feat">
                        <div class="al-feat-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="al-feat-title">Real-Time Tracking</strong>
                            <span class="al-feat-sub">Monitor your application status live</span>
                        </div>
                    </div>
                    <div class="al-feat">
                        <div class="al-feat-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="al-feat-title">Bilingual Support</strong>
                            <span class="al-feat-sub">Kurdish (Sorani) &amp; English</span>
                        </div>
                    </div>
                </div>

                <!-- Ministry grid -->
                <div class="al-ministry-grid">
                    <div class="al-min-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M16 9a4 4 0 01-8 0"/></svg>
                        <span class="al-min-name">Civil Registry</span>
                    </div>
                    <div class="al-min-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M9 17H5a2 2 0 00-2 2"/><path d="M15 17h4a2 2 0 012 2"/><circle cx="12" cy="10" r="4"/><path d="M12 2v2M12 18v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41"/></svg>
                        <span class="al-min-name">Traffic Police</span>
                    </div>
                    <div class="al-min-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        <span class="al-min-name">Electricity</span>
                    </div>
                    <div class="al-min-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3c-4 5-6 8-6 11a6 6 0 0012 0c0-3-2-6-6-11z"/></svg>
                        <span class="al-min-name">Water</span>
                    </div>
                    <div class="al-min-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        <span class="al-min-name">Health</span>
                    </div>
                    <div class="al-min-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                        <span class="al-min-name">Business</span>
                    </div>
                </div>

                <div class="al-left-footer">© {{ date('Y') }} Halzanîn — Kurdistan Government Services Portal</div>
            </div>
        </div>

        <!-- ── Right panel ── -->
        <div class="al-right">

            <!-- Top bar: navy branded header on mobile / plain toggles bar on desktop -->
            <div class="al-top-bar">
                <!-- Mobile branding (hidden on desktop via CSS) -->
                <div class="al-mobile-brand">
                    <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn" class="al-mobile-logo">
                    <div>
                        <p class="al-mobile-region">حکومەتی هەرێمی کوردستان — Kurdistan Region</p>
                        <h2 class="al-mobile-title">Kurdistan Government<br>Services Portal</h2>
                    </div>
                </div>

                <!-- Toggles (always present; styled per breakpoint) -->
                <div class="al-toggles">
                    <button id="theme-toggle" class="al-theme-btn" aria-label="Toggle dark mode">
                        <svg id="al-sun-icon" style="display:none;" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </svg>
                        <svg id="al-moon-icon" style="display:none;" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                        </svg>
                    </button>

                    <div class="al-lang-seg">
                        <button id="lang-en-btn" class="al-lang-opt" onclick="setAuthLang('en')">EN</button>
                        <button id="lang-ku-btn" class="al-lang-opt" style="font-family:'Noto Naskh Arabic',serif;" onclick="setAuthLang('ku')">کوردی</button>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="al-form-area">
                <div class="al-card">
                    {{ $slot }}
                </div>
            </div>
        </div>

    </div>

    <script>
        var alThemeBtn = document.getElementById('theme-toggle');
        var alSunIcon  = document.getElementById('al-sun-icon');
        var alMoonIcon = document.getElementById('al-moon-icon');

        function alUpdateThemeIcon() {
            var isDark = document.documentElement.classList.contains('dark');
            alSunIcon.style.display  = isDark  ? 'block' : 'none';
            alMoonIcon.style.display = !isDark ? 'block' : 'none';
        }
        alUpdateThemeIcon();

        alThemeBtn.addEventListener('click', function() {
            var isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            alUpdateThemeIcon();
        });

        function setAuthLang(lang) {
            var enBtn = document.getElementById('lang-en-btn');
            var kuBtn = document.getElementById('lang-ku-btn');
            if (lang === 'ku') {
                document.documentElement.dir  = 'rtl';
                document.documentElement.lang = 'ku';
                document.documentElement.classList.remove('font-outfit');
                document.documentElement.classList.add('font-arabic');
                localStorage.setItem('lang', 'ku');
                kuBtn.classList.add('al-active');
                enBtn.classList.remove('al-active');
            } else {
                document.documentElement.dir  = 'ltr';
                document.documentElement.lang = 'en';
                document.documentElement.classList.add('font-outfit');
                document.documentElement.classList.remove('font-arabic');
                localStorage.setItem('lang', 'en');
                enBtn.classList.add('al-active');
                kuBtn.classList.remove('al-active');
            }
            if (typeof applyTranslations === 'function') applyTranslations(lang);
        }

        (function() {
            var lang = localStorage.lang || 'en';
            var enBtn = document.getElementById('lang-en-btn');
            var kuBtn = document.getElementById('lang-ku-btn');
            if (lang === 'ku') { kuBtn.classList.add('al-active'); }
            else               { enBtn.classList.add('al-active'); }
        })();
    </script>

    <x-toast />
    @if(session('success'))
    <script>document.addEventListener('DOMContentLoaded',function(){const msg=@json(session('success'));showToast('success',window.i18n?i18n('common.success'):'Success',window.i18nMessage?i18nMessage(msg):msg);});</script>
    @endif
    @if(session('error'))
    <script>document.addEventListener('DOMContentLoaded',function(){const msg=@json(session('error'));showToast('error',window.i18n?i18n('common.error'):'Error',window.i18nMessage?i18nMessage(msg):msg);});</script>
    @endif
    @if(session('info'))
    <script>document.addEventListener('DOMContentLoaded',function(){const msg=@json(session('info'));showToast('info',window.i18n?i18n('common.info'):'Info',window.i18nMessage?i18nMessage(msg):msg);});</script>
    @endif
    @if(session('warning'))
    <script>document.addEventListener('DOMContentLoaded',function(){const msg=@json(session('warning'));showToast('warning',window.i18n?i18n('common.warning'):'Warning',window.i18nMessage?i18nMessage(msg):msg);});</script>
    @endif
    @if($errors->any())
    <script>document.addEventListener('DOMContentLoaded',function(){showToast('error',window.i18n?i18n('common.fix_errors'):'Please fix the errors',window.i18n?i18n('common.check_fields'):'Check the highlighted fields and try again.');});</script>
    @endif
    <script src="{{ asset('js/translations.js') }}"></script>
    </body>
</html>
