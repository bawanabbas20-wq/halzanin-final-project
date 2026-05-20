@extends('layouts.halzanin-app')

@section('content')

<div class="max-w-xl mx-auto space-y-6 animate-fade-up">

    {{-- Page Header --}}
    <div>
        <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="book.title">Book an Appointment</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="book.subtitle">Complete the steps below to schedule your visit to the directorate.</p>
    </div>

    {{-- Step Indicator --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
        <div class="flex items-start">
            <div class="flex flex-col items-center shrink-0">
                <div id="circle-1" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-brand text-white transition-all duration-300 shadow-brand-btn">1</div>
                <span id="label-1" class="text-[11px] mt-1.5 font-semibold text-brand dark:text-amber-400 transition-colors text-center leading-tight" data-i18n="book.step1">Personal Info</span>
            </div>
            <div id="line-1-2" class="flex-1 h-0.5 bg-gray-200 dark:bg-gray-700 mx-3 mt-4 transition-colors duration-300"></div>
            <div class="flex flex-col items-center shrink-0">
                <div id="circle-2" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 transition-all duration-300">2</div>
                <span id="label-2" class="text-[11px] mt-1.5 font-semibold text-gray-400 dark:text-gray-500 transition-colors text-center leading-tight" data-i18n="book.step2">Pick Appointment</span>
            </div>
            <div id="line-2-3" class="flex-1 h-0.5 bg-gray-200 dark:bg-gray-700 mx-3 mt-4 transition-colors duration-300"></div>
            <div class="flex flex-col items-center shrink-0">
                <div id="circle-3" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 transition-all duration-300">3</div>
                <span id="label-3" class="text-[11px] mt-1.5 font-semibold text-gray-400 dark:text-gray-500 transition-colors text-center leading-tight" data-i18n="book.step3">Review &amp; Submit</span>
            </div>
        </div>
    </div>

    {{-- ═══ STEP 1: Personal Info ═══ --}}
    <div id="step-1" class="animate-fade-up">
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-brand via-amber-500 to-accent"></div>
        <div class="p-6 space-y-5">
            <div>
                <label for="inp-full-name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5" data-i18n="book.full_name">Full Name</label>
                <input type="text" id="inp-full-name"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#141414] text-gray-900 dark:text-gray-100 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition"
                    placeholder="Enter your full legal name"
                    data-i18n-placeholder="book.full_name_placeholder"
                    autocomplete="name"
                    oninput="saveStep1()">
                <p id="err-full-name" class="text-xs text-red-500 mt-1 hidden" data-i18n="book.name_required">Full name is required.</p>
            </div>

            <div>
                <label for="inp-national-id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5" data-i18n="book.national_id">National ID Number</label>
                <input type="text" id="inp-national-id"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#141414] text-gray-900 dark:text-gray-100 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition font-mono"
                    placeholder="e.g. 1234567890"
                    autocomplete="off"
                    oninput="saveStep1()">
                <p id="err-national-id" class="text-xs text-red-500 mt-1 hidden" data-i18n="book.id_required">National ID number is required.</p>
            </div>

            <div>
                <label for="inp-doc-type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5" data-i18n="book.doc_type">Document Type</label>
                <select id="inp-doc-type"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#141414] text-gray-900 dark:text-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition"
                    onchange="saveStep1()">
                    <option value="" data-i18n="book.select_doc_type">Select a document type...</option>
                    <option value="Passport Renewal" data-i18n="doc.passport_renewal">Passport Renewal</option>
                    <option value="New Passport" data-i18n="doc.new_passport">New Passport</option>
                    <option value="ID Card" data-i18n="doc.id_card">ID Card</option>
                    <option value="Birth Certificate" data-i18n="doc.birth_cert">Birth Certificate</option>
                    <option value="Other" data-i18n="doc.other">Other</option>
                </select>
                <p id="err-doc-type" class="text-xs text-red-500 mt-1 hidden" data-i18n="book.doc_required">Please select a document type.</p>
            </div>

            <button type="button" onclick="step1Continue()"
                class="w-full py-3 bg-brand text-white font-semibold text-sm rounded-xl shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 mt-2">
                <span data-i18n="book.continue">Continue</span>
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        </div>
    </div>

    {{-- ═══ STEP 2: Pick Appointment ═══ --}}
    <div id="step-2" class="hidden space-y-4">

        {{-- Calendar Card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-brand via-amber-500 to-accent"></div>
        <div class="p-5">

            {{-- Month Navigation --}}
            <div class="flex items-center justify-between mb-4">
                <button type="button" id="btnPrev" onclick="navMonth(-1)"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 disabled:opacity-30 disabled:cursor-not-allowed transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <h3 id="calLabel" class="font-bold text-brand dark:text-white font-outfit text-base"></h3>
                <button type="button" id="btnNext" onclick="navMonth(1)"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 disabled:opacity-30 disabled:cursor-not-allowed transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            {{-- Day-of-week headers (Sun-start; Fri+Sat are off days) --}}
            <div class="grid grid-cols-7 gap-1 mb-1">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dow)
                    <div class="text-center text-[10px] font-bold py-1 {{ in_array($dow, ['Fri','Sat']) ? 'text-red-400 dark:text-red-500' : 'text-gray-400 dark:text-gray-500' }}" data-i18n="calendar.{{ strtolower($dow) }}">{{ $dow }}</div>
                @endforeach
            </div>

            {{-- Calendar Grid (populated by JS) --}}
            <div id="calGrid" class="grid grid-cols-7 gap-1"></div>

            {{-- Legend --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-4 pt-3 border-t border-gray-100 dark:border-gray-800">
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-emerald-200 dark:bg-emerald-800/60 inline-block shrink-0"></span><span data-i18n="book.available">Available</span></span>
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-yellow-200 dark:bg-yellow-800/60 inline-block shrink-0"></span><span data-i18n="book.filling">Filling up</span></span>
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-orange-200 dark:bg-orange-800/60 inline-block shrink-0"></span><span data-i18n="book.almost_full">Almost full</span></span>
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-red-200 dark:bg-red-900/60 inline-block shrink-0"></span><span data-i18n="book.full">Full</span></span>
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-gray-200 dark:bg-gray-700 inline-block shrink-0"></span><span data-i18n="book.off_day">Off day</span></span>
            </div>
        </div>
        </div>

        {{-- Time Slot Panel (shown after date selection) --}}
        <div id="slotPanel" class="hidden bg-white dark:bg-[#1F1F1F] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-5">
            <p id="slotDate" class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3"></p>
            <div id="slotContent"></div>
        </div>

        {{-- Step 2 Navigation --}}
        <div class="flex gap-3">
            <button type="button" onclick="goToStep(1)"
                class="flex-1 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold text-sm rounded-[10px] hover:bg-gray-200 dark:hover:bg-gray-700 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span data-i18n="book.back">Back</span>
            </button>
            <button type="button" id="step2Btn" onclick="step2Continue()" disabled
                class="flex-1 py-3 bg-brand text-white font-semibold text-sm rounded-[10px] hover:bg-brand/90 transition shadow-md disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                <span data-i18n="book.continue">Continue</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    {{-- ═══ STEP 3: Review & Required Documents ═══ --}}
    <div id="step-3" class="hidden space-y-4">

        {{-- Summary Card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-emerald-400 via-brand to-indigo-500"></div>
        <div class="p-5">
            <h4 class="font-bold text-brand dark:text-white font-outfit mb-4 text-sm uppercase tracking-wide" data-i18n="book.appointment_summary">Appointment Summary</h4>
            <dl class="space-y-3">
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0" data-i18n="book.full_name">Full Name</dt>
                    <dd id="rev-name" class="text-sm font-semibold text-gray-800 dark:text-gray-100 text-right truncate max-w-[60%]"></dd>
                </div>
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0" data-i18n="book.national_id_short">National ID</dt>
                    <dd id="rev-nid" class="text-sm font-semibold text-gray-800 dark:text-gray-100 text-right font-mono"></dd>
                </div>
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0" data-i18n="book.document">Document</dt>
                    <dd id="rev-doctype" class="text-sm font-semibold text-gray-800 dark:text-gray-100 text-right"></dd>
                </div>
                <div class="h-px bg-gray-100 dark:bg-gray-800"></div>
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0" data-i18n="book.date">Date</dt>
                    <dd id="rev-date" class="text-sm font-bold text-brand dark:text-amber-400 text-right"></dd>
                </div>
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0" data-i18n="book.time">Time</dt>
                    <dd id="rev-slot" class="text-sm font-bold text-brand dark:text-amber-400 text-right"></dd>
                </div>
            </dl>
        </div>
        </div>

        {{-- Required Documents --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-amber-400 via-brand to-accent"></div>
        <div class="p-5">
            <h4 class="font-bold text-brand dark:text-white font-outfit mb-1 text-sm" data-i18n="book.required_documents">Required Documents</h4>
            <p class="text-xs text-gray-400 dark:text-gray-500 mb-4" data-i18n="book.required_documents_help">For each document, select from your vault, upload a file, or confirm you'll bring it.</p>
            <div id="docs-loading" class="flex items-center gap-2 text-sm text-gray-400 py-2">
                <svg class="w-4 h-4 animate-spin shrink-0" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                <span data-i18n="book.loading_docs">Loading required documents...</span>
            </div>
            <div id="doc-cards" class="space-y-3 hidden"></div>
        </div>
        </div>

        {{-- Step 3 Navigation --}}
        <div class="flex gap-3">
            <button type="button" onclick="goToStep(2)"
                class="flex-1 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold text-sm rounded-[10px] hover:bg-gray-200 dark:hover:bg-gray-700 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span data-i18n="book.back">Back</span>
            </button>
            <button type="button" id="submitBtn" onclick="submitWizard()" disabled
                class="flex-1 py-3 bg-emerald-600 text-white font-semibold text-sm rounded-[10px] hover:bg-emerald-700 transition shadow-md disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                <span data-i18n="book.submit">Submit Appointment</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </button>
        </div>
    </div>

</div>{{-- /max-w-xl --}}

@push('scripts')
<script>
// ── Initial data from PHP ─────────────────────────
const CAL = {
    year:     {{ $year }},
    month:    {{ $month }},
    label:    @json($current->format('F Y')),
    counts:   @json($counts),
    offDates: @json($offDates),
    canPrev:  {{ $canPrev ? 'true' : 'false' }},
    canNext:  {{ $canNext ? 'true' : 'false' }},
};
const MONTH_URL      = @json(route('citizen.appointments.month-data'));
const SLOTS_URL      = @json(route('citizen.appointments.slots'));
const CSRF_TOKEN     = @json(csrf_token());
const STORE_URL      = @json(route('citizen.appointments.store'));
const VAULT_DOCS_URL = @json(route('citizen.appointments.vault-docs'));

function tr(key, replacements = {}) {
    return typeof window.i18n === 'function' ? window.i18n(key, replacements) : key;
}

function trDoc(label) {
    return typeof window.i18nDocument === 'function' ? window.i18nDocument(label) : label;
}

const TIME_LABELS = {
    '09:00':'9:00 AM','10:00':'10:00 AM','11:00':'11:00 AM',
    '12:00':'12:00 PM','13:00':'1:00 PM',
};

const DOC_REQS = {
    'Passport Renewal':  ['Original Passport','National ID Card','2 Passport-Size Photos','Fee Payment Receipt'],
    'New Passport':      ['Birth Certificate','National ID Card','2 Passport-Size Photos'],
    'ID Card':           ['Birth Certificate','2 Passport-Size Photos'],
    'Birth Certificate': ['Hospital Birth Record','Parent National ID Cards'],
    'Other':             ['Relevant supporting documents as required'],
};

const VAULT_TYPES = {
    'Original Passport':       ['Passport'],
    'National ID Card':        ['National ID'],
    '2 Passport-Size Photos':  [],
    'Fee Payment Receipt':     [],
    'Birth Certificate':       [],
    'Hospital Birth Record':   [],
    'Parent National ID Cards':['National ID'],
};

// ── Wizard state ──────────────────────────────────
const ws = {
    fullName:'', nationalId:'', docType:'',
    date:null, slot:null,
    cal: Object.assign({}, CAL),
    docCards: [],
};

// ── LocalStorage (Step 1 autosave) ────────────────
function saveStep1() {
    localStorage.setItem('hz_wiz_name',    document.getElementById('inp-full-name').value.trim());
    localStorage.setItem('hz_wiz_nid',     document.getElementById('inp-national-id').value.trim());
    localStorage.setItem('hz_wiz_doctype', document.getElementById('inp-doc-type').value);
}
function restoreStep1() {
    document.getElementById('inp-full-name').value   = localStorage.getItem('hz_wiz_name') || '';
    document.getElementById('inp-national-id').value = localStorage.getItem('hz_wiz_nid') || '';
    document.getElementById('inp-doc-type').value    = localStorage.getItem('hz_wiz_doctype') || '';
}

// ── Step Indicator ────────────────────────────────
function updateIndicator(n) {
    const TICK = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
    [1,2,3].forEach(i => {
        const c = document.getElementById('circle-' + i);
        const l = document.getElementById('label-' + i);
        if (i < n) {
            c.className = 'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-brand text-white transition-all duration-300';
            c.innerHTML = TICK;
            l.className = 'text-[11px] mt-1.5 font-semibold text-brand dark:text-amber-400 transition-colors text-center leading-tight';
        } else if (i === n) {
            c.className = 'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-brand text-white transition-all duration-300';
            c.textContent = i;
            l.className = 'text-[11px] mt-1.5 font-semibold text-brand dark:text-amber-400 transition-colors text-center leading-tight';
        } else {
            c.className = 'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 transition-all duration-300';
            c.textContent = i;
            l.className = 'text-[11px] mt-1.5 font-semibold text-gray-400 dark:text-gray-500 transition-colors text-center leading-tight';
        }
    });
    const on  = 'flex-1 h-0.5 mx-3 mt-4 transition-colors duration-300 bg-brand';
    const off = 'flex-1 h-0.5 mx-3 mt-4 transition-colors duration-300 bg-gray-200 dark:bg-gray-700';
    document.getElementById('line-1-2').className = n > 1 ? on : off;
    document.getElementById('line-2-3').className = n > 2 ? on : off;
}

// ── Step Navigation ───────────────────────────────
function goToStep(n) {
    document.getElementById('step-1').classList.toggle('hidden', n !== 1);
    document.getElementById('step-2').classList.toggle('hidden', n !== 2);
    document.getElementById('step-3').classList.toggle('hidden', n !== 3);
    updateIndicator(n);
    if (n === 2) renderCalendar();
    if (n === 3) renderReview();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Step 1 ────────────────────────────────────────
function step1Continue() {
    const name = document.getElementById('inp-full-name').value.trim();
    const nid  = document.getElementById('inp-national-id').value.trim();
    const dt   = document.getElementById('inp-doc-type').value;
    let ok = true;
    document.getElementById('err-full-name').classList.toggle('hidden', !!name);  if (!name) ok = false;
    document.getElementById('err-national-id').classList.toggle('hidden', !!nid); if (!nid)  ok = false;
    document.getElementById('err-doc-type').classList.toggle('hidden', !!dt);     if (!dt)   ok = false;
    if (!ok) return;
    ws.fullName   = name;
    ws.nationalId = nid;
    ws.docType    = dt;
    goToStep(2);
}

// ── Calendar ──────────────────────────────────────
function renderCalendar() {
    const { year, month, label, counts, offDates, canPrev, canNext } = ws.cal;
    document.getElementById('calLabel').textContent = label;
    document.getElementById('btnPrev').disabled = !canPrev;
    document.getElementById('btnNext').disabled = !canNext;

    const today    = new Date(); today.setHours(0,0,0,0);
    const firstDay = new Date(year, month - 1, 1);
    const dim      = new Date(year, month, 0).getDate();
    const startDow = firstDay.getDay(); // 0=Sun — correct for Sun-start

    const grid = document.getElementById('calGrid');
    grid.innerHTML = '';

    for (let i = 0; i < startDow; i++) {
        const blank = document.createElement('div');
        blank.className = 'aspect-square';
        grid.appendChild(blank);
    }

    for (let d = 1; d <= dim; d++) {
        const ds   = `${year}-${String(month).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const dObj = new Date(year, month - 1, d);
        const dow  = dObj.getDay();
        const isOff  = dow === 5 || dow === 6 || offDates.includes(ds); // Fri=5, Sat=6
        const isPast = dObj < today;
        const cnt    = counts[ds] || 0;
        const isFull = cnt >= 5;
        const isSel  = ws.date === ds;

        const btn  = document.createElement('button');
        btn.type   = 'button';
        btn.textContent = d;
        const base = 'w-full aspect-square rounded-lg text-xs font-semibold transition-all flex items-center justify-center select-none';

        if (isOff || isPast) {
            btn.disabled  = true;
            btn.className = `${base} bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600 cursor-not-allowed`;
        } else if (isFull) {
            btn.disabled  = true;
            btn.className = `${base} bg-red-100 dark:bg-red-950/40 text-red-400 cursor-not-allowed`;
            btn.title     = tr('book.fully_booked');
        } else if (isSel) {
            btn.className = `${base} bg-brand text-white ring-2 ring-brand ring-offset-1 dark:ring-offset-[#1F1F1F] scale-105 font-bold`;
        } else {
            let clr;
            if (cnt === 0)     clr = 'bg-emerald-100 dark:bg-emerald-900/25 text-emerald-700 dark:text-emerald-400 hover:scale-105 hover:shadow-sm';
            else if (cnt <= 2) clr = 'bg-yellow-100 dark:bg-yellow-900/25 text-yellow-700 dark:text-yellow-400 hover:scale-105 hover:shadow-sm';
            else               clr = 'bg-orange-100 dark:bg-orange-900/25 text-orange-700 dark:text-orange-400 hover:scale-105 hover:shadow-sm';
            btn.className = `${base} ${clr}`;
            btn.addEventListener('click', () => selectDate(ds));
        }
        grid.appendChild(btn);
    }
}

async function navMonth(dir) {
    let { year, month } = ws.cal;
    month += dir;
    if (month < 1)  { month = 12; year--; }
    if (month > 12) { month = 1;  year++; }
    try {
        const r  = await fetch(`${MONTH_URL}?year=${year}&month=${month}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        ws.cal   = await r.json();
        ws.date  = null; ws.slot = null;
        document.getElementById('slotPanel').classList.add('hidden');
        document.getElementById('step2Btn').disabled = true;
        renderCalendar();
    } catch(e) { console.error('navMonth failed', e); }
}

async function selectDate(ds) {
    ws.date = ds;
    ws.slot = null;
    document.getElementById('step2Btn').disabled = true;
    renderCalendar();

    const panel   = document.getElementById('slotPanel');
    const content = document.getElementById('slotContent');
    const label   = document.getElementById('slotDate');

    const dObj = new Date(ds + 'T00:00:00');
    label.textContent = dObj.toLocaleDateString('en-GB', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
    panel.classList.remove('hidden');
    content.innerHTML = `<div class="flex items-center gap-2 text-sm text-gray-400 py-2">
        <svg class="w-4 h-4 animate-spin shrink-0" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>${tr('book.loading_slots')}</div>`;

    try {
        const r    = await fetch(`${SLOTS_URL}?date=${ds}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await r.json();
        if (data.error) {
            content.innerHTML = `<p class="text-sm text-red-500 dark:text-red-400">${window.i18nMessage ? i18nMessage(data.error) : data.error}</p>`;
            return;
        }
        if (!data.slots?.length) {
            content.innerHTML = `<p class="text-sm text-gray-500 dark:text-gray-400">${tr('book.no_slots')}</p>`;
            return;
        }
        renderSlots(data.slots);
    } catch(e) {
        content.innerHTML = `<p class="text-sm text-red-500">${tr('book.failed_slots')}</p>`;
    }
}

function renderSlots(slots) {
    const wrap = document.createElement('div');
    wrap.className = 'grid grid-cols-2 sm:grid-cols-3 gap-2';
    slots.forEach(s => {
        const btn = document.createElement('button');
        btn.type  = 'button';
        btn.dataset.slot = s;
        btn.textContent  = TIME_LABELS[s] || s;
        btn.className    = slotCls(false);
        btn.addEventListener('click', () => selectSlot(s));
        wrap.appendChild(btn);
    });
    document.getElementById('slotContent').innerHTML = '';
    document.getElementById('slotContent').appendChild(wrap);
}

function slotCls(active) {
    return active
        ? 'py-2.5 px-3 rounded-xl text-sm font-bold transition-all bg-brand text-white border-2 border-brand shadow-sm'
        : 'py-2.5 px-3 rounded-xl text-sm font-medium transition-all bg-gray-50 dark:bg-[#141414] border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:border-brand hover:text-brand hover:bg-brand/5';
}

function selectSlot(s) {
    ws.slot = s;
    document.querySelectorAll('#slotContent button[data-slot]').forEach(btn => {
        btn.className = slotCls(btn.dataset.slot === s);
    });
    document.getElementById('step2Btn').disabled = false;
}

function step2Continue() {
    if (ws.date && ws.slot) goToStep(3);
}

// ── Step 3 ────────────────────────────────────────
function renderReview() {
    document.getElementById('rev-name').textContent    = ws.fullName;
    document.getElementById('rev-nid').textContent     = ws.nationalId;
    document.getElementById('rev-doctype').textContent = trDoc(ws.docType);

    const dObj = new Date(ws.date + 'T00:00:00');
    document.getElementById('rev-date').textContent = dObj.toLocaleDateString('en-GB', { weekday:'short', year:'numeric', month:'short', day:'numeric' });
    document.getElementById('rev-slot').textContent = TIME_LABELS[ws.slot] || ws.slot;

    loadDocCards();
}

// ── Step 3: Doc cards ─────────────────────────────
async function loadDocCards() {
    const reqs = DOC_REQS[ws.docType] || DOC_REQS['Other'];
    ws.docCards = reqs.map((name, i) => ({
        index: i, name, source: null, vaultDocId: null, file: null, fulfilled: false,
    }));

    document.getElementById('docs-loading').classList.remove('hidden');
    document.getElementById('doc-cards').classList.add('hidden');
    document.getElementById('submitBtn').disabled = true;

    let vaultDocs = [];
    try {
        const r = await fetch(VAULT_DOCS_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await r.json();
        vaultDocs = data.docs || [];
    } catch(e) {}

    document.getElementById('docs-loading').classList.add('hidden');
    document.getElementById('doc-cards').classList.remove('hidden');
    const container = document.getElementById('doc-cards');
    container.innerHTML = '';

    reqs.forEach((name, i) => {
        const matching = vaultDocs.filter(v => (VAULT_TYPES[name] || []).includes(v.type));
        container.appendChild(buildDocCard(i, name, matching));
    });
    checkSubmit();
}

function buildDocCard(i, name, matchingVaultDocs) {
    const card = document.createElement('div');
    card.id = `doc-card-${i}`;
    card.className = 'border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden transition-all';

    const vaultSection = matchingVaultDocs.length > 0 ? `
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800 bg-amber-50/40 dark:bg-amber-900/10">
            <p class="text-[10px] font-bold text-amber-500 dark:text-amber-400 uppercase tracking-wider mb-2">${tr('book.use_from_vault')}</p>
            <div class="space-y-1.5">
                ${matchingVaultDocs.map(v => `
                    <button type="button" id="vault-btn-${i}-${v.id}"
                        onclick="selectVault(${i}, ${v.id}, '${(v.name || v.type).replace(/'/g,"\\'")}' )"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg border border-indigo-200 dark:border-amber-800 hover:border-brand hover:bg-brand/5 transition text-left group">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 group-hover:text-brand truncate">${v.name}</p>
                            <p class="text-[10px] text-gray-400">${tr('book.expires_in_days', { days: v.expires_in })}</p>
                        </div>
                        <span class="text-xs font-bold text-brand ml-2 shrink-0">${tr('book.use')} -></span>
                    </button>`).join('')}
            </div>
        </div>` : '';

    const uploadSection = `
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
            <p class="text-[10px] font-bold text-blue-500 dark:text-blue-400 uppercase tracking-wider mb-2">${tr('book.upload_file')}</p>
            <label id="upload-zone-${i}" class="flex flex-col items-center gap-1.5 py-4 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-brand hover:bg-brand/5 transition">
                <input type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" onchange="handleUpload(event,${i})">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <p class="text-xs font-semibold text-gray-500">${tr('book.upload_photo')}</p>
                <p class="text-[10px] text-gray-400">${tr('book.file_help')}</p>
            </label>
            <div id="upload-preview-${i}" class="hidden mt-2 flex items-center gap-2 p-2.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="flex-1 min-w-0">
                    <p id="upload-name-${i}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 truncate"></p>
                    <p id="upload-size-${i}" class="text-[10px] text-gray-400"></p>
                </div>
                <button type="button" onclick="removeUpload(${i})" class="text-xs text-red-400 hover:text-red-600 shrink-0 ml-1">✕</button>
            </div>
        </div>`;

    const confirmSection = `
        <div class="px-4 py-3">
            <p class="text-[10px] font-bold text-amber-500 dark:text-amber-400 uppercase tracking-wider mb-2">${tr('book.or_confirm')}</p>
            <label class="flex items-start gap-3 p-3 bg-amber-50 dark:bg-amber-900/10 rounded-xl cursor-pointer hover:bg-amber-100 dark:hover:bg-amber-900/20 transition">
                <input type="checkbox" id="confirm-cb-${i}" class="mt-0.5 w-4 h-4 rounded accent-amber-500 shrink-0" onchange="handleConfirm(event,${i})">
                <span class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">${tr('book.confirm_bring')}</span>
            </label>
        </div>`;

    card.innerHTML = `
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-[#141414] border-b border-gray-100 dark:border-gray-800">
            <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">${trDoc(name)}</span>
            <span id="card-badge-${i}" class="hidden text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                ${tr('book.fulfilled')}
            </span>
        </div>
        ${vaultSection}${uploadSection}${confirmSection}`;

    return card;
}

function selectVault(ci, vaultDocId, label) {
    const card = ws.docCards[ci];
    const already = card.source === 'vault' && card.vaultDocId === vaultDocId;
    card.source     = already ? null : 'vault';
    card.vaultDocId = already ? null : vaultDocId;
    card.file       = null;
    card.fulfilled  = !already;
    if (!already) {
        // Uncheck confirm
        const cb = document.getElementById(`confirm-cb-${ci}`);
        if (cb) cb.checked = false;
    }
    updateCardUI(ci);
    checkSubmit();
}

function handleUpload(event, ci) {
    const file = event.target.files[0];
    if (!file) return;
    if (file.size > 5 * 1024 * 1024) {
        alert(tr('book.file_under'));
        event.target.value = '';
        return;
    }
    const card   = ws.docCards[ci];
    card.source  = 'upload';
    card.file    = file;
    card.vaultDocId = null;
    card.fulfilled  = true;
    document.getElementById(`upload-zone-${ci}`).classList.add('hidden');
    document.getElementById(`upload-preview-${ci}`).classList.remove('hidden');
    document.getElementById(`upload-name-${ci}`).textContent = file.name;
    document.getElementById(`upload-size-${ci}`).textContent = fmtBytes(file.size);
    const cb = document.getElementById(`confirm-cb-${ci}`);
    if (cb) cb.checked = false;
    updateCardUI(ci);
    checkSubmit();
}

function removeUpload(ci) {
    const card  = ws.docCards[ci];
    card.source = null; card.file = null; card.fulfilled = false;
    document.getElementById(`upload-zone-${ci}`).classList.remove('hidden');
    document.getElementById(`upload-preview-${ci}`).classList.add('hidden');
    updateCardUI(ci); checkSubmit();
}

function handleConfirm(event, ci) {
    const card  = ws.docCards[ci];
    card.source = event.target.checked ? 'confirmed' : null;
    card.file   = null; card.vaultDocId = null;
    card.fulfilled = event.target.checked;
    updateCardUI(ci); checkSubmit();
}

function updateCardUI(ci) {
    const card  = ws.docCards[ci];
    const badge = document.getElementById(`card-badge-${ci}`);
    const el    = document.getElementById(`doc-card-${ci}`);
    if (card.fulfilled) {
        badge.classList.remove('hidden');
        el.className = 'border border-emerald-200 dark:border-emerald-800 rounded-xl overflow-hidden transition-all bg-emerald-50/20 dark:bg-emerald-900/5';
    } else {
        badge.classList.add('hidden');
        el.className = 'border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden transition-all';
    }
}

function checkSubmit() {
    const all = ws.docCards.length > 0 && ws.docCards.every(c => c.fulfilled);
    document.getElementById('submitBtn').disabled = !all;
}

function fmtBytes(b) {
    if (b < 1024) return b + ' B';
    if (b < 1048576) return (b/1024).toFixed(1) + ' KB';
    return (b/1048576).toFixed(1) + ' MB';
}

async function submitWizard() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    const orig = btn.innerHTML;
    btn.innerHTML = `<svg class="w-4 h-4 animate-spin inline mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>${tr('book.submitting')}`;

    const fd = new FormData();
    fd.append('_token', CSRF_TOKEN);
    fd.append('full_name',          ws.fullName);
    fd.append('national_id_number', ws.nationalId);
    fd.append('document_type',      ws.docType);
    fd.append('date',               ws.date);
    fd.append('time_slot',          ws.slot);

    ws.docCards.forEach((c, i) => {
        fd.append(`docs[${i}][name]`,   c.name);
        fd.append(`docs[${i}][source]`, c.source);
        if (c.source === 'vault' && c.vaultDocId) fd.append(`docs[${i}][vault_id]`, c.vaultDocId);
        if (c.source === 'upload' && c.file)      fd.append(`doc_files[${i}]`, c.file, c.file.name);
    });

    try {
        const r = await fetch(STORE_URL, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: fd,
        });
        const data = await r.json().catch(() => ({}));
        if (r.ok && data.success) {
            localStorage.removeItem('hz_wiz_name');
            localStorage.removeItem('hz_wiz_nid');
            localStorage.removeItem('hz_wiz_doctype');
            window.location.href = data.redirect;
        } else {
            btn.disabled = false; btn.innerHTML = orig;
            const validationMessages = data.errors
                ? Object.values(data.errors).flat().join(' ')
                : '';
            const message = validationMessages || data.message || tr('book.failed_submit');
            if (window.showToast) showToast('error', tr('book.error_title'), window.i18nMessage ? i18nMessage(message) : message);
        }
    } catch(e) {
        btn.disabled = false; btn.innerHTML = orig;
        if (window.showToast) showToast('error', tr('book.error_title'), tr('book.network_error'));
    }
}

// ── Init ──────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    restoreStep1();
    updateIndicator(1);
});
</script>
@endpush

@endsection
