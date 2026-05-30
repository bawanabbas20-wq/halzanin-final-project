@extends('layouts.halzanin-app')

@section('content')
@php $color = $ministry->color ?? '#1B4F8A'; @endphp

<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="animate-fade-in">
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-2">
            <a href="{{ route('ministry_admin.dashboard') }}" class="hover:text-brand transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Appointment Availability</span>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <h2 class="text-2xl font-bold font-outfit text-gradient">Appointment Availability</h2>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                  style="background:{{ $color }}15; color:{{ $color }}; border:1px solid {{ $color }}30;">
                <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $color }};"></span>
                {{ $ministry->name }}
            </span>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mark dates when your directorate is closed for appointments. Fridays and Saturdays are always off.</p>
    </div>

    {{-- Session feedback --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-sm text-emerald-700 dark:text-emerald-400">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Add Off Day ── --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up">
        <div class="h-1" style="background: {{ $color }};"></div>
        <div class="p-6">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Add a Closure Date</h3>
            <form method="POST" action="{{ route('ministry_admin.off_days.store') }}" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Date <span class="text-red-400">*</span></label>
                    <input type="date" name="date" required min="{{ today()->format('Y-m-d') }}"
                           value="{{ old('date') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#141414] text-gray-900 dark:text-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                    @error('date')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Reason (optional)</label>
                    <input type="text" name="reason" placeholder="e.g. National holiday, maintenance…"
                           value="{{ old('reason') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#141414] text-gray-900 dark:text-gray-100 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                            class="px-5 py-2.5 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all whitespace-nowrap"
                            style="background: {{ $color }};">
                        Add Date
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Off Days List ── --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 80ms">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-5 rounded-full" style="background: {{ $color }};"></div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Scheduled Closures</h3>
            </div>
            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $offDays->count() }} date{{ $offDays->count() !== 1 ? 's' : '' }}</span>
        </div>

        @if($offDays->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                <div class="w-12 h-12 bg-gray-50 dark:bg-[#252525] rounded-2xl flex items-center justify-center mb-3 border border-gray-100 dark:border-slate-700">
                    <svg class="w-6 h-6 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">No closures scheduled</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Your directorate is available all working days.</p>
            </div>
        @else
            <div class="divide-y divide-gray-50 dark:divide-gray-800/60">
                @foreach($offDays as $offDay)
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border" style="border-color: {{ $color }}30;">
                            <div class="py-1 text-center text-[9px] font-bold text-white uppercase" style="background: {{ $color }};">
                                {{ $offDay->date->format('M') }}
                            </div>
                            <div class="py-1 text-center bg-white dark:bg-[#252525]">
                                <p class="text-base font-extrabold font-outfit leading-none" style="color: {{ $color }};">{{ $offDay->date->format('d') }}</p>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $offDay->date->format('l, F j, Y') }}</p>
                            @if($offDay->reason)
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $offDay->reason }}</p>
                            @endif
                        </div>
                        <form method="POST"
                              action="{{ route('ministry_admin.off_days.destroy', $offDay->id) }}"
                              onsubmit="return confirm('Remove this off day?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors shrink-0">
                                Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
