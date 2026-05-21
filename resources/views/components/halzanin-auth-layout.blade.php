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

                .al-passports { position: relative; height: 190px; margin-bottom: 24px; }
                .al-pp { position: absolute; object-fit: contain; border-radius: 7px; box-shadow: 0 10px 36px rgba(0,0,0,0.35); transition: transform 0.4s ease; }
                .al-pp-blue { width: 128px; height: 182px; top: 4px; left: 50%; transform: translateX(-50%); z-index: 3; }
                .al-pp-dark { width: 96px; height: 138px; top: 26px; left: 14px; z-index: 2; transform: rotate(-10deg); opacity: 0.82; }
                .al-pp-red  { width: 96px; height: 138px; top: 26px; right: 14px; z-index: 2; transform: rotate(10deg); opacity: 0.82; }
                .al-passports:hover .al-pp-dark { transform: rotate(-14deg) translateX(-8px); }
                .al-passports:hover .al-pp-red  { transform: rotate(14deg) translateX(8px); }
                .al-passports:hover .al-pp-blue { transform: translateX(-50%) translateY(-5px); }

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
                    <p class="al-region">Kurdistan Region – Iraq</p>
                    <h1 class="al-title">Passport &amp; Civil<br>Affairs Directorate</h1>
                    <div class="al-divider"></div>
                </div>

                <div class="al-features">
                    <div class="al-feat">
                        <div class="al-feat-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="al-feat-title">Secure &amp; Official</strong>
                            <span class="al-feat-sub">Government-grade authentication</span>
                        </div>
                    </div>
                    <div class="al-feat">
                        <div class="al-feat-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="al-feat-title">Digital Applications</strong>
                            <span class="al-feat-sub">Apply for passports online</span>
                        </div>
                    </div>
                    <div class="al-feat">
                        <div class="al-feat-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="al-feat-title">Real-Time Tracking</strong>
                            <span class="al-feat-sub">Monitor application status live</span>
                        </div>
                    </div>
                    <div class="al-feat">
                        <div class="al-feat-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="al-feat-title">Easy Scheduling</strong>
                            <span class="al-feat-sub">Book appointments in minutes</span>
                        </div>
                    </div>
                </div>

                <div class="al-passports">
                    <img src="{{ asset('images/passport-dark.png') }}" class="al-pp al-pp-dark" alt="">
                    <img src="{{ asset('images/passport-blue.png') }}" class="al-pp al-pp-blue" alt="">
                    <img src="{{ asset('images/passport-red.png') }}" class="al-pp al-pp-red"  alt="">
                </div>

                <div class="al-left-footer">© 2025 Halzanîn — Official Portal</div>
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
                        <p class="al-mobile-region">Kurdistan Region – Iraq</p>
                        <h2 class="al-mobile-title">Passport &amp; Civil Affairs<br>Directorate</h2>
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
