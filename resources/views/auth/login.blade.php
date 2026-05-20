<x-halzanin-auth-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand/10 dark:bg-amber-900/30 rounded-full mb-4">
            <div class="w-1.5 h-1.5 rounded-full bg-accent pulse-dot"></div>
            <span class="text-xs font-semibold text-brand dark:text-amber-400 uppercase tracking-wide" data-i18n="auth.secure_login">Secure Login</span>
        </div>
        <h2 class="text-[22px] font-bold text-charcoal dark:text-white mb-6 font-outfit tracking-tight" data-i18n="auth.welcome">Welcome back</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="Email Address" data-i18n-placeholder="auth.email"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#fdefc7] dark:focus:shadow-[0_0_0_3px_rgba(200,134,10,0.3)] transition-all duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="Password" data-i18n-placeholder="auth.password"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-11 ltr:pr-11 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#fdefc7] dark:focus:shadow-[0_0_0_3px_rgba(200,134,10,0.3)] transition-all duration-200">
                <button type="button" id="toggle-password" class="absolute inset-y-0 ltr:right-0 rtl:left-0 flex items-center ltr:pr-4 rtl:pl-4 text-gray-400 hover:text-brand focus:outline-none">
                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember / Forgot -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand shadow-sm focus:ring-brand" name="remember">
                    <span class="ltr:ml-2 rtl:mr-2 text-sm text-gray-600 dark:text-gray-400" data-i18n="auth.remember">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-brand dark:text-amber-400 hover:underline" href="{{ route('password.request') }}" data-i18n="auth.forgot">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1e293b] mt-4" data-i18n="auth.login_btn">
                Log In
            </button>

            <!-- Divider -->
            <div class="relative py-4 flex items-center">
                <div class="flex-grow border-t border-gray-200 dark:border-gray-700"></div>
                <span class="flex-shrink-0 mx-4 text-gray-400 text-sm" data-i18n="auth.or">or</span>
                <div class="flex-grow border-t border-gray-200 dark:border-gray-700"></div>
            </div>

            <!-- Register Link -->
            <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                <span data-i18n="auth.no_account">Don't have an account?</span>
                <a href="{{ route('register') }}" class="font-semibold text-brand dark:text-amber-400 hover:underline" data-i18n="auth.register">Register</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        });
    </script>
</x-halzanin-auth-layout>
