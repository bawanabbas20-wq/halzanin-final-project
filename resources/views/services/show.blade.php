<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $service->name }} — Halzanîn</title>
    <link rel="icon" type="image/png" href="{{ asset('images/halzanin-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Noto+Naskh+Arabic:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        (function() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
            if (localStorage.lang === 'ku') { document.documentElement.dir = 'rtl'; document.documentElement.lang = 'ku'; }
        })();
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --bg: #EFEDE8; --card: #ffffff; --text: #111111; --muted: #6B6860; --brand: #1B4F8A; --brand-dark: #163F6E; --line: #DDD9D0; --card-shadow: 0 2px 16px rgba(0,0,0,0.05); }
        html.dark { --bg: #141414; --card: #1F1F1F; --text: #F0EEE9; --muted: #9E9B94; --brand: #4A82C4; --brand-dark: #3A6BA8; --line: #2E2E2E; --card-shadow: 0 2px 16px rgba(0,0,0,0.3); }
        html { scroll-behavior: smooth; }
        body { background: var(--bg); color: var(--text); font-family: "Outfit", sans-serif; line-height: 1.6; }
        html[dir="rtl"] body { font-family: "Noto Naskh Arabic", serif; }
        .s-wrap { width: min(900px, calc(100% - 40px)); margin: 0 auto; padding: 40px 0 80px; }
        .s-back { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: var(--muted); font-size: 13px; font-weight: 600; margin-bottom: 28px; transition: color .15s; }
        .s-back:hover { color: var(--brand); }
        .s-back svg { width: 16px; height: 16px; }
        .s-header { background: var(--card); border: 1px solid var(--line); border-radius: 20px; padding: 36px 40px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 24px; box-shadow: var(--card-shadow); border-top: 4px solid {{ $service->ministry->color }}; }
        .s-icon { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: {{ $service->ministry->color }}18; }
        .s-icon svg { width: 28px; height: 28px; stroke: {{ $service->ministry->color }}; }
        .s-meta { flex: 1; min-width: 0; }
        .s-ministry { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: var(--muted); margin-bottom: 6px; }
        .s-name { font-size: clamp(22px, 3vw, 32px); font-weight: 800; letter-spacing: -0.02em; color: var(--text); margin-bottom: 6px; line-height: 1.15; }
        .s-name-ku { font-size: 18px; color: var(--muted); font-family: "Noto Naskh Arabic", serif; margin-bottom: 12px; }
        .s-badges { display: flex; flex-wrap: wrap; gap: 8px; }
        .s-badge { display: inline-flex; align-items: center; gap: 5px; border-radius: 999px; padding: 5px 12px; font-size: 12px; font-weight: 700; }
        .s-badge-active { background: rgba(5,150,105,0.1); color: #059669; border: 1px solid rgba(5,150,105,0.25); }
        .s-badge-soon   { background: rgba(107,104,96,0.08); color: var(--muted); border: 1px solid var(--line); }
        .s-badge-days   { background: rgba(27,79,138,0.08); color: var(--brand); border: 1px solid rgba(27,79,138,0.18); }
        .s-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }
        .s-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 28px 28px 24px; box-shadow: var(--card-shadow); }
        .s-card h3 { font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: .04em; color: var(--muted); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .s-card h3 svg { width: 16px; height: 16px; color: var(--brand); flex-shrink: 0; }
        .s-doc-list, .s-status-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .s-doc-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; color: var(--text); line-height: 1.5; }
        .s-doc-list li::before { content: ""; width: 18px; height: 18px; border-radius: 50%; background: rgba(27,79,138,0.1); border: 1px solid rgba(27,79,138,0.2); flex-shrink: 0; margin-top: 2px; }
        .s-status-list li { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; color: var(--muted); }
        .s-status-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--line); flex-shrink: 0; border: 2px solid var(--line); }
        .s-status-list li:first-child .s-status-dot { background: var(--brand); border-color: var(--brand); }
        .s-status-list li:last-child .s-status-dot { background: #059669; border-color: #059669; }
        .s-status-label { text-transform: capitalize; }
        .s-desc { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 28px; margin-bottom: 20px; font-size: 15px; color: var(--muted); line-height: 1.8; box-shadow: var(--card-shadow); }
        .s-cta { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
        .s-btn { display: inline-flex; align-items: center; gap: 8px; border-radius: 999px; padding: 13px 28px; font-family: "Outfit", sans-serif; font-size: 15px; font-weight: 700; text-decoration: none; cursor: pointer; transition: all .2s; border: none; white-space: nowrap; }
        .s-btn-primary { background: #1B4F8A; color: #fff; box-shadow: 0 6px 18px rgba(27,79,138,0.3); }
        html.dark .s-btn-primary { background: #4A82C4; }
        .s-btn-primary:hover { background: #163F6E; transform: translateY(-1px); }
        .s-btn-outline { background: var(--card); border: 1.5px solid var(--line); color: var(--text); }
        .s-btn-outline:hover { border-color: var(--brand); color: var(--brand); }
        .s-btn-disabled { background: var(--line); color: var(--muted); cursor: not-allowed; }
        .s-login-note { font-size: 13px; color: var(--muted); }
        @media (max-width: 680px) {
            .s-header { flex-direction: column; padding: 24px 20px; }
            .s-grid { grid-template-columns: 1fr; }
            .s-card, .s-desc { padding: 20px; }
            .s-wrap { padding: 24px 0 60px; }
        }
    </style>
</head>
<body>

{{-- Back nav --}}
<div class="s-wrap">
    <a href="{{ url('/') }}#ministries" class="s-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Back to Portal
    </a>

    {{-- Header card --}}
    <div class="s-header">
        <div class="s-icon">
            @if($service->ministry->slug === 'civil-registry')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c0 1.657 1.343 3 3 3s3-1.343 3-3"/></svg>
            @elseif($service->ministry->slug === 'traffic-police')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            @elseif($service->ministry->slug === 'electricity')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            @elseif($service->ministry->slug === 'water')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10c0-5.5-10-10-10-10z"/></svg>
            @else
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
            @endif
        </div>
        <div class="s-meta">
            <div class="s-ministry">{{ $service->ministry->name }} &mdash; {{ $service->ministry->name_ku }}</div>
            <div class="s-name">{{ $service->name }}</div>
            <div class="s-name-ku">{{ $service->name_ku }}</div>
            <div class="s-badges">
                @if($service->is_active)
                    <span class="s-badge s-badge-active">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Now Available
                    </span>
                @else
                    <span class="s-badge s-badge-soon">Coming Soon</span>
                @endif
                <span class="s-badge s-badge-days">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                    Est. {{ $service->estimated_days }} days
                </span>
                <span class="s-badge" style="background:rgba(107,104,96,0.07);color:var(--muted);border:1px solid var(--line);">Free</span>
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($service->description)
        <div class="s-desc">{{ $service->description }}</div>
    @endif

    {{-- Docs + Workflow grid --}}
    <div class="s-grid">

        {{-- Required documents --}}
        <div class="s-card">
            <h3>
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Documents Required
            </h3>
            @if(!empty($service->required_documents))
                <ul class="s-doc-list">
                    @foreach($service->required_documents as $doc)
                        <li>{{ $doc }}</li>
                    @endforeach
                </ul>
            @else
                <p style="font-size:13px;color:var(--muted);">Document list will be available when this service launches.</p>
            @endif
        </div>

        {{-- Status workflow --}}
        <div class="s-card">
            <h3>
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Application Workflow
            </h3>
            @if(!empty($service->statuses))
                <ul class="s-status-list">
                    @foreach($service->statuses as $status)
                        <li>
                            <span class="s-status-dot"></span>
                            <span class="s-status-label">{{ ucwords(str_replace('_', ' ', $status)) }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- CTA --}}
    <div class="s-cta">
        @if($service->is_active)
            @auth
                @if(auth()->user()->role === 'citizen')
                    <a href="{{ route('services.apply', $service->slug) }}" class="s-btn s-btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Apply Now
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="s-btn s-btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Sign In to Apply
                </a>
                <span class="s-login-note">Free account — takes 2 minutes to register</span>
            @endauth
        @else
            <span class="s-btn s-btn-disabled">Coming Soon</span>
        @endif
        <a href="{{ url('/') }}#track" class="s-btn s-btn-outline">Track an Existing Application</a>
    </div>
</div>

<script src="{{ asset('js/translations.js') }}"></script>
</body>
</html>
