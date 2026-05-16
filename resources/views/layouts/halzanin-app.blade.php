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
        
        <div class="flex h-screen overflow-hidden">
            
            <!-- Desktop Sidebar -->
            <aside class="hidden lg:flex lg:flex-col w-[240px] bg-brand text-white flex-shrink-0 shadow-xl relative z-30">
                <!-- Logo -->
                <div class="flex items-center space-x-3 px-6 py-8 ltr:space-x-reverse rtl:space-x-reverse relative">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">
                        <span class="text-brand text-xl font-bold font-outfit">H</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold font-outfit leading-tight">Halzanîn</h1>
                        <p class="text-[10px] text-white/70 font-arabic opacity-80">بزانە بەلگەکەت لە کوێیە</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 space-y-2 mt-4 overflow-y-auto">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('staff.queue') }}" class="{{ request()->routeIs('staff.queue') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            All Applications
                        </a>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            User Management
                        </a>
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile
                        </a>
                    @elseif(auth()->user()->role === 'staff')
                        <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('staff.queue') }}" class="{{ request()->routeIs('staff.queue') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Application Queue
                        </a>
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('*dashboard*') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Home
                        </a>
                        <a href="{{ route('citizen.appointment.create') }}" class="{{ request()->routeIs('*appointment*') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Book Appointment
                        </a>
                        <a href="#" class="text-white/70 hover:bg-white/5 hover:text-white flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Track
                        </a>
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile
                        </a>
                    @endif
                </nav>

                <!-- User Profile & Logout -->
                <div class="p-4 border-t border-white/10">
                    <div class="flex items-center px-2 py-2">
                        <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center font-bold text-white uppercase shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ltr:ml-3 rtl:mr-3 overflow-hidden">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-brand-light uppercase tracking-wider font-bold truncate">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-white/5 rounded-xl transition-all">
                            <svg class="w-4 h-4 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col relative h-screen overflow-y-auto overflow-x-hidden">
                
                <!-- Header (Toggles) -->
                <header class="h-16 flex items-center justify-end px-4 lg:px-8 shrink-0 relative z-20">
                    <!-- Floating Toggles -->
                    <div class="flex items-center space-x-3 rtl:space-x-reverse bg-white/80 dark:bg-slate-800/80 backdrop-blur-md px-3 py-2 rounded-full shadow-sm border border-gray-100 dark:border-slate-700">
                        <!-- Dark Mode Toggle -->
                        <button id="theme-toggle" class="p-1.5 rounded-full text-brand dark:text-[#f1f5f9] hover:bg-brand/10 dark:hover:bg-[#f1f5f9]/10 transition">
                            <svg id="theme-toggle-light-icon" class="hidden w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                            <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        </button>

                        <div class="w-px h-4 bg-gray-200 dark:bg-slate-600"></div>

                        <!-- Language Toggle -->
                        <button id="lang-toggle" class="flex items-center text-xs font-semibold transition overflow-hidden">
                            <span id="lang-en" class="px-2 py-0.5 rounded-full transition-colors">EN</span>
                            <span id="lang-ku" class="px-2 py-0.5 rounded-full transition-colors font-arabic">کوردی</span>
                        </button>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-4 lg:p-8 pb-24 lg:pb-8 relative z-10 w-full max-w-5xl mx-auto">
                    @yield('content')
                </main>

            </div>

            <!-- Mobile Bottom Nav -->
            <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 flex items-center justify-around pb-safe pt-2 px-2 z-50 h-[68px] shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.dashboard') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] font-semibold">Dash</span>
                    </a>
                    <a href="{{ route('staff.queue') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('staff.queue') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand dark:hover:text-indigo-400' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-[10px] font-semibold">Apps</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.users') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand dark:hover:text-indigo-400' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-[10px] font-semibold">Users</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.edit') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-[10px] font-semibold">Profile</span>
                    </a>
                @elseif(auth()->user()->role === 'staff')
                    <a href="{{ route('staff.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('staff.dashboard') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] font-semibold">Dash</span>
                    </a>
                    <a href="{{ route('staff.queue') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('staff.queue') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-[10px] font-semibold">Queue</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.edit') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-[10px] font-semibold">Profile</span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('*dashboard*') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] font-semibold">Home</span>
                    </a>
                    <a href="{{ route('citizen.appointment.create') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('*appointment*') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-[10px] font-semibold">Book</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-brand dark:hover:text-indigo-400">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-[10px] font-semibold">Track</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.edit') ? 'text-brand dark:text-indigo-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-[10px] font-semibold">Profile</span>
                    </a>
                @endif
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
                } else {
                    // Switch to English
                    document.documentElement.dir = 'ltr';
                    document.documentElement.lang = 'en';
                    document.documentElement.classList.add('font-outfit');
                    document.documentElement.classList.remove('font-arabic');
                    localStorage.setItem('lang', 'en');
                    updateLangUI('en');
                }
            });
        </script>
    </body>
</html>
