@extends('layouts.halzanin-app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center space-x-3 animate-fade-in">
        <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-[12px] flex items-center justify-center">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">QR Check-in Scanner</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Scan citizen QR codes to register arrivals for today</p>
        </div>
    </div>

    <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay:100ms">
        <div class="relative bg-black" id="scanner-container" style="min-height: 340px;">
            <div id="reader" class="w-full"></div>

            <div id="scanner-inactive" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900/80 text-white">
                <div class="w-20 h-20 rounded-full bg-emerald-500/20 border-2 border-emerald-400/40 flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="font-semibold text-lg mb-2">Camera is off</p>
                <p class="text-sm text-gray-400 mb-5">Press Start to activate the camera</p>
                <button onclick="startScanner()" id="btn-start" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-[10px] shadow-md transition-colors">
                    Start Scanner
                </button>
            </div>

            <div id="scan-corners" class="absolute inset-0 pointer-events-none hidden">
                <div class="absolute top-4 left-4 w-8 h-8 border-t-4 border-l-4 border-emerald-400 rounded-tl-lg"></div>
                <div class="absolute top-4 right-4 w-8 h-8 border-t-4 border-r-4 border-emerald-400 rounded-tr-lg"></div>
                <div class="absolute bottom-4 left-4 w-8 h-8 border-b-4 border-l-4 border-emerald-400 rounded-bl-lg"></div>
                <div class="absolute bottom-4 right-4 w-8 h-8 border-b-4 border-r-4 border-emerald-400 rounded-br-lg"></div>
            </div>
        </div>

        <div class="p-4 flex items-center justify-between border-t border-gray-100 dark:border-gray-800">
            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                <span id="scan-status-dot" class="w-2 h-2 rounded-full bg-gray-400"></span>
                <span id="scan-status-text">Inactive</span>
            </div>
            <div class="flex gap-2">
                <button onclick="stopScanner()" id="btn-stop" class="hidden px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-[8px] transition-colors">
                    Stop
                </button>
                <button onclick="resetScanner()" id="btn-reset" class="hidden px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-[8px] transition-colors">
                    Scan Next
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-5 animate-fade-up" style="animation-delay:150ms">
        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">Manual Tracking Code Entry</h3>
        <form onsubmit="manualCheckin(event)" class="flex gap-3">
            <input type="text" id="manualCode" placeholder="TRK-XXXXXXXX" autocomplete="off" autocapitalize="characters" class="flex-1 h-[40px] rounded-[8px] border-gray-200 dark:border-gray-700 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 text-sm px-3 font-mono transition-colors">
            <button type="submit" class="px-4 h-[40px] bg-brand hover:bg-indigo-700 text-white text-sm font-semibold rounded-[8px] transition-colors">
                Check In
            </button>
        </form>
    </div>

    <div id="result-card" class="hidden animate-fade-up"></div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
const CHECKIN_URL = "{{ route('staff.scan.checkin') }}";
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

let scanner = null;
let scanning = false;
let activeCameraConfig = null;

function setScannerUi(active) {
    document.getElementById('scanner-inactive').classList.toggle('hidden', active);
    document.getElementById('scan-corners').classList.toggle('hidden', !active);
    document.getElementById('btn-stop').classList.toggle('hidden', !active);
    document.getElementById('btn-start').classList.toggle('hidden', active);
}

function setStatus(type, text) {
    const dot = document.getElementById('scan-status-dot');
    const label = document.getElementById('scan-status-text');
    label.textContent = text;
    dot.className = 'w-2 h-2 rounded-full ' + ({
        scanning: 'bg-emerald-500 animate-pulse',
        inactive: 'bg-gray-400',
        success: 'bg-emerald-500',
        error: 'bg-red-500'
    }[type] || 'bg-gray-400');
}

function getCameraErrorMessage(err) {
    const message = String(err && (err.message || err)).toLowerCase();

    if (!window.isSecureContext) {
        return 'Camera access requires a secure page. Use localhost or HTTPS.';
    }
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        return 'This browser does not support camera access.';
    }
    if (message.includes('permission') || message.includes('denied') || message.includes('notallowed')) {
        return 'Camera permission was denied. Allow access in the browser and try again.';
    }
    if (message.includes('notfound') || message.includes('device not found') || message.includes('requested device not found')) {
        return 'No camera was found on this device.';
    }
    if (message.includes('notreadable') || message.includes('trackstart') || message.includes('in use')) {
        return 'The camera is busy in another app or browser tab.';
    }

    return 'Unable to start the camera. Please try again.';
}

async function resolveCameraConfig() {
    if (!window.Html5Qrcode) {
        throw new Error('QR scanner library did not load.');
    }

    const cameras = await Html5Qrcode.getCameras();
    if (!cameras || cameras.length === 0) {
        throw new Error('No camera devices available.');
    }

    const preferredCamera = cameras.find((camera) => {
        const label = (camera.label || '').toLowerCase();
        return label.includes('back') || label.includes('rear') || label.includes('environment');
    });

    if (preferredCamera) {
        return { deviceId: { exact: preferredCamera.id } };
    }

    return { deviceId: { exact: cameras[0].id } };
}

