<x-halzanin-auth-layout>
    <x-slot name="illustration">
        <!-- Flat SVG: Person submitting documents at a desk -->
        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl">
            <!-- Background Blob -->
            <path d="M100 270C40 270 10 220 20 150C30 80 80 30 160 20C240 10 320 60 350 130C380 200 300 270 220 270C180 270 140 270 100 270Z" fill="#312e81" opacity="0.3"/>
            <!-- Desk -->
            <rect x="50" y="220" width="300" height="15" rx="5" fill="#312e81"/>
            <rect x="80" y="235" width="15" height="45" fill="#312e81"/>
            <rect x="305" y="235" width="15" height="45" fill="#312e81"/>
            <!-- Person (behind desk) -->
            <path d="M150 220C150 180 170 140 220 140C270 140 290 180 290 220" fill="#1e1b4b"/>
            <!-- Person Head -->
            <circle cx="220" cy="90" r="35" fill="#1e1b4b"/>
            <!-- Stack of Documents on desk -->
            <rect x="110" y="205" width="60" height="15" fill="#f8fafc" stroke="#059669" stroke-width="3"/>
            <rect x="115" y="195" width="60" height="10" fill="white" stroke="#059669" stroke-width="3"/>
            <!-- Document being handed over -->
            <rect x="230" y="150" width="50" height="70" rx="3" transform="rotate(15 230 150)" fill="white" stroke="#059669" stroke-width="3"/>
            <!-- Accent details -->
            <circle cx="80" cy="100" r="10" fill="#059669"/>
            <circle cx="340" cy="60" r="15" fill="#059669" opacity="0.6"/>
        </svg>
    </x-slot>

    <div class="w-full">
        <h2 class="text-[22px] font-bold text-brand dark:text-white mb-6 font-outfit" data-i18n="auth.create">Create your account</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       placeholder="Full Name" data-i18n-placeholder="auth.name"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Phone Number -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none text-xl">
                    🇮🇶
                </div>
                <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}" autocomplete="tel"
                       placeholder="07XX XXX XXXX"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
            </div>

            <!-- Email Address -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       placeholder="Email Address" data-i18n-placeholder="auth.email"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="Password" data-i18n-placeholder="auth.password"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-11 ltr:pr-11 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <button type="button" id="toggle-password" class="absolute inset-y-0 ltr:right-0 rtl:left-0 flex items-center ltr:pr-4 rtl:pl-4 text-gray-400 hover:text-brand focus:outline-none" tabindex="-1">
                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
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
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-11 ltr:pr-11 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <button type="button" id="toggle-confirm-password" class="absolute inset-y-0 ltr:right-0 rtl:left-0 flex items-center ltr:pr-4 rtl:pl-4 text-gray-400 hover:text-brand focus:outline-none" tabindex="-1">
                    <svg id="eye-icon-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Register Button -->
            <button type="submit" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1F1F1F] mt-6" data-i18n="auth.create_btn">
                Create Account
            </button>

            <!-- Login Link -->
            <div class="text-center text-sm text-gray-600 dark:text-gray-400 pt-4">
                <span data-i18n="auth.have_account">Already have an account?</span> 
                <a href="{{ route('login') }}" class="font-semibold text-brand dark:text-indigo-400 hover:underline" data-i18n="auth.login_link">Log in</a>
            </div>
        </form>
    </div>

    <script>
        (function() {
            var eyeOpen  = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            var eyeClosed = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';

            document.getElementById('toggle-password').addEventListener('click', function() {
                var inp = document.getElementById('password');
                var ico = document.getElementById('eye-icon');
                inp.type = inp.type === 'password' ? 'text' : 'password';
                ico.innerHTML = inp.type === 'text' ? eyeClosed : eyeOpen;
            });

            document.getElementById('toggle-confirm-password').addEventListener('click', function() {
                var inp = document.getElementById('password_confirmation');
                var ico = document.getElementById('eye-icon-confirm');
                inp.type = inp.type === 'password' ? 'text' : 'password';
                ico.innerHTML = inp.type === 'text' ? eyeClosed : eyeOpen;
            });
        })();
    </script>

</x-halzanin-auth-layout>
