@extends('layouts.halzanin-app')

@section('content')
@php $color = $ministry->color ?? '#1B4F8A'; @endphp

<div class="space-y-6 lg:space-y-8 max-w-4xl mx-auto">

    {{-- ── Greeting ── --}}
    <div class="animate-fade-in">
        <div class="flex items-center gap-3 flex-wrap mb-1">
            <h2 class="text-2xl font-bold font-outfit text-gradient">
                Welcome, {{ explode(' ', auth()->user()->name)[0] }}!
            </h2>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                  style="background:{{ $color }}15; color:{{ $color }}; border:1px solid {{ $color }}30;">
                <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $color }};"></span>
                {{ $ministry->name }} — Ministry Admin
            </span>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Manage your ministry's staff and appointment availability.</p>
    </div>

    {{-- ── Stats ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:gap-5">
        @php
            $statItems = [
                ['label' => 'Staff',        'value' => $stats['staff'],   'delay' =>   0, 'icon_bg' => 'bg-purple-50 dark:bg-purple-900/20',  'icon_c' => 'text-purple-600 dark:text-purple-400', 'ring' => 'ring-purple-100 dark:ring-purple-900/30', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                ['label' => 'Total Apps',   'value' => $stats['total'],   'delay' =>  80, 'icon_bg' => 'bg-blue-50 dark:bg-blue-900/20',      'icon_c' => 'text-blue-600 dark:text-blue-400',    'ring' => 'ring-blue-100 dark:ring-blue-900/30',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                ['label' => 'Pending',      'value' => $stats['pending'], 'delay' => 160, 'icon_bg' => 'bg-amber-50 dark:bg-amber-900/20',    'icon_c' => 'text-amber-500 dark:text-amber-400',  'ring' => 'ring-amber-100 dark:ring-amber-900/30',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                ['label' => "Today's Apps", 'value' => $stats['today'],   'delay' => 240, 'icon_bg' => 'bg-emerald-50 dark:bg-emerald-900/20','icon_c' => 'text-emerald-600 dark:text-emerald-400','ring' => 'ring-emerald-100 dark:ring-emerald-900/30','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
            ];
        @endphp

        @foreach($statItems as $s)
            <div class="bg-white dark:bg-[#1F1F1F] rounded-xl p-4 lg:p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift animate-fade-up"
                 style="animation-delay: {{ $s['delay'] }}ms">
                <div class="w-9 h-9 rounded-full ring-4 {{ $s['ring'] }} {{ $s['icon_bg'] }} {{ $s['icon_c'] }} flex items-center justify-center mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $s['icon'] !!}</svg>
                </div>
                <p class="text-2xl font-extrabold text-brand dark:text-white font-outfit">{{ number_format($s['value']) }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-medium">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ── Quick Links ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 animate-fade-up" style="animation-delay: 320ms">
        <a href="{{ route('ministry_admin.users') }}"
           class="group bg-white dark:bg-[#1F1F1F] rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift flex items-center gap-4"
           style="border-top: 2px solid {{ $color }}30;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform"
                 style="background: {{ $color }}12; color: {{ $color }};">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Manage Staff</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Add staff, assign permissions</p>
            </div>
            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 ltr:ml-auto rtl:mr-auto rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>

        <a href="{{ route('ministry_admin.off_days') }}"
           class="group bg-white dark:bg-[#1F1F1F] rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift flex items-center gap-4">
            <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-500 dark:text-amber-400 shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Appointment Availability</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Set off-days for your directorate</p>
            </div>
            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 ltr:ml-auto rtl:mr-auto rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    {{-- ── Recent Applications ── --}}
    @if($recentApplications->isNotEmpty())
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 400ms">
        <div class="h-1" style="background: {{ $color }};"></div>
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Recent Applications</h3>
            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $ministry->name }}</span>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-800/60">
            @foreach($recentApplications as $app)
                <div class="px-6 py-3.5 flex items-center gap-4">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                         style="background: {{ $color }};">
                        {{ mb_substr($app->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $app->user->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $app->service->name ?? '—' }}</p>
                    </div>
                    <span class="shrink-0 px-2.5 py-1 text-[11px] font-bold rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 capitalize">
                        {{ str_replace('_', ' ', $app->current_status) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
