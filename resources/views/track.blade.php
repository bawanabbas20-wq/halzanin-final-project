<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-outfit">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Track Application{{ $application ? ' - ' . $application->tracking_code : '' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        // Initialize theme
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Initialize language
        if (localStorage.lang === 'ku') {
            document.documentElement.dir = 'rtl';
            document.documentElement.lang = 'ku';
            document.documentElement.classList.remove('font-outfit');
            document.documentElement.classList.add('font-arabic');
        } else {
            document.documentElement.dir = 'ltr';
            document.documentElement.lang = 'en';
            document.documentElement.classList.add('font-outfit');
            document.documentElement.classList.remove('font-arabic');
        }
    </script>
</head>
<body class="bg-[#f8fafc] dark:bg-[#0f172a] text-gray-900 dark:text-[#f1f5f9] antialiased transition-colors duration-200 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white dark:bg-[#1e293b] border-b border-gray-200 dark:border-slate-700 animate-fade-in z-50 sticky top-0">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <!-- Left: Logo & Brand -->
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-bold font-outfit">H</span>
                </div>
                <span class="font-bold text-brand dark:text-white font-outfit text-lg">Halzanîn</span>
            </div>

            <!-- Right: Toggles -->
            <div class="flex items-center space-x-3 rtl:space-x-reverse bg-gray-50 dark:bg-[#0f172a] px-2 py-1 rounded-full border border-gray-200 dark:border-slate-700">
                <!-- Dark Mode Toggle -->
                <button id="theme-toggle" class="p-1.5 rounded-full text-brand dark:text-[#f1f5f9] hover:bg-brand/10 dark:hover:bg-[#f1f5f9]/10 transition">
                    <svg id="theme-toggle-light-icon" class="hidden w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>
                <div class="w-px h-4 bg-gray-300 dark:bg-slate-600"></div>
                <!-- Language Toggle -->
                <button id="lang-toggle" class="flex items-center text-xs font-semibold transition overflow-hidden">
                    <span id="lang-en" class="px-2 py-0.5 rounded-full transition-colors">EN</span>
                    <span id="lang-ku" class="px-2 py-0.5 rounded-full transition-colors font-arabic">کوردی</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow w-full max-w-5xl mx-auto px-4 sm:px-6 py-8 flex flex-col items-center">
        
        <!-- Hero Section -->
        <div class="text-center w-full max-w-[600px] mb-8 animate-fade-up" style="animation-delay: 100ms;">
            <h1 class="text-[28px] font-bold text-brand dark:text-white font-outfit mb-2">Track Your Application</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Real-time status updates for your document submission</p>
        </div>

        @if(!$application)
            <!-- Search & Scan Section -->
            <div class="w-full max-w-[600px] bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 p-6 animate-fade-up" style="animation-delay: 200ms;">
                <form action="javascript:void(0)" onsubmit="manualTrack()" class="flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" id="manualTrackingCode" placeholder="Enter tracking code (e.g. TRK-...)" class="flex-1 h-[48px] rounded-[10px] border-gray-300 dark:border-slate-600 bg-transparent dark:text-white focus:border-brand focus:ring-0 px-4 transition-colors">
                        <button type="submit" class="h-[48px] px-6 bg-brand text-white font-semibold rounded-[10px] shadow-brand-btn hover:-translate-y-[1px] transition-all">Track Now</button>
                    </div>
                    
                    <div class="flex items-center gap-4 my-2">
                        <div class="flex-1 h-px bg-gray-200 dark:bg-slate-700"></div>
                        <span class="text-sm text-gray-400 font-semibold uppercase">OR</span>
                        <div class="flex-1 h-px bg-gray-200 dark:bg-slate-700"></div>
                    </div>

                    <button type="button" onclick="startScanner()" class="h-[48px] w-full flex items-center justify-center gap-2 bg-emerald-500 text-white font-semibold rounded-[10px] shadow-md hover:-translate-y-[1px] transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Scan QR Code
                    </button>
                </form>
            </div>
        @else

        @php
            $badgeColors = [
                'submitted'    => ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300'],
                'received'     => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400'],
                'under_review' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400'],
                'approved'     => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400'],
                'rejected'     => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-400'],
            ];
            $currentBadge = $badgeColors[$application->current_status] ?? $badgeColors['submitted'];
            $statusLabel = str_replace('_', ' ', $application->current_status);
        @endphp

        <!-- Application Info Card -->
        <div class="w-full max-w-[600px] bg-white dark:bg-[#1e293b] rounded-[16px] shadow-md mb-10 overflow-hidden animate-fade-up" style="animation-delay: 200ms;">
            <div class="p-6">
                <!-- Top Row -->
                <div class="flex items-center justify-between mb-4">
                    <span class="font-mono font-bold text-brand dark:text-indigo-400 text-lg tracking-widest">{{ $application->tracking_code }}</span>
                    <span class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $currentBadge['bg'] }} {{ $currentBadge['text'] }}">
                        {{ $statusLabel }}
                    </span>
                </div>
                
                <hr class="border-gray-100 dark:border-slate-700 mb-6">
                
                <!-- 2-Column Grid (1 on mobile) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Applicant Name</p>
                        <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment->full_name ?? $application->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Document Type</p>
                        <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment->document_type ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Submitted Date</p>
                        <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->submitted_at ? $application->submitted_at->format('M d, Y h:i A') : '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Appointment Date</p>
                        <p class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $application->appointment ? \Carbon\Carbon::parse($application->appointment->preferred_date)->format('M d, Y') : '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="w-full max-w-[600px] mb-12">
            <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-6">
                <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2 text-brand dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Status Timeline
            </h3>

            <div class="relative">
                @foreach($application->statusLogs as $index => $log)
                    @php
                        $isLast = $loop->last;
                        $logBadge = $badgeColors[$log->status] ?? $badgeColors['submitted'];
                        
                        // Icons mapping
                        $iconSvg = '';
                        $iconColorClass = '';
                        $bgColorClass = '';
                        
                        switch($log->status) {
                            case 'submitted':
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                                $iconColorClass = 'text-gray-500 dark:text-gray-400';
                                $bgColorClass = 'bg-gray-100 dark:bg-gray-800';
                                break;
                            case 'received':
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>';
                                $iconColorClass = 'text-blue-500 dark:text-blue-400';
                                $bgColorClass = 'bg-blue-100 dark:bg-blue-900/30';
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
                            default:
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
                                $iconColorClass = 'text-gray-500 dark:text-gray-400';
                                $bgColorClass = 'bg-gray-100 dark:bg-gray-800';
                                break;
                        }

                        $delay = 300 + ($index * 100);
                        $highlightClass = $isLast ? $logBadge['bg'] . ' rounded-[12px] p-3 -mx-3' : 'pb-8';
                    @endphp

                    <div class="relative flex animate-fade-up" style="animation-delay: {{ $delay }}ms;">
                        <!-- Connector Line -->
                        @if(!$isLast)
                            <div class="absolute ltr:left-[19px] sm:ltr:left-[23px] rtl:right-[19px] sm:rtl:right-[23px] top-9 bottom-0 w-0.5 bg-gray-200 dark:bg-slate-700"></div>
                        @endif

                        <!-- Left Column (Icon) -->
                        <div class="w-[40px] sm:w-[48px] shrink-0 flex flex-col items-center pt-1 relative z-10">
                            <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full flex items-center justify-center {{ $bgColorClass }} {{ $iconColorClass }} shadow-sm ring-4 ring-[#f8fafc] dark:ring-[#0f172a]">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $iconSvg !!}</svg>
                            </div>
                        </div>

                        <!-- Right Column (Content) -->
                        <div class="flex-grow ltr:pl-4 rtl:pr-4 {{ $highlightClass }}">
                            <h4 class="text-base font-bold capitalize {{ $logBadge['text'] }}">
                                {{ str_replace('_', ' ', $log->status) }}
                            </h4>
                            <p class="text-[12px] sm:text-[13px] text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $log->created_at->format('M d, Y h:i A') }}
                            </p>
                            @if($log->notes)
                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-300 italic bg-white dark:bg-[#1e293b] p-3 rounded-[8px] border border-gray-100 dark:border-slate-700 shadow-sm">
                                    "{{ $log->notes }}"
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bottom CTA Section -->
        <div class="w-full max-w-[600px] animate-fade-up" style="animation-delay: {{ 300 + ($application->statusLogs->count() * 100) }}ms;">
            @if($application->current_status === 'approved')
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-[12px] p-4 text-center mb-6">
                    <p class="text-green-800 dark:text-green-300 font-semibold text-sm">
                        🎉 Your document is ready! Please visit the Passport Directorate to collect it.
                    </p>
                </div>
            @elseif($application->current_status === 'rejected')
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-[12px] p-4 text-center mb-6">
                    <p class="text-red-800 dark:text-red-300 font-semibold text-sm">
                        ⚠️ Your application was rejected. Please review the notes above and resubmit.
                    </p>
                </div>
            @else
                <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-[12px] p-4 flex flex-col sm:flex-row items-center justify-between mb-6">
                    <p class="text-brand dark:text-indigo-300 text-sm font-medium text-center sm:text-left sm:rtl:text-right mb-3 sm:mb-0">
                        Your application is being processed. Check back later for updates.
                    </p>
                    <button onclick="window.location.reload()" class="shrink-0 px-4 py-2 bg-white dark:bg-[#1e293b] border border-indigo-200 dark:border-indigo-700 rounded-[8px] text-xs font-semibold text-brand dark:text-indigo-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors flex items-center">
                        <svg class="w-3.5 h-3.5 ltr:mr-1.5 rtl:ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Refresh Status
                    </button>
                </div>
            @endif

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-brand dark:text-indigo-400 hover:underline">
                    Login to your account
                </a>
            </div>
        </div>
        @endif

    </main>

    <!-- QR Code Scanner Modal -->
    <div id="qrModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white dark:bg-[#1e293b] rounded-[24px] shadow-2xl p-6 w-[90%] max-w-[400px] transform scale-95 transition-transform duration-300 relative" id="qrModalContent">
            <button type="button" onclick="stopScanner()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="text-center mb-4 mt-2">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white font-outfit mb-1">Scan QR Code</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Point your camera at the QR code</p>
            </div>
            <div class="rounded-[16px] overflow-hidden border-2 border-brand/20 relative bg-black/5 dark:bg-white/5">
                <div id="reader" style="width: 100%; min-height: 250px;"></div>
            </div>
        </div>
    </div>

    <script>
        // QR Scanner Logic
        let html5QrcodeScanner = null;

        function manualTrack() {
            const code = document.getElementById('manualTrackingCode').value.trim();
            if (code) {
                window.location.href = `/track/${code}`;
            }
        }

        function startScanner() {
            const modal = document.getElementById('qrModal');
            const modalContent = document.getElementById('qrModalContent');
            
            modal.classList.remove('hidden');
            // Trigger animation next frame
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                });
            });

            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5Qrcode("reader");
            }

            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            
            html5QrcodeScanner.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
                .catch((err) => {
                    console.error(err);
                    alert("Unable to access camera. Please check your permissions.");
                    stopScanner();
                });
        }

        function stopScanner() {
            if (html5QrcodeScanner && html5QrcodeScanner.isScanning) {
                html5QrcodeScanner.stop().catch(err => console.error(err));
            }
            const modal = document.getElementById('qrModal');
            const modalContent = document.getElementById('qrModalContent');
            
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function onScanSuccess(decodedText, decodedResult) {
            stopScanner();
            if (decodedText.includes('/track/')) {
                window.location.href = decodedText;
            } else {
                window.location.href = `/track/${decodedText}`;
            }
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning
        }

        // Theme Toggle Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            lightIcon.classList.remove('hidden');
        } else {
            darkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');

            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // Language Toggle Logic
        const langToggleBtn = document.getElementById('lang-toggle');
        const langEn = document.getElementById('lang-en');
        const langKu = document.getElementById('lang-ku');

        function updateLangUI(lang) {
            if (lang === 'ku') {
                langKu.classList.add('bg-brand', 'text-white', 'dark:bg-[#f1f5f9]', 'dark:text-brand');
                langKu.classList.remove('text-brand', 'dark:text-[#f1f5f9]', 'bg-transparent');
                langEn.classList.remove('bg-brand', 'text-white', 'dark:bg-[#f1f5f9]', 'dark:text-brand');
                langEn.classList.add('text-brand', 'dark:text-[#f1f5f9]', 'bg-transparent');
            } else {
                langEn.classList.add('bg-brand', 'text-white', 'dark:bg-[#f1f5f9]', 'dark:text-brand');
                langEn.classList.remove('text-brand', 'dark:text-[#f1f5f9]', 'bg-transparent');
                langKu.classList.remove('bg-brand', 'text-white', 'dark:bg-[#f1f5f9]', 'dark:text-brand');
                langKu.classList.add('text-brand', 'dark:text-[#f1f5f9]', 'bg-transparent');
            }
        }

        updateLangUI(localStorage.lang || 'en');

        langToggleBtn.addEventListener('click', function() {
            const currentLang = document.documentElement.lang;
            if (currentLang === 'en') {
                document.documentElement.dir = 'rtl';
                document.documentElement.lang = 'ku';
                document.documentElement.classList.remove('font-outfit');
                document.documentElement.classList.add('font-arabic');
                localStorage.setItem('lang', 'ku');
                updateLangUI('ku');
            } else {
                document.documentElement.dir = 'ltr';
                document.documentElement.lang = 'en';
                document.documentElement.classList.add('font-outfit');
                document.documentElement.classList.remove('font-arabic');
                localStorage.setItem('lang', 'en');
                updateLangUI('en');
            }
        });
    </script>
</body>
</html>
