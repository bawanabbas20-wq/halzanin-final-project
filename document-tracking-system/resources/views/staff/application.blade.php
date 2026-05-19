@extends('layouts.halzanin-app')

@section('content')
    <div class="max-w-6xl mx-auto pb-10">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 animate-fade-in">
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit flex items-center">
                Application Detail
                <span class="ltr:ml-3 rtl:mr-3 px-2.5 py-1 bg-brand/10 dark:bg-indigo-900/30 text-brand dark:text-indigo-400 text-sm font-mono tracking-widest rounded-[8px]">
                    {{ $application->tracking_code }}
                </span>
            </h2>
            <a href="{{ route('staff.queue') }}" class="text-sm font-semibold text-gray-500 hover:text-brand dark:text-gray-400 dark:hover:text-indigo-400 transition-colors flex items-center">
                <svg class="w-4 h-4 ltr:mr-1.5 rtl:ml-1.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Queue
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-[10px] mb-6 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-[10px] mb-6 animate-fade-in">
                <ul class="list-disc ltr:pl-4 rtl:pr-4 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            
            <!-- LEFT COLUMN (60%) -->
            <div class="w-full lg:w-[60%] flex flex-col space-y-6">
                
                <!-- Appointment Info Card -->
                <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 100ms;">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-slate-800/50">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Appointment Information</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Applicant Name</p>
                            <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment->full_name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">National ID</p>
                            <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment->national_id_number ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Document Type</p>
                            <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment->document_type ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Preferred Date</p>
                            <p class="text-[14px] font-bold text-gray-900 dark:text-white">
                                {{ $application->appointment ? \Carbon\Carbon::parse($application->appointment->date)->format('M d, Y') : '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Time Slot</p>
                            <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment->time_slot ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Submitted At</p>
                            <p class="text-[14px] font-bold text-gray-900 dark:text-white">
                                {{ $application->submitted_at ? $application->submitted_at->format('M d, Y h:i A') : '—' }}
                            </p>
                        </div>
                        @if($application->appointment?->notes)
                            <div class="sm:col-span-2 bg-gray-50 dark:bg-slate-800/30 p-4 rounded-[10px] border border-gray-100 dark:border-gray-800">
                                <p class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Applicant Notes</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 italic">"{{ $application->appointment->notes }}"</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 200ms;">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Uploaded Documents</h3>
                        <span class="text-xs text-gray-500 font-bold bg-gray-200 dark:bg-slate-700 px-2 py-0.5 rounded">{{ $application->documents->count() }} Files</span>
                    </div>
                    <div class="p-6">
                        @if($application->documents->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No documents uploaded yet.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($application->documents as $doc)
                                    <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-[10px] bg-gray-50 dark:bg-slate-800/30">
                                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                            <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-[8px] flex items-center justify-center text-brand dark:text-indigo-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div>
                                                <a href="{{ route('staff.documents.view', $doc->id) }}"
                                                   class="text-sm font-semibold text-brand dark:text-indigo-400 hover:underline line-clamp-1"
                                                   target="_blank">
                                                    {{ $doc->original_name ?? $doc->document_name }}
                                                </a>
                                                @php
                                                    $documentSourceLabel = 'Citizen will bring original';

                                                    if ($doc->source === 'upload') {
                                                        $documentSourceLabel = 'Uploaded file';

                                                        if ($doc->file_size) {
                                                            $documentSourceLabel .= ' - ' . number_format($doc->file_size / 1024, 1) . ' KB';
                                                        }
                                                    } elseif ($doc->source === 'vault') {
                                                        $documentSourceLabel = 'From vault';
                                                    }
                                                @endphp
                                                <p class="text-xs text-gray-500 mt-0.5 capitalize">{{ $documentSourceLabel }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Verified Toggle Display -->
                                        <label class="flex items-center cursor-pointer">
                                            <div class="relative">
                                                <input type="checkbox" class="sr-only" {{ $loop->first ? 'checked' : '' }}>
                                                <div class="block bg-gray-300 dark:bg-gray-600 w-10 h-6 rounded-full transition-colors"></div>
                                                <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform"></div>
                                            </div>
                                            <span class="ltr:ml-2 rtl:mr-2 text-xs font-semibold text-gray-500 dark:text-gray-400">Verified</span>
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

                <!-- Timeline -->
                <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 300ms;">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-slate-800/50">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Status Timeline</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $badgeColors = [
                                'submitted'    => ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300'],
                                'under_review' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400'],
                                'approved'     => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400'],
                                'rejected'     => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-400'],
                            ];
                        @endphp
                        
                        <div class="relative">
                            @foreach($application->statusLogs as $index => $log)
                                @php
                                    $isLast = $loop->last;
                                    $logBadge = $badgeColors[$log->status] ?? $badgeColors['submitted'];
                                    
                                    $iconSvg = '';
                                    $iconColorClass = '';
                                    $bgColorClass = '';
                                    
                                    switch($log->status) {
                                        case 'submitted':
                                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                                            $iconColorClass = 'text-gray-500 dark:text-gray-400';
                                            $bgColorClass = 'bg-gray-100 dark:bg-gray-800';
                                            break;
                                        case 'under_review':
                                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>';
                                            $iconColorClass = 'text-yellow-500 dark:text-yellow-400';
                                            $bgColorClass = 'bg-yellow-100 dark:bg-yellow-900/30';
                                            break;
                                        case 'approved':
                                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                                            $iconColorClass = 'text-green-500 dark:text-green-400';
                                            $bgColorClass = 'bg-green-100 dark:bg-green-900/30';
                                            break;
                                        case 'rejected':
                                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                                            $iconColorClass = 'text-red-500 dark:text-red-400';
                                            $bgColorClass = 'bg-red-100 dark:bg-red-900/30';
                                            break;
                                    }
                                @endphp

                                <div class="relative flex">
                                    <!-- Connector Line -->
                                    @if(!$isLast)
                                        <div class="absolute ltr:left-[19px] rtl:right-[19px] top-9 bottom-0 w-0.5 bg-gray-200 dark:bg-slate-700"></div>
                                    @endif

                                    <!-- Left Column -->
                                    <div class="w-[40px] shrink-0 flex flex-col items-center pt-1 relative z-10">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $bgColorClass }} {{ $iconColorClass }} shadow-sm ring-4 ring-white dark:ring-[#1e293b]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $iconSvg !!}</svg>
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="flex-grow ltr:pl-4 rtl:pr-4 pb-8">
                                        <h4 class="text-[15px] font-bold capitalize {{ $logBadge['text'] }}">
                                            {{ str_replace('_', ' ', $log->status) }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            {{ $log->created_at->format('M d, Y h:i A') }}
                                        </p>
                                        @if($log->notes)
                                            <div class="mt-2 text-[13px] text-gray-600 dark:text-gray-300 italic bg-gray-50 dark:bg-slate-800/30 p-3 rounded-[8px] border border-gray-100 dark:border-slate-700">
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

            <!-- RIGHT COLUMN (40%) -->
            <div class="w-full lg:w-[40%]">
                <div class="sticky top-24">
                    
                    @php
                        $currBadge = $badgeColors[$application->current_status] ?? $badgeColors['submitted'];
                    @endphp

                    <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 400ms;">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-slate-800/50">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider text-center">Update Status</h3>
                        </div>
                        
                        <div class="p-6 flex flex-col items-center">
                            <p class="text-[11px] text-gray-400 uppercase font-semibold mb-2">Current Status</p>
                            <div class="px-4 py-2 rounded-full font-bold text-sm uppercase {{ $currBadge['bg'] }} {{ $currBadge['text'] }} mb-8">
                                {{ str_replace('_', ' ', $application->current_status) }}
                            </div>

                            @if(count($nextStatuses) > 0)
                                <form method="POST" action="{{ route('staff.applications.update-status', $application->id) }}" class="w-full text-left ltr:text-left rtl:text-right" 
                                      x-data="{ status: '{{ old('new_status') }}', notes: `{{ old('notes') }}`, confirmed: false }" 
                                      @submit.prevent="
                                    if (status === 'rejected' && !confirmed) { $dispatch('open-modal', 'confirm-rejection') }
                                    else if (status === 'approved' && !confirmed) { $dispatch('open-modal', 'confirm-approval') }
                                    else { $el.submit() }
                                ">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-4 relative">
                                        <label for="new_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Next Status</label>
                                        <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 mt-6 flex items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                        </div>
                                        <select id="new_status" name="new_status" required x-model="status"
                                                class="block w-full h-[48px] ltr:pl-9 rtl:pr-9 rtl:pl-3 ltr:pr-3 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all font-semibold">
                                            <option value="">Choose...</option>
                                            @foreach ($nextStatuses as $value => $label)
                                                <option value="{{ $value }}">
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-6 relative" x-show="status !== 'rejected'">
                                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Add notes for the citizen...</label>
                                        <textarea id="notes" name="notes" rows="3" x-model="notes"
                                                  class="block w-full p-3 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all text-sm"></textarea>
                                        <p class="text-xs text-gray-400 mt-1">This will be visible on their public tracking page.</p>
                                    </div>

                                    <button type="submit" x-ref="submitBtn" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all">
                                        Update Status
                                    </button>

                                    <!-- Approval Modal -->
                                    <x-modal name="confirm-approval">
                                        <div class="p-6">
                                            <div class="flex items-center gap-3 mb-4 text-green-600 dark:text-green-500">
                                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <h2 class="text-xl font-bold font-outfit">Confirm Approval</h2>
                                            </div>

                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                                                You are about to <strong>approve</strong> this application. The citizen will be notified by email. This action cannot be undone.
                                            </p>

                                            <div class="flex items-center justify-end gap-3">
                                                <button type="button" x-on:click="$dispatch('close')"
                                                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 rounded-[10px] font-semibold transition-colors text-sm">
                                                    Cancel
                                                </button>
                                                <button type="button" x-on:click="confirmed = true; $refs.submitBtn.click()"
                                                        class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-[10px] font-semibold shadow-md transition-colors text-sm flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Confirm Approval
                                                </button>
                                            </div>
                                        </div>
                                    </x-modal>

                                    <!-- Rejection Modal -->
                                    <x-modal name="confirm-rejection">
                                        <div class="p-6">
                                            <div class="flex items-center gap-3 mb-4 text-red-600 dark:text-red-500">
                                                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                </div>
                                                <h2 class="text-xl font-bold font-outfit">Confirm Rejection</h2>
                                            </div>
                                            
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                Are you sure you want to reject this application? This cannot be undone.
                                            </p>

                                            <div class="mb-6">
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Rejection reason (required)</label>
                                                <textarea rows="4" x-model="notes" required x-ref="rejectNotes"
                                                          placeholder="Please explain why this application is being rejected..."
                                                          class="block w-full p-3 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-red-500 focus:ring-0 focus:shadow-[0_0_0_3px_#fee2e2] dark:focus:shadow-[0_0_0_3px_rgba(220,38,38,0.3)] transition-all text-sm"></textarea>
                                            </div>

                                            <div class="flex items-center justify-end gap-3">
                                                <button type="button" x-on:click="$dispatch('close-modal', 'confirm-rejection')" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 rounded-[10px] font-semibold transition-colors text-sm">
                                                    Cancel
                                                </button>
                                                <button type="button" x-on:click="if(notes.trim() !== '') { confirmed = true; $refs.submitBtn.click(); } else { $refs.rejectNotes.focus(); }" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-[10px] font-semibold shadow-md transition-colors text-sm flex items-center">
                                                    Confirm Rejection
                                                </button>
                                            </div>
                                        </div>
                                    </x-modal>
                                </form>
                            @else
                                <div class="w-full bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-[12px] p-5 text-center">
                                    <div class="w-12 h-12 bg-white dark:bg-[#0f172a] rounded-full mx-auto flex items-center justify-center mb-3 shadow-sm border border-gray-100 dark:border-gray-800">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <h4 class="text-[15px] font-bold text-gray-900 dark:text-white mb-1">Status Finalized</h4>
                                    <p class="text-[13px] text-gray-500 dark:text-gray-400">
                                        This application has reached its final state. No further updates are possible.
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
