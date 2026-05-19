@extends('layouts.halzanin-app')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    <!-- Header & View Toggle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <h2 id="view-title" class="text-2xl font-bold text-brand dark:text-white font-outfit">Application Queue</h2>
            <span id="queue-count" class="px-3 py-1 bg-brand/10 dark:bg-indigo-900/30 text-brand dark:text-indigo-400 text-sm font-bold rounded-full">
                {{ $applications->total() }}
            </span>
        </div>

        <!-- Toggle Switcher -->
        <div class="flex items-center bg-white dark:bg-[#1e293b] border border-gray-200 dark:border-gray-700 rounded-[10px] p-1 shadow-sm self-start sm:self-auto">
            <button id="btn-list" onclick="switchView('list')"
                    class="view-toggle-btn flex items-center gap-2 px-4 py-2 rounded-[8px] text-sm font-semibold transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                <span class="hidden sm:inline">List</span>
            </button>
            <button id="btn-calendar" onclick="switchView('calendar')"
                    class="view-toggle-btn flex items-center gap-2 px-4 py-2 rounded-[8px] text-sm font-semibold transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="hidden sm:inline">Calendar</span>
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-[10px] animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    <!-- ══════════════════════════════════════════ -->
    <!-- LIST VIEW                                  -->
    <!-- ══════════════════════════════════════════ -->
    <div id="view-list" class="view-panel space-y-5">

        <!-- Filter & Search Bar -->
        <div class="bg-white dark:bg-[#1e293b] p-4 rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up flex flex-col xl:flex-row gap-4" style="animation-delay: 100ms">
            <div class="relative w-full xl:w-80 shrink-0">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="searchInput" placeholder="Search by name or tracking code..."
                       class="block w-full h-[42px] ltr:pl-10 rtl:pr-10 rtl:pl-3 ltr:pr-3 rounded-[8px] border-gray-200 dark:border-gray-700 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 text-sm transition-colors">
            </div>

            <div class="flex flex-wrap gap-2 items-center" id="filterChips">
                <button data-filter="all" class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-brand text-white border border-brand">All</button>
                <button data-filter="submitted" class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700">Submitted</button>
                <button data-filter="received" class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700">Received</button>
                <button data-filter="under_review" class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700">Under Review</button>
                <button data-filter="approved" class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700">Approved</button>
                <button data-filter="rejected" class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700">Rejected</button>
            </div>
        </div>

        <!-- Application List Wrapper -->
        <div class="animate-fade-up" style="animation-delay: 200ms">

            <!-- MOBILE VIEW: Cards -->
            <div class="block lg:hidden space-y-4" id="mobileList">
                @forelse ($applications as $app)
                    @php
                        $colors = [
                            'submitted'    => ['border' => 'border-gray-400',   'badge' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300'],
                            'received'     => ['border' => 'border-blue-400',   'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'],
                            'under_review' => ['border' => 'border-yellow-400', 'badge' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'],
                            'approved'     => ['border' => 'border-green-400',  'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'],
                            'rejected'     => ['border' => 'border-red-400',    'badge' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'],
                        ];
                        $color = $colors[$app->current_status] ?? $colors['submitted'];
                        $appName = $app->appointment->full_name ?? $app->user->name;
                    @endphp
                    <div class="app-item bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden ltr:border-l-4 rtl:border-r-4 {{ $color['border'] }}" data-status="{{ $app->current_status }}" data-search="{{ strtolower($appName . ' ' . $app->tracking_code) }}">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-gray-900 dark:text-white truncate ltr:pr-2 rtl:pl-2">{{ $appName }}</h3>
                                <span class="shrink-0 px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $color['badge'] }}">
                                    {{ str_replace('_', ' ', $app->current_status) }}
                                </span>
                            </div>
                            <div class="mb-4 flex flex-col space-y-1">
                                <span class="font-mono font-bold text-brand dark:text-indigo-400 text-sm tracking-tight">{{ $app->tracking_code }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $app->appointment->document_type ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : '—' }}
                                </span>
                                <a href="{{ route('staff.applications.show', $app->id) }}" class="px-4 py-1.5 text-xs font-semibold rounded-[8px] border border-brand text-brand dark:border-indigo-400 dark:text-indigo-400 hover:bg-brand/5 transition-colors">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 empty-msg">
                        <x-empty-state
                            type="no-results"
                            title="No applications found"
                            description="Try adjusting your search or filter to find what you're looking for."
                        />
                    </div>
                @endforelse
            </div>

            <!-- DESKTOP VIEW: Table -->
            <div class="hidden lg:block bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden" id="desktopList">
                <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-gray-50 dark:bg-slate-800 z-10 shadow-sm">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Applicant Name</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tracking Code</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Document Type</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Preferred Date</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse ($applications as $index => $app)
                                @php
                                    $colors = [
                                        'submitted'    => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                        'received'     => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'under_review' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'approved'     => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        'rejected'     => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                    ];
                                    $badge = $colors[$app->current_status] ?? $colors['submitted'];
                                    $appName = $app->appointment->full_name ?? $app->user->name;
                                @endphp
                                <tr class="app-item hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors {{ $index % 2 === 0 ? 'bg-white dark:bg-[#1e293b]' : 'bg-[#f8fafc] dark:bg-slate-800/20' }}"
                                    data-status="{{ $app->current_status }}" data-search="{{ strtolower($appName . ' ' . $app->tracking_code) }}">
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">{{ $appName }}</td>
                                    <td class="px-6 py-4 text-sm font-mono font-bold text-brand dark:text-indigo-400">{{ $app->tracking_code }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $app->appointment->document_type ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $app->appointment ? \Carbon\Carbon::parse($app->appointment->date)->format('M d, Y') : '—' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 inline-flex text-[11px] font-bold rounded-full capitalize {{ $badge }}">
                                            {{ str_replace('_', ' ', $app->current_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : '—' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('staff.applications.show', $app->id) }}" class="inline-flex px-3 py-1.5 text-xs font-semibold rounded-[8px] bg-brand text-white hover:bg-brand-light transition-colors shadow-sm">
                                            View
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
                                        />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $applications->links() }}
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!-- CALENDAR VIEW                              -->
    <!-- ══════════════════════════════════════════ -->
    <div id="view-calendar" class="view-panel hidden">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <!-- Calendar Card -->
            <div class="xl:col-span-2 bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-6">

                <!-- Month Navigation -->
                <div class="flex items-center justify-between mb-6">
                    <button id="cal-prev" class="p-2 rounded-[10px] hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-600 dark:text-gray-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <h3 id="cal-month-label" class="text-lg font-bold text-gray-900 dark:text-white font-outfit"></h3>
                    <button id="cal-next" class="p-2 rounded-[10px] hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-600 dark:text-gray-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                <!-- Day Names -->
                <div class="grid grid-cols-7 mb-2">
                    @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dn)
                        <div class="text-center text-[11px] font-bold text-gray-400 uppercase tracking-wider py-2">{{ $dn }}</div>
                    @endforeach
                </div>

                <!-- Calendar Grid (JS-rendered) -->
                <div class="grid grid-cols-7 gap-1.5" id="cal-grid"></div>

                <!-- Legend -->
                <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-800 flex flex-wrap gap-4">
                    <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                        <span class="w-3 h-3 rounded-sm bg-emerald-500 inline-block"></span> Open
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                        <span class="w-3 h-3 rounded-sm bg-amber-400 inline-block"></span> Filling
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                        <span class="w-3 h-3 rounded-sm bg-orange-500 inline-block"></span> Almost full
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                        <span class="w-3 h-3 rounded-sm bg-red-500 inline-block"></span> Full
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                        <span class="w-3 h-3 rounded-sm bg-gray-300 dark:bg-gray-600 inline-block"></span> Off day
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <div id="panel-empty" class="text-center py-12 text-gray-400 dark:text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm font-medium">Select a day to see appointments</p>
                </div>

                <div id="panel-content" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 id="panel-date" class="text-base font-bold text-gray-900 dark:text-white font-outfit"></h3>
                        <span id="panel-count" class="text-xs bg-brand/10 text-brand dark:bg-indigo-900/30 dark:text-indigo-400 px-2.5 py-0.5 rounded-full font-bold"></span>
                    </div>

                    <div id="panel-loading" class="text-center py-6 hidden">
                        <div class="inline-block w-5 h-5 border-2 border-brand border-t-transparent rounded-full animate-spin"></div>
                    </div>

                    <div id="panel-list" class="space-y-3 overflow-y-auto max-h-[480px]"></div>

                    <div id="panel-none" class="hidden text-center py-8">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-gray-400 dark:text-gray-500">No appointments for this day</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    .view-panel { transition: opacity 0.15s ease; }
</style>

<script>
const CAL_INIT = {
    year: {{ $calYear }},
    month: {{ $calMonth }},
    counts: @json($calCounts),
    offDates: @json($calOffDates),
};
const MAX_SLOTS  = 5;
const TODAY      = '{{ now()->toDateString() }}';
const DAY_URL    = "{{ route('staff.appointments.day') }}";
const STATUS_URL = "{{ url('/staff/appointments') }}";
const MONTH_URL  = "{{ route('staff.calendar.month-data') }}";

let cal = { ...CAL_INIT, selectedDate: null };

// ── View Switcher ───────────────────────────────────────────────────
function switchView(view) {
    const listPanel = document.getElementById('view-list');
    const calPanel  = document.getElementById('view-calendar');
    const title     = document.getElementById('view-title');
    const badge     = document.getElementById('queue-count');

    listPanel.style.opacity = '0';
    calPanel.style.opacity  = '0';

    setTimeout(() => {
        if (view === 'calendar') {
            listPanel.classList.add('hidden');
            calPanel.classList.remove('hidden');
            title.textContent = 'Appointments Calendar';
            badge.classList.add('hidden');
        } else {
            calPanel.classList.add('hidden');
            listPanel.classList.remove('hidden');
            title.textContent = 'Application Queue';
            badge.classList.remove('hidden');
        }
        listPanel.style.opacity = '';
        calPanel.style.opacity  = '';
        applyToggleStyles(view);
    }, 150);

    localStorage.setItem('staff_view', view);
}

function applyToggleStyles(view) {
    const active   = 'flex items-center gap-2 px-4 py-2 rounded-[8px] text-sm font-semibold transition-all bg-brand text-white shadow-sm';
    const inactive = 'flex items-center gap-2 px-4 py-2 rounded-[8px] text-sm font-semibold transition-all text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200';
    document.getElementById('btn-list').className     = view === 'list'     ? active : inactive;
    document.getElementById('btn-calendar').className = view === 'calendar' ? active : inactive;
}

// ── Calendar Rendering ──────────────────────────────────────────────
function renderCalendar() {
    const { year, month, counts, offDates, selectedDate } = cal;
    const grid  = document.getElementById('cal-grid');
    const label = document.getElementById('cal-month-label');

    const monthDate  = new Date(year, month - 1, 1);
    label.textContent = monthDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

    const startPad   = monthDate.getDay();
    const daysInMonth = new Date(year, month, 0).getDate();

    let html = '';
    for (let i = 0; i < startPad; i++) html += '<div></div>';

    for (let day = 1; day <= daysInMonth; day++) {
        const ds       = `${year}-${String(month).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        const dow      = new Date(ds + 'T00:00:00').getDay();
        const isOff    = (dow === 5 || dow === 6) || offDates.includes(ds);
        const isToday  = ds === TODAY;
        const isSel    = ds === selectedDate;
        const booked   = counts[ds] || 0;
        const isFull   = booked >= MAX_SLOTS;

        let bg, fg, cursor;
        if (isSel) {
            bg = 'bg-brand dark:bg-indigo-600'; fg = 'text-white'; cursor = 'cursor-pointer';
        } else if (isOff) {
            bg = 'bg-gray-100 dark:bg-gray-800'; fg = 'text-gray-400 dark:text-gray-600'; cursor = 'cursor-default';
        } else if (isFull) {
            bg = 'bg-red-500 hover:bg-red-600'; fg = 'text-white'; cursor = 'cursor-pointer';
        } else if (booked === 0) {
            bg = 'bg-emerald-500 hover:bg-emerald-600'; fg = 'text-white'; cursor = 'cursor-pointer';
        } else if (booked === 1) {
            bg = 'bg-emerald-400 hover:bg-emerald-500'; fg = 'text-white'; cursor = 'cursor-pointer';
        } else if (booked === 2) {
            bg = 'bg-amber-400 hover:bg-amber-500'; fg = 'text-white'; cursor = 'cursor-pointer';
        } else if (booked === 3) {
            bg = 'bg-orange-400 hover:bg-orange-500'; fg = 'text-white'; cursor = 'cursor-pointer';
        } else {
            bg = 'bg-orange-500 hover:bg-orange-600'; fg = 'text-white'; cursor = 'cursor-pointer';
        }

        const ring = isToday && !isSel ? 'ring-2 ring-brand dark:ring-indigo-400 ring-offset-1' : '';
        const click = !isOff ? `onclick="selectDay('${ds}')"` : '';

        html += `<div class="rounded-[12px] min-h-[64px] flex flex-col items-center justify-center p-1.5 select-none transition-all ${bg} ${fg} ${cursor} ${ring}" data-date="${ds}" ${click}>
                    <span class="text-sm font-bold leading-none">${day}</span>
                    ${!isOff && booked > 0 ? `<span class="text-[10px] opacity-80 mt-1">${booked}/${MAX_SLOTS}</span>` : ''}
                    ${isOff ? '<span class="text-[10px] opacity-60 mt-1">off</span>' : ''}
                 </div>`;
    }

    grid.innerHTML = html;
}

// ── Month Navigation ────────────────────────────────────────────────
async function changeMonth(delta) {
    let { year, month } = cal;
    month += delta;
    if (month < 1) { month = 12; year--; }
    if (month > 12) { month = 1;  year++; }

    try {
        const res  = await fetch(`${MONTH_URL}?year=${year}&month=${month}`);
        const data = await res.json();
        cal = { year: data.year, month: data.month, counts: data.counts, offDates: data.offDates, selectedDate: null };
    } catch {
        cal = { year, month, counts: {}, offDates: [], selectedDate: null };
    }

    renderCalendar();
    document.getElementById('panel-empty').classList.remove('hidden');
    document.getElementById('panel-content').classList.add('hidden');
}

// ── Day Selection ───────────────────────────────────────────────────
async function selectDay(ds) {
    cal.selectedDate = ds;
    renderCalendar();

    document.getElementById('panel-empty').classList.add('hidden');
    document.getElementById('panel-content').classList.remove('hidden');
    document.getElementById('panel-loading').classList.remove('hidden');
    document.getElementById('panel-list').innerHTML = '';
    document.getElementById('panel-none').classList.add('hidden');

    const d = new Date(ds + 'T00:00:00');
    document.getElementById('panel-date').textContent =
        d.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' });

    try {
        const res  = await fetch(DAY_URL + '?date=' + ds);
        const data = await res.json();
        document.getElementById('panel-loading').classList.add('hidden');
        renderAppointments(data.appointments);
    } catch {
        document.getElementById('panel-loading').classList.add('hidden');
    }
}

// ── Appointment Rendering ───────────────────────────────────────────
const STATUS_LABELS = {
    'pending':   { label: 'Pending',   cls: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' },
    'confirmed': { label: 'Confirmed', cls: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' },
    'completed': { label: 'Completed', cls: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' },
    'cancelled': { label: 'Cancelled', cls: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' },
};
const STATUS_BORDER = {
    'pending':   'border-amber-400',
    'confirmed': 'border-emerald-500',
    'completed': 'border-blue-400',
    'cancelled': 'border-red-400',
};
const TIME_LABELS = {
    '09:00': '9:00 AM', '10:00': '10:00 AM', '11:00': '11:00 AM',
    '12:00': '12:00 PM', '13:00': '1:00 PM'
};

function renderAppointments(appointments) {
    const list    = document.getElementById('panel-list');
    const countEl = document.getElementById('panel-count');
    countEl.textContent = appointments.length + (appointments.length !== 1 ? ' appointments' : ' appointment');

    if (appointments.length === 0) {
        document.getElementById('panel-none').classList.remove('hidden');
        return;
    }

    list.innerHTML = '';
    appointments.forEach(appt => {
        const s      = STATUS_LABELS[appt.status] || { label: appt.status, cls: 'bg-gray-100 text-gray-600' };
        const border = STATUS_BORDER[appt.status] || 'border-gray-300';
        const card   = document.createElement('div');
        card.className = `border-l-4 ${border} bg-gray-50 dark:bg-slate-800/50 rounded-r-[12px] p-3`;
        card.id = 'appt-' + appt.id;

        const docBadges = appt.documents && appt.documents.length
            ? `<div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Documents</p>
                <div class="flex flex-wrap gap-1.5">
                    ${appt.documents.map(d => {
                        const viewUrl = @json(request()->getBaseUrl() . route('staff.documents.view', ['id' => '__DOCUMENT_ID__'], false)).replace('__DOCUMENT_ID__', d.id);
                        if (d.source === 'vault')
                            return `<a href="${viewUrl}" target="_blank" class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 font-medium hover:opacity-80">Vault - ${d.name} View</a>`;
                        if (d.source === 'upload')
                            return `<a href="${viewUrl}" target="_blank" class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-medium hover:opacity-80">Upload - ${d.name} View</a>`;
                        return `<a href="${viewUrl}" target="_blank" class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 font-medium hover:opacity-80">Confirmed - ${d.name} View</a>`;
                    }).join('')}
                </div>
               </div>` : '';

        card.innerHTML = `
            <div class="flex items-start justify-between mb-2">
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">${TIME_LABELS[appt.time_slot] || appt.time_slot}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">${appt.full_name || appt.citizen}</p>
                    ${appt.document_type ? `<p class="text-xs text-brand dark:text-indigo-400 font-medium mt-0.5">${appt.document_type}</p>` : ''}
                    ${appt.notes ? `<p class="text-xs text-gray-400 mt-0.5 italic">${appt.notes}</p>` : ''}
                </div>
                <span id="badge-${appt.id}" class="shrink-0 text-[11px] px-2.5 py-0.5 rounded-full font-bold ${s.cls}">${s.label}</span>
            </div>
            <div class="flex gap-1.5 flex-wrap">
                ${buildStatusBtns(appt.id, appt.status)}
            </div>
            ${docBadges}
        `;
        list.appendChild(card);
    });
}

function buildStatusBtns(id, current) {
    return [
        { status: 'confirmed', label: 'Confirm',  cls: 'bg-emerald-500 hover:bg-emerald-600 text-white' },
        { status: 'completed', label: 'Complete', cls: 'bg-blue-500 hover:bg-blue-600 text-white' },
        { status: 'cancelled', label: 'Cancel',   cls: 'bg-red-500 hover:bg-red-600 text-white' },
    ]
    .filter(a => a.status !== current)
    .map(a => `<button onclick="updateStatus(${id},'${a.status}')" class="text-xs px-3 py-1 rounded-full font-semibold transition-colors ${a.cls}">${a.label}</button>`)
    .join('');
}

async function updateStatus(id, status) {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const res   = await fetch(`${STATUS_URL}/${id}/status`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ status }),
    });
    const data = await res.json();
    if (data.success) await selectDay(cal.selectedDate);
}

// ── List View Filter ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    // Restore saved view
    const savedView = localStorage.getItem('staff_view') || 'list';
    const isCalView = savedView === 'calendar';
    document.getElementById('view-list').classList.toggle('hidden', isCalView);
    document.getElementById('view-calendar').classList.toggle('hidden', !isCalView);
    document.getElementById('queue-count').classList.toggle('hidden', isCalView);
    document.getElementById('view-title').textContent = isCalView ? 'Appointments Calendar' : 'Application Queue';
    applyToggleStyles(savedView);

    // Calendar nav
    document.getElementById('cal-prev').addEventListener('click', () => changeMonth(-1));
    document.getElementById('cal-next').addEventListener('click', () => changeMonth(+1));
    renderCalendar();

    // List view search + filter
    const searchInput = document.getElementById('searchInput');
    const filterBtns  = document.querySelectorAll('.filter-btn');
    const appItems    = document.querySelectorAll('.app-item');
    let currentFilter = 'all';
    let currentSearch = '';

    function applyFilters() {
        appItems.forEach(item => {
            const status    = item.getAttribute('data-status');
            const searchVal = item.getAttribute('data-search');
            const okFilter  = currentFilter === 'all' || status === currentFilter;
            const okSearch  = currentSearch === '' || searchVal.includes(currentSearch);
            item.style.display = (okFilter && okSearch) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', e => {
        currentSearch = e.target.value.toLowerCase().trim();
        applyFilters();
    });

    filterBtns.forEach(btn => {
        btn.addEventListener('click', e => {
            filterBtns.forEach(b => {
                b.className = 'filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700';
            });
            e.target.className = 'filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-brand text-white border border-brand shadow-sm';
            currentFilter = e.target.getAttribute('data-filter');
            applyFilters();
        });
    });
});
</script>
@endsection
