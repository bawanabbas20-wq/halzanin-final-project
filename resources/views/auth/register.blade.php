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
        <!-- Progress Indicator -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex flex-col items-center flex-1">
                <div class="w-8 h-8 bg-brand text-white rounded-full flex items-center justify-center font-bold text-sm">1</div>
                <span class="text-xs text-brand font-medium mt-1">Step 1</span>
            </div>
            <div class="h-0.5 bg-gray-200 dark:bg-gray-700 flex-1 mx-2 mt-[-16px]"></div>
            <div class="flex flex-col items-center flex-1">
                <div class="w-8 h-8 bg-gray-100 dark:bg-gray-800 text-gray-400 rounded-full flex items-center justify-center font-bold text-sm">2</div>
                <span class="text-xs text-gray-400 font-medium mt-1">Step 2</span>
            </div>
            <div class="h-0.5 bg-gray-200 dark:bg-gray-700 flex-1 mx-2 mt-[-16px]"></div>
            <div class="flex flex-col items-center flex-1">
                <div class="w-8 h-8 bg-gray-100 dark:bg-gray-800 text-gray-400 rounded-full flex items-center justify-center font-bold text-sm">3</div>
                <span class="text-xs text-gray-400 font-medium mt-1">Step 3</span>
            </div>
        </div>

        <h2 class="text-[22px] font-semibold text-brand dark:text-white mb-6 font-outfit">Create your account</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       placeholder="Full Name"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Phone Number -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none text-xl">
                    🇮🇶
                </div>
                <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}" autocomplete="tel"
                       placeholder="07XX XXX XXXX"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
            </div>

            <!-- Email Address -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       placeholder="Email Address"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="Password"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="Confirm Password"
                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all duration-200">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Register Button -->
            <button type="submit" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1e293b] mt-6">
                Create Account
            </button>

            <!-- Login Link -->
            <div class="text-center text-sm text-gray-600 dark:text-gray-400 pt-4">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-semibold text-brand dark:text-indigo-400 hover:underline">Log in</a>
            </div>
        </form>
    </div>
</x-halzanin-auth-layout>
