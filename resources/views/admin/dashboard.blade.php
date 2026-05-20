@extends('layouts.halzanin-app')

@section('content')
    <div class="space-y-6 lg:space-y-8 max-w-7xl mx-auto pb-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
            <div>
                <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="Admin Dashboard">Admin Dashboard</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="admin.subtitle">System overview and application statistics</p>
            </div>
            <span class="self-start sm:self-auto text-sm font-semibold text-gray-500 dark:text-gray-400 bg-white dark:bg-slate-800 px-4 py-2 rounded-full border border-gray-100 dark:border-slate-700 shadow-sm">
                {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
            </span>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
            @php
                $statCards = [
                    ['title' => 'Total Applications', 'value' => $stats['total'],        'color' => 'indigo', 'ring' => 'ring-indigo-100 dark:ring-indigo-900/40', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                    ['title' => 'Submitted',          'value' => $stats['submitted'],    'color' => 'gray',   'ring' => 'ring-gray-100 dark:ring-gray-700/40',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                    ['title' => 'Received',           'value' => $stats['received'],     'color' => 'blue',   'ring' => 'ring-blue-100 dark:ring-blue-900/40',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>'],
                    ['title' => 'Under Review',       'value' => $stats['under_review'], 'color' => 'yellow', 'ring' => 'ring-yellow-100 dark:ring-yellow-900/40', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>'],
                    ['title' => 'Approved',           'value' => $stats['approved'],     'color' => 'green',  'ring' => 'ring-green-100 dark:ring-green-900/40',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                    ['title' => 'Rejected',           'value' => $stats['rejected'],     'color' => 'red',    'ring' => 'ring-red-100 dark:ring-red-900/40',      'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                    ['title' => 'Total Citizens',     'value' => $stats['citizens'],     'color' => 'purple', 'ring' => 'ring-purple-100 dark:ring-purple-900/40', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                    ['title' => "Today's Apps",       'value' => $stats['today'],        'color' => 'teal',   'ring' => 'ring-teal-100 dark:ring-teal-900/40',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ];
            @endphp

            @foreach($statCards as $index => $card)
                <div class="bg-white dark:bg-[#1e293b] rounded-xl p-4 lg:p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift animate-fade-up"
                     style="animation-delay: {{ $index * 60 }}ms">
                    <div class="w-9 h-9 rounded-full ring-4 {{ $card['ring'] }} bg-{{ $card['color'] }}-50 dark:bg-{{ $card['color'] }}-900/30 text-{{ $card['color'] }}-500 dark:text-{{ $card['color'] }}-400 flex items-center justify-center mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
                    </div>
                    <p class="text-2xl font-extrabold text-brand dark:text-white font-outfit">{{ number_format($card['value']) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-medium" data-i18n="{{ $card['title'] }}">{{ $card['title'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- Bar Chart --}}
            <div class="lg:col-span-2 bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 500ms">
                <div class="h-1.5 bg-gradient-to-r from-brand via-amber-500 to-accent"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white font-outfit" data-i18n="Applications This Week">Applications This Week</h3>
                        <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-slate-800 px-3 py-1 rounded-full border border-gray-100 dark:border-slate-700" data-i18n="admin.last_7_days">Last 7 days</span>
                    </div>

                    @php
                        $chartData = [];
                        $maxCount = 0;
                        for ($i = 6; $i >= 0; $i--) {
                            $date = \Carbon\Carbon::today()->subDays($i);
                            $count = \App\Models\Application::whereDate('created_at', $date)->count();
                            $chartData[] = ['date' => $date->format('D'), 'count' => $count];
                            if ($count > $maxCount) $maxCount = $count;
                        }
                        $maxCount = $maxCount > 0 ? $maxCount : 1;
                    @endphp

                    <div class="relative h-[220px] flex items-end justify-between pt-6 border-b border-gray-200 dark:border-slate-700 pb-2">
                        <div class="absolute inset-0 flex flex-col justify-between pb-8 pointer-events-none">
                            <div class="w-full border-t border-dashed border-gray-100 dark:border-slate-700/60"></div>
                            <div class="w-full border-t border-dashed border-gray-100 dark:border-slate-700/60"></div>
                            <div class="w-full border-t border-dashed border-gray-100 dark:border-slate-700/60"></div>
                            <div class="w-full border-t border-dashed border-gray-100 dark:border-slate-700/60"></div>
                        </div>

                        @foreach($chartData as $index => $data)
                            @php
                                $heightPct = max(1, ($data['count'] / $maxCount) * 100);
                            @endphp
                            <div class="relative flex flex-col items-center flex-1 group h-full justify-end z-10">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-xs font-bold px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-lg">
                                    {{ $data['count'] }}
                                </div>
                                <div class="w-8 sm:w-10 rounded-t-lg origin-bottom bg-gradient-to-t from-brand to-amber-400 dark:from-amber-600 dark:to-amber-400 hover:from-amber-500 hover:to-amber-300 transition-all"
                                     style="height: {{ $heightPct }}%; animation: scaleUp 600ms cubic-bezier(0.4, 0, 0.2, 1) forwards; animation-delay: {{ $index * 80 }}ms; transform: scaleY(0)">
                                </div>
                                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 mt-2.5">{{ $data['date'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 600ms">
                <div class="h-1.5 bg-gradient-to-r from-brand via-amber-500 to-accent"></div>
                <div class="p-6 flex flex-col h-full">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-6 font-outfit" data-i18n="Quick Actions">Quick Actions</h3>
                    <div class="flex flex-col space-y-3 flex-grow justify-center">
                        <a href="{{ route('staff.queue') }}"
                           class="w-full py-3.5 bg-brand text-white text-center rounded-xl font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span data-i18n="View All Applications">View All Applications</span>
                        </a>
                        <a href="{{ route('admin.users') }}"
                           class="w-full py-3.5 bg-white dark:bg-slate-800 text-brand dark:text-amber-400 border-2 border-brand/20 dark:border-amber-700/40 text-center rounded-xl font-semibold font-outfit hover:border-brand dark:hover:border-amber-500 hover:bg-brand/5 dark:hover:bg-slate-700 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span data-i18n="Manage Users">Manage Users</span>
                        </a>
                    </div>

                    {{-- Mini Stats --}}
                    <div class="mt-6 pt-5 border-t border-gray-100 dark:border-slate-800 grid grid-cols-2 gap-3">
                        <div class="text-center p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                            <p class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400 font-outfit">{{ number_format($stats['approved']) }}</p>
                            <p class="text-[10px] font-semibold text-emerald-600/70 dark:text-emerald-400/70 uppercase tracking-wide mt-0.5" data-i18n="status.approved">Approved</p>
                        </div>
                        <div class="text-center p-3 bg-red-50 dark:bg-red-900/20 rounded-xl">
                            <p class="text-xl font-extrabold text-red-500 dark:text-red-400 font-outfit">{{ number_format($stats['rejected']) }}</p>
                            <p class="text-[10px] font-semibold text-red-500/70 dark:text-red-400/70 uppercase tracking-wide mt-0.5" data-i18n="status.rejected">Rejected</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Applications Table --}}
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 700ms">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 rounded-full bg-brand dark:bg-indigo-400"></div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider" data-i18n="Recent Applications">Recent Applications</h3>
                </div>
                <a href="{{ route('staff.queue') }}"
                   class="text-xs font-semibold text-brand dark:text-amber-400 hover:underline flex items-center gap-1">
                    <span data-i18n="View All">View All</span>
                    <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-slate-800 bg-white dark:bg-[#1e293b]">
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Applicant">Applicant</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Tracking Code">Tracking Code</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Status">Status</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Submitted">Submitted</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                        @forelse ($recent as $app)
                            @php
                                $badgeColors = [
                                    'submitted'    => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                    'received'     => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'under_review' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'approved'     => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    'rejected'     => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                ];
                                $badge = $badgeColors[$app->current_status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-brand/10 dark:bg-amber-900/30 flex items-center justify-center text-brand dark:text-amber-400 font-bold text-sm shrink-0">
                                            {{ mb_substr($app->appointment->full_name ?? $app->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $app->appointment->full_name ?? $app->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-mono font-bold text-brand dark:text-amber-400">{{ $app->tracking_code }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $badge }}">
                                        {{ str_replace('_', ' ', $app->current_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 text-sm" data-i18n="No recent applications.">No recent applications.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <style>
        @keyframes scaleUp {
            from { transform: scaleY(0); }
            to   { transform: scaleY(1); }
        }
    </style>
@endsection
