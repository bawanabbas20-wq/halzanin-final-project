@extends('layouts.halzanin-app')

@section('content')
@php
    $minColor = $ministry?->color ?? '#1B4F8A';
@endphp

<div class="space-y-6 lg:space-y-8 max-w-4xl mx-auto">

    {{-- ── Greeting ── --}}
    <div class="animate-fade-in">
        <div class="flex items-center gap-3 flex-wrap mb-1">
            <h2 class="text-2xl font-bold font-outfit text-gradient">
                <span data-i18n="staff.welcome">Welcome,</span> {{ explode(' ', auth()->user()->name)[0] }}!
            </h2>
            @if($ministry)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                      style="background: {{ $minColor }}15; color: {{ $minColor }}; border: 1px solid {{ $minColor }}30;">
                    <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $minColor }};"></span>
                    {{ $ministry->name }}
                </span>
            @endif
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-sm" data-i18n="staff.dashboard_subtitle">
            Here's the current overview of the application queue.
        </p>
    </div>

    {{-- ── Stats Row ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:gap-5">
        @php
            $statItems = [
                [
                    'label'   => 'Total',
                    'value'   => $stats['total'],
                    'delay'   => 0,
                    'icon_bg' => 'bg-brand/5 dark:bg-brand/10',
                    'icon_c'  => 'text-brand dark:text-blue-400',
                    'ring'    => 'ring-brand/10 dark:ring-brand/20',
                    'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                ],
                [
                    'label'   => 'Pending',
                    'value'   => $stats['pending'],
                    'delay'   => 80,
                    'icon_bg' => 'bg-amber-50 dark:bg-amber-900/20',
                    'icon_c'  => 'text-amber-500 dark:text-amber-400',
                    'ring'    => 'ring-amber-100 dark:ring-amber-900/30',
                    'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ],
                [
                    'label'   => 'Reviewing',
                    'value'   => $stats['reviewing'],
                    'delay'   => 160,
                    'icon_bg' => 'bg-blue-50 dark:bg-blue-900/30',
                    'icon_c'  => 'text-blue-500 dark:text-blue-400',
                    'ring'    => 'ring-blue-100 dark:ring-blue-900/30',
                    'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>',
                ],
                [
                    'label'   => 'Completed',
                    'value'   => $stats['completed'],
                    'delay'   => 240,
                    'icon_bg' => 'bg-emerald-50 dark:bg-emerald-900/30',
                    'icon_c'  => 'text-emerald-500 dark:text-emerald-400',
                    'ring'    => 'ring-emerald-100 dark:ring-emerald-900/30',
                    'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ],
            ];
        @endphp

        @foreach($statItems as $s)
            <div class="bg-white dark:bg-[#1F1F1F] rounded-xl p-4 lg:p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift animate-fade-up"
                 style="animation-delay: {{ $s['delay'] }}ms">
                <div class="w-9 h-9 rounded-full ring-4 {{ $s['ring'] }} {{ $s['icon_bg'] }} {{ $s['icon_c'] }} flex items-center justify-center mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $s['icon'] !!}</svg>
                </div>
                <p class="text-2xl font-extrabold text-brand dark:text-white font-outfit">{{ number_format($s['value']) }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-medium" data-i18n="{{ $s['label'] }}">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ── Queue CTA ── --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up"
         style="animation-delay: 320ms">
        <div class="h-1.5" style="background: {{ $minColor }};"></div>

        <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0"
                 style="background: {{ $minColor }}10; border: 1px solid {{ $minColor }}20;">
                <svg class="w-7 h-7" fill="none" stroke="{{ $minColor }}" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1" data-i18n="staff.application_queue">Application Queue</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed" data-i18n="staff.queue_desc_short">
                    Review, process, and update the status of submitted citizen applications.
                </p>
                @if($stats['pending'] > 0)
                    <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold"
                         style="color: {{ $minColor }};">
                        <div class="w-1.5 h-1.5 rounded-full pulse-dot" style="background: {{ $minColor }};"></div>
                        {{ $stats['pending'] }} <span data-i18n="{{ $stats['pending'] !== 1 ? 'admin.applications' : 'admin.application' }}">application{{ $stats['pending'] !== 1 ? 's' : '' }}</span> <span data-i18n="staff.awaiting_review">awaiting review</span>
                    </div>
                @endif
            </div>
            <a href="{{ route('staff.queue') }}"
               class="shrink-0 inline-flex items-center gap-2 px-6 py-3 text-white rounded-xl font-semibold font-outfit shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm"
               style="background: {{ $minColor }};">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span data-i18n="staff.view_queue">View Queue</span>
            </a>
        </div>
    </div>

    {{-- ── Quick Links ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 animate-fade-up" style="animation-delay: 400ms">
        <a href="{{ route('staff.calendar') }}"
           class="group bg-white dark:bg-[#1F1F1F] rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift flex items-center gap-4"
           style="border-top: 2px solid {{ $minColor }}20;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform"
                 style="background: {{ $minColor }}12; color: {{ $minColor }};">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900 dark:text-white text-sm" data-i18n="staff.appointment_calendar">Appointments Calendar</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5" data-i18n="staff.calendar_subtitle">View day-by-day schedule</p>
            </div>
            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 ltr:ml-auto rtl:mr-auto rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="group bg-white dark:bg-[#1F1F1F] rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift flex items-center gap-4">
            <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center text-purple-500 dark:text-purple-400 shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900 dark:text-white text-sm" data-i18n="staff.profile_title">My Profile</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5" data-i18n="staff.profile_subtitle">Update your account details</p>
            </div>
            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 ltr:ml-auto rtl:mr-auto rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

</div>
@endsection
