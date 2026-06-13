@extends('layouts.halzanin-app')

@section('content')
    @php
        // Shared status -> colour mapping. Handles every per-service status
        // (not just the old fixed set) by grouping them: final/positive = green,
        // rejected = red, submitted = grey, early-review = blue, anything else
        // in-progress = amber.
        $statusColor = function (string $status): array {
            $s = strtolower($status);
            if (in_array($s, ['completed', 'collected', 'connected', 'approved', 'license_ready', 'ready_for_pickup', 'theory_test_passed'])) {
                return ['border' => 'border-green-400', 'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400', 'dot' => 'status-dot-green'];
            }
            if (str_contains($s, 'reject')) {
                return ['border' => 'border-red-400', 'badge' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400', 'dot' => 'status-dot-red'];
            }
            if ($s === 'submitted') {
                return ['border' => 'border-gray-400', 'badge' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300', 'dot' => 'status-dot-gray'];
            }
            if (in_array($s, ['received', 'documents_verified', 'documents_reviewed', 'checked_in', 'name_availability_check'])) {
                return ['border' => 'border-blue-400', 'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400', 'dot' => 'status-dot-blue'];
            }
            return ['border' => 'border-yellow-400', 'badge' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400', 'dot' => 'status-dot-yellow'];
        };
    @endphp
    <div class="space-y-6 max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 animate-fade-in">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="staff.workspace_title">Applications</h2>
                    <span class="px-3 py-1 bg-brand/10 dark:bg-brand/10 text-brand dark:text-blue-400 text-sm font-bold rounded-full">
                        {{ $applications->total() }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="staff.workspace_subtitle">Review applications as a queue or by appointment date.</p>
            </div>
            <div class="inline-flex items-center gap-1 rounded-2xl bg-white dark:bg-[#252525] border border-gray-200 dark:border-gray-700 p-1 shadow-sm w-full sm:w-auto">
                <button type="button"
                        data-view-toggle="queue"
                        aria-pressed="{{ $viewMode === 'queue' ? 'true' : 'false' }}"
                        class="view-toggle flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ $viewMode === 'queue' ? 'bg-brand text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#2E2E2E]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span data-i18n="staff.queue_view">Queue View</span>
                </button>
                <button type="button"
                        data-view-toggle="calendar"
                        aria-pressed="{{ $viewMode === 'calendar' ? 'true' : 'false' }}"
                        class="view-toggle flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ $viewMode === 'calendar' ? 'bg-brand text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#2E2E2E]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span data-i18n="staff.calendar_view">Calendar View</span>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl animate-fade-in flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter & Search Bar --}}
        <div id="queueFilters" class="{{ $viewMode === 'calendar' ? 'hidden' : '' }} bg-white dark:bg-[#1F1F1F] p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up flex flex-col xl:flex-row gap-4" style="animation-delay: 100ms">
            {{-- Search --}}
            <div class="relative w-full xl:w-80 shrink-0">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 ltr:pl-3.5 rtl:pr-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput"
                       placeholder="Search by name or tracking code..."
                       data-i18n-placeholder="Search by name or tracking code..."
                       class="block w-full h-[42px] ltr:pl-10 rtl:pr-10 rtl:pl-3 ltr:pr-3 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 text-sm transition-colors">
            </div>

            {{-- Filter Chips --}}
            <div class="flex gap-2 items-center overflow-x-auto pb-0.5 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden [&>button]:shrink-0" id="filterChips">
                <button data-filter="all"
                        class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-brand text-white border border-brand shadow-sm"
                        data-i18n="All">All</button>
                {{-- Chips are built dynamically from the real per-service status flows
                     so the queue filters always match the statuses applications can have. --}}
                @foreach ($statusFilters as $key => $label)
                <button data-filter="{{ $key }}"
                        class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-[#252525] text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#2E2E2E]"
                        data-i18n="status.{{ $key }}">{{ $label }}</button>
                @endforeach
            </div>
        </div>

        {{-- Application List --}}
        <div id="queueView" class="{{ $viewMode === 'calendar' ? 'hidden' : '' }} animate-fade-up" style="animation-delay: 200ms">

            {{-- MOBILE VIEW: Cards --}}
            <div class="block lg:hidden space-y-3" id="mobileList">
                @forelse ($applications as $app)
                    @php
                        $color   = $statusColor($app->current_status);
                        $appName = $app->appointment->full_name ?? $app->user->name;
                    @endphp
                    <div class="app-item bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden ltr:border-l-4 rtl:border-r-4 {{ $color['border'] }} hover-lift"
                         data-status="{{ $app->current_status }}"
                         data-search="{{ strtolower($appName . ' ' . $app->tracking_code) }}">
                        <div class="p-4 sm:p-5">
                            <div class="flex justify-between items-start mb-2.5">
                                <div class="flex items-center gap-2 min-w-0">
                                    <div class="w-2 h-2 rounded-full shrink-0 {{ $color['dot'] }}"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $appName }}</h3>
                                </div>
                                <span class="shrink-0 px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $color['badge'] }} ltr:ml-2 rtl:mr-2" data-i18n="status.{{ $app->current_status }}">
                                    {{ str_replace('_', ' ', $app->current_status) }}
                                </span>
                            </div>
                            <div class="mb-3 flex flex-col space-y-1">
                                <span class="font-mono font-bold text-brand dark:text-blue-400 text-sm tracking-tight">{{ $app->tracking_code }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $app->appointment->document_type ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-800">
                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : '—' }}
                                </span>
                                <a href="{{ route('staff.applications.show', $app->id) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-semibold rounded-xl border border-brand text-brand dark:border-blue-400 dark:text-blue-400 hover:bg-brand/5 transition-colors"
                                   data-i18n="View">
                                    View
                                    <svg class="w-3 h-3 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 empty-msg">
                        <x-empty-state
                            type="no-results"
                            title="No applications found"
                            description="Try adjusting your search or filter to find what you're looking for."
                            titleKey="staff.no_applications"
                            descriptionKey="staff.no_applications_desc"
                        />
                    </div>
                @endforelse
            </div>

            {{-- DESKTOP VIEW: Table --}}
            <div class="hidden lg:block bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden" id="desktopList">
                <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                    <table class="w-full min-w-[1040px] text-left border-collapse">
                        <thead class="sticky top-0 bg-gray-50 dark:bg-[#252525] z-10 border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Applicant Name">Applicant Name</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Tracking Code">Tracking Code</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Document Type">Document Type</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Preferred Date">Preferred Date</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Status">Status</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Submitted">Submitted</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ltr:text-right rtl:text-left" data-i18n="Actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse ($applications as $index => $app)
                                @php
                                    $color   = $statusColor($app->current_status);
                                    $appName = $app->appointment->full_name ?? $app->user->name;
                                @endphp
                                <tr class="app-item hover:bg-gray-50/70 dark:hover:bg-white/[0.04] transition-colors"
                                    data-status="{{ $app->current_status }}"
                                    data-search="{{ strtolower($appName . ' ' . $app->tracking_code) }}">
                                    <td class="px-6 py-4 text-sm text-gray-400 dark:text-gray-500 font-mono">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 rounded-full shrink-0 {{ $color['dot'] }}"></div>
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $appName }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-mono font-bold text-brand dark:text-blue-400">{{ $app->tracking_code }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $app->appointment->document_type ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $app->appointment ? \Carbon\Carbon::parse($app->appointment->date)->format('M d, Y') : '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 inline-flex text-[11px] font-bold rounded-full capitalize {{ $color['badge'] }}" data-i18n="status.{{ $app->current_status }}">
                                            {{ str_replace('_', ' ', $app->current_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : '—' }}
                                    </td>
                                    <td class="px-6 py-4 ltr:text-right rtl:text-left">
                                        <a href="{{ route('staff.applications.show', $app->id) }}"
                                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold rounded-xl bg-brand text-white hover:bg-brand-light transition-colors shadow-sm"
                                           data-i18n="View">
                                            View
                                            <svg class="w-3 h-3 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-msg">
                                        <x-empty-state
                                            type="no-results"
                                            title="No applications found"
                                            description="Try adjusting your search or filter."
                                            titleKey="staff.no_applications"
                                            descriptionKey="staff.no_applications_desc"
                                        />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $applications->links() }}
            </div>

        </div>

        <div id="calendarView" class="{{ $viewMode === 'queue' ? 'hidden' : '' }} animate-fade-up" style="animation-delay: 100ms">
            @php
                $prevMonth = $current->copy()->subMonth();
                $nextMonth = $current->copy()->addMonth();
                $startOfMonth = $current->copy()->startOfMonth();
                $endOfMonth = $current->copy()->endOfMonth();
                $today = now()->toDateString();
                $startPad = $startOfMonth->dayOfWeek;
                $totalDays = $endOfMonth->day;
                $maxSlots = 5;
            @endphp

            <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1fr)_380px] gap-6">
                <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                    <div class="h-1 bg-gradient-to-r from-brand via-emerald-500 to-amber-500"></div>
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center justify-between mb-6">
                            <a href="{{ route('staff.queue', ['view' => 'calendar', 'year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
                               class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-[#2E2E2E] text-gray-600 dark:text-gray-400 transition"
                               aria-label="Previous month">
                                <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">{{ $current->format('F Y') }}</h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5" data-i18n="staff.calendar_hint">Select a day to review appointments</p>
                            </div>
                            <a href="{{ route('staff.queue', ['view' => 'calendar', 'year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
                               class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-[#2E2E2E] text-gray-600 dark:text-gray-400 transition"
                               aria-label="Next month">
                                <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-7 gap-2 mb-2">
                            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                                <div class="text-center text-xs font-bold py-1 {{ in_array($day, ['Fri','Sat']) ? 'text-gray-300 dark:text-gray-600' : 'text-gray-500 dark:text-gray-400' }}" data-i18n="{{ $day }}">{{ $day }}</div>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-7 gap-2" id="calendar-grid">
                            @for($i = 0; $i < $startPad; $i++)
                                <div></div>
                            @endfor

                            @for($day = 1; $day <= $totalDays; $day++)
                                @php
                                    $dateStr = $current->format('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                    $dayOfWeek = date('N', strtotime($dateStr));
                                    $isWeekend = in_array($dayOfWeek, [5, 6]);
                                    $isOffDay = $isWeekend || in_array($dateStr, $offDates);
                                    $isToday = $dateStr === $today;
                                    $booked = $counts[$dateStr] ?? 0;
                                    $isFull = $booked >= $maxSlots;

                                    if ($isOffDay) {
                                        $cellCls = 'text-gray-300 dark:text-gray-600 cursor-default';
                                        $dotCls  = '';
                                        $cntCls  = '';
                                    } else {
                                        $cellCls = 'text-gray-800 dark:text-gray-200 hover:bg-brand/5 dark:hover:bg-brand/10 cursor-pointer';
                                        if ($isFull)          { $dotCls = 'bg-red-500';    $cntCls = 'text-red-500 dark:text-red-400'; }
                                        elseif ($booked >= 3) { $dotCls = 'bg-orange-400'; $cntCls = 'text-orange-500 dark:text-orange-400'; }
                                        elseif ($booked >= 1) { $dotCls = 'bg-yellow-400'; $cntCls = 'text-yellow-600 dark:text-yellow-400'; }
                                        else                  { $dotCls = 'bg-emerald-400'; $cntCls = ''; }
                                    }
                                    $todayCls = $isToday ? ($isOffDay ? 'ring-1 ring-inset ring-brand/30' : 'ring-2 ring-inset ring-brand dark:ring-amber-400 bg-brand/10 dark:bg-amber-900/20') : '';
                                @endphp

                                <button type="button"
                                        class="calendar-day flex flex-col items-center justify-center py-1.5 min-h-[52px] rounded-xl transition-colors select-none {{ $cellCls }} {{ $todayCls }}"
                                        data-date="{{ $dateStr }}"
                                        data-off="{{ $isOffDay ? '1' : '0' }}"
                                        @if(!$isOffDay) onclick="selectDay(this)" @else disabled @endif>
                                    <span class="text-sm font-bold leading-none">{{ $day }}</span>
                                    @if(!$isOffDay)
                                        <div class="mt-1 w-1.5 h-1.5 rounded-full {{ $dotCls }}"></div>
                                        @if($booked > 0)
                                            <span class="text-[9px] font-bold mt-0.5 leading-none {{ $cntCls }}">{{ $booked }}</span>
                                        @endif
                                    @endif
                                </button>
                            @endfor
                        </div>

                        <div class="mt-5 flex flex-wrap gap-3 text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-emerald-500 inline-block"></span> <span data-i18n="cal.open">Open</span></div>
                            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-yellow-400 inline-block"></span> <span data-i18n="cal.filling">Filling</span></div>
                            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-orange-500 inline-block"></span> <span data-i18n="cal.almost">Almost full</span></div>
                            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-red-500 inline-block"></span> <span data-i18n="cal.full">Full</span></div>
                            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-gray-300 dark:bg-[#4A4A4A] inline-block"></span> <span data-i18n="cal.off">Off day</span></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden min-h-[360px]">
                    <div class="h-1 bg-gradient-to-r from-amber-400 via-purple-500 to-brand"></div>
                    <div class="p-5 sm:p-6">
                        <div id="panel-empty" class="text-center py-16 text-gray-400 dark:text-gray-500">
                            <div class="w-14 h-14 bg-gray-100 dark:bg-[#252525] rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm" data-i18n="cal.click_day">Click a day to see appointments</p>
                        </div>

                        <div id="panel-content" class="hidden">
                            <div class="flex items-center justify-between mb-4">
                                <h3 id="panel-date" class="text-base font-bold text-gray-900 dark:text-white"></h3>
                                <span id="panel-count" class="text-xs bg-brand/10 dark:bg-amber-900/30 text-brand dark:text-amber-400 px-2.5 py-0.5 rounded-full font-semibold"></span>
                            </div>

                            <div id="panel-loading" class="text-center py-6 hidden">
                                <div class="inline-block w-6 h-6 border-2 border-brand border-t-transparent rounded-full animate-spin"></div>
                            </div>

                            <div id="panel-list" class="space-y-3"></div>
                            <div id="panel-none" class="hidden text-center py-6 text-gray-400 dark:text-gray-500 text-sm" data-i18n="cal.no_appointments">No appointments for this day.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dayUrl = "{{ route('staff.appointments.day') }}";
        const statusUrl = "{{ url('/staff/appointments') }}";
        const uiLang = () => document.documentElement.lang === 'ku' ? 'ku' : 'en';
        const tr = (key, replacements = {}) => window.i18n ? i18n(key, replacements, uiLang()) : key;
        const trDoc = (label) => window.i18nDocument ? i18nDocument(label, {}, uiLang()) : label;

        const appointmentStatusLabels = {
            pending: { key: 'status.pending', cls: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' },
            confirmed: { key: 'status.confirmed', cls: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' },
            completed: { key: 'status.completed', cls: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' },
            cancelled: { key: 'status.cancelled', cls: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' },
        };

        const timeLabels = {
            '09:00': '9:00 AM',
            '10:00': '10:00 AM',
            '11:00': '11:00 AM',
            '12:00': '12:00 PM',
            '13:00': '1:00 PM',
        };

        let activeDay = null;

        async function selectDay(el) {
            const date = el.dataset.date;

            document.querySelectorAll('.calendar-day').forEach((day) => day.classList.remove('ring-2', 'ring-brand', 'ring-offset-1'));
            el.classList.add('ring-2', 'ring-brand', 'ring-offset-1');

            document.getElementById('panel-empty')?.classList.add('hidden');
            document.getElementById('panel-content')?.classList.remove('hidden');
            document.getElementById('panel-loading')?.classList.remove('hidden');
            document.getElementById('panel-none')?.classList.add('hidden');
            const list = document.getElementById('panel-list');
            if (list) list.innerHTML = '';

            const selectedDate = new Date(date + 'T00:00:00');
            const dateLabel = document.getElementById('panel-date');
            if (dateLabel) {
                dateLabel.textContent = selectedDate.toLocaleDateString(uiLang() === 'ku' ? 'ckb-IQ' : 'en-US', {
                    weekday: 'long',
                    month: 'long',
                    day: 'numeric',
                });
            }

            activeDay = date;

            try {
                const res = await fetch(dayUrl + '?date=' + date);
                const data = await res.json();
                document.getElementById('panel-loading')?.classList.add('hidden');
                renderAppointments(data.appointments || []);
            } catch (e) {
                document.getElementById('panel-loading')?.classList.add('hidden');
            }
        }

        function renderAppointments(appointments) {
            const list = document.getElementById('panel-list');
            const countEl = document.getElementById('panel-count');
            if (!list || !countEl) return;

            countEl.textContent = tr(appointments.length === 1 ? 'cal.appointment_count' : 'cal.appointment_count_plural', { count: appointments.length });

            if (!appointments.length) {
                document.getElementById('panel-none')?.classList.remove('hidden');
                return;
            }

            list.innerHTML = '';
            appointments.forEach((appt) => {
                const status = appointmentStatusLabels[appt.status] || { key: appt.status, cls: 'bg-gray-100 dark:bg-[#2E2E2E] text-gray-600 dark:text-gray-300' };
                const card = document.createElement('div');
                card.className = 'border border-gray-100 dark:border-[#2E2E2E] rounded-xl p-3 hover:border-brand/30 dark:hover:border-indigo-500/30 transition-colors';

                const documents = appt.documents && appt.documents.length ? `
                    <div class="mt-2 pt-2 border-t border-gray-100 dark:border-[#2E2E2E]">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">${tr('staff.documents')}</p>
                        <div class="flex flex-wrap gap-1.5">
                            ${appt.documents.map((doc) => {
                                if (doc.source === 'upload') {
                                    return `<a href="/staff/documents/${doc.id}/file" target="_blank" class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium hover:bg-blue-200 dark:hover:bg-blue-900/50">${doc.name} - ${tr('common.view')}</a>`;
                                }
                                return `<span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 font-medium">${doc.name} - ${tr(doc.source === 'vault' ? 'staff.vault' : 'staff.bringing')}</span>`;
                            }).join('')}
                        </div>
                    </div>` : '';

                card.innerHTML = `
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div>
                            <p class="text-sm font-bold text-gray-800 dark:text-white">${timeLabels[appt.time_slot] || appt.time_slot}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">${appt.full_name || appt.citizen}</p>
                            ${appt.document_type ? `<p class="text-xs text-amber-600 dark:text-amber-400 font-medium mt-0.5">${trDoc(appt.document_type)}</p>` : ''}
                            ${appt.notes ? `<p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 italic">${appt.notes}</p>` : ''}
                        </div>
                        <span class="text-[10px] px-2.5 py-0.5 rounded-full font-bold ${status.cls}">${tr(status.key)}</span>
                    </div>
                    <div class="flex gap-1.5 flex-wrap">${buildStatusButtons(appt.id, appt.status)}</div>
                    ${documents}
                `;
                list.appendChild(card);
            });
        }

        function buildStatusButtons(id, current) {
            return [
                { status: 'confirmed', label: tr('staff.confirm'), color: 'bg-emerald-500 hover:bg-emerald-600' },
                { status: 'completed', label: tr('staff.complete'), color: 'bg-blue-500 hover:bg-blue-600' },
                { status: 'cancelled', label: tr('common.cancel'), color: 'bg-red-500 hover:bg-red-600' },
            ].filter((action) => action.status !== current).map((action) => (
                `<button type="button" onclick="updateStatus(${id}, '${action.status}')" class="text-xs text-white px-3 py-1 rounded-lg ${action.color} font-semibold transition">${action.label}</button>`
            )).join('');
        }

        async function updateStatus(id, status) {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const res = await fetch(`${statusUrl}/${id}/status`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ status }),
            });
            const data = await res.json();
            if (data.success) {
                const activeEl = document.querySelector('.calendar-day[data-date="' + activeDay + '"]');
                if (activeEl) selectDay(activeEl);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const viewToggles = document.querySelectorAll('[data-view-toggle]');
            const queueFilters = document.getElementById('queueFilters');
            const queueView = document.getElementById('queueView');
            const calendarView = document.getElementById('calendarView');
            const activeToggleClass = 'bg-brand text-white shadow-sm';
            const inactiveToggleClass = 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#2E2E2E]';

            function setWorkspaceView(view) {
                const showCalendar = view === 'calendar';
                queueFilters?.classList.toggle('hidden', showCalendar);
                queueView?.classList.toggle('hidden', showCalendar);
                calendarView?.classList.toggle('hidden', !showCalendar);

                viewToggles.forEach((button) => {
                    const active = button.dataset.viewToggle === view;
                    button.setAttribute('aria-pressed', active ? 'true' : 'false');
                    button.classList.remove(...activeToggleClass.split(' '), ...inactiveToggleClass.split(' '));
                    button.classList.add(...(active ? activeToggleClass : inactiveToggleClass).split(' '));
                });

                const url = new URL(window.location.href);
                if (showCalendar) {
                    url.searchParams.set('view', 'calendar');
                } else {
                    url.searchParams.delete('view');
                }
                window.history.replaceState({}, '', url.toString());
            }

            viewToggles.forEach((button) => {
                button.addEventListener('click', () => setWorkspaceView(button.dataset.viewToggle));
            });

            const searchInput = document.getElementById('searchInput');
            const filterBtns  = document.querySelectorAll('.filter-btn');
            const appItems    = document.querySelectorAll('.app-item');

            let currentFilter = 'all';
            let currentSearch = '';

            function applyFilters() {
                appItems.forEach(item => {
                    const status     = item.getAttribute('data-status');
                    const searchData = item.getAttribute('data-search');
                    const matchesFilter = currentFilter === 'all' || status === currentFilter;
                    const matchesSearch = currentSearch === '' || searchData.includes(currentSearch);
                    item.style.display = (matchesFilter && matchesSearch) ? '' : 'none';
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    currentSearch = e.target.value.toLowerCase().trim();
                    applyFilters();
                });
            }

            filterBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    filterBtns.forEach(b => {
                        b.className = 'filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-[#252525] text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#2E2E2E]';
                    });
                    e.target.className = 'filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-brand text-white border border-brand shadow-sm';
                    currentFilter = e.target.getAttribute('data-filter');
                    applyFilters();
                });
            });
        });
    </script>
@endsection
