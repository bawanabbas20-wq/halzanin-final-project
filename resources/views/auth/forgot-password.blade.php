<x-halzanin-auth-layout>

    <div class="w-full">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand/10 dark:bg-amber-900/30 rounded-full mb-4">
            <div class="w-1.5 h-1.5 rounded-full bg-accent pulse-dot"></div>
            <span class="text-xs font-semibold text-brand dark:text-amber-400 uppercase tracking-wide" data-i18n="auth.password_reset">Password Reset</span>
        </div>

        <h2 class="text-[22px] font-bold text-charcoal dark:text-white mb-2 font-outfit tracking-tight" data-i18n="auth.forgot_title">Forgot Password?</h2>
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
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#fdefc7] dark:focus:shadow-[0_0_0_3px_rgba(200,134,10,0.3)] transition-all duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <button type="submit" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1e293b] mt-2" data-i18n="auth.send_reset_link">
                Send Reset Link
            </button>

            <div class="text-center text-sm text-gray-600 dark:text-gray-400 pt-2">
                <a href="{{ route('login') }}" class="font-semibold text-brand dark:text-amber-400 hover:underline" data-i18n="auth.back_to_login">← Back to Login</a>
            </div>
        </form>
    </div>
</x-halzanin-auth-layout>
