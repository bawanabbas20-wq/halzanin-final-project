<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-outfit">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Halzanîn') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/halzanin-logo.png') }}">

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
    <body class="bg-[#EFEDE8] dark:bg-[#141414] text-charcoal dark:text-[#f1f5f9] antialiased transition-colors duration-200">
        
        <div class="flex h-screen overflow-hidden">
            
            <!-- Desktop Sidebar -->
            <aside class="hidden lg:flex lg:flex-col w-56 bg-white dark:bg-[#1F1F1F] border-r border-stone-200 dark:border-slate-800 flex-shrink-0 relative z-30">
                <!-- Logo -->
                <div class="flex items-center gap-3 px-5 py-4 border-b border-stone-100 dark:border-slate-800">
                    <a href="{{ url('/') }}" class="block focus:outline-none focus:ring-2 focus:ring-brand/40 rounded-lg">
                        <img src="{{ asset('images/halzanin-logo.png') }}" alt="Halzanîn — Back to portal" class="h-14 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto">
                    @php
                        $navActive   = 'bg-brand/5 dark:bg-brand/10 ltr:border-l-2 rtl:border-r-2 border-brand text-brand dark:text-blue-400 font-medium';
                        $navInactive = 'text-gray-600 dark:text-gray-400 hover:bg-stone-50 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white';
                        $navBase     = 'flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all text-sm';
                    @endphp
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span data-i18n="nav.dashboard">Dashboard</span>
                        </a>
                        <a href="{{ route('staff.queue') }}" class="{{ request()->routeIs('staff.queue') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span data-i18n="nav.all_applications">All Applications</span>
                        </a>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span data-i18n="nav.users">User Management</span>
                        </a>
                        <a href="{{ route('admin.services') }}" class="{{ request()->routeIs('admin.services*') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span>Services</span>
                        </a>
                        <a href="{{ route('admin.task-types') }}" class="{{ request()->routeIs('admin.task-types*') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2h2z"></path></svg>
                            <span>Task Types</span>
                        </a>
                        <a href="{{ route('admin.offdays') }}" class="{{ request()->routeIs('admin.offdays*') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span data-i18n="nav.off_days">Appointment Availability</span>
                        </a>
                        <a href="{{ route('admin.sub-roles.index') }}" class="{{ request()->routeIs('admin.sub-roles*') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Sub-Role Management</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span data-i18n="nav.profile">Profile</span>
                        </a>
                    @elseif(auth()->user()->role === 'staff')
                        <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span data-i18n="nav.dashboard">Dashboard</span>
                        </a>
                        <a href="{{ route('staff.queue') }}" class="{{ request()->routeIs('staff.queue') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span data-i18n="nav.queue">Application Queue</span>
                        </a>
                        @if(auth()->user()->hasPermission('scan_qr_checkin'))
                        <a href="{{ route('staff.scan') }}" class="{{ request()->routeIs('staff.scan') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span data-i18n="nav.qr_scanner">QR Scanner</span>
                        </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span data-i18n="nav.profile">Profile</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('*dashboard*') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span data-i18n="nav.home">Home</span>
                        </a>
                        <a href="{{ route('citizen.applications.index') }}" class="{{ request()->routeIs('citizen.applications.index') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span data-i18n="nav.my_applications">My Applications</span>
                        </a>
                        <a href="{{ route('citizen.appointments.calendar') }}" class="{{ request()->routeIs('*appointment*') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span data-i18n="nav.book">Service Booking</span>
                        </a>
                        <a href="{{ route('citizen.vault.index') }}" class="{{ request()->routeIs('*vault*') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span data-i18n="nav.vault">Document Vault</span>
                        </a>
                        <a href="{{ route('track') }}" class="{{ (request()->routeIs('track*') || request()->is('track*')) ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span data-i18n="nav.track">Track</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? $navActive : $navInactive }} {{ $navBase }}">
                            <svg class="w-5 h-5 shrink-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span data-i18n="nav.profile">Profile</span>
                        </a>
                    @endif
                </nav>

                <!-- User Profile & Logout -->
                <div class="p-4 border-t border-stone-100 dark:border-slate-800">
                    <div class="flex items-center px-2 py-2">
                        <div class="w-8 h-8 bg-accent rounded-full flex items-center justify-center font-bold text-white uppercase shrink-0 text-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ltr:ml-2.5 rtl:mr-2.5 overflow-hidden">
                            <p class="text-sm font-semibold text-charcoal dark:text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-brand uppercase tracking-wider font-bold truncate" data-i18n="role.{{ auth()->user()->role }}">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <div x-data="{}">
                        <button type="button"
                                x-on:click="$dispatch('open-modal', 'confirm-logout')"
                                class="mt-1 w-full text-left flex items-center px-4 py-2 text-sm text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                            <svg class="w-4 h-4 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span data-i18n="nav.logout">Log Out</span>
                        </button>
                        <form id="sidebar-logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col relative h-screen overflow-y-auto overflow-x-hidden">
                
                <!-- Header (Toggles) -->
                <header class="h-16 flex items-center justify-end px-4 lg:px-8 shrink-0 relative z-20">

                    @if(auth()->user()->role === 'citizen')
                    {{-- ═══════════════════════════════════════════ --}}
                    {{-- Notification Bell (citizens only)           --}}
                    {{-- ═══════════════════════════════════════════ --}}
                    <div class="ltr:mr-3 rtl:ml-3 relative"
                         x-data="{
                             open: false, count: 0, items: [],
                             init() {
                                 this.fetch();
                                 setInterval(() => this.fetch(), 30000);
                             },
                             async fetch() {
                                 try {
                                     const r = await window.fetch('{{ url('/notifications') }}', { headers: { 'Accept': 'application/json' } });
                                     const d = await r.json();
                                     this.count = d.count;
                                     this.items = d.notifications;
                                 } catch(e) {}
                             },
                             async markAllRead() {
                                 await window.fetch('{{ url('/notifications/read-all') }}', {
                                     method: 'POST',
                                     headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                                 });
                                 await this.fetch();
                             },
                             markRead(id) {
                                 const n = this.items.find(i => i.id === id);
                                 if (n && !n.read) { n.read = true; this.count = Math.max(0, this.count - 1); }
                                 window.fetch('/notifications/' + id + '/read', {
                                     method: 'PATCH',
                                     headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                                 });
                             }
                         }"
                         x-on:click.outside="open = false">

                        {{-- Bell button --}}
                        <button type="button"
                                x-on:click="open = !open; if(open) fetchNotifs()"
                                class="relative p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            {{-- Unread badge --}}
                            <span x-show="count > 0"
                                  x-text="count > 9 ? '9+' : count"
                                  class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] flex items-center justify-center bg-red-500 text-white text-[10px] font-bold rounded-full px-1 leading-none"
                                  style="display:none">
                            </span>
                        </button>

                        {{-- Dropdown panel --}}
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                             style="display:none"
                             class="absolute ltr:right-0 rtl:left-0 top-full mt-2 w-80 bg-white dark:bg-[#1F1F1F] rounded-[14px] shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden z-50">

                            {{-- Dropdown header --}}
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
                                <span class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider" data-i18n="common.notifications">Notifications</span>
                                <button type="button"
                                        x-on:click="markAllRead()"
                                        x-show="count > 0"
                                        class="text-xs font-semibold text-brand dark:text-blue-400 hover:underline">
                                    <span data-i18n="common.mark_all_read">Mark all read</span>
                                </button>
                            </div>

                            {{-- Notification list --}}
                            <div class="max-h-[340px] overflow-y-auto divide-y divide-gray-100 dark:divide-slate-700">
                                <template x-if="items.length === 0">
                                    <div class="px-4 py-8 text-center">
                                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                        <p class="text-xs text-gray-400 dark:text-gray-500" data-i18n="common.no_notifications">No notifications yet</p>
                                    </div>
                                </template>
                                <template x-for="n in items" :key="n.id">
                                    <div x-on:click="markRead(n.id); n.read = true"
                                         class="flex items-start gap-3 px-4 py-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors"
                                         :class="n.read ? '' : 'bg-brand/5 dark:bg-brand/10'">
                                        {{-- Status dot --}}
                                        <div class="mt-0.5 w-2 h-2 rounded-full shrink-0"
                                             :class="{
                                                 'bg-green-500':  n.status === 'approved',
                                                 'bg-red-500':    n.status === 'rejected',
                                                 'bg-yellow-400': n.status === 'under_review',
                                                 'bg-blue-400':   n.status === 'received',
                                                 'bg-gray-400':   !['approved','rejected','under_review','received'].includes(n.status)
                                             }">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-900 dark:text-white leading-snug">
                                                Your application <span class="font-mono text-brand dark:text-blue-400" x-text="n.tracking"></span>
                                                status changed to <span class="capitalize" x-text="n.status.replace('_',' ')"></span>
                                            </p>
                                            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5" x-text="n.time"></p>
                                        </div>
                                        <div x-show="!n.read" class="w-2 h-2 bg-brand rounded-full shrink-0 mt-1"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    @endif

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

                {{-- ═══════════════════════════════════════════════ --}}
                {{-- Page Transition Skeleton Overlay                 --}}
                {{-- ═══════════════════════════════════════════════ --}}
                <div id="nav-skeleton" class="hidden absolute top-16 inset-x-0 bottom-0 z-50 bg-[#EFEDE8] dark:bg-[#141414] overflow-y-auto" aria-hidden="true">
                    <div class="p-4 lg:p-8 pb-24 lg:pb-8 max-w-5xl mx-auto w-full space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="h-8 w-52 skeleton rounded-xl"></div>
                            <div class="h-9 w-24 skeleton rounded-full"></div>
                        </div>
                        <div class="h-[88px] skeleton rounded-[16px]"></div>
                        <div class="grid grid-cols-3 gap-3 lg:gap-6">
                            <div class="h-[100px] skeleton rounded-[16px]"></div>
                            <div class="h-[100px] skeleton rounded-[16px]"></div>
                            <div class="h-[100px] skeleton rounded-[16px]"></div>
                        </div>
                        <div class="h-6 w-36 skeleton rounded-lg"></div>
                        <div class="space-y-4">
                            <div class="h-[100px] skeleton rounded-[16px]"></div>
                            <div class="h-[100px] skeleton rounded-[16px]"></div>
                            <div class="h-[100px] skeleton rounded-[16px]"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Mobile Bottom Nav -->
            <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-[#1F1F1F] border-t border-gray-200 dark:border-[#2E2E2E] flex items-center justify-around pb-safe pt-2 px-2 z-50 h-[68px] shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.dashboard') ? 'text-brand dark:text-blue-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] font-semibold" data-i18n="nav.dash">Dash</span>
                    </a>
                    <a href="{{ route('staff.queue') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('staff.queue') ? 'text-brand dark:text-blue-400' : 'text-gray-400 hover:text-brand dark:hover:text-blue-400' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-[10px] font-semibold" data-i18n="nav.apps">Apps</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.users') ? 'text-brand dark:text-blue-400' : 'text-gray-400 hover:text-brand dark:hover:text-blue-400' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-[10px] font-semibold" data-i18n="nav.users">Users</span>
                    </a>
                    <div x-data="{open:false}" class="flex flex-col items-center justify-center w-full h-full relative">
                        <button x-on:click="open=!open" x-on:click.outside="open=false" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.edit') ? 'text-brand dark:text-blue-400' : 'text-gray-400' }}">
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-[10px] font-semibold" data-i18n="nav.profile">Profile</span>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" style="display:none" class="absolute bottom-full ltr:right-0 rtl:left-0 mb-2 w-44 bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span data-i18n="nav.profile">Profile</span>
                            </a>
                            <div class="border-t border-gray-100 dark:border-slate-700"></div>
                            <button x-on:click="$dispatch('open-modal','confirm-logout')" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span data-i18n="nav.logout">Log Out</span>
                            </button>
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'staff')
                    <a href="{{ route('staff.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('staff.dashboard') ? 'text-brand dark:text-blue-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] font-semibold" data-i18n="nav.dashboard">Dashboard</span>
                    </a>
                    <a href="{{ route('staff.queue') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('staff.queue') ? 'text-brand dark:text-blue-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-[10px] font-semibold" data-i18n="nav.queue">Queue</span>
                    </a>
                    <div x-data="{open:false}" class="flex flex-col items-center justify-center w-full h-full relative">
                        <button x-on:click="open=!open" x-on:click.outside="open=false" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.edit') ? 'text-brand dark:text-blue-400' : 'text-gray-400' }}">
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-[10px] font-semibold" data-i18n="nav.profile">Profile</span>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" style="display:none" class="absolute bottom-full ltr:right-0 rtl:left-0 mb-2 w-44 bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span data-i18n="nav.profile">Profile</span>
                            </a>
                            <div class="border-t border-gray-100 dark:border-slate-700"></div>
                            <button x-on:click="$dispatch('open-modal','confirm-logout')" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span data-i18n="nav.logout">Log Out</span>
                            </button>
                        </div>
                    </div>
                @else
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('*dashboard*') ? 'text-brand dark:text-blue-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] font-semibold" data-i18n="nav.home">Home</span>
                    </a>
                    <a href="{{ route('citizen.vault.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('*vault*') ? 'text-brand dark:text-blue-400' : 'text-gray-400 hover:text-brand' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-[10px] font-semibold" data-i18n="nav.vault">Vault</span>
                    </a>
                    <a href="{{ route('track') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('track*') ? 'text-brand dark:text-blue-400' : 'text-gray-400 hover:text-brand dark:hover:text-blue-400' }}">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-[10px] font-semibold" data-i18n="nav.track">Track</span>
                    </a>
                    <div x-data="{open:false}" class="flex flex-col items-center justify-center w-full h-full relative">
                        <button x-on:click="open=!open" x-on:click.outside="open=false" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.edit') ? 'text-brand dark:text-blue-400' : 'text-gray-400' }}">
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-[10px] font-semibold" data-i18n="nav.profile">Profile</span>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" style="display:none" class="absolute bottom-full ltr:right-0 rtl:left-0 mb-2 w-44 bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span data-i18n="nav.profile">Profile</span>
                            </a>
                            <div class="border-t border-gray-100 dark:border-slate-700"></div>
                            <button x-on:click="$dispatch('open-modal','confirm-logout')" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span data-i18n="nav.logout">Log Out</span>
                            </button>
                        </div>
                    </div>
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

                if (typeof window.updateChatQuickPrompts === 'function') {
                    window.updateChatQuickPrompts(lang);
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

            // Page transition skeleton — show shimmer overlay on internal navigation
            (function() {
                var sk = document.getElementById('nav-skeleton');
                if (!sk) return;
                document.addEventListener('click', function(e) {
                    var a = e.target.closest('a[href]');
                    if (!a || e.defaultPrevented || e.ctrlKey || e.metaKey || e.shiftKey) return;
                    var href = a.getAttribute('href');
                    if (!href || href === '#' || href[0] === '#' || href.startsWith('javascript') || href.startsWith('mailto') || href.startsWith('tel')) return;
                    if (a.getAttribute('target') === '_blank') return;
                    try {
                        var u = new URL(href, location.origin);
                        if (u.origin !== location.origin) return;
                    } catch (err) { return; }
                    sk.classList.remove('hidden');
                });
                // Reset skeleton if page is restored from bfcache
                window.addEventListener('pageshow', function(e) {
                    if (e.persisted) sk.classList.add('hidden');
                });
            })();
        </script>

        {{-- ═══════════════════════════════════════════════ --}}
        {{-- Logout Confirmation Modal                       --}}
        {{-- ═══════════════════════════════════════════════ --}}
        <x-modal name="confirm-logout" maxWidth="sm">
            <div class="p-6 bg-white dark:bg-[#1F1F1F]">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-11 h-11 rounded-full bg-red-50 dark:bg-red-900/30 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-900 dark:text-white font-outfit" data-i18n="nav.logout">Log Out</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5" data-i18n="common.logout_confirm">Are you sure you want to end your session?</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-[10px] transition-colors">
                        <span data-i18n="common.cancel">Cancel</span>
                    </button>
                    <button type="button" onclick="document.getElementById('sidebar-logout-form').submit()"
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-[10px] transition-all shadow-sm">
                        <span data-i18n="nav.logout">Log Out</span>
                    </button>
                </div>
            </div>
        </x-modal>

        {{-- ═══════════════════════════════════════════════ --}}
        {{-- Global Toast System                             --}}
        {{-- ═══════════════════════════════════════════════ --}}
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
        @if(session('status') === 'profile-updated')
        <script>document.addEventListener('DOMContentLoaded',function(){showToast('success',window.i18n ? i18n('common.profile_updated') : 'Profile Updated',window.i18n ? i18n('common.profile_saved') : 'Your profile has been saved successfully.');});</script>
        @endif
        @if($errors->any())
        <script>document.addEventListener('DOMContentLoaded',function(){showToast('error',window.i18n ? i18n('common.fix_errors') : 'Please fix the errors',window.i18n ? i18n('common.check_fields') : 'Check the highlighted fields below and try again.');});</script>
        @endif

        {{-- ═══════════════════════════════════════════════ --}}
        {{-- AI Chatbot Widget                               --}}
        {{-- ═══════════════════════════════════════════════ --}}

        {{-- Floating Button --}}
        <div id="chatbot-wrapper" style="position:fixed;bottom:88px;right:20px;z-index:10000;display:flex;flex-direction:column;align-items:flex-end;gap:12px;">

            {{-- Chat Window (hidden by default) --}}
            <div id="chatbot-window"
                 style="display:none;width:340px;max-width:90vw;height:480px;background:#ffffff;border-radius:16px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);display:none;flex-direction:column;overflow:hidden;border:1px solid rgba(0,0,0,0.06);"
                 class="dark:[background:#1F1F1F] animate-fade-in">

                {{-- Header --}}
                <div style="background:#1B4F8A;padding:14px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0;">
                    <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="color:#fff;font-weight:700;font-size:14px;margin:0;font-family:Outfit,sans-serif;" data-i18n="chat.assistant">Halzanin Assistant</p>
                        <div style="display:flex;align-items:center;gap:5px;margin-top:2px;">
                            <div style="width:7px;height:7px;background:#4ade80;border-radius:50%;"></div>
                            <span style="color:rgba(255,255,255,0.8);font-size:11px;font-weight:600;" data-i18n="chat.online">Online</span>
                        </div>
                    </div>
                    <button id="chatbot-close" onclick="toggleChat()" style="background:rgba(255,255,255,0.15);border:none;width:28px;height:28px;border-radius:50%;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Messages Area --}}
                <div id="chatbot-messages" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;background:inherit;">
                </div>

                {{-- Input Area --}}
                <div style="padding:12px;border-top:1px solid rgba(0,0,0,0.07);background:inherit;flex-shrink:0;">
                    @php($chatQuickQuestions = config('chatbot.quick_questions', []))
                    <div id="chatbot-quick-questions" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
                        @foreach($chatQuickQuestions as $question)
                            <button type="button"
                                    class="chat-quick-btn"
                                    data-en="{{ $question['en'] ?? '' }}"
                                    data-ku="{{ $question['ku'] ?? '' }}"
                                    onclick="sendQuickQuestion(this)"></button>
                        @endforeach
                    </div>
                    <div style="display:flex;gap:8px;align-items:flex-end;">
                        <textarea id="chatbot-input"
                                  placeholder="Ask me anything..."
                                  data-i18n-placeholder="chat.placeholder"
                                  rows="1"
                                  onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendChatMessage();}"
                                  oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,88)+'px';"
                                  style="flex:1;resize:none;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 12px;font-size:13px;font-family:Outfit,sans-serif;outline:none;background:#f8fafc;color:#1F1F1F;max-height:88px;line-height:1.4;transition:border-color 0.2s;"
                                  onfocus="this.style.borderColor='#1B4F8A'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                        <button onclick="sendChatMessage()" id="chatbot-send"
                                style="width:40px;height:40px;border-radius:10px;background:#1B4F8A;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:transform 0.15s,opacity 0.15s;"
                                onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Floating Bubble Button --}}
            <div style="position:relative;">
                {{-- Pulse ring --}}
                <div id="chatbot-pulse" style="position:absolute;inset:-6px;border-radius:50%;background:rgba(27,79,138,0.3);animation:chatPulse 2s ease-in-out infinite;pointer-events:none;"></div>
                <button id="chatbot-btn" onclick="toggleChat()"
                        style="width:56px;height:56px;border-radius:50%;background:#1B4F8A;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 25px -5px rgba(27,79,138,0.5);transition:transform 0.2s,box-shadow 0.2s;position:relative;z-index:1;"
                        onmouseover="this.style.transform='scale(1.08)';this.style.boxShadow='0 15px 30px -5px rgba(27,79,138,0.6)'"
                        onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 10px 25px -5px rgba(27,79,138,0.5)'">
                    <svg id="chatbot-icon-open" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <svg id="chatbot-icon-close" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    {{-- Unread badge --}}
                    <div id="chatbot-badge" style="position:absolute;top:-2px;right:-2px;width:14px;height:14px;background:#ef4444;border-radius:50%;border:2px solid #fff;display:none;"></div>
                </button>
            </div>
        </div>

        <style>
            @keyframes chatPulse {
                0%,100% { transform:scale(1); opacity:0.7; }
                50%      { transform:scale(1.3); opacity:0; }
            }
            #chatbot-messages::-webkit-scrollbar { width:4px; }
            #chatbot-messages::-webkit-scrollbar-track { background:transparent; }
            #chatbot-messages::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:4px; }
            @media (min-width:1024px) { #chatbot-wrapper { bottom:24px !important; } }

            .chat-msg-user {
                align-self: flex-end;
                background: #1B4F8A;
                color: #fff;
                padding: 9px 13px;
                border-radius: 14px 14px 4px 14px;
                font-size: 13px;
                max-width: 80%;
                line-height: 1.5;
                word-wrap: break-word;
                font-family: Outfit, sans-serif;
            }
            .chat-msg-ai {
                align-self: flex-start;
                background: #f1f5f9;
                color: #1F1F1F;
                padding: 9px 13px;
                border-radius: 14px 14px 14px 4px;
                font-size: 13px;
                max-width: 85%;
                line-height: 1.5;
                word-wrap: break-word;
                font-family: Outfit, sans-serif;
            }
            .chat-quick-btn {
                border: 1px solid #cbd5e1;
                background: #f8fafc;
                color: #334155;
                border-radius: 9999px;
                padding: 6px 10px;
                font-size: 11px;
                font-weight: 600;
                line-height: 1.2;
                cursor: pointer;
                transition: all 0.15s ease;
            }
            .chat-quick-btn:hover {
                border-color: #1B4F8A;
                color: #163F6E;
                background: #EEF3FA;
            }
            html.dark .chat-msg-ai { background:#334155; color:#f1f5f9; }
            html.dark #chatbot-window { background:#1F1F1F !important; }
            html.dark #chatbot-input  { background:#141414 !important; border-color:#2E2E2E !important; color:#f1f5f9 !important; }
            html.dark .chat-quick-btn {
                background: #141414;
                border-color: #334155;
                color: #cbd5e1;
            }
            html.dark .chat-quick-btn:hover {
                background: #1F1F1F;
                border-color: #4A82C4;
                color: #D6E4F5;
            }

            .typing-dot {
                width: 7px; height: 7px;
                background: #94a3b8;
                border-radius: 50%;
                display: inline-block;
                animation: typingBounce 1.2s infinite ease-in-out;
            }
            .typing-dot:nth-child(2) { animation-delay: 0.2s; }
            .typing-dot:nth-child(3) { animation-delay: 0.4s; }
            @keyframes typingBounce {
                0%,80%,100% { transform:translateY(0); }
                40%          { transform:translateY(-6px); }
            }
        </style>

        <script>
            let chatOpened = false;
            const WELCOME = () => window.i18n ? i18n('chat.welcome') : "Hello! I'm your Halzanin Assistant. Ask me anything about your documents or application process!";

            function getCurrentUiLang() {
                return document.documentElement.lang === 'ku' ? 'ku' : 'en';
            }

            window.updateChatQuickPrompts = function(lang = getCurrentUiLang()) {
                const quickButtons = document.querySelectorAll('#chatbot-quick-questions .chat-quick-btn');
                quickButtons.forEach((btn) => {
                    btn.textContent = lang === 'ku' ? btn.dataset.ku : btn.dataset.en;
                });
            };

            function sendQuickQuestion(button) {
                const lang = getCurrentUiLang();
                const question = lang === 'ku' ? button.dataset.ku : button.dataset.en;
                if (!question) return;

                const input = document.getElementById('chatbot-input');
                input.value = question;
                input.dispatchEvent(new Event('input'));
                sendChatMessage();
            }

            function toggleChat() {
                const win    = document.getElementById('chatbot-window');
                const iconO  = document.getElementById('chatbot-icon-open');
                const iconC  = document.getElementById('chatbot-icon-close');
                const badge  = document.getElementById('chatbot-badge');
                const pulse  = document.getElementById('chatbot-pulse');

                chatOpened = !chatOpened;

                if (chatOpened) {
                    win.style.display = 'flex';
                    iconO.style.display = 'none';
                    iconC.style.display = 'block';
                    badge.style.display = 'none';
                    pulse.style.animation = 'none';

                    // Show welcome message on first open
                    const msgs = document.getElementById('chatbot-messages');
                    if (msgs.children.length === 0) {
                        appendMsg('ai', WELCOME());
                    }

                    window.updateChatQuickPrompts(getCurrentUiLang());
                    setTimeout(() => document.getElementById('chatbot-input').focus(), 100);
                } else {
                    win.style.display = 'none';
                    iconO.style.display = 'block';
                    iconC.style.display = 'none';
                    pulse.style.animation = 'chatPulse 2s ease-in-out infinite';
                }
            }

            function appendMsg(role, text) {
                const msgs = document.getElementById('chatbot-messages');
                const el   = document.createElement('div');
                el.className = role === 'user' ? 'chat-msg-user' : 'chat-msg-ai';
                el.textContent = text;
                msgs.appendChild(el);
                msgs.scrollTop = msgs.scrollHeight;
                return el;
            }

            function showTyping() {
                const msgs = document.getElementById('chatbot-messages');
                const el   = document.createElement('div');
                el.className = 'chat-msg-ai';
                el.id = 'chatbot-typing';
                el.style.display = 'flex';
                el.style.gap     = '4px';
                el.style.alignItems = 'center';
                el.style.padding = '10px 14px';
                el.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
                msgs.appendChild(el);
                msgs.scrollTop = msgs.scrollHeight;
            }

            function removeTyping() {
                const el = document.getElementById('chatbot-typing');
                if (el) el.remove();
            }

            async function sendChatMessage() {
                const input = document.getElementById('chatbot-input');
                const msg   = input.value.trim();
                if (!msg) return;

                input.value = '';
                input.style.height = 'auto';

                appendMsg('user', msg);
                showTyping();

                const sendBtn = document.getElementById('chatbot-send');
                sendBtn.disabled = true;
                sendBtn.style.opacity = '0.5';

                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res  = await fetch('{{ url('/chatbot/chat') }}', {
                        method:  'POST',
                        headers: {
                            'Content-Type':  'application/json',
                            'X-CSRF-TOKEN':  csrf,
                            'Accept':        'application/json',
                        },
                        body: JSON.stringify({ message: msg }),
                    });

                    const data = await res.json();
                    removeTyping();
                    appendMsg('ai', data.reply || (window.i18n ? i18n('common.sorry_wrong') : 'Sorry, something went wrong.'));

                    // Show badge if chat is closed
                    if (!chatOpened) {
                        document.getElementById('chatbot-badge').style.display = 'block';
                    }
                } catch (e) {
                    removeTyping();
                    appendMsg('ai', window.i18n ? i18n('common.connection_error') : 'Connection error. Please try again.');
                } finally {
                    sendBtn.disabled = false;
                    sendBtn.style.opacity = '1';
                }
            }

            window.updateChatQuickPrompts(getCurrentUiLang());
        </script>

        <script src="{{ asset('js/translations.js') }}"></script>
        @stack('scripts')
    </body>
</html>
