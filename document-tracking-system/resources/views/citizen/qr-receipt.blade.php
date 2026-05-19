@extends('layouts.halzanin-app')

@section('content')
<style>
    .anim-scale-in {
        animation: scaleIn 400ms cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        transform: scale(0);
    }
    .anim-draw-check {
        stroke-dasharray: 100;
        stroke-dashoffset: 100;
        animation: drawCheck 600ms ease-out 200ms forwards;
    }
    @keyframes scaleIn { from { transform: scale(0); } to { transform: scale(1); } }
    @keyframes drawCheck { to { stroke-dashoffset: 0; } }
    .ticket-card { filter: drop-shadow(0 20px 25px rgba(0,0,0,0.10)); }

    /* ===== PRINT STYLES ===== */
    @media print {
        body * { visibility: hidden !important; }
        #printable-receipt,
        #printable-receipt * { visibility: visible !important; }
        #printable-receipt {
            position: fixed !important;
            top: 0 !important; left: 0 !important;
            width: 100% !important;
            padding: 15mm 20mm !important;
            background: #fff !important;
        }
        .ticket-inner {
            background: #fff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            box-shadow: none !important;
        }
        .tracking-code-print { color: #312e81 !important; }
        .print-divider { border-top: 2px dashed #cbd5e1 !important; }
        @page { size: A4 portrait; margin: 0; }
    }
</style>

<div class="w-full max-w-[480px] mx-auto flex flex-col items-center">

    {{-- Success Header --}}
    <div class="flex flex-col items-center text-center mb-8 print:hidden">
        <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center mb-4 anim-scale-in shadow-lg">
            <svg class="w-8 h-8 text-white anim-draw-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-accent font-outfit mb-1">Application Submitted!</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Your QR receipt is ready — print it or save it</p>
    </div>

    {{-- ===== PRINTABLE RECEIPT ===== --}}
    <div id="printable-receipt" class="w-full ticket-card animate-fade-up" style="animation-delay: 300ms;">

        {{-- Print-only title --}}
        <div class="hidden print:block mb-6 text-center border-b border-gray-200 pb-4">
            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Kurdistan Region — Passport Directorate</p>
            <h1 class="text-xl font-bold text-gray-900">Appointment Receipt</h1>
        </div>

        <div class="ticket-inner bg-white dark:bg-[#1e293b] rounded-[24px] w-full flex flex-col overflow-hidden">

            {{-- Top: Brand + Date + Details --}}
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-bold">H</span>
                        </div>
                        <span class="font-bold text-brand dark:text-white font-outfit">Halzanîn</span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">
                        {{ $application->submitted_at ? $application->submitted_at->format('M d, Y') : now()->format('M d, Y') }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-x-4 gap-y-4">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Applicant Name</p>
                        <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $application->appointment->full_name ?? $application->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5">National ID</p>
                        <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $application->appointment->national_id_number ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Document Type</p>
                        <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $application->appointment->document_type ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Appointment</p>
                        <p class="font-bold text-gray-900 dark:text-white text-sm">
                            @if($application->appointment)
                                {{ \Carbon\Carbon::parse($application->appointment->date)->format('M d, Y') }}
                                · {{ $application->appointment->time_slot }}
                            @else —
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Dashed Divider --}}
            <div class="relative">
                <div class="print-divider border-t-2 border-dashed border-[#e2e8f0] dark:border-slate-700"></div>
                <div class="absolute -left-3 -top-3 w-6 h-6 bg-[#f8fafc] dark:bg-[#0f172a] rounded-full"></div>
                <div class="absolute -right-3 -top-3 w-6 h-6 bg-[#f8fafc] dark:bg-[#0f172a] rounded-full"></div>
            </div>

            {{-- QR Code --}}
            <div class="p-6 flex flex-col items-center">
                <p class="text-[11px] text-gray-400 tracking-[0.1em] uppercase font-semibold mb-1">Tracking Code</p>
                <p class="tracking-code-print font-bold text-[28px] text-brand dark:text-indigo-400 font-mono tracking-wider mb-5">
                    {{ $application->tracking_code }}
                </p>
                <div class="p-3 bg-white rounded-[16px] inline-block border border-gray-200 shadow-sm">
                    <div class="w-[180px] h-[180px] flex items-center justify-center">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->margin(0)->generate(url('/track/' . $application->tracking_code)) !!}
                    </div>
                </div>
            </div>

            {{-- Dashed Divider --}}
            <div class="relative">
                <div class="print-divider border-t-2 border-dashed border-[#e2e8f0] dark:border-slate-700"></div>
                <div class="absolute -left-3 -top-3 w-6 h-6 bg-[#f8fafc] dark:bg-[#0f172a] rounded-full"></div>
                <div class="absolute -right-3 -top-3 w-6 h-6 bg-[#f8fafc] dark:bg-[#0f172a] rounded-full"></div>
            </div>

            {{-- Footer --}}
            <div class="py-5 px-6 text-center">
                <p class="text-[12px] text-gray-500 dark:text-gray-400 leading-relaxed">
                    Scan the QR code or visit <strong class="font-mono text-brand dark:text-indigo-400">{{ url('/track/' . $application->tracking_code) }}</strong>
                </p>
                <p class="text-[11px] text-gray-400 mt-1.5">Please bring this receipt to your appointment.</p>
            </div>

        </div>
    </div>
    {{-- ===== END PRINTABLE RECEIPT ===== --}}

    {{-- Action Buttons --}}
    <div class="w-full flex flex-col space-y-3 mt-8 animate-fade-up print:hidden" style="animation-delay: 500ms;">
        <button onclick="window.print()"
            class="flex items-center justify-center w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all">
            <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Receipt
        </button>
        <a href="{{ route('citizen.dashboard') }}"
            class="flex items-center justify-center w-full h-[52px] bg-transparent border-2 border-brand dark:border-indigo-400 text-brand dark:text-indigo-400 rounded-[10px] font-semibold font-outfit hover:bg-brand/5 transition-colors">
            Back to Dashboard
        </a>
    </div>

</div>
@endsection
