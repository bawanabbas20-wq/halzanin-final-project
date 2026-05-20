<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-outfit">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Halzanîn') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Initialize theme
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            // Initialize language
            if (localStorage.lang === 'ku') {
                document.documentElement.dir = 'rtl';
                document.documentElement.lang = 'ku';
                document.documentElement.classList.remove('font-outfit');
                document.documentElement.classList.add('font-arabic');
            } else {
                document.documentElement.dir = 'ltr';
                document.documentElement.lang = 'en';
                document.documentElement.classList.add('font-outfit');
                document.documentElement.classList.remove('font-arabic');
            }
        </script>
    </head>
    <body class="bg-[#f8fafc] dark:bg-[#0f172a] text-gray-900 dark:text-[#f1f5f9] antialiased transition-colors duration-200">
        
        <!-- Floating Toggles -->
        <div class="fixed top-4 ltr:right-4 rtl:left-4 z-50 flex items-center space-x-3 rtl:space-x-reverse">
            <!-- Dark Mode Toggle -->
            <button id="theme-toggle" class="p-2 rounded-full border-1.5 border-brand dark:border-[#f1f5f9] text-brand dark:text-[#f1f5f9] hover:bg-brand/10 dark:hover:bg-[#f1f5f9]/10 transition">
                <!-- Sun icon (shows in dark mode) -->
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <!-- Moon icon (shows in light mode) -->
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </button>

            <!-- Language Toggle -->
            <button id="lang-toggle" class="flex items-center border-[1.5px] border-brand dark:border-[#f1f5f9] rounded-full p-1 text-sm font-semibold transition overflow-hidden">
                <span id="lang-en" class="px-3 py-0.5 rounded-full transition-colors">EN</span>
                <span id="lang-ku" class="px-3 py-0.5 rounded-full transition-colors font-arabic">کوردی</span>
            </button>
        </div>

        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Left Side / Top Side (Illustration & Logo) -->
            <div class="w-full lg:w-[45%] lg:bg-brand flex flex-col items-center justify-center pt-10 pb-8 lg:py-0 lg:min-h-screen relative overflow-hidden shrink-0">
                
                <!-- Illustration (Mobile: top 38%, Desktop: centered) -->
                <div class="w-full max-w-sm px-8 mb-6 animate-fade-in relative z-10">
                    {{ $illustration }}
                </div>

                <!-- Logo & Brand Info -->
                <div class="flex flex-col items-center animate-fade-in relative z-10">
                    <div class="w-14 h-14 bg-brand lg:bg-white rounded-full flex items-center justify-center shadow-md mb-4 border border-brand/10 lg:border-none">
                        <span class="text-white lg:text-brand text-3xl font-bold font-outfit">H</span>
                    </div>
                    <h1 class="text-[28px] font-bold text-brand lg:text-white mb-1 font-outfit">Halzanîn</h1>
                    <p class="text-[14px] text-gray-500 lg:text-white/80 font-arabic">بزانە بەلگەکەت لە کوێیە</p>
                </div>

                <!-- Desktop Decorative Background Element -->
                <div class="hidden lg:block absolute -bottom-24 -left-24 w-64 h-64 bg-brand-light rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
                <div class="hidden lg:block absolute top-24 -right-12 w-48 h-48 bg-accent/20 rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
            </div>

            <!-- Right Side / Bottom Side (Form Card) -->
            <div class="w-full lg:w-[55%] min-h-screen flex items-center justify-center lg:bg-white lg:dark:bg-[#0f172a] p-4 lg:p-0">
                
                <!-- Mobile Card Wrapper / Desktop Centered Container -->
                <div class="w-full max-w-[420px] mx-auto bg-white dark:bg-[#1e293b] lg:bg-transparent lg:dark:bg-transparent rounded-tl-[24px] rounded-tr-[24px] lg:rounded-none px-8 py-10 lg:p-0 shadow-[0_-10px_40px_-15px_rgba(0,0,0,0.1)] lg:shadow-none animate-slide-up z-20">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
            // Theme Toggle Logic
            const themeToggleBtn = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                lightIcon.classList.remove('hidden');
            } else {
                darkIcon.classList.remove('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                darkIcon.classList.toggle('hidden');
                lightIcon.classList.toggle('hidden');

                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            });

            // Language Toggle Logic
            const langToggleBtn = document.getElementById('lang-toggle');
            const langEn = document.getElementById('lang-en');
            const langKu = document.getElementById('lang-ku');

            function updateLangUI(lang) {
                if (lang === 'ku') {
                    langKu.classList.add('bg-brand', 'text-white', 'dark:bg-[#f1f5f9]', 'dark:text-brand');
                    langKu.classList.remove('text-brand', 'dark:text-[#f1f5f9]', 'bg-transparent');
                    langEn.classList.remove('bg-brand', 'text-white', 'dark:bg-[#f1f5f9]', 'dark:text-brand');
                    langEn.classList.add('text-brand', 'dark:text-[#f1f5f9]', 'bg-transparent');
                } else {
                    langEn.classList.add('bg-brand', 'text-white', 'dark:bg-[#f1f5f9]', 'dark:text-brand');
                    langEn.classList.remove('text-brand', 'dark:text-[#f1f5f9]', 'bg-transparent');
                    langKu.classList.remove('bg-brand', 'text-white', 'dark:bg-[#f1f5f9]', 'dark:text-brand');
                    langKu.classList.add('text-brand', 'dark:text-[#f1f5f9]', 'bg-transparent');
                }
            }

            updateLangUI(localStorage.lang || 'en');

            langToggleBtn.addEventListener('click', function() {
                const currentLang = document.documentElement.lang;
                if (currentLang === 'en') {
                    // Switch to Kurdish
                    document.documentElement.dir = 'rtl';
                    document.documentElement.lang = 'ku';
                    document.documentElement.classList.remove('font-outfit');
                    document.documentElement.classList.add('font-arabic');
                    localStorage.setItem('lang', 'ku');
                    updateLangUI('ku');
                    if (typeof applyTranslations === 'function') applyTranslations('ku');
                } else {
                    // Switch to English
                    document.documentElement.dir = 'ltr';
                    document.documentElement.lang = 'en';
                    document.documentElement.classList.add('font-outfit');
                    document.documentElement.classList.remove('font-arabic');
                    localStorage.setItem('lang', 'en');
                    updateLangUI('en');
                    if (typeof applyTranslations === 'function') applyTranslations('en');
                }
            });
        </script>
        {{-- Toast Notifications --}}
        <x-toast />
        @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded',function(){showToast('success','Success',@json(session('success')));});</script>
        @endif
        @if(session('error'))
        <script>document.addEventListener('DOMContentLoaded',function(){showToast('error','Error',@json(session('error')));});</script>
        @endif
        @if(session('info'))
        <script>document.addEventListener('DOMContentLoaded',function(){showToast('info','Info',@json(session('info')));});</script>
        @endif
        @if(session('warning'))
        <script>document.addEventListener('DOMContentLoaded',function(){showToast('warning','Warning',@json(session('warning')));});</script>
        @endif
        @if($errors->any())
        <script>document.addEventListener('DOMContentLoaded',function(){showToast('error','Please fix the errors','Check the highlighted fields and try again.');});</script>
        @endif
        <script src="{{ asset('js/translations.js') }}"></script>
    </body>
</html>
