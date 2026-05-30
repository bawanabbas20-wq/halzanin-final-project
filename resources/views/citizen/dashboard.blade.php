@extends('layouts.halzanin-app')

@section('content')
@php
    $total     = $upcomingAppointments->count();

    $statusCfg = [
        'submitted'              => ['bg' => 'bg-gray-100 dark:bg-gray-800',           'text' => 'text-gray-600 dark:text-gray-300'],
        'received'               => ['bg' => 'bg-blue-100 dark:bg-blue-900/30',        'text' => 'text-blue-700 dark:text-blue-300'],
        'docs_verified'          => ['bg' => 'bg-blue-100 dark:bg-blue-900/30',        'text' => 'text-blue-700 dark:text-blue-300'],
        'docs_reviewed'          => ['bg' => 'bg-blue-100 dark:bg-blue-900/30',        'text' => 'text-blue-700 dark:text-blue-300'],
        'under_processing'       => ['bg' => 'bg-indigo-100 dark:bg-indigo-900/30',    'text' => 'text-indigo-700 dark:text-indigo-300'],
        'under_review'           => ['bg' => 'bg-amber-100 dark:bg-amber-900/30',      'text' => 'text-amber-700 dark:text-amber-300'],
        'theory_scheduled'       => ['bg' => 'bg-purple-100 dark:bg-purple-900/30',    'text' => 'text-purple-700 dark:text-purple-300'],
        'theory_passed'          => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30',  'text' => 'text-emerald-700 dark:text-emerald-300'],
        'practical_scheduled'    => ['bg' => 'bg-purple-100 dark:bg-purple-900/30',    'text' => 'text-purple-700 dark:text-purple-300'],
        'license_ready'          => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30',  'text' => 'text-emerald-700 dark:text-emerald-300'],
        'inspection_scheduled'   => ['bg' => 'bg-amber-100 dark:bg-amber-900/30',      'text' => 'text-amber-700 dark:text-amber-300'],
        'inspection_completed'   => ['bg' => 'bg-blue-100 dark:bg-blue-900/30',        'text' => 'text-blue-700 dark:text-blue-300'],
        'fee_assessed'           => ['bg' => 'bg-orange-100 dark:bg-orange-900/30',    'text' => 'text-orange-700 dark:text-orange-300'],
        'fee_pending'            => ['bg' => 'bg-orange-100 dark:bg-orange-900/30',    'text' => 'text-orange-700 dark:text-orange-300'],
        'installation_scheduled' => ['bg' => 'bg-indigo-100 dark:bg-indigo-900/30',    'text' => 'text-indigo-700 dark:text-indigo-300'],
        'name_check'             => ['bg' => 'bg-amber-100 dark:bg-amber-900/30',      'text' => 'text-amber-700 dark:text-amber-300'],
        'legal_review'           => ['bg' => 'bg-amber-100 dark:bg-amber-900/30',      'text' => 'text-amber-700 dark:text-amber-300'],
        'approved'               => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30',  'text' => 'text-emerald-700 dark:text-emerald-300'],
        'ready_for_pickup'       => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30',  'text' => 'text-emerald-700 dark:text-emerald-300'],
        'completed'              => ['bg' => 'bg-green-100 dark:bg-green-900/30',      'text' => 'text-green-700 dark:text-green-300'],
        'collected'              => ['bg' => 'bg-green-100 dark:bg-green-900/30',      'text' => 'text-green-700 dark:text-green-300'],
        'connected'              => ['bg' => 'bg-green-100 dark:bg-green-900/30',      'text' => 'text-green-700 dark:text-green-300'],
        'rejected'               => ['bg' => 'bg-red-100 dark:bg-red-900/30',          'text' => 'text-red-700 dark:text-red-300'],
        'checked_in'             => ['bg' => 'bg-purple-100 dark:bg-purple-900/30',    'text' => 'text-purple-700 dark:text-purple-300'],
    ];

    // Ministry SVG icon paths keyed by slug
    $ministryIcons = [
        'civil-registry'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>',
        'traffic-police'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>',
        'electricity'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
        'water'                => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c-4.97 5.93-7 9.18-7 12a7 7 0 0014 0c0-2.82-2.03-6.07-7-12z"/>',
        'business-registration'=> '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
    ];
@endphp

