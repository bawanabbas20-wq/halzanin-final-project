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
    @keyframes scaleIn {
        from { transform: scale(0); }
        to { transform: scale(1); }
    }
    @keyframes drawCheck {
        to { stroke-dashoffset: 0; }
    }
    /* Simple ticket cutout shadow fix to prevent shadow inside the hole */
    .ticket-card {
        filter: drop-shadow(0 20px 25px rgba(0,0,0,0.10));
    }
</style>

<div class="w-full max-w-[480px] mx-auto flex flex-col items-center">

    <!-- Top Section -->
    <div class="flex flex-col items-center text-center mb-8">
        <!-- Animated Checkmark -->
        <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center mb-4 anim-scale-in shadow-lg">
            <svg class="w-8 h-8 text-white anim-draw-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h2 class="text-2xl font-bold text-accent font-outfit mb-1">Application Submitted!</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Your application is being processed</p>
    </div>

    <!-- Ticket Card -->
    <!-- We use a wrapper with drop-shadow so the cutouts don't have weird inner shadows -->
    <div class="w-full ticket-card animate-fade-up" style="animation-delay: 300ms;">
        <div class="bg-white dark:bg-[#1e293b] rounded-[24px] w-full flex flex-col overflow-hidden relative">
            
            <!-- Top Section -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center shrink-0">
                            <span class="text-white text-sm font-bold font-outfit">H</span>
                        </div>
                        <span class="font-bold text-brand dark:text-white font-outfit">Halzanîn</span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">
                        {{ $application->submitted_at ? $application->submitted_at->format('M d, Y') : now()->format('M d, Y') }}
                    </span>
                </div>
                
                <div class="flex flex-col">
                    <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $application->appointment->full_name ?? $application->user->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $application->appointment->document_type ?? 'Document Application' }}</p>
                </div>
            </div>

            <!-- Divider 1 -->
            <div class="relative w-full h-0">
                <div class="absolute w-full border-t-2 border-dashed border-[#e2e8f0] dark:border-slate-700 top-0"></div>
                <!-- Cutouts -->
                <div class="absolute -left-3 -top-3 w-6 h-6 bg-[#f8fafc] dark:bg-[#0f172a] rounded-full"></div>
                <div class="absolute -right-3 -top-3 w-6 h-6 bg-[#f8fafc] dark:bg-[#0f172a] rounded-full"></div>
            </div>

            <!-- Middle Section (QR & Code) -->
            <div class="p-6 flex flex-col items-center">
                <p class="text-[11px] text-gray-400 tracking-[0.1em] uppercase font-semibold mb-1">Tracking Code</p>
                <p class="font-bold text-[28px] text-brand dark:text-indigo-400 font-mono tracking-wider mb-6">{{ $application->tracking_code }}</p>
                
                <div class="p-2 bg-gray-50 dark:bg-white rounded-[16px] inline-block border border-gray-100 dark:border-none shadow-sm">
                    <!-- The QR code SVG string -->
                    <div class="w-[180px] h-[180px] flex items-center justify-center">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->margin(0)->generate(url('/track/' . $application->tracking_code)) !!}
                    </div>
                </div>
            </div>

            <!-- Divider 2 -->
            <div class="relative w-full h-0">
                <div class="absolute w-full border-t-2 border-dashed border-[#e2e8f0] dark:border-slate-700 top-0"></div>
                <!-- Cutouts -->
                <div class="absolute -left-3 -top-3 w-6 h-6 bg-[#f8fafc] dark:bg-[#0f172a] rounded-full"></div>
                <div class="absolute -right-3 -top-3 w-6 h-6 bg-[#f8fafc] dark:bg-[#0f172a] rounded-full"></div>
            </div>

            <!-- Bottom Section -->
            <div class="py-4 px-6 text-center">
                <p class="text-[13px] text-gray-500 dark:text-gray-400 leading-relaxed">
                    Scan the QR code or use the tracking code to check your application status anytime.
                </p>
            </div>
            
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="w-full flex flex-col space-y-3 mt-8 animate-fade-up" style="animation-delay: 500ms;">
        <a href="{{ route('citizen.applications.qr-pdf', $application->id) }}" class="flex items-center justify-center w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all">
            <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download PDF Receipt
        </a>
        <a href="{{ route('citizen.dashboard') }}" class="flex items-center justify-center w-full h-[52px] bg-transparent border-2 border-brand dark:border-indigo-400 text-brand dark:text-indigo-400 rounded-[10px] font-semibold font-outfit hover:bg-brand/5 dark:hover:bg-indigo-400/10 transition-colors">
            Back to Dashboard
        </a>
    </div>

</div>
@endsection
