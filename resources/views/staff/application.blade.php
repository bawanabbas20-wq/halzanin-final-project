@extends('layouts.halzanin-app')

@section('content')
    <div class="max-w-6xl mx-auto pb-10">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6 animate-fade-in">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="staff.application_detail">Application Detail</h2>
                    <span class="px-2.5 py-1 bg-brand/10 dark:bg-amber-900/30 text-brand dark:text-amber-400 text-sm font-mono font-bold tracking-widest rounded-xl">
                        {{ $application->tracking_code }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Submitted {{ $application->submitted_at ? $application->submitted_at->diffForHumans() : '—' }}
                </p>
            </div>
            <a href="{{ route('staff.queue') }}"
               class="text-sm font-semibold text-gray-500 hover:text-brand dark:text-gray-400 dark:hover:text-amber-400 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span data-i18n="staff.back_to_queue">Back to Queue</span>
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6 animate-fade-in flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl mb-6 animate-fade-in">
                <ul class="list-disc ltr:pl-4 rtl:pr-4 text-sm space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

            {{-- LEFT COLUMN (60%) --}}
            <div class="w-full lg:w-[60%] flex flex-col space-y-6">

                {{-- Appointment Info Card --}}
                <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 100ms">
                    <div class="h-1 bg-gradient-to-r from-brand via-amber-500 to-accent"></div>
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.03] flex items-center gap-2">
                        <div class="w-1.5 h-5 rounded-full bg-brand dark:bg-indigo-400"></div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider" data-i18n="staff.appointment_info">Appointment Information</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-8">
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 dark:text-gray-500 font-semibold mb-1" data-i18n="track.applicant">Applicant Name</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $application->appointment->full_name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 dark:text-gray-500 font-semibold mb-1" data-i18n="book.national_id_short">National ID</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white font-mono">{{ $application->appointment->national_id_number ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 dark:text-gray-500 font-semibold mb-1" data-i18n="track.doc_type">Document Type</p>
                            <span class="inline-block px-2.5 py-1 text-xs font-bold rounded-full bg-amber-50 text-brand dark:bg-amber-900/30 dark:text-amber-400">
                                {{ $application->appointment->document_type ?? '—' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 dark:text-gray-500 font-semibold mb-1" data-i18n="book.preferred_date">Preferred Date</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $application->appointment ? \Carbon\Carbon::parse($application->appointment->date)->format('M d, Y') : '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 dark:text-gray-500 font-semibold mb-1" data-i18n="book.time_slot">Time Slot</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $application->appointment->time_slot ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 dark:text-gray-500 font-semibold mb-1" data-i18n="track.submitted">Submitted At</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $application->submitted_at ? $application->submitted_at->format('M d, Y h:i A') : '—' }}
                            </p>
                        </div>
                        @if($application->appointment?->notes)
                            <div class="sm:col-span-2 bg-amber-50 dark:bg-amber-900/10 p-4 rounded-xl border border-amber-100 dark:border-amber-900/30">
                                <p class="text-[11px] uppercase tracking-wider text-amber-500 dark:text-amber-400 font-semibold mb-1" data-i18n="staff.applicant_notes">Applicant Notes</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 italic">"{{ $application->appointment->notes }}"</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Documents Section --}}
                <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 200ms">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.03] flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-5 rounded-full bg-blue-500 dark:bg-blue-400"></div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider" data-i18n="staff.uploaded_documents">Uploaded Documents</h3>
                        </div>
                        <span class="text-xs font-bold bg-gray-100 dark:bg-[#2E2E2E] text-gray-600 dark:text-gray-300 px-2.5 py-1 rounded-full">
                            {{ $application->documents->count() }} <span data-i18n="common.files">Files</span>
                        </span>
                    </div>
                    <div class="p-5">
                        @if($application->documents->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-6" data-i18n="staff.no_documents">No documents uploaded yet.</p>
                        @else
                            <div class="space-y-2.5">
                                @foreach($application->documents as $doc)
                                    <div class="flex items-center justify-between p-3.5 border border-gray-100 dark:border-gray-700 rounded-xl bg-gray-50/50 dark:bg-white/[0.02] hover:border-brand/20 dark:hover:border-indigo-700/40 transition-colors">
                                        <div class="flex items-center gap-3 rtl:space-x-reverse min-w-0">
                                            <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-brand dark:text-amber-400 shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                @if($doc->source === 'upload' && $doc->file_path)
                                                    <a href="{{ route('staff.documents.view', $doc->id) }}"
                                                       class="text-sm font-semibold text-brand dark:text-amber-400 hover:underline truncate block"
                                                       target="_blank">{{ $doc->original_name ?? $doc->document_name }}</a>
                                                @else
                                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 truncate">{{ $doc->original_name ?? $doc->document_name }}</p>
                                                @endif
                                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                    {{ $doc->source === 'upload' ? number_format(($doc->file_size ?? 0) / 1024, 1) . ' KB' : ucfirst($doc->source) }}
                                                </p>
                                            </div>
                                        </div>

                                        <label class="flex items-center gap-2 cursor-pointer shrink-0">
                                            <div class="relative">
                                                <input type="checkbox" class="sr-only" {{ $loop->first ? 'checked' : '' }}>
                                                <div class="block bg-gray-300 dark:bg-gray-600 w-10 h-6 rounded-full transition-colors"></div>
                                                <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform shadow-sm"></div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400" data-i18n="staff.verified">Verified</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <style>
                                input:checked ~ .block { background-color: #059669; }
                                input:checked ~ .dot { transform: translateX(100%); }
                                html[dir="rtl"] input:checked ~ .dot { transform: translateX(-100%); }
                            </style>
                        @endif
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 300ms">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.03] flex items-center gap-2">
                        <div class="w-1.5 h-5 rounded-full bg-emerald-500 dark:bg-emerald-400"></div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider" data-i18n="track.timeline">Status Timeline</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $timelineCfg = [
                                'submitted'    => ['bg' => 'bg-gray-100 dark:bg-gray-800',           'icon_c' => 'text-gray-500 dark:text-gray-400',       'badge_bg' => 'bg-gray-100 dark:bg-gray-800',            'badge_t' => 'text-gray-700 dark:text-gray-300',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                'received'     => ['bg' => 'bg-blue-100 dark:bg-blue-900/30',        'icon_c' => 'text-blue-500 dark:text-blue-400',        'badge_bg' => 'bg-blue-100 dark:bg-blue-900/30',         'badge_t' => 'text-blue-700 dark:text-blue-400',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>'],
                                'under_review' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30',    'icon_c' => 'text-yellow-600 dark:text-yellow-400',    'badge_bg' => 'bg-yellow-100 dark:bg-yellow-900/30',     'badge_t' => 'text-yellow-700 dark:text-yellow-400', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>'],
                                'approved'     => ['bg' => 'bg-green-100 dark:bg-green-900/30',      'icon_c' => 'text-green-600 dark:text-green-400',      'badge_bg' => 'bg-green-100 dark:bg-green-900/30',       'badge_t' => 'text-green-700 dark:text-green-400',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                'rejected'     => ['bg' => 'bg-red-100 dark:bg-red-900/30',          'icon_c' => 'text-red-600 dark:text-red-400',          'badge_bg' => 'bg-red-100 dark:bg-red-900/30',           'badge_t' => 'text-red-700 dark:text-red-400',       'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                            ];
                        @endphp

                        <div class="relative">
                            @foreach($application->statusLogs as $index => $log)
                                @php
                                    $isLast = $loop->last;
                                    $tc     = $timelineCfg[$log->status] ?? $timelineCfg['submitted'];
                                @endphp
                                <div class="relative flex">
                                    @if(!$isLast)
                                        <div class="absolute ltr:left-[19px] rtl:right-[19px] top-10 bottom-0 w-0.5 bg-gray-100 dark:bg-[#2E2E2E]"></div>
                                    @endif
                                    <div class="w-[40px] shrink-0 flex flex-col items-center pt-1 relative z-10">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $tc['bg'] }} {{ $tc['icon_c'] }} shadow-sm ring-4 ring-white dark:ring-[#1F1F1F]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $tc['icon'] !!}</svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow ltr:pl-4 rtl:pr-4 pb-8">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            <span class="px-2.5 py-0.5 text-[11px] font-bold rounded-full capitalize {{ $tc['badge_bg'] }} {{ $tc['badge_t'] }}" data-i18n="status.{{ $log->status }}">
                                                {{ str_replace('_', ' ', $log->status) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                            {{ $log->created_at->format('M d, Y h:i A') }}
                                        </p>
                                        @if($log->notes)
                                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-300 italic bg-gray-50 dark:bg-white/[0.02] p-3 rounded-xl border border-gray-100 dark:border-[#2E2E2E]">
                                                "{{ $log->notes }}"
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN (40%) --}}
            <div class="w-full lg:w-[40%]">
                <div class="sticky top-24">

                    @php
                        $badgeColors = [
                            'submitted'    => ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300'],
                            'received'     => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400'],
                            'under_review' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400'],
                            'approved'     => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400'],
                            'rejected'     => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-400'],
                        ];
                        $currBadge = $badgeColors[$application->current_status] ?? $badgeColors['submitted'];
                    @endphp

                    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 400ms">
                        <div class="h-1 bg-gradient-to-r from-brand via-amber-500 to-accent"></div>
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.03]">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider text-center" data-i18n="staff.update_status">Update Status</h3>
                        </div>

                        <div class="p-6 flex flex-col items-center">
                            <p class="text-[11px] text-gray-400 dark:text-gray-500 uppercase font-semibold mb-2" data-i18n="staff.current_status">Current Status</p>
                            <span class="px-4 py-2 rounded-full font-bold text-sm uppercase {{ $currBadge['bg'] }} {{ $currBadge['text'] }} mb-8" data-i18n="status.{{ $application->current_status }}">
                                {{ str_replace('_', ' ', $application->current_status) }}
                            </span>

                            @if(count($nextStatuses) > 0)
                                <form method="POST"
                                      id="statusUpdateForm"
                                      action="{{ route('staff.applications.update-status', $application->id) }}"
                                      class="w-full"
                                      x-data="{ status: '{{ old('new_status') }}', notes: `{{ old('notes') }}` }"
                                      @submit.prevent="
                                          if (status === 'rejected') {
                                              if (notes.trim() === '') { $refs.notesField.focus(); return; }
                                              $dispatch('open-modal', 'confirm-rejection');
                                          } else if (status === 'approved') {
                                              $dispatch('open-modal', 'confirm-approval');
                                          } else {
                                              $el.submit();
                                          }
                                      ">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-4">
                                        <label for="new_status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5" data-i18n="staff.select_next_status">Select Next Status</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                                                </svg>
                                            </div>
                                            <select id="new_status" name="new_status" required x-model="status"
                                                    class="block w-full h-[48px] ltr:pl-9 rtl:pr-9 rtl:pl-3 ltr:pr-3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 transition-all font-semibold text-sm">
                                                <option value="" data-i18n="common.choose">Choose...</option>
                                                @foreach ($nextStatuses as $value => $label)
                                                    <option value="{{ $value }}" data-i18n="status.{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                            <span x-show="status === 'rejected'" data-i18n="staff.rejection_reason">Rejection reason (required)</span>
                                            <span x-show="status !== 'rejected'" data-i18n="staff.notes_for_citizen">Notes for the citizen</span>
                                        </label>
                                        <textarea id="notes" name="notes" rows="3" x-model="notes" x-ref="notesField" :required="status === 'rejected'"
                                                  class="block w-full p-3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 transition-all text-sm resize-none"></textarea>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1" data-i18n="staff.notes_help">Visible on the citizen's public tracking page.</p>
                                    </div>

                                    <button type="submit"
                                            class="w-full h-[52px] bg-brand text-white rounded-xl font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-0.5 transition-all">
                                        <span data-i18n="staff.update_status">Update Status</span>
                                    </button>

                                    {{-- Approval Modal --}}
                                    <x-modal name="confirm-approval">
                                        <div class="p-6">
                                            <div class="flex items-center gap-3 mb-4 text-green-600 dark:text-green-500">
                                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <h2 class="text-xl font-bold font-outfit" data-i18n="staff.confirm_approval">Confirm Approval</h2>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                                                <span data-i18n="staff.confirm_approval_body">You are about to approve this application. The citizen will be notified by WhatsApp if a phone number is available. This action cannot be undone.</span>
                                            </p>
                                            <div class="flex items-center justify-end gap-3">
                                                <button type="button" x-on:click="$dispatch('close')"
                                                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-[#2E2E2E] dark:hover:bg-[#3A3A3A] text-gray-700 dark:text-gray-200 rounded-xl font-semibold transition-colors text-sm">
                                                    <span data-i18n="common.cancel">Cancel</span>
                                                </button>
                                                <button type="button" x-on:click="$dispatch('close'); document.getElementById('statusUpdateForm').submit()"
                                                        class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold shadow-md transition-colors text-sm flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    <span data-i18n="staff.confirm_approval">Confirm Approval</span>
                                                </button>
                                            </div>
                                        </div>
                                    </x-modal>

                                    {{-- Rejection Modal --}}
                                    <x-modal name="confirm-rejection">
                                        <div class="p-6">
                                            <div class="flex items-center gap-3 mb-4 text-red-600 dark:text-red-500">
                                                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                </div>
                                                <h2 class="text-xl font-bold font-outfit" data-i18n="staff.confirm_rejection">Confirm Rejection</h2>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                <span data-i18n="staff.confirm_rejection_body">Are you sure you want to reject this application? This cannot be undone.</span>
                                            </p>
                                            <div class="mb-6 rounded-xl bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-[#2E2E2E] p-3">
                                                <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1" data-i18n="staff.rejection_reason">Rejection reason</p>
                                                <p class="text-sm text-gray-700 dark:text-gray-200 whitespace-pre-line" x-text="notes"></p>
                                            </div>
                                            <div class="flex items-center justify-end gap-3">
                                                <button type="button" x-on:click="$dispatch('close-modal', 'confirm-rejection')"
                                                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-[#2E2E2E] dark:hover:bg-[#3A3A3A] text-gray-700 dark:text-gray-200 rounded-xl font-semibold transition-colors text-sm">
                                                    <span data-i18n="common.cancel">Cancel</span>
                                                </button>
                                                <button type="button"
                                                        x-on:click="$dispatch('close'); document.getElementById('statusUpdateForm').submit()"
                                                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold shadow-md transition-colors text-sm">
                                                    <span data-i18n="staff.confirm_rejection">Confirm Rejection</span>
                                                </button>
                                            </div>
                                        </div>
                                    </x-modal>
                                </form>
                            @else
                                <div class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-[#2E2E2E] rounded-2xl p-6 text-center">
                                    <div class="w-12 h-12 bg-white dark:bg-[#141414] rounded-full mx-auto flex items-center justify-center mb-3 shadow-sm border border-gray-100 dark:border-gray-800">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1" data-i18n="staff.status_finalized">Status Finalized</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <span data-i18n="staff.status_finalized_desc">This application has reached its final state. No further updates are possible.</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
