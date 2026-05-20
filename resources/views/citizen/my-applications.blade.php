@extends('layouts.halzanin-app')

@section('content')
@php
    $statusConfig = [
        'submitted'    => ['bg' => 'bg-indigo-100 dark:bg-indigo-900/30', 'text' => 'text-indigo-700 dark:text-indigo-300', 'dot' => 'bg-indigo-500'],
        'received'     => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-300', 'dot' => 'bg-blue-500'],
        'under_review' => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-300', 'dot' => 'bg-amber-500'],
        'approved'     => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-300', 'dot' => 'bg-emerald-500'],
        'rejected'     => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-300', 'dot' => 'bg-red-500'],
        'checked_in'   => ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-700 dark:text-purple-300', 'dot' => 'bg-purple-500'],
    ];
    $timeLabels = ['09:00' => '9:00 AM', '10:00' => '10:00 AM', '11:00' => '11:00 AM', '12:00' => '12:00 PM', '13:00' => '1:00 PM'];
@endphp

<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit" data-i18n="applications.title">My Applications</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="applications.subtitle">Track all your submitted applications and their current status.</p>
    </div>

    @if($applications->isEmpty())
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-1" data-i18n="applications.empty_title">No applications yet</h4>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-6" data-i18n="applications.empty_desc">Book an appointment to get started.</p>
                <a href="{{ route('citizen.appointments.calendar') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand/90 transition shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span data-i18n="dashboard.book_btn">Book Appointment</span>
                </a>
            </div>
        </div>
    @else
        <div class="space-y-4">
            @foreach($applications as $app)
                @php
                    $sc = $statusConfig[$app->current_status] ?? $statusConfig['submitted'];
                    $lastLog = $app->statusLogs->first();
                    $appt = $app->appointment;
                @endphp
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $sc['dot'] }} shrink-0"></span>
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $sc['bg'] }} {{ $sc['text'] }}" data-i18n="status.{{ $app->current_status }}">
                                    {{ ucwords(str_replace('_', ' ', $app->current_status)) }}
                                </span>
                            </div>
                            <span class="font-mono text-sm font-bold text-brand dark:text-indigo-400 truncate">{{ $app->tracking_code }}</span>
                        </div>
                        <span class="text-[11px] text-gray-400 dark:text-gray-500 shrink-0 ml-3">
                            {{ $app->submitted_at ? $app->submitted_at->format('M j, Y') : $app->created_at->format('M j, Y') }}
                        </span>
                    </div>

                    <div class="px-5 py-4 space-y-3">
                        @if($appt)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5" data-i18n="book.doc_type">Document Type</p>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100" data-i18n="{{ $appt->document_type }}">{{ $appt->document_type ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5" data-i18n="track.appointment">Appointment Date</p>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($appt->date)->format('M j, Y') }}
                                        <span aria-hidden="true"> - </span>{{ $timeLabels[$appt->time_slot] ?? $appt->time_slot }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if($lastLog)
                            <div class="flex items-start gap-2.5 p-3 bg-gray-50 dark:bg-slate-800/50 rounded-xl border border-gray-100 dark:border-gray-800">
                                <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-[11px] text-gray-400 mb-0.5">
                                        <span data-i18n="applications.latest_update">Latest update</span>
                                        <span aria-hidden="true"> - </span>{{ $lastLog->created_at->diffForHumans() }}
                                    </p>
                                    <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">
                                        @if($lastLog->notes)
                                            {{ $lastLog->notes }}
                                        @else
                                            <span data-i18n="applications.status_changed">Status changed to</span>
                                            <span data-i18n="status.{{ $lastLog->status }}">{{ ucwords(str_replace('_', ' ', $lastLog->status)) }}</span>.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 px-5 pb-4">
                        <a href="{{ route('track.show', $app->tracking_code) }}"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-3 text-xs font-semibold bg-brand text-white rounded-lg hover:bg-brand/90 transition shadow-sm">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            <span data-i18n="applications.view_timeline">View Full Timeline</span>
                        </a>
                        <a href="{{ route('citizen.applications.receipt', $app) }}"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-3 text-xs font-semibold bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span data-i18n="applications.download_receipt">Download Receipt</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
