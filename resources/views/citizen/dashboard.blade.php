@extends('layouts.halzanin-app')

@section('content')
    @php
        $total = $applications->count();
        $approved = $applications->where('current_status', 'approved')->count();
        $pending = $applications->whereIn('current_status', ['submitted', 'received', 'under_review'])->count();
    @endphp

    <div class="space-y-6 lg:space-y-8">
        

        <!-- Top Section: Greeting -->
        <div>
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">سڵاو، {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Here's your document status at a glance</p>
        </div>

        <!-- Quick Action Card -->
        <div class="relative overflow-hidden rounded-[16px] bg-gradient-to-r from-brand to-[#312e81] shadow-lg animate-fade-up">
            <!-- Background Illustration -->
            <div class="absolute right-0 bottom-0 opacity-20 pointer-events-none ltr:right-0 rtl:left-0 rtl:transform rtl:-scale-x-100">
                <svg width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-white transform translate-x-4 translate-y-4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            </div>

            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between relative z-10 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Ready to submit documents?</h3>
                    <p class="text-sm text-white/80">Book a new appointment in minutes</p>
                </div>
                <a href="{{ route('citizen.appointment.create') }}" class="inline-flex items-center px-5 py-2.5 bg-accent text-white font-semibold text-sm rounded-[10px] shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all whitespace-nowrap">
                    Book Appointment
                </a>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-3 gap-3 lg:gap-6">
            <!-- Total -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-4 lg:p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 0ms">
                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <p class="text-2xl font-bold text-brand dark:text-white font-outfit">{{ $total }}</p>
                <p class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">Total Applications</p>
            </div>
            <!-- Approved -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-4 lg:p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 100ms">
                <div class="w-10 h-10 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-2xl font-bold text-brand dark:text-white font-outfit">{{ $approved }}</p>
                <p class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">Approved</p>
            </div>
            <!-- Pending -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-4 lg:p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 200ms">
                <div class="w-10 h-10 rounded-full bg-yellow-50 dark:bg-yellow-900/30 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-2xl font-bold text-brand dark:text-white font-outfit">{{ $pending }}</p>
                <p class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">Pending</p>
            </div>
        </div>

        <!-- My Applications Section -->
        <div>
            <div class="flex items-center mb-4 space-x-2 rtl:space-x-reverse">
                <h3 class="text-lg font-bold text-brand dark:text-white font-outfit">My Applications</h3>
                <span class="px-2 py-0.5 bg-brand/10 dark:bg-[#1e293b] text-brand dark:text-white text-xs font-bold rounded-full">{{ $total }}</span>
            </div>

            @if($applications->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-10 text-center shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up">
                    <div class="w-24 h-24 mx-auto bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-gray-900 dark:text-white font-semibold mb-1">No applications yet</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Start tracking your documents by booking your first appointment.</p>
                    <a href="{{ route('citizen.appointment.create') }}" class="inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-semibold rounded-[10px] hover:bg-brand-light transition-colors">
                        Book Appointment
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($applications as $index => $app)
                        @php
                            $colors = [
                                'submitted'    => ['border' => 'border-gray-400',   'badge' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300'],
                                'received'     => ['border' => 'border-blue-400',   'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'],
                                'under_review' => ['border' => 'border-yellow-400', 'badge' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'],
                                'approved'     => ['border' => 'border-green-400',  'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'],
                                'rejected'     => ['border' => 'border-red-400',    'badge' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'],
                            ];
                            $color = $colors[$app->current_status] ?? $colors['submitted'];
                            $canUpload = in_array($app->current_status, ['received', 'under_review']) && $app->documents->count() < 3;
                            $delay = 50 * $index;
                        @endphp
                        
                        <!-- Application Card -->
                        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden ltr:border-l-4 rtl:border-r-4 {{ $color['border'] }} animate-fade-up" style="animation-delay: {{ $delay }}ms">
                            <div class="p-5">
                                <!-- Top Row -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span class="font-mono font-bold text-brand dark:text-indigo-400 text-sm tracking-tight">{{ $app->tracking_code }}</span>
                                        <span class="text-[10px] text-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-gray-400 px-1.5 py-0.5 rounded font-semibold">{{ $app->documents->count() }}/3 docs</span>
                                    </div>
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $color['badge'] }}">
                                        {{ str_replace('_', ' ', $app->current_status) }}
                                    </span>
                                </div>
                                
                                <!-- Middle Row -->
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $app->appointment->document_type ?? '—' }}</h4>
                                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <svg class="w-3.5 h-3.5 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Preferred: {{ $app->appointment ? \Carbon\Carbon::parse($app->appointment->preferred_date)->format('M d, Y') : '—' }}
                                    </div>
                                </div>
                                
                                <!-- Bottom Row -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800 gap-3">
                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                        Submitted: {{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : '—' }}
                                    </div>
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <a href="{{ route('citizen.applications.qr-receipt', $app->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-white dark:bg-slate-800 border border-gray-300 dark:border-gray-600 rounded-[8px] text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                            <svg class="w-3.5 h-3.5 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Receipt
                                        </a>
                                        @if($canUpload)
                                            <a href="{{ route('citizen.documents.create', $app->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 border border-transparent rounded-[8px] text-xs font-semibold hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                                                <svg class="w-3.5 h-3.5 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                Upload
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
