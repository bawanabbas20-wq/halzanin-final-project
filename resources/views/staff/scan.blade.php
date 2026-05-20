@extends('layouts.halzanin-app')

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@section('content')
<div class="max-w-xl mx-auto pb-10 space-y-6" x-data="qrScanner()" x-init="init()">

    {{-- Header --}}
    <div class="flex items-center justify-between animate-fade-in">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-1 h-7 bg-gradient-to-b from-brand to-accent rounded-full"></div>
                <h2 class="text-2xl font-bold font-outfit text-gradient">QR Check-in Scanner</h2>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 ltr:pl-4 rtl:pr-4">Scan citizen QR codes to check them in</p>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-full">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400">Live Scanner</span>
        </div>
    </div>

    {{-- Camera Viewfinder Card --}}
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay:100ms">
        <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
        <div class="p-6">
            <div id="qr-reader" class="rounded-xl overflow-hidden w-full"></div>

            {{-- Idle state before camera starts --}}
            <div id="scan-idle" class="flex flex-col items-center justify-center py-12 gap-4">
                <div class="w-20 h-20 bg-brand/8 dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-brand dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Camera not started</p>
                <button x-on:click="startScanner()"
                        class="px-6 py-2.5 bg-brand text-white text-sm font-semibold rounded-xl shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-px transition-all">
                    Start Camera
                </button>
            </div>

            {{-- Manual entry fallback --}}
            <div class="mt-4 flex items-center gap-3">
                <div class="flex-1 h-px bg-gray-200 dark:bg-slate-700"></div>
                <span class="text-xs text-gray-400 font-semibold uppercase">or enter manually</span>
                <div class="flex-1 h-px bg-gray-200 dark:bg-slate-700"></div>
            </div>
            <form x-on:submit.prevent="checkin(manualCode)" class="mt-3 flex gap-2">
                <input type="text" x-model="manualCode" placeholder="TRK-XXXXXXXX"
                       class="flex-1 h-[42px] px-4 rounded-xl border-gray-200 dark:border-slate-600 dark:bg-[#0f172a] dark:text-white text-sm focus:border-brand focus:ring-0 transition-all font-mono">
                <button type="submit"
                        class="px-4 h-[42px] bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand-light transition-colors shrink-0">
                    Check In
                </button>
            </form>
        </div>
    </div>

    {{-- Result card (slides up) --}}
    <div x-show="result" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
         class="rounded-2xl shadow-lg border overflow-hidden"
         :class="{
             'bg-white dark:bg-[#1e293b] border-gray-100 dark:border-slate-800': result?.status === 'success',
             'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800': result?.status === 'already_checked_in' || result?.status === 'wrong_date',
             'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800': result?.status === 'not_found' || result?.status === 'error',
         }">

        {{-- SUCCESS --}}
        <template x-if="result?.status === 'success'">
            <div>
                <div class="h-1.5 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center text-2xl font-bold text-emerald-600 uppercase shrink-0">
                            <span x-text="result.citizen_name?.charAt(0) || '?'"></span>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white text-lg" x-text="result.citizen_name"></p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-mono" x-text="result.tracking_code"></p>
                            <template x-if="result.appointment_time">
                                <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-0.5">
                                    Appointment: <span x-text="result.appointment_time"></span>
                                </p>
                            </template>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-3 bg-emerald-500 rounded-xl text-white">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span class="font-bold">Checked In!</span>
                    </div>
                    <button x-on:click="result = null; manualCode = ''; startScanner()"
                            class="mt-4 w-full py-2.5 text-sm font-semibold text-brand dark:text-indigo-400 bg-brand/8 dark:bg-indigo-900/20 hover:bg-brand/15 rounded-xl transition-colors">
                        Scan Next
                    </button>
                </div>
            </div>
        </template>

        {{-- ALREADY CHECKED IN --}}
        <template x-if="result?.status === 'already_checked_in'">
            <div class="p-6 flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <p class="font-bold text-amber-800 dark:text-amber-300">Already checked in</p>
                    <p class="text-sm text-amber-700 dark:text-amber-400 mt-1">
                        <span x-text="result.citizen_name"></span> was checked in at <span class="font-semibold" x-text="result.checked_in_at"></span>
                    </p>
                    <button x-on:click="result = null" class="mt-3 text-xs font-semibold text-amber-700 dark:text-amber-400 hover:underline">Dismiss</button>
                </div>
            </div>
        </template>

        {{-- WRONG DATE --}}
        <template x-if="result?.status === 'wrong_date'">
            <div class="p-6 flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <div>
                    <p class="font-bold text-amber-800 dark:text-amber-300">Wrong appointment date</p>
                    <p class="text-sm text-amber-700 dark:text-amber-400 mt-1">
                        Appointment is on <span class="font-semibold" x-text="result.appointment_date"></span>, not today.
                    </p>
                    <button x-on:click="result = null" class="mt-3 text-xs font-semibold text-amber-700 dark:text-amber-400 hover:underline">Dismiss</button>
                </div>
            </div>
        </template>

        {{-- NOT FOUND / ERROR --}}
        <template x-if="result?.status === 'not_found' || result?.status === 'error'">
            <div class="p-6 flex items-start gap-3">
                <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="font-bold text-red-800 dark:text-red-300">QR code not recognized</p>
                    <p class="text-sm text-red-700 dark:text-red-400 mt-1">No application found for this tracking code.</p>
                    <button x-on:click="result = null" class="mt-3 text-xs font-semibold text-red-700 dark:text-red-400 hover:underline">Dismiss</button>
                </div>
            </div>
        </template>
    </div>

</div>

<script>
function qrScanner() {
    return {
        manualCode: '',
        result: null,
        scanner: null,

        init() {
            // auto-start
            this.$nextTick(() => this.startScanner());
        },

        startScanner() {
            const idle = document.getElementById('scan-idle');
            if (idle) idle.style.display = 'none';

            if (this.scanner) {
                this.scanner.resume().catch(() => {});
                return;
            }

            this.scanner = new Html5Qrcode('qr-reader');
            this.scanner.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 260, height: 260 } },
                (decodedText) => {
                    this.scanner.pause(true);
                    this.checkin(decodedText.trim());
                },
                () => {}
            ).catch(() => {
                if (idle) idle.style.display = 'flex';
            });
        },

        async checkin(code) {
            if (!code) return;
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]').content;
                const res = await fetch('{{ route('staff.scan.checkin') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ tracking_code: code }),
                });
                const data = await res.json();
                this.result = data;
            } catch(e) {
                this.result = { status: 'error' };
            }
            this.manualCode = '';
        },
    };
}
</script>
@endsection
