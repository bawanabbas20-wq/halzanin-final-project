@extends('layouts.halzanin-app')

@section('content')
    <div class="space-y-6 lg:space-y-8 max-w-7xl mx-auto pb-10">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">Admin Dashboard</h2>
            <span class="text-sm font-semibold text-gray-500 dark:text-gray-400 bg-white dark:bg-slate-800 px-4 py-2 rounded-full border border-gray-100 dark:border-slate-700 shadow-sm">
                {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
            </span>
        </div>

        <!-- Stats Grid (2x3 desktop, 1 col mobile + 2 extra cards = 8 cards total) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @php
                $statCards = [
                    ['title' => 'Total Applications', 'value' => $stats['total'],        'color' => 'indigo', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>'],
                    ['title' => 'Submitted',          'value' => $stats['submitted'],    'color' => 'gray',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                    ['title' => 'Received',           'value' => $stats['received'],     'color' => 'blue',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>'],
                    ['title' => 'Under Review',       'value' => $stats['under_review'], 'color' => 'yellow', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>'],
                    ['title' => 'Approved',           'value' => $stats['approved'],     'color' => 'green',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                    ['title' => 'Rejected',           'value' => $stats['rejected'],     'color' => 'red',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                    ['title' => 'Total Citizens',     'value' => $stats['citizens'],     'color' => 'purple', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>'],
                    ['title' => 'Today\'s Apps',      'value' => $stats['today'],        'color' => 'teal',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>'],
                ];
            @endphp

            @foreach($statCards as $index => $card)
                <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-6 shadow-sm border border-gray-100 dark:border-slate-800 animate-fade-up relative overflow-hidden" style="animation-delay: {{ $index * 50 }}ms;">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-500 dark:bg-{{ $card['color'] }}-900/30 dark:text-{{ $card['color'] }}-400 ring-4 ring-white dark:ring-[#1e293b] z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white font-outfit">{{ number_format($card['value']) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider mt-1">{{ $card['title'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Left: Bar Chart -->
            <div class="lg:col-span-2 bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 p-6 animate-fade-up" style="animation-delay: 400ms;">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Applications This Week</h3>
                
                @php
                    $chartData = [];
                    $maxCount = 0;
                    for ($i = 6; $i >= 0; $i--) {
                        $date = \Carbon\Carbon::today()->subDays($i);
                        $count = \App\Models\Application::whereDate('created_at', $date)->count();
                        $chartData[] = [
                            'date' => $date->format('D'),
                            'count' => $count
                        ];
                        if ($count > $maxCount) $maxCount = $count;
                    }
                    $maxCount = $maxCount > 0 ? $maxCount : 1; // Prevent div by zero
                @endphp

                <div class="relative h-[240px] flex items-end justify-between pt-6 border-b border-gray-200 dark:border-slate-700 pb-2">
                    <!-- Y Axis Lines -->
                    <div class="absolute inset-0 flex flex-col justify-between pb-8 pointer-events-none">
                        <div class="w-full border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        <div class="w-full border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        <div class="w-full border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        <div class="w-full border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                    </div>

                    @foreach($chartData as $index => $data)
                        @php
                            $heightPercentage = ($data['count'] / $maxCount) * 100;
                            // Ensure tiny height if count is 0 so the bar still exists
                            $heightPercentage = $heightPercentage > 0 ? $heightPercentage : 1;
                        @endphp
                        <div class="relative flex flex-col items-center flex-1 group h-full justify-end z-10">
                            <!-- Tooltip -->
                            <div class="absolute -top-10 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                {{ $data['count'] }}
                            </div>
                            
                            <!-- Bar -->
                            <div class="w-8 sm:w-12 bg-brand dark:bg-indigo-500 rounded-t-md origin-bottom transition-colors hover:bg-brand-light dark:hover:bg-indigo-400" 
                                 style="height: {{ $heightPercentage }}%; animation: scaleUp 600ms cubic-bezier(0.4, 0, 0.2, 1) forwards; animation-delay: {{ $index * 100 }}ms; transform: scaleY(0);">
                            </div>
                            
                            <!-- Label -->
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-3">{{ $data['date'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Quick Links & Actions -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 p-6 animate-fade-up flex flex-col" style="animation-delay: 500ms;">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Quick Actions</h3>
                <div class="flex flex-col space-y-4 flex-grow justify-center">
                    <a href="{{ route('staff.queue') }}" class="w-full py-3.5 bg-brand text-white text-center rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all flex items-center justify-center">
                        <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        View All Applications
                    </a>
                    <a href="{{ route('admin.users') }}" class="w-full py-3.5 bg-white dark:bg-slate-800 text-brand dark:text-indigo-400 border-2 border-brand dark:border-indigo-500 text-center rounded-[10px] font-semibold font-outfit hover:bg-brand/5 dark:hover:bg-slate-700 transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Manage Users
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Applications Table -->
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 600ms;">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Recent Applications</h3>
                <a href="{{ route('staff.queue') }}" class="text-sm font-semibold text-brand dark:text-indigo-400 hover:underline flex items-center">
                    View All <svg class="w-4 h-4 ltr:ml-1 rtl:mr-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-slate-800">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-white dark:bg-[#1e293b]">Applicant</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-white dark:bg-[#1e293b]">Tracking Code</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-white dark:bg-[#1e293b]">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-white dark:bg-[#1e293b]">Submitted</th>
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
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $app->appointment->full_name ?? $app->user->name }}
                                </td>
                                <td class="px-6 py-4 text-sm font-mono font-bold text-brand dark:text-indigo-400">
                                    {{ $app->tracking_code }}
                                </td>
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
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">No recent applications.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- CSS Keyframes for Chart -->
    <style>
        @keyframes scaleUp {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }
    </style>
@endsection
