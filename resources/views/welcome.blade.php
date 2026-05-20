<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halzanin | Passport Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Noto+Naskh+Arabic:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:    #F7F4EF;
            --text:  #1A1A1A;
            --muted: #6B7280;
            --brand: #C8860A;
            --brand-dark: #A06B07;
            --white: #ffffff;
            --line:  #E5E0D8;
            --card:  #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: "Outfit", sans-serif;
        }

        .container {
            width: min(1160px, calc(100% - 48px));
            margin: 0 auto;
        }

        /* ── Navbar ── */
        .topbar {
            position: sticky; top: 0; z-index: 40;
            background: rgba(247, 244, 239, 0.96);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--line);
        }

        .nav {
            min-height: 72px;
            display: flex; align-items: center; justify-content: space-between; gap: 24px;
        }

        .brand {
            display: inline-flex; align-items: center; gap: 12px;
            text-decoration: none; color: var(--text);
        }

.brand-text { font-family: "Outfit", sans-serif; line-height: 1.1; }
        .brand-text strong { display: block; font-size: 20px; font-weight: 800; letter-spacing: -0.01em; }
        .brand-text span { display: block; font-size: 11px; color: var(--muted); font-weight: 600; }

        .menu { display: flex; gap: 28px; align-items: center; font-size: 14px; font-weight: 700; }
        .menu a { color: #4B5563; text-decoration: none; transition: color .15s; }
        .menu a:hover { color: var(--brand); }

        .actions { display: flex; gap: 10px; align-items: center; }

        .btn {
            border: 0; border-radius: 999px;
            padding: 10px 20px;
            font-family: "Outfit", sans-serif; font-size: 14px; font-weight: 700;
            text-decoration: none; display: inline-flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all .15s ease;
        }

        .btn-outline {
            background: var(--white); border: 1.5px solid var(--line);
            color: var(--text);
        }
        .btn-outline:hover { border-color: var(--brand); color: var(--brand); }

        .btn-primary {
            background: var(--brand); color: #fff;
            box-shadow: 0 6px 18px rgba(200, 134, 10, 0.35);
        }
        .btn-primary:hover { background: var(--brand-dark); }

        /* ── Hero ── */
        .hero-wrap { padding: 52px 0 36px; }

        .hero {
            position: relative;
            padding: 72px 64px 64px;
            border-radius: 28px;
            background: var(--white);
            border: 1px solid var(--line);
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
        }

        /* Subtle dot pattern */
        .hero::before {
            content: "";
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(200,134,10,0.7) 1px, transparent 1px);
            background-size: 28px 28px;
            opacity: 0.07;
            pointer-events: none;
        }

        /* Amber glow top-right */
        .hero-glow {
            position: absolute; top: -80px; right: -80px;
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(200,134,10,0.18) 0%, transparent 65%);
            border-radius: 50%; pointer-events: none;
        }

        .hero-kicker {
            position: relative; z-index: 2;
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(200,134,10,0.1); border: 1px solid rgba(200,134,10,0.25);
            border-radius: 999px; padding: 6px 14px;
            font-size: 12px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase;
            color: var(--brand-dark); margin-bottom: 20px;
        }
        .hero-kicker-dot {
            width: 6px; height: 6px; border-radius: 50%; background: var(--brand);
            animation: kicker-pulse 2s ease-in-out infinite;
        }
        @keyframes kicker-pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

        .hero h1 {
            position: relative; z-index: 2; margin: 0;
            font-size: clamp(38px, 5.5vw, 64px);
            font-weight: 800; line-height: 1.05; letter-spacing: -0.025em;
            color: var(--text); max-width: 15ch;
        }
        .hero h1 .accent { color: var(--brand); }

        .hero-p {
            position: relative; z-index: 2;
            margin: 22px 0 0; font-size: 18px; line-height: 1.75;
            color: var(--muted); max-width: 54ch;
        }

        .hero-cta {
            position: relative; z-index: 2;
            margin-top: 32px; display: flex; flex-wrap: wrap; gap: 12px;
        }

        .stats {
            position: relative; z-index: 2;
            margin-top: 44px;
            display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px; max-width: 600px;
        }

        .stat {
            background: var(--bg); border: 1px solid var(--line);
            border-radius: 14px; padding: 16px 18px;
        }
        .stat strong {
            display: block; font-size: 22px; font-weight: 800;
            color: var(--brand); font-family: "Outfit", sans-serif; margin-bottom: 4px;
        }
        .stat span { font-size: 12px; color: var(--muted); font-weight: 600; }

        /* ── Sections ── */
        .section { padding: 60px 0; }

        .section-head { margin-bottom: 40px; }

        .section h2 {
            margin: 0 0 10px;
            font-size: clamp(26px, 3vw, 40px);
            font-weight: 800; letter-spacing: -0.025em;
            color: var(--text);
        }
        .section-head p {
            margin: 0; color: var(--muted); max-width: 64ch;
            line-height: 1.75; font-size: 16px;
        }

        /* ── Service cards ── */
        .service-grid {
            display: grid; gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .card {
            background: var(--card); border: 1px solid var(--line);
            border-radius: 20px; padding: 28px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: box-shadow .2s ease, transform .2s ease;
        }
        .card:hover {
            box-shadow: 0 10px 30px rgba(200,134,10,0.13);
            transform: translateY(-3px);
        }

        .card-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(200,134,10,0.1);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }
        .card-icon svg { width: 22px; height: 22px; stroke: var(--brand); }

        .card .tag {
            display: inline-block;
            background: rgba(200,134,10,0.1); color: var(--brand-dark);
            border-radius: 999px; padding: 3px 10px;
            font-size: 11px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase;
            margin-bottom: 12px;
        }
        .card h3 {
            margin: 0 0 10px; font-size: 19px; font-weight: 700; letter-spacing: -0.01em;
            color: var(--text);
        }
        .card p { margin: 0; color: var(--muted); line-height: 1.75; font-size: 14px; }

        /* ── How It Works — numbered timeline ── */
        .timeline { display: flex; flex-direction: column; gap: 0; }

        .timeline-item {
            display: flex; gap: 28px; position: relative; padding-bottom: 36px;
        }
        .timeline-item:last-child { padding-bottom: 0; }

        .timeline-left {
            display: flex; flex-direction: column; align-items: center;
            flex-shrink: 0; width: 52px;
        }

        .timeline-num {
            width: 52px; height: 52px; border-radius: 50%;
            background: var(--brand); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 800;
            box-shadow: 0 4px 14px rgba(200,134,10,0.35);
            flex-shrink: 0; position: relative; z-index: 1;
        }

        .timeline-line {
            width: 2px; flex: 1; min-height: 24px; margin-top: 6px;
            background: linear-gradient(to bottom, rgba(200,134,10,0.5), rgba(200,134,10,0.08));
        }
        .timeline-item:last-child .timeline-line { display: none; }

        .timeline-content { flex: 1; padding-top: 12px; }
        .timeline-content h3 {
            margin: 0 0 6px; font-size: 19px; font-weight: 700; letter-spacing: -0.01em;
            color: var(--text);
        }
        .timeline-content p { margin: 0; color: var(--muted); line-height: 1.75; font-size: 15px; }

        /* ── Updates ── */
        .news-grid { display: grid; gap: 16px; grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .news { background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--line); }

        .news-media {
            height: 140px;
            background: linear-gradient(145deg, rgba(200,134,10,0.12), rgba(200,134,10,0.04));
            display: flex; align-items: center; justify-content: center;
        }
        .news-media-icon {
            width: 52px; height: 52px; border-radius: 14px;
            background: rgba(200,134,10,0.12);
            display: flex; align-items: center; justify-content: center;
        }
        .news-media-icon svg { width: 26px; height: 26px; stroke: var(--brand); }

        .news-body { padding: 18px 20px 22px; }
        .news h4 { margin: 0 0 8px; font-size: 17px; font-weight: 700; color: var(--text); }
        .news p { margin: 0; color: var(--muted); line-height: 1.65; font-size: 13px; }

        /* ── Footer ── */
        footer { border-top: 1px solid var(--line); padding: 28px 0 44px; }
        .foot { display: flex; justify-content: space-between; gap: 18px; flex-wrap: wrap; }
        .foot span { font-size: 13px; color: #9CA3AF; }

        /* ── Responsive ── */
        @media (max-width: 1050px) {
            .menu { display: none; }
            .service-grid, .news-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 760px) {
            .container { width: min(1160px, calc(100% - 28px)); }
            .nav { min-height: 68px; }
            .actions { display: none; }
            .hero { padding: 40px 24px 36px; }
            .hero h1 { font-size: 34px; }
            .stats { grid-template-columns: 1fr 1fr; max-width: none; }
            .service-grid, .news-grid { grid-template-columns: 1fr; }
            .timeline-item { gap: 18px; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container nav">
            <a href="{{ url('/') }}" class="brand">
                <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn" style="height:36px;width:auto;">
                <span class="brand-text">
                    <strong>Halzanin</strong>
                    <span data-i18n="Kurdistan Passport Directorate">Kurdistan Passport Directorate</span>
                </span>
            </a>

            <nav class="menu">
                <a href="#services" data-i18n="Services">Services</a>
                <a href="#process" data-i18n="Process">Process</a>
                <a href="#updates" data-i18n="Updates">Updates</a>
            </nav>

            <div class="actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline" data-i18n="Dashboard">Dashboard</a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-outline" data-i18n="Log In">Log In</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary" data-i18n="Create Account">Create Account</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <section class="hero-wrap">
            <div class="container">
                <div class="hero">
                    <div class="hero-glow"></div>
                    <div class="hero-kicker">
                        <span class="hero-kicker-dot"></span>
                        <span data-i18n="Public Service Portal">Public Service Portal</span>
                    </div>
                    <h1>
                        <span data-i18n="Digital Passport Services for the Kurdistan Region">Digital Passport<br><span class="accent">Services</span> for the<br>Kurdistan Region</span>
                    </h1>
                    <p class="hero-p" data-i18n="Submit applications, upload required documents, and track your request status in one place. Designed to reduce waiting time and make government service access clear, secure, and fast.">
                        Submit applications, upload required documents, and track your request status in one place.
                        Designed to reduce waiting time and make government service access clear, secure, and fast.
                    </p>
                    <div class="hero-cta">
                        @auth
                            <a class="btn btn-primary" href="{{ url('/dashboard') }}" data-i18n="Go To Dashboard">Go To Dashboard</a>
                        @else
                            @if (Route::has('login'))
                                <a class="btn btn-primary" href="{{ route('login') }}" data-i18n="Start Application">Start Application</a>
                            @endif
                            @if (Route::has('register'))
                                <a class="btn btn-outline" href="{{ route('register') }}" data-i18n="Register Account">Register Account</a>
                            @endif
                        @endauth
                        @if (Route::has('track'))
                            <a class="btn btn-outline" href="{{ route('track') }}" data-i18n="Track Application">Track Application</a>
                        @endif
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <strong>24/7</strong>
                            <span data-i18n="Tracking Access">Tracking Access</span>
                        </div>
                        <div class="stat">
                            <strong>1 Portal</strong>
                            <span data-i18n="For Citizens And Staff">For Citizens And Staff</span>
                        </div>
                        <div class="stat">
                            <strong data-i18n="Fast">Fast</strong>
                            <span data-i18n="Digital Document Review">Digital Document Review</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services -->
        <section class="section" id="services">
            <div class="container">
                <div class="section-head">
                    <h2 data-i18n="Main Services">Main Services</h2>
                    <p data-i18n="Halzanin is built around practical citizen workflows. From scheduling appointments to document upload and status tracking, each step is structured for clarity.">
                        Halzanin is built around practical citizen workflows. From scheduling appointments to document upload
                        and status tracking, each step is structured for clarity.
                    </p>
                </div>
                <div class="service-grid">
                    <article class="card">
                        <div class="card-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="tag" data-i18n="Appointments">Appointments</span>
                        <h3 data-i18n="Book With Calendar Slots">Book With Calendar Slots</h3>
                        <p data-i18n="Choose available dates and times, submit requests, and manage appointments through your citizen dashboard.">Choose available dates and times, submit requests, and manage appointments through your citizen dashboard.</p>
                    </article>
                    <article class="card">
                        <div class="card-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="tag" data-i18n="Tracking">Tracking</span>
                        <h3 data-i18n="Follow Progress By Code">Follow Progress By Code</h3>
                        <p data-i18n="Use your tracking code to check each status update from submission through review and final decision.">Use your tracking code to check each status update from submission through review and final decision.</p>
                    </article>
                    <article class="card">
                        <div class="card-icon">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <span class="tag" data-i18n="Document Vault">Document Vault</span>
                        <h3 data-i18n="Secure Upload And Storage">Secure Upload And Storage</h3>
                        <p data-i18n="Store required files in your vault and reuse them in supported application workflows.">Store required files in your vault and reuse them in supported application workflows.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- How It Works — numbered timeline -->
        <section class="section" id="process" style="background: var(--white); border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);">
            <div class="container">
                <div class="section-head">
                    <h2 data-i18n="How It Works">How It Works</h2>
                    <p data-i18n="Three simple steps to complete your passport application digitally.">
                        Three simple steps to complete your passport application digitally.
                    </p>
                </div>
                <div class="timeline" style="max-width: 680px;">
                    <div class="timeline-item">
                        <div class="timeline-left">
                            <div class="timeline-num">1</div>
                            <div class="timeline-line"></div>
                        </div>
                        <div class="timeline-content">
                            <h3 data-i18n="Create Your Account">Create Your Account</h3>
                            <p data-i18n="Register once, then access your dashboard to begin passport-related submissions and updates.">Register once, then access your dashboard to begin passport-related submissions and updates.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-left">
                            <div class="timeline-num">2</div>
                            <div class="timeline-line"></div>
                        </div>
                        <div class="timeline-content">
                            <h3 data-i18n="Submit Application">Submit Application</h3>
                            <p data-i18n="Complete appointment details, attach required documents, and confirm your request.">Complete appointment details, attach required documents, and confirm your request.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-left">
                            <div class="timeline-num">3</div>
                            <div class="timeline-line"></div>
                        </div>
                        <div class="timeline-content">
                            <h3 data-i18n="Track And Receive Updates">Track And Receive Updates</h3>
                            <p data-i18n="Monitor application status changes from staff review through final processing outcomes.">Monitor application status changes from staff review through final processing outcomes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Updates -->
        <section class="section" id="updates">
            <div class="container">
                <div class="section-head">
                    <h2 data-i18n="Latest Updates">Latest Updates</h2>
                </div>
                <div class="news-grid">
                    <article class="news">
                        <div class="news-media">
                            <div class="news-media-icon">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <div class="news-body">
                            <h4 data-i18n="Service Availability">Service Availability</h4>
                            <p data-i18n="Citizen portal is available daily for account access, application tracking, and profile updates.">Citizen portal is available daily for account access, application tracking, and profile updates.</p>
                        </div>
                    </article>
                    <article class="news">
                        <div class="news-media">
                            <div class="news-media-icon">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                        </div>
                        <div class="news-body">
                            <h4 data-i18n="Staff Review Queue">Staff Review Queue</h4>
                            <p data-i18n="Applications are reviewed according to queue status and required documents submitted by citizens.">Applications are reviewed according to queue status and required documents submitted by citizens.</p>
                        </div>
                    </article>
                    <article class="news">
                        <div class="news-media">
                            <div class="news-media-icon">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                            </div>
                        </div>
                        <div class="news-body">
                            <h4 data-i18n="Digital Workflow">Digital Workflow</h4>
                            <p data-i18n="Ongoing improvements continue to reduce manual handling and speed up passport-related processing.">Ongoing improvements continue to reduce manual handling and speed up passport-related processing.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container foot">
            <span data-i18n="Halzanin | Kurdistan Passport Directorate">Halzanin | Kurdistan Passport Directorate</span>
            <span data-i18n="Built for transparent and efficient public service delivery">Built for transparent and efficient public service delivery</span>
        </div>
    </footer>

    <script src="/js/translations.js"></script>
    <script>
        if (localStorage.lang === 'ku') {
            document.documentElement.dir = 'rtl';
            document.documentElement.lang = 'ku';
            document.body.style.fontFamily = '"Noto Naskh Arabic", serif';
        }
    </script>
</body>
</html>
