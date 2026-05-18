@extends('layouts.halzanin-app')

@section('content')
@php
    $calStart  = $start->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
    $calEnd    = $start->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SUNDAY);
    $today     = \Carbon\Carbon::today();
    $prevMonth = $start->copy()->subMonth()->format('Y-m');
    $nextMonth = $start->copy()->addMonth()->format('Y-m');
    $totalAppts = $appointments->flatten()->count();
@endphp

<div class="space-y-6 max-w-6xl mx-auto pb-10"
     x-data="{
         open: false,
         selectedDate: '',
         selectedAppts: [],
         selectDay(dateKey, dateLabel) {
             const appts = window._calData[dateKey];
             if (!appts || appts.length === 0) return;
             this.selectedDate = dateLabel;
             this.selectedAppts = appts;
             this.open = true;
         }
     }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
        <div>
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">Appointment Calendar</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                @if($totalAppts > 0)
                    {{ $totalAppts }} appointment{{ $totalAppts === 1 ? '' : 's' }} in {{ $start->format('F Y') }}
                @else
                    {{ $start->format('F Y') }} — no appointments booked
                @endif
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('staff.calendar', ['month' => $prevMonth]) }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-gray-200 dark:border-slate-700 bg-white dark:bg-[#1e293b] text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <span class="text-sm font-bold text-gray-900 dark:text-white min-w-[130px] text-center">
                {{ $start->format('F Y') }}
            </span>
            <a href="{{ route('staff.calendar', ['month' => $nextMonth]) }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-gray-200 dark:border-slate-700 bg-white dark:bg-[#1e293b] text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="{{ route('staff.calendar') }}"
               class="ltr:ml-2 rtl:mr-2 px-4 py-2 text-sm font-semibold text-brand dark:text-indigo-400 bg-brand/10 dark:bg-indigo-900/30 rounded-[8px] hover:bg-brand/20 dark:hover:bg-indigo-900/50 transition-colors">
                Today
            </a>
        </div>
    </div>

    {{-- Calendar Grid --}}
    <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up">

        {{-- Day-of-week header --}}
        <div class="grid grid-cols-7 border-b border-gray-100 dark:border-slate-800 bg-gray-50 dark:bg-slate-800/50">
            @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $i => $dayName)
                <div class="py-3 text-center text-xs font-bold uppercase tracking-wider
                    {{ $i >= 5 ? 'text-indigo-400 dark:text-indigo-500' : 'text-gray-500 dark:text-gray-400' }}">
                    {{ $dayName }}
                </div>
            @endforeach
        </div>

        {{-- Day cells --}}
        <div class="grid grid-cols-7">
            @php $current = $calStart->copy(); @endphp
            @while($current->lte($calEnd))
                @php
                    $dateKey     = $current->format('Y-m-d');
                    $dayAppts    = $appointments[$dateKey] ?? collect();
                    $isToday     = $current->isSameDay($today);
                    $isCurMonth  = $current->month === $start->month;
                    $hasAppts    = $isCurMonth && $dayAppts->isNotEmpty();
                    $dayOfWeek   = $current->dayOfWeekIso; // 1=Mon … 7=Sun
                    $isWeekend   = $dayOfWeek >= 6;
                    $dateLabel   = $current->format('l, F j, Y');
                @endphp

                <div
                    class="min-h-[80px] lg:min-h-[96px] p-1.5 lg:p-2 border-r border-b border-gray-100 dark:border-slate-800
                        {{ $isCurMonth ? 'bg-white dark:bg-[#1e293b]' : 'bg-gray-50/60 dark:bg-slate-800/30' }}
                        {{ $hasAppts ? 'cursor-pointer select-none' : '' }}"
                    @if($hasAppts)
                        x-on:click="selectDay('{{ $dateKey }}', '{{ $dateLabel }}')"
                        x-on:mouseenter="$el.classList.add('bg-indigo-50/40', 'dark:bg-indigo-900/10')"
                        x-on:mouseleave="$el.classList.remove('bg-indigo-50/40', 'dark:bg-indigo-900/10')"
                    @endif
                >
                    {{-- Day number --}}
                    <div class="flex justify-between items-start mb-1">
                        @if($isToday)
                            <span class="w-6 h-6 flex items-center justify-center bg-brand text-white text-xs font-bold rounded-full">
                                {{ $current->day }}
                            </span>
                        @else
                            <span class="text-xs font-{{ $isCurMonth ? 'semibold' : 'normal' }}
                                {{ $isCurMonth ? ($isWeekend ? 'text-indigo-400 dark:text-indigo-500' : 'text-gray-700 dark:text-gray-300') : 'text-gray-300 dark:text-gray-600' }}
                                w-6 h-6 flex items-center justify-center">
                                {{ $current->day }}
                            </span>
                        @endif
                    </div>

                    {{-- Appointment badges --}}
                    @if($hasAppts)
                        <div class="space-y-0.5">
                            @foreach($dayAppts->take(2) as $appt)
                                <div class="text-[10px] font-semibold px-1.5 py-0.5 rounded-[4px]
                                    bg-brand/10 dark:bg-indigo-900/30 text-brand dark:text-indigo-400
                                    truncate leading-[1.4]">
                                    <span class="hidden sm:inline">{{ $appt->time_slot }} · {{ $appt->full_name }}</span>
                                    <span class="sm:hidden">{{ $appt->time_slot }}</span>
                                </div>
                            @endforeach
                            @if($dayAppts->count() > 2)
                                <div class="text-[10px] font-bold text-brand/60 dark:text-indigo-500 px-1">
                                    +{{ $dayAppts->count() - 2 }} more
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @php $current->addDay(); @endphp
            @endwhile
        </div>
    </div>

    {{-- Day detail slide-in panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        style="display:none"
        class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden"
    >
        {{-- Panel header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/50">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white" x-text="selectedDate"></h3>
                <p class="text-xs text-brand dark:text-indigo-400 font-semibold mt-0.5"
                   x-text="selectedAppts.length + (selectedAppts.length === 1 ? ' appointment' : ' appointments')">
                </p>
            </div>
            <button type="button"
                    x-on:click="open = false"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-500 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Appointment list --}}
        <div class="divide-y divide-gray-100 dark:divide-slate-800">
            <template x-for="(appt, idx) in selectedAppts" :key="appt.id">
                <div class="flex items-center justify-between gap-4 px-6 py-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-brand/10 dark:bg-indigo-900/30 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-brand dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate" x-text="appt.full_name"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="appt.document_type"></p>
                        </div>
                    </div>
                    <span class="shrink-0 px-2.5 py-1 text-[11px] font-bold rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400"
                          x-text="appt.time_slot">
                    </span>
                </div>
            </template>
        </div>
    </div>

    {{-- Empty month state --}}
    @if($totalAppts === 0)
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 animate-fade-up">
            <x-empty-state
                type="no-results"
                title="No appointments this month"
                description="No appointments have been booked for {{ $start->format('F Y') }}."
            />
        </div>
    @endif

</div>

<script>
    window._calData = @json($appointments->map(function ($dayAppts) {
        return $dayAppts->map(function ($appt) {
            return [
                'id'            => $appt->id,
                'full_name'     => $appt->full_name,
                'document_type' => $appt->document_type,
                'time_slot'     => $appt->time_slot,
            ];
        })->values()->all();
    })->toArray());
</script>
@endsection
