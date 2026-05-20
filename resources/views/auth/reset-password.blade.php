<x-halzanin-auth-layout>
    <x-slot name="illustration">
        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl">
            <path d="M200 280C280 280 350 230 355 155C360 80 290 30 205 25C120 20 50 70 40 145C30 220 120 280 200 280Z" fill="#312e81" opacity="0.3"/>
            <!-- Shield -->
            <path d="M200 60L270 90V155C270 200 200 240 200 240C200 240 130 200 130 155V90L200 60Z" fill="#1e1b4b"/>
            <path d="M200 75L255 100V155C255 192 200 225 200 225C200 225 145 192 145 155V100L200 75Z" fill="#312e81"/>
            <!-- Checkmark inside shield -->
            <path d="M178 155l15 15 30-30" stroke="#059669" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
            <!-- Accent -->
            <circle cx="90" cy="90" r="10" fill="#059669" opacity="0.8"/>
            <circle cx="320" cy="210" r="14" fill="#059669" opacity="0.5"/>
        </svg>
    </x-slot>

    <div class="w-full">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand/8 dark:bg-indigo-900/30 rounded-full mb-4">
            <div class="w-1.5 h-1.5 rounded-full bg-accent pulse-dot"></div>
            <span class="text-xs font-semibold text-brand dark:text-indigo-400 uppercase tracking-wide">New Password</span>
        </div>

        <h2 class="text-[22px] font-bold text-brand dark:text-white mb-6 font-outfit" data-i18n="auth.reset_title">Reset Your Password</h2>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                       placeholder="Email Address" data-i18n-placeholder="auth.email"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="New Password" data-i18n-placeholder="auth.password"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                <x-password-strength inputId="password" />
            </div>

            <!-- Confirm Password -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="Confirm Password" data-i18n-placeholder="auth.confirm_password"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <button type="submit" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1e293b] mt-2" data-i18n="auth.reset_btn">
                Reset Password
            </button>
        </form>
    </div>
</x-halzanin-auth-layout>