<div class="space-y-6 lg:space-y-8">

    {{-- ── Greeting ── --}}
    <div class="animate-fade-in">
        <h2 class="text-2xl font-bold font-outfit text-gradient">
            <span data-i18n="dashboard.greeting">Hello,</span>
            <span dir="auto" style="unicode-bidi:isolate">{{ explode(' ', auth()->user()->name)[0] }}</span><span style="unicode-bidi:isolate">!</span>
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1" data-i18n="dashboard.manage_applications">
            Manage your government service applications from one place.
        </p>
    </div>

    {{-- ── Hero CTA ── --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand via-[#2d2a6e] to-[#A06B07] shadow-brand-btn animate-fade-up">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full pointer-events-none"></div>
        <div class="absolute top-4 right-4 w-3 h-3 bg-accent rounded-full pulse-dot pointer-events-none"></div>

        <div class="relative z-10 p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
            <div>
                <p class="text-white/60 text-xs font-semibold uppercase tracking-widest mb-1" data-i18n="Kurdistan Region">Kurdistan Region</p>
                <h3 class="text-xl font-bold text-white mb-1.5" data-i18n="dashboard.apply_services">Apply for Government Services</h3>
                <p class="text-sm text-white/70" data-i18n="dashboard.services_hint">ID cards, driving licences, utility connections, and more</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2.5 shrink-0">
                <a href="/"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white text-brand font-bold text-sm rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span data-i18n="Browse Services">Browse Services</span>
                </a>
                <a href="{{ route('citizen.appointments.calendar') }}"
                   class="inline-flex items-center gap-2 px-4 py-3 bg-white/10 text-white font-semibold text-sm rounded-xl border border-white/20 hover:bg-white/20 transition-all whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span data-i18n="book.short_title">Book Appointment</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Government Directorates ── --}}
    <div class="animate-fade-up" style="animation-delay: 60ms">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-brand dark:text-white font-outfit" data-i18n="dashboard.directorates">Government Directorates</h3>
            <a href="/" class="text-xs font-semibold text-brand dark:text-blue-400 hover:underline flex items-center gap-1">
                <span data-i18n="dashboard.all_services">All services</span>
                <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach($ministries as $ministry)
                @php
                    $iconPath = $ministryIcons[$ministry->slug] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>';
                    $activeCount = $ministry->activeServices->count();
                @endphp
                <a href="{{ route('citizen.appointments.calendar') }}"
                   class="group bg-white dark:bg-[#1F1F1F] rounded-xl p-4 border border-gray-100 dark:border-gray-800 shadow-sm hover-lift flex flex-col gap-3 transition-all"
                   style="border-top: 3px solid {{ $ministry->color }}">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                         style="background: {{ $ministry->color }}18;">
                        <svg class="w-5 h-5" fill="none" stroke="{{ $ministry->color }}" viewBox="0 0 24 24">
                            {!! $iconPath !!}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-900 dark:text-white leading-snug">{{ $ministry->name }}</p>
                        <p class="text-xs mt-1 font-medium" style="color: {{ $ministry->color }}">
                            {{ $activeCount }} <span data-i18n="admin.active_services">active service{{ $activeCount !== 1 ? 's' : '' }}</span>
                        </p>
                    </div>
                    <span class="text-xs font-semibold flex items-center gap-1 opacity-60 group-hover:opacity-100 transition-opacity"
                          style="color: {{ $ministry->color }}">
                        <span data-i18n="Apply">Apply</span>
                        <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- ── Application Stats ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 lg:gap-5">
        @php
            $statItems = [
                [
                    'value'   => $appStats['total'],
                    'label'   => 'Applications',
                    'i18n'    => 'dashboard.stat_total',
                    'delay'   => 0,
                    'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                    'ring'    => 'ring-blue-100 dark:ring-blue-900/30',
                    'icon_bg' => 'bg-blue-50 dark:bg-blue-900/30',
                    'icon_c'  => 'text-blue-600 dark:text-blue-400',
                ],
                [
                    'value'   => $appStats['active'],
                    'label'   => 'In Progress',
                    'i18n'    => 'dashboard.stat_active',
                    'delay'   => 80,
                    'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'ring'    => 'ring-amber-100 dark:ring-amber-900/30',
                    'icon_bg' => 'bg-amber-50 dark:bg-amber-900/30',
                    'icon_c'  => 'text-amber-500 dark:text-amber-400',
                ],
                [
                    'value'   => $appStats['done'],
                    'label'   => 'Completed',
                    'i18n'    => 'dashboard.stat_done',
                    'delay'   => 160,
                    'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'ring'    => 'ring-green-100 dark:ring-green-900/30',
                    'icon_bg' => 'bg-green-50 dark:bg-green-900/30',
                    'icon_c'  => 'text-green-600 dark:text-green-400',
                ],
                [
                    'value'   => $appStats['upcoming'],
                    'label'   => 'Upcoming',
                    'i18n'    => 'dashboard.stat_upcoming',
                    'delay'   => 240,
                    'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'ring'    => 'ring-purple-100 dark:ring-purple-900/30',
                    'icon_bg' => 'bg-purple-50 dark:bg-purple-900/30',
                    'icon_c'  => 'text-purple-600 dark:text-purple-400',
                ],
            ];
        @endphp

        @foreach ($statItems as $s)
            <div class="bg-white dark:bg-[#1F1F1F] rounded-xl p-4 lg:p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift animate-fade-up"
                 style="animation-delay: {{ $s['delay'] }}ms">
                <div class="w-9 h-9 rounded-full ring-4 {{ $s['ring'] }} {{ $s['icon_bg'] }} {{ $s['icon_c'] }} flex items-center justify-center mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $s['icon'] !!}</svg>
                </div>
                <p class="text-2xl font-bold text-brand dark:text-white font-outfit">{{ $s['value'] }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate" data-i18n="{{ $s['i18n'] }}">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ── Recent Applications ── --}}
    <div class="animate-fade-up" style="animation-delay: 320ms">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <h3 class="text-base font-bold text-brand dark:text-white font-outfit" data-i18n="dashboard.my_applications">My Applications</h3>
                @if($appStats['total'] > 0)
                    <span class="px-2 py-0.5 bg-brand/10 dark:bg-blue-900/30 text-brand dark:text-blue-400 text-xs font-bold rounded-full">
                        {{ $appStats['total'] }}
                    </span>
                @endif
            </div>
            <a href="{{ route('citizen.applications.index') }}"
               class="text-xs font-semibold text-brand dark:text-blue-400 hover:underline flex items-center gap-1">
                <span data-i18n="View All">View all</span>
                <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($recentApplications->isEmpty())
            <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="flex flex-col items-center justify-center py-14 px-6 text-center">
                    <div class="w-16 h-16 bg-gray-50 dark:bg-[#252525] rounded-2xl flex items-center justify-center mb-4 border border-gray-100 dark:border-slate-700">
                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1" data-i18n="dashboard.no_applications">No applications yet</h4>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mb-5" data-i18n="dashboard.no_applications_desc">Apply for a government service to get started.</p>
                    <a href="/"
                       class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand-light transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span data-i18n="Browse Services">Browse Services</span>
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-3">
                @foreach($recentApplications as $index => $app)
                    @php
                        $sc = $statusCfg[$app->current_status] ?? $statusCfg['submitted'];
                        $ministryColor = $app->service->ministry->color ?? '#1B4F8A';
                        $ministryName  = $app->service->ministry->name ?? 'Government Service';
                        $delay = 50 + $index * 60;
                    @endphp
                    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover-lift animate-fade-up"
                         style="animation-delay: {{ $delay }}ms; border-left: 3px solid {{ $ministryColor }};">
                        <div class="p-4 sm:p-5 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: {{ $ministryColor }}14;">
                                <svg class="w-5 h-5" fill="none" stroke="{{ $ministryColor }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                    {{ $app->service->name ?? ($app->appointment->document_type ?? 'Application') }}
                                </p>
                                <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                                    <span class="text-xs font-mono text-brand dark:text-blue-400">{{ $app->tracking_code }}</span>
                                    <span class="text-gray-300 dark:text-gray-600" aria-hidden="true">·</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $app->submitted_at ? $app->submitted_at->format('M j, Y') : $app->created_at->format('M j, Y') }}
                                    </span>
                                </div>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 rounded-full text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                                <span data-i18n="status.{{ $app->current_status }}">{{ ucwords(str_replace('_', ' ', $app->current_status)) }}</span>
                            </span>
                        </div>
                        <div class="px-4 sm:px-5 py-2 bg-gray-50/50 dark:bg-white/[0.02] border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                            {{-- Ministry badge --}}
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background: {{ $ministryColor }}"></span>
                                <span class="text-gray-500 dark:text-gray-400 truncate">{{ $ministryName }}</span>
                            </span>
                            <a href="{{ route('track.show', $app->tracking_code) }}"
                               class="text-xs font-semibold text-brand dark:text-blue-400 hover:underline flex items-center gap-1 shrink-0 ml-3">
                                <span data-i18n="common.view">View</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── My Appointments ── --}}
    @if($upcomingAppointments->isNotEmpty())
    <div class="animate-fade-up" style="animation-delay: 480ms">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <h3 class="text-base font-bold text-brand dark:text-white font-outfit" data-i18n="dashboard.my_appointments">My Appointments</h3>
                <span class="px-2 py-0.5 bg-brand/10 dark:bg-amber-900/30 text-brand dark:text-amber-400 text-xs font-bold rounded-full">
                    {{ $total }}
                </span>
            </div>
            <a href="{{ route('citizen.appointments.calendar') }}"
               class="text-xs font-semibold text-brand dark:text-amber-400 hover:underline flex items-center gap-1">
                <span data-i18n="dashboard.manage">Manage</span>
                <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="space-y-3">
            @php
                $apptStatusCfg = [
                    'pending'   => ['border' => 'border-amber-400',   'badge' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',       'dot' => 'status-dot-yellow'],
                    'confirmed' => ['border' => 'border-emerald-400', 'badge' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400', 'dot' => 'status-dot-green'],
                    'completed' => ['border' => 'border-blue-400',    'badge' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',             'dot' => 'status-dot-blue'],
                    'cancelled' => ['border' => 'border-red-400',     'badge' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400',                 'dot' => 'status-dot-red'],
                ];
                $timeLabels = ['09:00' => '9:00 AM', '10:00' => '10:00 AM', '11:00' => '11:00 AM', '12:00' => '12:00 PM', '13:00' => '1:00 PM'];
            @endphp

            @foreach($upcomingAppointments as $index => $appt)
                @php
                    $cfg           = $apptStatusCfg[$appt->status] ?? $apptStatusCfg['pending'];
                    $apptDate      = \Carbon\Carbon::parse($appt->date);
                    $apptMinColor  = $appt->service->ministry->color ?? '#1B4F8A';
                    $apptMinName   = $appt->service->ministry->name  ?? 'Government Service';
                    $apptSvcName   = $appt->service->name            ?? ($appt->document_type ?? 'Appointment');
                    $delay         = 50 + $index * 60;
                @endphp
                <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800
                            ltr:border-l-4 rtl:border-r-4 {{ $cfg['border'] }} hover-lift overflow-hidden animate-fade-up"
                     style="animation-delay: {{ $delay }}ms">
                    <div class="p-4 sm:p-5 flex items-start gap-4">
                        {{-- Date card --}}
                        <div class="shrink-0 w-14 rounded-xl overflow-hidden border dark:border-gray-700 shadow-sm"
                             style="border-color: {{ $apptMinColor }}30;">
                            <div class="px-1 py-1 text-center" style="background: {{ $apptMinColor }};">
                                <p class="text-[10px] font-bold text-white/90 uppercase tracking-wider leading-none">{{ $apptDate->format('M') }}</p>
                            </div>
                            <div class="bg-white dark:bg-[#252525] px-1 py-1.5 text-center">
                                <p class="text-[22px] font-extrabold leading-none font-outfit" style="color: {{ $apptMinColor }};">{{ $apptDate->format('d') }}</p>
                                <p class="text-[10px] font-medium text-gray-400 dark:text-gray-500 mt-0.5">{{ $apptDate->format('D') }}</p>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-2 min-w-0">
                                    <div class="w-2 h-2 rounded-full shrink-0 {{ $cfg['dot'] }}"></div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $apptSvcName }}</p>
                                </div>
                                <span class="shrink-0 px-2.5 py-0.5 text-[11px] font-bold rounded-full capitalize {{ $cfg['badge'] }}">
                                    <span data-i18n="status.{{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 flex-wrap">
                                {{-- Time --}}
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $timeLabels[$appt->time_slot] ?? $appt->time_slot }}
                                </span>
                                {{-- Ministry badge --}}
                                <span class="inline-flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full" style="background: {{ $apptMinColor }};"></span>
                                    <span>{{ $apptMinName }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 sm:px-5 py-2.5 bg-gray-50/50 dark:bg-white/[0.03] border-t border-gray-100 dark:border-gray-800 flex items-center justify-between gap-2">
                        <span class="text-[11px] text-gray-400 dark:text-gray-500 shrink-0">
                            <span data-i18n="dashboard.booked">Booked</span> {{ $appt->created_at->diffForHumans() }}
                        </span>
                        <div class="flex items-center gap-2.5 shrink-0">
                            @if($appt->application)
                                <a href="{{ route('citizen.applications.receipt', $appt->application) }}"
                                   class="text-[11px] font-semibold text-brand dark:text-blue-400 hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span data-i18n="dashboard.receipt">Receipt</span>
                                </a>
                            @endif
                            @if($appt->status === 'pending' || $appt->status === 'confirmed')
                                <form method="POST"
                                      action="{{ route('citizen.appointments.cancel', $appt) }}"
                                      onsubmit="return confirm(window.i18n ? i18n('dashboard.cancel_appointment') : 'Cancel this appointment?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="text-[11px] font-semibold text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        <span data-i18n="common.cancel">Cancel</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
