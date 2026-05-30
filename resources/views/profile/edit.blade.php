@extends('layouts.halzanin-app')

@section('content')
    <div class="max-w-4xl mx-auto pb-10 space-y-6 lg:space-y-8">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-center sm:items-start sm:justify-between gap-4 animate-fade-in">
            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-5">
                {{-- Avatar --}}
                <div class="relative shrink-0">
                    <div class="w-20 h-20 bg-brand rounded-full flex items-center justify-center text-3xl font-bold text-white uppercase shadow-lg ring-4 ring-white dark:ring-[#1F1F1F]">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-accent rounded-full border-2 border-white dark:border-[#1F1F1F] flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>

                <div class="text-center sm:text-left rtl:sm:text-right">
                    <div class="flex items-center justify-center sm:justify-start gap-3 mb-1">
                        <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="profile.title">My Profile</h2>
                        @php
                            $roleBadge = [
                                'citizen' => 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-300',
                                'staff'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'admin'   => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                            ][auth()->user()->role] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $roleBadge }}" data-i18n="role.{{ auth()->user()->role }}">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400" data-i18n="profile.subtitle">Manage your account settings and preferences.</p>
                </div>
            </div>
        </div>

        {{-- ── Digital Identity Card ───────────────────────────── --}}
        @php
            $user       = auth()->user();
            $qrPayload  = $user->qrPayload();
            $roleLabel  = ['citizen' => 'Citizen', 'staff' => 'Staff', 'admin' => 'Administrator'][$user->role] ?? ucfirst($user->role);
            $roleColor  = ['citizen' => '#34d399', 'staff' => '#60a5fa', 'admin' => '#fbbf24'][$user->role] ?? '#34d399';
            $memberSince = $user->created_at->format('d M Y');
        @endphp

        <div class="animate-fade-up" style="animation-delay: 80ms">
            {{-- Card --}}
            <div id="gov-id-card" style="background:linear-gradient(140deg,#050d1a 0%,#0d2241 45%,#1B4F8A 100%);border-radius:20px;overflow:hidden;position:relative;box-shadow:0 20px 60px rgba(0,0,0,0.35);">
                {{-- Dot texture --}}
                <div style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,0.07) 1px,transparent 1px);background-size:24px 24px;pointer-events:none;"></div>
                {{-- Glow blobs --}}
                <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;background:rgba(27,79,138,0.4);border-radius:50%;filter:blur(60px);pointer-events:none;"></div>
                <div style="position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;background:rgba(52,211,153,0.08);border-radius:50%;filter:blur(40px);pointer-events:none;"></div>

                <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:24px;padding:28px 28px 24px;flex-wrap:wrap;">

                    {{-- Left: identity info --}}
                    <div style="flex:1;min-width:200px;">
                        {{-- Header row --}}
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                            <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn" style="height:32px;width:auto;filter:brightness(0) invert(1);opacity:.9;">
                            <div>
                                <div style="font-size:8.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,0.45);line-height:1;">Kurdistan Regional Government</div>
                                <div style="font-size:10px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,0.7);margin-top:2px;">Government Digital ID</div>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div style="font-size:20px;font-weight:800;color:#fff;letter-spacing:-.02em;line-height:1.2;margin-bottom:4px;">
                            {{ $user->name }}
                        </div>
                        {{-- Role badge --}}
                        <div style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.18);border-radius:999px;padding:3px 10px;margin-bottom:18px;">
                            <div style="width:6px;height:6px;border-radius:50%;background:{{ $roleColor }};flex-shrink:0;"></div>
                            <span style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.85);text-transform:uppercase;letter-spacing:.07em;">{{ $roleLabel }}</span>
                        </div>

                        {{-- Gov ID --}}
                        <div style="margin-bottom:14px;">
                            <div style="font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:5px;">Government ID</div>
                            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                                <span id="gov-id-display" style="font-family:'JetBrains Mono',monospace;font-size:18px;font-weight:700;letter-spacing:.12em;color:#34d399;">
                                    {{ $user->gov_id }}
                                </span>
                                <button onclick="copyGovId()" id="copy-btn" title="Copy ID" style="display:inline-flex;align-items:center;gap:4px;background:rgba(52,211,153,0.15);border:1px solid rgba(52,211,153,0.3);border-radius:6px;padding:4px 10px;cursor:pointer;color:#34d399;font-size:11px;font-weight:600;transition:all .2s;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                                    <span id="copy-label">Copy</span>
                                </button>
                            </div>
                        </div>

                        {{-- Meta row --}}
                        <div style="display:flex;gap:20px;flex-wrap:wrap;">
                            <div>
                                <div style="font-size:8.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:2px;">Member Since</div>
                                <div style="font-size:11px;font-weight:600;color:rgba(255,255,255,0.65);">{{ $memberSince }}</div>
                            </div>
                            <div>
                                <div style="font-size:8.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:2px;">Portal</div>
                                <div style="font-size:11px;font-weight:600;color:rgba(255,255,255,0.65);">Halzanîn e-Gov</div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: QR Code --}}
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;flex-shrink:0;">
                        <div style="background:#fff;border-radius:12px;padding:10px;box-shadow:0 4px 24px rgba(0,0,0,0.4);">
                            <div id="gov-qr-code"></div>
                        </div>
                        <div style="font-size:9px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,0.4);">Scan to verify</div>
                    </div>
                </div>

                {{-- Bottom stripe --}}
                <div style="background:rgba(0,0,0,0.25);padding:8px 28px;display:flex;align-items:center;justify-content:space-between;gap:8px;border-top:1px solid rgba(255,255,255,0.07);">
                    <span style="font-size:9px;color:rgba(255,255,255,0.3);font-weight:600;letter-spacing:.06em;text-transform:uppercase;">Kurdistan Region — Government Digital ID</span>
                    <span style="font-size:9px;color:rgba(255,255,255,0.25);font-weight:600;letter-spacing:.04em;">© {{ date('Y') }} Halzanîn</span>
                </div>
            </div>

            {{-- Security notice --}}
            <div style="display:flex;align-items:flex-start;gap:10px;margin-top:12px;padding:12px 16px;background:rgba(251,191,36,0.06);border:1px solid rgba(251,191,36,0.2);border-radius:12px;">
                <svg style="width:16px;height:16px;stroke:#f59e0b;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                <p style="font-size:12px;color:#92400e;line-height:1.55;margin:0;" class="dark:text-yellow-300/70">
                    <strong>Keep this ID confidential.</strong> Your Government ID and QR code are your digital identity on the Halzanîn portal. Never share the QR code with unknown parties. Staff may scan it to verify your identity during in-person service collection.
                </p>
            </div>
        </div>

        {{-- Profile Info Card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 100ms">
            <div class="border-b border-stone-200 dark:border-slate-700"></div>
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Update Password Card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 200ms">
            <div class="border-b border-stone-200 dark:border-slate-700"></div>
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-red-100 dark:border-red-900/30 overflow-hidden animate-fade-up" style="animation-delay: 300ms">
            <div class="border-b border-stone-200 dark:border-slate-700"></div>
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>

    {{-- QR code library + generation --}}
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script>
        (function () {
            var payload = @json($qrPayload);
            new QRCode(document.getElementById('gov-qr-code'), {
                text:          payload,
                width:         120,
                height:        120,
                colorDark:     '#050d1a',
                colorLight:    '#ffffff',
                correctLevel:  QRCode.CorrectLevel.H,
            });
        })();

        function copyGovId() {
            var govId = @json($user->gov_id);
            navigator.clipboard.writeText(govId).then(function () {
                var lbl = document.getElementById('copy-label');
                var btn = document.getElementById('copy-btn');
                lbl.textContent = 'Copied!';
                btn.style.background = 'rgba(52,211,153,0.3)';
                setTimeout(function () {
                    lbl.textContent = 'Copy';
                    btn.style.background = 'rgba(52,211,153,0.15)';
                }, 2000);
            });
        }
    </script>
@endsection