async function startScanner() {
    setStatus('scanning', 'Starting camera...');
    setScannerUi(true);

    if (!scanner) {
        scanner = new Html5Qrcode('reader');
    }

    try {
        if (!activeCameraConfig) {
            activeCameraConfig = await resolveCameraConfig();
        }

        scanning = true;
        await scanner.start(
            activeCameraConfig,
            { fps: 10, qrbox: { width: 260, height: 260 } },
            onScanSuccess,
            () => {}
        );
        setStatus('scanning', 'Scanning...');
    } catch (err) {
        console.error(err);
        scanning = false;
        activeCameraConfig = null;
        setStatus('error', 'Camera error');
        showResult('error', `<p class="text-sm text-red-700 dark:text-red-400 font-semibold">${getCameraErrorMessage(err)}</p>`);
        stopScanner(true);
    }
}

function stopScanner(silent = false) {
    scanning = false;
    if (scanner && scanner.isScanning) {
        scanner.stop().catch(() => {});
    }
    setScannerUi(false);
    if (!silent) {
        setStatus('inactive', 'Inactive');
    }
}

function resetScanner() {
    document.getElementById('result-card').classList.add('hidden');
    document.getElementById('btn-reset').classList.add('hidden');
    startScanner();
}

async function onScanSuccess(decodedText) {
    if (!scanning) return;
    scanning = false;
    stopScanner(true);
    setStatus('scanning', 'Processing...');
    await doCheckin(decodedText);
}

async function manualCheckin(event) {
    event.preventDefault();
    const code = document.getElementById('manualCode').value.trim();
    if (!code) return;
    await doCheckin(code);
    document.getElementById('manualCode').value = '';
}

async function doCheckin(raw) {
    setStatus('scanning', 'Checking in...');
    showResult('loading', '<div class="flex items-center gap-3 py-2"><div class="w-5 h-5 border-2 border-brand border-t-transparent rounded-full animate-spin"></div><span class="text-sm text-gray-600 dark:text-gray-300">Checking in...</span></div>');

    try {
        const response = await fetch(CHECKIN_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ tracking_code: raw })
        });
        const data = await response.json();
        renderResult(data);
    } catch (error) {
        showResult('error', '<p class="text-sm text-red-600 font-semibold">Network error - please try again.</p>');
        setStatus('error', 'Error');
    }
}

const timeMap = {
    '09:00': '9:00 AM',
    '10:00': '10:00 AM',
    '11:00': '11:00 AM',
    '12:00': '12:00 PM',
    '13:00': '1:00 PM'
};

function renderResult(data) {
    document.getElementById('btn-reset').classList.remove('hidden');

    if (data.result === 'success') {
        setStatus('success', 'Checked in!');
        showResult('success', `
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="bg-emerald-500 px-5 py-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-base">Checked In!</p>
                        <p class="text-emerald-100 text-xs">Successfully registered arrival</p>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Citizen</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">${data.name}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Document</span>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">${data.document_type}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Time Slot</span>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">${timeMap[data.time_slot] || data.time_slot}</span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-800">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tracking Code</span>
                        <span class="text-sm font-mono font-bold text-brand dark:text-indigo-400">${data.tracking_code}</span>
                    </div>
                </div>
                <div class="px-5 pb-4">
                    <p class="text-xs text-center text-emerald-600 dark:text-emerald-400 font-medium bg-emerald-50 dark:bg-emerald-900/20 rounded-[8px] py-2">
                        Please take a seat and wait to be called.
                    </p>
                </div>
            </div>
        `);
    } else if (data.result === 'already_checked_in') {
        setStatus('error', 'Already checked in');
        showResult('warn', `
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-[12px] p-5 flex items-start gap-4">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="font-bold text-amber-800 dark:text-amber-300">Already Checked In</p>
                    <p class="text-sm text-amber-700 dark:text-amber-400 mt-0.5">Checked in at <strong>${data.time}</strong></p>
                </div>
            </div>
        `);
    } else if (data.result === 'wrong_date') {
        setStatus('error', 'Wrong date');
        showResult('warn', `
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-[12px] p-5 flex items-start gap-4">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="font-bold text-amber-800 dark:text-amber-300">Wrong Date</p>
                    <p class="text-sm text-amber-700 dark:text-amber-400 mt-0.5">This appointment is scheduled for <strong>${data.date}</strong>, not today.</p>
                </div>
            </div>
        `);
    } else {
        setStatus('error', 'Not found');
        showResult('error', `
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-[12px] p-5 flex items-start gap-4">
                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="font-bold text-red-800 dark:text-red-300">QR Code Not Recognized</p>
                    <p class="text-sm text-red-700 dark:text-red-400 mt-0.5">No application found matching this code.</p>
                </div>
            </div>
        `);
    }
}

function showResult(type, html) {
    const card = document.getElementById('result-card');
    card.innerHTML = html;
    card.classList.remove('hidden');
    card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>
@endsection
