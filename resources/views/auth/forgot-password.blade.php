<x-halzanin-auth-layout>
    <x-slot name="illustration">
        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl">
            <path d="M200 280C280 280 340 230 350 155C360 80 290 35 210 25C130 15 55 65 35 140C15 215 120 280 200 280Z" fill="#312e81" opacity="0.3"/>
            <!-- Envelope -->
            <rect x="80" y="100" width="240" height="160" rx="12" fill="white" stroke="#059669" stroke-width="3"/>
            <path d="M80 112L200 185L320 112" stroke="#059669" stroke-width="3" stroke-linecap="round"/>
            <!-- Lock icon overlay -->
            <circle cx="310" cy="200" r="32" fill="#1e1b4b"/>
            <rect x="299" y="200" width="22" height="18" rx="3" fill="white"/>
            <path d="M303 200V195a7 7 0 0114 0v5" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
            <circle cx="310" cy="209" r="2.5" fill="#1e1b4b"/>
            <!-- Accent dots -->
            <circle cx="80" cy="80" r="8" fill="#059669" opacity="0.7"/>
            <circle cx="340" cy="70" r="12" fill="#059669" opacity="0.5"/>
        </svg>
    </x-slot>

    <div class="w-full">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand/8 dark:bg-indigo-900/30 rounded-full mb-4">
            <div class="w-1.5 h-1.5 rounded-full bg-accent pulse-dot"></div>
            <span class="text-xs font-semibold text-brand dark:text-indigo-400 uppercase tracking-wide" data-i18n="auth.password_reset">Password Reset</span>
        </div>

        <h2 class="text-[22px] font-bold text-brand dark:text-white mb-2 font-outfit" data-i18n="auth.forgot_title">Forgot Password?</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6" data-i18n="auth.forgot_desc">
            No problem. Enter your email and we'll send you a reset link.
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="Email Address" data-i18n-placeholder="auth.email"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <button type="submit" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1e293b] mt-2" data-i18n="auth.send_reset_link">
                Send Reset Link
            </button>

            <div class="text-center text-sm text-gray-600 dark:text-gray-400 pt-2">
                <a href="{{ route('login') }}" class="font-semibold text-brand dark:text-indigo-400 hover:underline" data-i18n="auth.back_to_login">← Back to Login</a>
            </div>
        </form>
    </div>
</x-halzanin-auth-layout>
