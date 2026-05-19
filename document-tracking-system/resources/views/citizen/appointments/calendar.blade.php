@extends('layouts.halzanin-app')

@section('content')

<div class="max-w-xl mx-auto space-y-6 animate-fade-up">

    {{-- Page Header --}}
    <div>
        <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">Book an Appointment</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Complete the steps below to schedule your visit to the directorate.</p>
    </div>

    {{-- Step Indicator --}}
    <div class="flex items-start">
        <div class="flex flex-col items-center shrink-0">
            <div id="circle-1" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-brand text-white transition-all duration-300">1</div>
            <span id="label-1" class="text-[11px] mt-1.5 font-semibold text-brand dark:text-indigo-400 transition-colors text-center leading-tight">Personal<br>Info</span>
        </div>
        <div id="line-1-2" class="flex-1 h-0.5 bg-gray-200 dark:bg-gray-700 mx-3 mt-4 transition-colors duration-300"></div>
        <div class="flex flex-col items-center shrink-0">
            <div id="circle-2" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 transition-all duration-300">2</div>
            <span id="label-2" class="text-[11px] mt-1.5 font-semibold text-gray-400 dark:text-gray-500 transition-colors text-center leading-tight">Pick<br>Appointment</span>
        </div>
        <div id="line-2-3" class="flex-1 h-0.5 bg-gray-200 dark:bg-gray-700 mx-3 mt-4 transition-colors duration-300"></div>
        <div class="flex flex-col items-center shrink-0">
            <div id="circle-3" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 transition-all duration-300">3</div>
            <span id="label-3" class="text-[11px] mt-1.5 font-semibold text-gray-400 dark:text-gray-500 transition-colors text-center leading-tight">Review &amp;<br>Submit</span>
        </div>
    </div>

    {{-- ═══ STEP 1: Personal Info ═══ --}}
    <div id="step-1" class="animate-fade-up">
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-6 space-y-5">
            <div>
                <label for="inp-full-name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Full Name</label>
                <input type="text" id="inp-full-name"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition"
                    placeholder="Enter your full legal name"
                    autocomplete="name"
                    oninput="saveStep1()">
                <p id="err-full-name" class="text-xs text-red-500 mt-1 hidden">Full name is required.</p>
            </div>

            <div>
                <label for="inp-national-id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">National ID Number</label>
                <input type="text" id="inp-national-id"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition font-mono"
                    placeholder="e.g. 1234567890"
                    autocomplete="off"
                    oninput="saveStep1()">
                <p id="err-national-id" class="text-xs text-red-500 mt-1 hidden">National ID number is required.</p>
            </div>

            <div>
                <label for="inp-doc-type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Document Type</label>
                <select id="inp-doc-type"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition"
                    onchange="saveStep1()">
                    <option value="">Select a document type...</option>
                    <option value="Passport Renewal">Passport Renewal</option>
                    <option value="New Passport">New Passport</option>
                    <option value="ID Card">ID Card</option>
                    <option value="Birth Certificate">Birth Certificate</option>
                    <option value="Other">Other</option>
                </select>
                <p id="err-doc-type" class="text-xs text-red-500 mt-1 hidden">Please select a document type.</p>
            </div>

            <button type="button" onclick="step1Continue()"
                class="w-full py-3 bg-brand text-white font-semibold text-sm rounded-[10px] hover:bg-brand/90 transition-all shadow-md flex items-center justify-center gap-2 mt-2">
                Continue
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    {{-- ═══ STEP 2: Pick Appointment ═══ --}}
    <div id="step-2" class="hidden space-y-4">

        {{-- Calendar Card --}}
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-5">

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
                    <div class="text-center text-[10px] font-bold py-1 {{ in_array($dow, ['Fri','Sat']) ? 'text-red-400 dark:text-red-500' : 'text-gray-400 dark:text-gray-500' }}">{{ $dow }}</div>
                @endforeach
            </div>

            {{-- Calendar Grid (populated by JS) --}}
            <div id="calGrid" class="grid grid-cols-7 gap-1"></div>

            {{-- Legend --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-4 pt-3 border-t border-gray-100 dark:border-gray-800">
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-emerald-200 dark:bg-emerald-800/60 inline-block shrink-0"></span>Available</span>
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-yellow-200 dark:bg-yellow-800/60 inline-block shrink-0"></span>Filling up</span>
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-orange-200 dark:bg-orange-800/60 inline-block shrink-0"></span>Almost full</span>
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-red-200 dark:bg-red-900/60 inline-block shrink-0"></span>Full</span>
                <span class="flex items-center gap-1.5 text-[11px] text-gray-400"><span class="w-3 h-3 rounded-sm bg-gray-200 dark:bg-gray-700 inline-block shrink-0"></span>Off day</span>
            </div>
        </div>

        {{-- Time Slot Panel (shown after date selection) --}}
        <div id="slotPanel" class="hidden bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-5">
            <p id="slotDate" class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3"></p>
            <div id="slotContent"></div>
        </div>

        {{-- Step 2 Navigation --}}
        <div class="flex gap-3">
            <button type="button" onclick="goToStep(1)"
                class="flex-1 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold text-sm rounded-[10px] hover:bg-gray-200 dark:hover:bg-gray-700 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back
            </button>
            <button type="button" id="step2Btn" onclick="step2Continue()" disabled
                class="flex-1 py-3 bg-brand text-white font-semibold text-sm rounded-[10px] hover:bg-brand/90 transition shadow-md disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                Continue
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    {{-- ═══ STEP 3: Review & Required Documents ═══ --}}
    <div id="step-3" class="hidden space-y-4">

        {{-- Summary Card --}}
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-5">
            <h4 class="font-bold text-brand dark:text-white font-outfit mb-4 text-sm uppercase tracking-wide">Appointment Summary</h4>
            <dl class="space-y-3">
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0">Full Name</dt>
                    <dd id="rev-name" class="text-sm font-semibold text-gray-800 dark:text-gray-100 text-right truncate max-w-[60%]"></dd>
                </div>
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0">National ID</dt>
                    <dd id="rev-nid" class="text-sm font-semibold text-gray-800 dark:text-gray-100 text-right font-mono"></dd>
                </div>
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0">Document</dt>
                    <dd id="rev-doctype" class="text-sm font-semibold text-gray-800 dark:text-gray-100 text-right"></dd>
                </div>
                <div class="h-px bg-gray-100 dark:bg-gray-800"></div>
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0">Date</dt>
                    <dd id="rev-date" class="text-sm font-bold text-brand dark:text-indigo-400 text-right"></dd>
                </div>
                <div class="flex justify-between items-baseline gap-4">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide shrink-0">Time</dt>
                    <dd id="rev-slot" class="text-sm font-bold text-brand dark:text-indigo-400 text-right"></dd>
                </div>
            </dl>
        </div>

        {{-- Required Documents Checklist --}}
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-5">
            <h4 class="font-bold text-brand dark:text-white font-outfit mb-1 text-sm">Required Documents</h4>
            <p class="text-xs text-gray-400 dark:text-gray-500 mb-4">Please confirm you have all required documents before submitting your appointment.</p>
            <div id="req-checklist" class="space-y-2"></div>
        </div>

        {{-- Step 3 Navigation --}}
        <div class="flex gap-3">
            <button type="button" onclick="goToStep(2)"
                class="flex-1 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold text-sm rounded-[10px] hover:bg-gray-200 dark:hover:bg-gray-700 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back
            </button>
            <button type="button" id="submitBtn" onclick="submitWizard()" disabled
                class="flex-1 py-3 bg-emerald-600 text-white font-semibold text-sm rounded-[10px] hover:bg-emerald-700 transition shadow-md disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                Submit Appointment
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </button>
        </div>
    </div>

</div>{{-- /max-w-xl --}}

{{-- Hidden form for final POST submission --}}
<form id="wizardForm" method="POST" action="{{ route('citizen.appointments.store') }}" class="hidden">
    @csrf
    <input type="hidden" id="form-full-name"   name="full_name">
    <input type="hidden" id="form-national-id" name="national_id_number">
    <input type="hidden" id="form-doc-type"    name="document_type">
    <input type="hidden" id="form-date"         name="date">
    <input type="hidden" id="form-slot"         name="time_slot">
    <input type="hidden"                        name="notes" value="">
</form>

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
const MONTH_URL = @json(route('citizen.appointments.month-data'));
const SLOTS_URL = @json(route('citizen.appointments.slots'));

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

// ── Wizard state ──────────────────────────────────
const ws = {
    fullName:'', nationalId:'', docType:'',
    date:null, slot:null,
    cal: Object.assign({}, CAL),
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
            l.className = 'text-[11px] mt-1.5 font-semibold text-brand dark:text-indigo-400 transition-colors text-center leading-tight';
        } else if (i === n) {
            c.className = 'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold bg-brand text-white transition-all duration-300';
            c.textContent = i;
            l.className = 'text-[11px] mt-1.5 font-semibold text-brand dark:text-indigo-400 transition-colors text-center leading-tight';
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
            btn.title     = 'Fully booked';
        } else if (isSel) {
            btn.className = `${base} bg-brand text-white ring-2 ring-brand ring-offset-1 dark:ring-offset-[#1e293b] scale-105 font-bold`;
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
        </svg>Loading available time slots...</div>`;

    try {
        const r    = await fetch(`${SLOTS_URL}?date=${ds}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await r.json();
        if (data.error) {
            content.innerHTML = `<p class="text-sm text-red-500 dark:text-red-400">${data.error}</p>`;
            return;
        }
        if (!data.slots?.length) {
            content.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">No slots available for this date.</p>';
            return;
        }
        renderSlots(data.slots);
    } catch(e) {
        content.innerHTML = '<p class="text-sm text-red-500">Failed to load slots. Please try again.</p>';
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
        : 'py-2.5 px-3 rounded-xl text-sm font-medium transition-all bg-gray-50 dark:bg-[#0f172a] border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:border-brand hover:text-brand hover:bg-brand/5';
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
    document.getElementById('rev-doctype').textContent = ws.docType;

    const dObj = new Date(ws.date + 'T00:00:00');
    document.getElementById('rev-date').textContent = dObj.toLocaleDateString('en-GB', { weekday:'short', year:'numeric', month:'short', day:'numeric' });
    document.getElementById('rev-slot').textContent = TIME_LABELS[ws.slot] || ws.slot;

    const reqs = DOC_REQS[ws.docType] || DOC_REQS['Other'];
    const list = document.getElementById('req-checklist');
    list.innerHTML = '';
    reqs.forEach((req, i) => {
        const lbl = document.createElement('label');
        lbl.className = 'flex items-center gap-3 p-3.5 rounded-xl cursor-pointer bg-gray-50 dark:bg-[#0f172a] hover:bg-gray-100 dark:hover:bg-gray-800/60 transition group';
        lbl.innerHTML = `<input type="checkbox" id="rc-${i}" class="req-cb w-4 h-4 rounded accent-brand shrink-0" onchange="checkSubmit()"><span class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-gray-100 transition leading-snug">${req}</span>`;
        list.appendChild(lbl);
    });
    checkSubmit();
}

function checkSubmit() {
    const all = [...document.querySelectorAll('.req-cb')];
    document.getElementById('submitBtn').disabled = !all.length || !all.every(cb => cb.checked);
}

function submitWizard() {
    document.getElementById('form-full-name').value   = ws.fullName;
    document.getElementById('form-national-id').value = ws.nationalId;
    document.getElementById('form-doc-type').value    = ws.docType;
    document.getElementById('form-date').value         = ws.date;
    document.getElementById('form-slot').value         = ws.slot;
    localStorage.removeItem('hz_wiz_name');
    localStorage.removeItem('hz_wiz_nid');
    localStorage.removeItem('hz_wiz_doctype');
    document.getElementById('wizardForm').submit();
}

// ── Init ──────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    restoreStep1();
    updateIndicator(1);
});
</script>
@endpush

@endsection
