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
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

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
    <body class="antialiased transition-colors duration-200">

        <!-- Floating Toggles -->
        <div class="fixed top-4 ltr:right-4 rtl:left-4 z-50 flex items-center space-x-3 rtl:space-x-reverse">
            <button id="theme-toggle" class="p-2 rounded-full border border-brand/30 dark:border-amber-400/30 text-brand dark:text-amber-300 hover:bg-brand/10 dark:hover:bg-amber-400/10 transition bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm">
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </button>

            <button id="lang-toggle" class="flex items-center border border-brand/30 dark:border-amber-400/30 rounded-full p-1 text-sm font-semibold transition overflow-hidden bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm">
                <span id="lang-en" class="px-3 py-0.5 rounded-full transition-colors">EN</span>
                <span id="lang-ku" class="px-3 py-0.5 rounded-full transition-colors font-arabic">کوردی</span>
            </button>
        </div>

        <!-- Full-page background with dot pattern -->
        <div class="min-h-screen bg-[#F7F4EF] dark:bg-[#0f172a] flex items-center justify-center p-4 relative overflow-hidden">

            <!-- Geometric dot pattern -->
            <div class="absolute inset-0 opacity-[0.18] dark:opacity-[0.07]"
                 style="background-image: radial-gradient(circle, #C8860A 1px, transparent 1px); background-size: 28px 28px;"></div>

            <!-- Warm ambient blobs -->
            <div class="absolute top-1/4 ltr:-left-20 rtl:-right-20 w-72 h-72 bg-brand/10 rounded-full filter blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-1/4 ltr:-right-20 rtl:-left-20 w-64 h-64 bg-amber-300/20 rounded-full filter blur-3xl pointer-events-none"></div>

            <!-- Centered card -->
            <div class="w-full max-w-[420px] relative z-10 animate-slide-up">

                <!-- Logo header -->
                <div class="flex flex-col items-center mb-6">
                    <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn" class="h-12 w-auto mx-auto mb-6">
                </div>

                <!-- Card -->
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl border border-stone-100 dark:border-slate-800 px-8 py-8">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
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

            const langToggleBtn = document.getElementById('lang-toggle');
            const langEn = document.getElementById('lang-en');
            const langKu = document.getElementById('lang-ku');

            function updateLangUI(lang) {
                if (lang === 'ku') {
                    langKu.classList.add('bg-brand', 'text-white', 'dark:bg-amber-500', 'dark:text-white');
                    langKu.classList.remove('text-brand', 'dark:text-amber-300', 'bg-transparent');
                    langEn.classList.remove('bg-brand', 'text-white', 'dark:bg-amber-500', 'dark:text-white');
                    langEn.classList.add('text-brand', 'dark:text-amber-300', 'bg-transparent');
                } else {
                    langEn.classList.add('bg-brand', 'text-white', 'dark:bg-amber-500', 'dark:text-white');
                    langEn.classList.remove('text-brand', 'dark:text-amber-300', 'bg-transparent');
                    langKu.classList.remove('bg-brand', 'text-white', 'dark:bg-amber-500', 'dark:text-white');
                    langKu.classList.add('text-brand', 'dark:text-amber-300', 'bg-transparent');
                }
            }

            updateLangUI(localStorage.lang || 'en');

            langToggleBtn.addEventListener('click', function() {
                const currentLang = document.documentElement.lang;
                if (currentLang === 'en') {
                    document.documentElement.dir = 'rtl';
                    document.documentElement.lang = 'ku';
                    document.documentElement.classList.remove('font-outfit');
                    document.documentElement.classList.add('font-arabic');
                    localStorage.setItem('lang', 'ku');
                    updateLangUI('ku');
                    if (typeof applyTranslations === 'function') applyTranslations('ku');
                } else {
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
        <x-toast />
        @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded',function(){const msg=@json(session('success'));showToast('success',window.i18n ? i18n('common.success') : 'Success',window.i18nMessage ? i18nMessage(msg) : msg);});</script>
        @endif
        @if(session('error'))
        <script>document.addEventListener('DOMContentLoaded',function(){const msg=@json(session('error'));showToast('error',window.i18n ? i18n('common.error') : 'Error',window.i18nMessage ? i18nMessage(msg) : msg);});</script>
        @endif
        @if(session('info'))
        <script>document.addEventListener('DOMContentLoaded',function(){const msg=@json(session('info'));showToast('info',window.i18n ? i18n('common.info') : 'Info',window.i18nMessage ? i18nMessage(msg) : msg);});</script>
        @endif
        @if(session('warning'))
        <script>document.addEventListener('DOMContentLoaded',function(){const msg=@json(session('warning'));showToast('warning',window.i18n ? i18n('common.warning') : 'Warning',window.i18nMessage ? i18nMessage(msg) : msg);});</script>
        @endif
        @if($errors->any())
        <script>document.addEventListener('DOMContentLoaded',function(){showToast('error',window.i18n ? i18n('common.fix_errors') : 'Please fix the errors',window.i18n ? i18n('common.check_fields') : 'Check the highlighted fields and try again.');});</script>
        @endif
        <script src="{{ asset('js/translations.js') }}"></script>
    </body>
</html>
