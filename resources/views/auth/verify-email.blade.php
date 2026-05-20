<x-halzanin-auth-layout>
    <x-slot name="illustration">
        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl">
            <path d="M200 280C285 280 348 228 352 153C356 78 288 30 204 23C120 16 50 67 37 142C24 217 115 280 200 280Z" fill="#312e81" opacity="0.3"/>
            <!-- Envelope -->
            <rect x="80" y="95" width="240" height="165" rx="14" fill="white" stroke="#312e81" stroke-width="3"/>
            <path d="M80 109L200 182L320 109" stroke="#312e81" stroke-width="3" stroke-linecap="round"/>
            <!-- Verified badge -->
            <circle cx="305" cy="95" r="34" fill="#059669"/>
            <path d="M289 95l10 10 18-20" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            <!-- Accent dots -->
            <circle cx="85" cy="75" r="9" fill="#059669" opacity="0.6"/>
        </svg>
    </x-slot>

    <div class="w-full">
        <div class="w-16 h-16 bg-accent/10 dark:bg-accent/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h2 class="text-[22px] font-bold text-brand dark:text-white mb-2 font-outfit text-center" data-i18n="auth.verify_title">Verify Your Email</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 text-center" data-i18n="auth.verify_desc">
            Thanks for signing up! Please verify your email address by clicking the link we sent you.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-5 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-[10px] flex items-start gap-3">
                <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium text-green-700 dark:text-green-400" data-i18n="auth.verification_sent">
                    A new verification link has been sent to your email address.
                </p>
            </div>
        @endif

        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1e293b]" data-i18n="auth.resend_email">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full h-[48px] bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-slate-700 rounded-[10px] font-semibold transition-all duration-200" data-i18n="auth.logout">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</x-halzanin-auth-layout>
