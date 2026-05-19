<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halzanin | Passport Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f6f8fc;
            --text: #101828;
            --muted: #475467;
            --navy: #0d2451;
            --navy-2: #12316d;
            --gold: #dfb650;
            --white: #ffffff;
            --line: #dbe2ef;
            --card: #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: radial-gradient(circle at 10% 0%, #e9eef8 0%, #f6f8fc 35%, #f6f8fc 100%);
            color: var(--text);
            font-family: "Manrope", sans-serif;
        }

        .container {
            width: min(1180px, calc(100% - 48px));
            margin: 0 auto;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(6px);
            border-bottom: 1px solid #ecf0f7;
        }

        .nav {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text);
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(145deg, var(--gold), #f1d487);
            color: #302305;
            display: grid;
            place-items: center;
            font-family: "Outfit", sans-serif;
            font-weight: 800;
            font-size: 18px;
            box-shadow: 0 6px 18px rgba(223, 182, 80, 0.35);
        }

        .brand-text {
            font-family: "Outfit", sans-serif;
            line-height: 1.1;
        }

        .brand-text strong {
            display: block;
            font-size: 21px;
            letter-spacing: 0.2px;
        }

        .brand-text span {
            display: block;
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
        }

        .menu {
            display: flex;
            gap: 26px;
            align-items: center;
            font-size: 14px;
            font-weight: 700;
        }

        .menu a {
            color: #344054;
            text-decoration: none;
            transition: color .15s ease;
        }

        .menu a:hover { color: var(--navy-2); }

        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn {
            border: 0;
            border-radius: 999px;
            padding: 11px 18px;
            font-family: "Outfit", sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-outline {
            background: #eef2fb;
            color: var(--navy);
        }

        .btn-primary {
            background: var(--gold);
            color: #1f2937;
            box-shadow: 0 8px 20px rgba(223, 182, 80, 0.35);
        }

        .hero-wrap {
            padding: 36px 0 26px;
        }

        .hero {
            position: relative;
            min-height: 500px;
            border-radius: 24px;
            overflow: hidden;
            background:
                linear-gradient(120deg, rgba(7, 24, 57, 0.88) 0%, rgba(14, 46, 102, 0.66) 55%, rgba(17, 53, 115, 0.45) 100%),
                radial-gradient(circle at 80% 25%, rgba(223, 182, 80, 0.32) 0%, transparent 44%),
                linear-gradient(135deg, #132f64, #0a1f44);
            display: flex;
            align-items: center;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 34px 34px;
            pointer-events: none;
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: min(760px, calc(100% - 48px));
            margin-left: 40px;
            color: var(--white);
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .2px;
            margin-bottom: 16px;
        }

        .hero h1 {
            margin: 0;
            font-family: "Outfit", sans-serif;
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1.06;
            letter-spacing: .2px;
            max-width: 16ch;
        }

        .hero p {
            margin: 20px 0 0;
            font-size: 18px;
            line-height: 1.65;
            color: rgba(255, 255, 255, 0.9);
            max-width: 56ch;
        }

        .hero-cta {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hero-cta .btn-outline {
            background: rgba(255, 255, 255, 0.12);
            color: #f4f7ff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .stats {
            margin-top: 18px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            max-width: 680px;
        }

        .stat {
            background: rgba(255, 255, 255, 0.13);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 14px 16px;
        }

        .stat strong {
            display: block;
            font-family: "Outfit", sans-serif;
            font-size: 24px;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat span {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.88);
            font-weight: 600;
        }

        .section {
            padding: 52px 0;
        }

        .section h2 {
            margin: 0 0 22px;
            font-family: "Outfit", sans-serif;
            font-size: clamp(28px, 3.3vw, 42px);
            line-height: 1.1;
            color: #101828;
        }

        .section-head p {
            margin: 0 0 26px;
            color: #475467;
            max-width: 70ch;
            line-height: 1.7;
        }

        .grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 12px 24px rgba(17, 24, 39, 0.05);
        }

        .card .tag {
            display: inline-block;
            background: #edf2fb;
            color: #1d3f7c;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .card h3 {
            margin: 0 0 10px;
            font-family: "Outfit", sans-serif;
            font-size: 22px;
        }

        .card p {
            margin: 0;
            color: #475467;
            line-height: 1.7;
        }

        .news-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .news {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--line);
        }

        .news-media {
            height: 150px;
            background:
                radial-gradient(circle at 30% 30%, rgba(223, 182, 80, 0.35), transparent 55%),
                linear-gradient(145deg, #0f2f6a, #1c3f88);
            position: relative;
        }

        .news-media::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .news-body {
            padding: 16px 18px 20px;
        }

        .news h4 {
            margin: 0 0 8px;
            font-family: "Outfit", sans-serif;
            font-size: 20px;
        }

        .news p {
            margin: 0;
            color: #475467;
            line-height: 1.6;
        }

        footer {
            border-top: 1px solid #e3e8f2;
            padding: 30px 0 46px;
            color: #667085;
            font-size: 14px;
        }

        .foot {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
        }

        @media (max-width: 1050px) {
            .menu { display: none; }
            .grid, .news-grid { grid-template-columns: 1fr 1fr; }
            .hero-content { margin-left: 24px; }
        }

        @media (max-width: 760px) {
            .container { width: min(1180px, calc(100% - 28px)); }
            .nav { min-height: 70px; }
            .actions { display: none; }
            .hero { min-height: 520px; }
            .hero-content { width: calc(100% - 24px); margin-left: 12px; }
            .hero p { font-size: 16px; }
            .stats { grid-template-columns: 1fr; max-width: none; }
            .grid, .news-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container nav">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark">H</span>
                <span class="brand-text">
                    <strong>Halzanin</strong>
                    <span>Kurdistan Passport Directorate</span>
                </span>
            </a>

            <nav class="menu">
                <a href="#services">Services</a>
                <a href="#process">Process</a>
                <a href="#updates">Updates</a>
            </nav>

            <div class="actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline">Dashboard</a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-outline">Log In</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="hero-wrap">
            <div class="container">
                <div class="hero">
                    <div class="hero-content">
                        <div class="hero-kicker">Public Service Portal</div>
                        <h1>Digital Passport Services for the Kurdistan Region</h1>
                        <p>
                            Submit applications, upload required documents, and track your request status in one place.
                            Designed to reduce waiting time and make government service access clear, secure, and fast.
                        </p>
                        <div class="hero-cta">
                            @auth
                                <a class="btn btn-primary" href="{{ url('/dashboard') }}">Go To Dashboard</a>
                            @else
                                @if (Route::has('login'))
                                    <a class="btn btn-primary" href="{{ route('login') }}">Start Application</a>
                                @endif
                                @if (Route::has('register'))
                                    <a class="btn btn-outline" href="{{ route('register') }}">Register Account</a>
                                @endif
                            @endauth
                            @if (Route::has('track'))
                                <a class="btn btn-outline" href="{{ route('track') }}">Track Application</a>
                            @endif
                        </div>
                        <div class="stats">
                            <div class="stat">
                                <strong>24/7</strong>
                                <span>Tracking Access</span>
                            </div>
                            <div class="stat">
                                <strong>1 Portal</strong>
                                <span>For Citizens And Staff</span>
                            </div>
                            <div class="stat">
                                <strong>Fast</strong>
                                <span>Digital Document Review</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="services">
            <div class="container">
                <div class="section-head">
                    <h2>Main Services</h2>
                    <p>
                        Halzanin is built around practical citizen workflows. From scheduling appointments to document upload
                        and status tracking, each step is structured for clarity.
                    </p>
                </div>
                <div class="grid">
                    <article class="card">
                        <span class="tag">Appointments</span>
                        <h3>Book With Calendar Slots</h3>
                        <p>Choose available dates and times, submit requests, and manage appointments through your citizen dashboard.</p>
                    </article>
                    <article class="card">
                        <span class="tag">Tracking</span>
                        <h3>Follow Progress By Code</h3>
                        <p>Use your tracking code to check each status update from submission through review and final decision.</p>
                    </article>
                    <article class="card">
                        <span class="tag">Document Vault</span>
                        <h3>Secure Upload And Storage</h3>
                        <p>Store required files in your vault and reuse them in supported application workflows.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="process">
            <div class="container">
                <div class="section-head">
                    <h2>How It Works</h2>
                </div>
                <div class="grid">
                    <article class="card">
                        <span class="tag">Step 1</span>
                        <h3>Create Your Account</h3>
                        <p>Register once, then access your dashboard to begin passport-related submissions and updates.</p>
                    </article>
                    <article class="card">
                        <span class="tag">Step 2</span>
                        <h3>Submit Application</h3>
                        <p>Complete appointment details, attach required documents, and confirm your request.</p>
                    </article>
                    <article class="card">
                        <span class="tag">Step 3</span>
                        <h3>Track And Receive Updates</h3>
                        <p>Monitor application status changes from staff review through final processing outcomes.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="updates">
            <div class="container">
                <div class="section-head">
                    <h2>Latest Updates</h2>
                </div>
                <div class="news-grid">
                    <article class="news">
                        <div class="news-media"></div>
                        <div class="news-body">
                            <h4>Service Availability</h4>
                            <p>Citizen portal is available daily for account access, application tracking, and profile updates.</p>
                        </div>
                    </article>
                    <article class="news">
                        <div class="news-media"></div>
                        <div class="news-body">
                            <h4>Staff Review Queue</h4>
                            <p>Applications are reviewed according to queue status and required documents submitted by citizens.</p>
                        </div>
                    </article>
                    <article class="news">
                        <div class="news-media"></div>
                        <div class="news-body">
                            <h4>Digital Workflow</h4>
                            <p>Ongoing improvements continue to reduce manual handling and speed up passport-related processing.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container foot">
            <div>Halzanin | Kurdistan Passport Directorate</div>
            <div>Built for transparent and efficient public service delivery</div>
        </div>
    </footer>
</body>
</html>
