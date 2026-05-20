@extends('layouts.halzanin-app')

@section('content')

{{-- QR scanner library (loaded inline since layout has no scripts stack) --}}
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<div class="w-full max-w-[620px] mx-auto">

    {{-- Hero --}}
    <div class="mb-7 animate-fade-in">
        <h2 class="text-2xl font-bold font-outfit text-brand dark:text-white" data-i18n="track.title">
            Track Your Application
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="track.subtitle">
            Real-time status updates for your document submission
        </p>
    </div>

    @if(!$application)

        {{-- Search & Scan card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay:100ms;">
            <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
            <div class="p-5 sm:p-6">
                <form action="javascript:void(0)" onsubmit="ctTrack()" class="flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" id="ctCode"
                               placeholder="Enter tracking code (e.g. TRK-...)"
                               data-i18n-placeholder="track.placeholder"
                               class="flex-1 h-[48px] rounded-[10px] border-gray-300 dark:border-gray-700 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 px-4 transition-colors">
                        <button type="submit"
                                class="h-[48px] px-6 bg-brand text-white font-semibold rounded-[10px] shadow-brand-btn hover:-translate-y-[1px] transition-all whitespace-nowrap"
                                data-i18n="track.now">Track Now</button>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-800"></div>
                        <span class="text-xs text-gray-400 font-semibold uppercase" data-i18n="track.or">OR</span>
                        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-800"></div>
                    </div>

                    <button type="button" onclick="ctStartScanner()"
                            class="h-[48px] w-full flex items-center justify-center gap-2 bg-emerald-500 text-white font-semibold rounded-[10px] shadow-md hover:-translate-y-[1px] transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span data-i18n="track.scan_qr">Scan QR Code</span>
                    </button>
                </form>
            </div>
        </div>

    @else

        @php
            $badgeColors = [
                'submitted'    => ['bg' => 'bg-gray-100 dark:bg-gray-800',          'text' => 'text-gray-700 dark:text-gray-300'],
                'checked_in'   => ['bg' => 'bg-purple-100 dark:bg-purple-900/30',   'text' => 'text-purple-700 dark:text-purple-400'],
                'under_review' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30',   'text' => 'text-yellow-700 dark:text-yellow-400'],
                'approved'     => ['bg' => 'bg-green-100 dark:bg-green-900/30',     'text' => 'text-green-700 dark:text-green-400'],
                'rejected'     => ['bg' => 'bg-red-100 dark:bg-red-900/30',         'text' => 'text-red-700 dark:text-red-400'],
            ];
            $currentBadge = $badgeColors[$application->current_status] ?? $badgeColors['submitted'];
            $statusLabel  = str_replace('_', ' ', $application->current_status);
        @endphp

        {{-- Application info card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 mb-6 overflow-hidden animate-fade-up" style="animation-delay:100ms;">
            <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
            <div class="p-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="font-mono font-bold text-brand dark:text-blue-400 text-lg tracking-widest">{{ $application->tracking_code }}</span>
                    <span class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $currentBadge['bg'] }} {{ $currentBadge['text'] }}"
                          data-i18n="status.{{ $application->current_status }}">
                        {{ $statusLabel }}
                    </span>
                </div>
                <hr class="border-gray-100 dark:border-gray-800 mb-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-4">
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1" data-i18n="track.applicant">Applicant Name</p>
                        <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment->full_name ?? $application->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1" data-i18n="track.doc_type">Document Type</p>
                        <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment->document_type ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1" data-i18n="track.submitted">Submitted Date</p>
                        <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->submitted_at ? $application->submitted_at->format('M d, Y h:i A') : '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1" data-i18n="track.appointment">Appointment Date</p>
                        <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment ? \Carbon\Carbon::parse($application->appointment->date)->format('M d, Y') : '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="mb-8 animate-fade-up" style="animation-delay:200ms;">
            <h3 class="flex items-center text-base font-bold text-gray-900 dark:text-white mb-5">
                <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2 text-brand dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span data-i18n="track.timeline">Status Timeline</span>
            </h3>

            <div class="relative">
                @foreach($application->statusLogs as $index => $log)
                    @php
                        $isLast   = $loop->last;
                        $logBadge = $badgeColors[$log->status] ?? $badgeColors['submitted'];
                        $iconMap   = [
                            'submitted'    => ['path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'ic' => 'text-gray-500 dark:text-gray-400', 'bg' => 'bg-gray-100 dark:bg-gray-800'],
                            'under_review' => ['path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>', 'ic' => 'text-yellow-500 dark:text-yellow-400', 'bg' => 'bg-yellow-100 dark:bg-yellow-900/30'],
                            'approved'     => ['path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'ic' => 'text-green-500 dark:text-green-400', 'bg' => 'bg-green-100 dark:bg-green-900/30'],
                            'checked_in'   => ['path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>', 'ic' => 'text-purple-500 dark:text-purple-400', 'bg' => 'bg-purple-100 dark:bg-purple-900/30'],
                            'rejected'     => ['path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'ic' => 'text-red-500 dark:text-red-400', 'bg' => 'bg-red-100 dark:bg-red-900/30'],
                        ];
                        $icon           = $iconMap[$log->status] ?? $iconMap['submitted'];
                        $highlightClass = $isLast ? $logBadge['bg'] . ' rounded-[12px] p-3 -mx-3' : 'pb-8';
                        $delay          = 300 + ($index * 100);
                    @endphp

                    <div class="relative flex animate-fade-up" style="animation-delay:{{ $delay }}ms;">
                        @if(!$isLast)
                            <div class="absolute ltr:left-[19px] sm:ltr:left-[23px] rtl:right-[19px] sm:rtl:right-[23px] top-9 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-800"></div>
                        @endif
                        <div class="w-[40px] sm:w-[48px] shrink-0 flex flex-col items-center pt-1 relative z-10">
                            <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full flex items-center justify-center {{ $icon['bg'] }} {{ $icon['ic'] }} shadow-sm ring-4 ring-[#EFEDE8] dark:ring-[#141414]">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon['path'] !!}</svg>
                            </div>
                        </div>
                        <div class="flex-grow ltr:pl-4 rtl:pr-4 {{ $highlightClass }}">
                            <h4 class="text-base font-bold capitalize {{ $logBadge['text'] }}" data-i18n="status.{{ $log->status }}">
                                {{ str_replace('_', ' ', $log->status) }}
                            </h4>
                            <p class="text-[12px] sm:text-[13px] text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $log->created_at->format('M d, Y h:i A') }}
                            </p>
                            @if($log->notes)
                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-300 italic bg-white dark:bg-[#1F1F1F] p-3 rounded-[8px] border border-gray-100 dark:border-gray-800 shadow-sm">
                                    "{{ $log->notes }}"
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Status CTA --}}
        <div class="animate-fade-up" style="animation-delay:{{ 300 + ($application->statusLogs->count() * 100) }}ms;">
            @if($application->current_status === 'checked_in')
                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-2xl p-4 text-center">
                    <p class="text-purple-800 dark:text-purple-300 font-semibold text-sm">
                        📍 <span data-i18n="track.checked_in">You have been checked in. Please take a seat and wait for your number to be called.</span>
                    </p>
                </div>
            @elseif($application->current_status === 'approved')
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-2xl p-4 text-center">
                    <p class="text-green-800 dark:text-green-300 font-semibold text-sm">
                        🎉 <span data-i18n="track.ready">Your document is ready! Please visit the Passport Directorate to collect it.</span>
                    </p>
                </div>
            @elseif($application->current_status === 'rejected')
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-2xl p-4 text-center">
                    <p class="text-red-800 dark:text-red-300 font-semibold text-sm">
                        ⚠️ <span data-i18n="track.rejected">Your application was rejected. Please review the notes above and resubmit.</span>
                    </p>
                </div>
            @else
                <div class="bg-brand/5 dark:bg-brand/10 border border-brand/15 dark:border-brand/20 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-brand dark:text-blue-300 text-sm font-medium text-center sm:text-left">
                        <span data-i18n="track.processing">Your application is being processed. Check back later for updates.</span>
                    </p>
                    <button onclick="window.location.reload()"
                            class="shrink-0 px-4 py-2 bg-white dark:bg-[#1F1F1F] border border-brand/20 dark:border-brand/30 rounded-[8px] text-xs font-semibold text-brand dark:text-blue-400 hover:bg-brand/5 transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span data-i18n="track.refresh">Refresh Status</span>
                    </button>
                </div>
            @endif
        </div>

    @endif

</div>

{{-- QR Scanner Modal --}}
<div id="ctQrModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div id="ctQrModalContent" class="bg-white dark:bg-[#1F1F1F] rounded-[24px] shadow-2xl p-6 w-[90%] max-w-[400px] transform scale-95 transition-transform duration-300 relative">
        <button type="button" onclick="ctStopScanner()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="text-center mb-4 mt-2">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white font-outfit mb-1" data-i18n="track.scan_qr">Scan QR Code</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400" data-i18n="track.camera_help">Point your camera at the QR code</p>
        </div>
        <div class="rounded-[16px] overflow-hidden border-2 border-brand/20 relative bg-black/5 dark:bg-white/5">
            <div id="ct-reader" style="width:100%;min-height:250px;"></div>
        </div>
    </div>
</div>

<script>
    var ctScanner = null;

    function ctTrack() {
        var code = document.getElementById('ctCode').value.trim();
        if (code) window.location.href = '/track/' + code;
    }

    function ctStartScanner() {
        var modal = document.getElementById('ctQrModal');
        var mc    = document.getElementById('ctQrModalContent');
        modal.classList.remove('hidden');
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                modal.classList.remove('opacity-0');
                mc.classList.remove('scale-95');
            });
        });
        if (!ctScanner) ctScanner = new Html5Qrcode('ct-reader');
        ctScanner.start({ facingMode: 'environment' }, { fps: 10, qrbox: { width: 250, height: 250 } },
            function(text) {
                ctStopScanner();
                window.location.href = text.includes('/track/') ? text : '/track/' + text;
            },
            function() {}
        ).catch(function(err) {
            ctStopScanner();
            if (typeof showToast === 'function') showToast('error', 'Camera Access Denied', 'Please allow camera permissions and try again.');
        });
    }

    function ctStopScanner() {
        if (ctScanner && ctScanner.isScanning) ctScanner.stop().catch(function(){});
        var modal = document.getElementById('ctQrModal');
        var mc    = document.getElementById('ctQrModalContent');
        modal.classList.add('opacity-0');
        mc.classList.add('scale-95');
        setTimeout(function() { modal.classList.add('hidden'); }, 300);
    }
</script>

@endsection
