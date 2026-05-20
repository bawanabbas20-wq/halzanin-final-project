@extends('layouts.halzanin-app')

@section('content')
    <div class="space-y-6 max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="Application Queue">Application Queue</h2>
                    <span class="px-3 py-1 bg-brand/10 dark:bg-brand/10 text-brand dark:text-blue-400 text-sm font-bold rounded-full">
                        {{ $applications->total() }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="staff.queue_subtitle">Review and process submitted applications</p>
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
        <div class="bg-white dark:bg-[#1F1F1F] p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up flex flex-col xl:flex-row gap-4" style="animation-delay: 100ms">
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
            <div class="flex flex-wrap gap-2 items-center" id="filterChips">
                <button data-filter="all"
                        class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-brand text-white border border-brand shadow-sm"
                        data-i18n="All">All</button>
                <button data-filter="submitted"
                        class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700"
                        data-i18n="Submitted">Submitted</button>
                <button data-filter="received"
                        class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700"
                        data-i18n="Received">Received</button>
                <button data-filter="under_review"
                        class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700"
                        data-i18n="Under Review">Under Review</button>
                <button data-filter="approved"
                        class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700"
                        data-i18n="Approved">Approved</button>
                <button data-filter="rejected"
                        class="filter-btn px-4 py-1.5 rounded-full text-sm font-semibold transition-colors bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700"
                        data-i18n="Rejected">Rejected</button>
            </div>
        </div>

        {{-- Application List --}}
        <div class="animate-fade-up" style="animation-delay: 200ms">

            {{-- MOBILE VIEW: Cards --}}
            <div class="block lg:hidden space-y-3" id="mobileList">
                @forelse ($applications as $app)
                    @php
                        $colors = [
                            'submitted'    => ['border' => 'border-gray-400',   'badge' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',       'dot' => 'status-dot-gray'],
                            'received'     => ['border' => 'border-blue-400',   'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',    'dot' => 'status-dot-blue'],
                            'under_review' => ['border' => 'border-yellow-400', 'badge' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400', 'dot' => 'status-dot-yellow'],
                            'approved'     => ['border' => 'border-green-400',  'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400', 'dot' => 'status-dot-green'],
                            'rejected'     => ['border' => 'border-red-400',    'badge' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',         'dot' => 'status-dot-red'],
                        ];
                        $color   = $colors[$app->current_status] ?? $colors['submitted'];
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
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-gray-50 dark:bg-slate-800 z-10 border-b border-gray-100 dark:border-gray-800">
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
                                    $colors = [
                                        'submitted'    => ['badge' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',       'dot' => 'status-dot-gray'],
                                        'received'     => ['badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',    'dot' => 'status-dot-blue'],
                                        'under_review' => ['badge' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400', 'dot' => 'status-dot-yellow'],
                                        'approved'     => ['badge' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400', 'dot' => 'status-dot-green'],
                                        'rejected'     => ['badge' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',         'dot' => 'status-dot-red'],
                                    ];
                                    $color   = $colors[$app->current_status] ?? $colors['submitted'];
                                    $appName = $app->appointment->full_name ?? $app->user->name;
                                @endphp
                                <tr class="app-item hover:bg-gray-50/70 dark:hover:bg-slate-800/40 transition-colors"
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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

            searchInput.addEventListener('input', (e) => {
                currentSearch = e.target.value.toLowerCase().trim();
                applyFilters();
            });

            filterBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
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
