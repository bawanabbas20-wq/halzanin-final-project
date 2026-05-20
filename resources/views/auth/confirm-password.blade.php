<x-halzanin-auth-layout>
    <x-slot name="illustration">
        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl">
            <path d="M200 275C285 275 345 225 352 150C359 75 290 28 205 22C120 16 52 68 38 143C24 218 115 275 200 275Z" fill="#312e81" opacity="0.3"/>
            <!-- Lock body -->
            <rect x="140" y="160" width="120" height="90" rx="14" fill="#1e1b4b"/>
            <!-- Lock shackle -->
            <path d="M165 160V130a35 35 0 0170 0v30" stroke="#312e81" stroke-width="14" stroke-linecap="round" fill="none"/>
            <!-- Keyhole -->
            <circle cx="200" cy="200" r="12" fill="white" opacity="0.9"/>
            <rect x="196" y="200" width="8" height="18" rx="3" fill="white" opacity="0.9"/>
            <!-- Accent -->
            <circle cx="85" cy="100" r="10" fill="#059669" opacity="0.8"/>
            <circle cx="335" cy="80" r="14" fill="#059669" opacity="0.5"/>
        </svg>
    </x-slot>

    <div class="w-full">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 dark:bg-amber-900/20 rounded-full mb-4">
            <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <span class="text-xs font-semibold text-amber-700 dark:text-amber-400 uppercase tracking-wide">Secure Area</span>
        </div>

        <h2 class="text-[22px] font-bold text-brand dark:text-white mb-2 font-outfit" data-i18n="auth.confirm_title">Confirm Your Password</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6" data-i18n="auth.confirm_desc">
            This is a secure area. Please confirm your password before continuing.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="Password" data-i18n-placeholder="auth.password"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <button type="submit" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1e293b]" data-i18n="auth.confirm_btn">
                Confirm Password
            </button>
        </form>
    </div>
</x-halzanin-auth-layout>
