@extends('layouts.halzanin-app')

@section('content')
<div class="w-full max-w-[580px] mx-auto">
    <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-6 lg:p-8 shadow-[0_10px_15px_rgba(0,0,0,0.08)] relative overflow-hidden">
        <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit text-center mb-8" data-i18n="book.short_title">Book Appointment</h2>

        {{-- Step Indicator --}}
        <div class="relative flex justify-between mb-10" id="step-indicator">
            <div class="absolute top-4 left-0 w-full h-0.5 bg-gray-200 dark:bg-gray-700 -z-10"></div>
            <div id="progress-line" class="absolute top-4 left-0 h-0.5 bg-accent transition-all duration-300 -z-10 w-0"></div>
            @foreach([1=>['book.step1','Personal Info'], 2=>['book.step2','Appointment'], 3=>['book.step_documents','Documents'], 4=>['book.step_review','Review']] as $n => $step)
            <div class="flex flex-col items-center w-1/4">
                <div id="indicator-{{ $n }}" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors {{ $n === 1 ? 'bg-brand text-white shadow-md' : 'bg-white dark:bg-[#1e293b] border-2 border-gray-300 dark:border-gray-600 text-gray-400' }}">
                    <span class="step-num">{{ $n }}</span>
                    <svg class="step-check hidden w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-xs font-semibold mt-2 text-center {{ $n === 1 ? 'text-brand dark:text-indigo-400' : 'text-gray-400' }}" data-i18n="{{ $step[0] }}">{{ $step[1] }}</span>
            </div>
            @endforeach
        </div>

        {{-- Form --}}
        <div class="relative overflow-hidden w-full">
            <form method="POST" action="{{ route('citizen.appointment.store') }}" id="appointment-form"
                  enctype="multipart/form-data"
                  class="flex transition-transform duration-300 ease-in-out w-[400%]"
                  x-data="{ confirmed: false }"
                  @submit.prevent="if(!confirmed){ $dispatch('open-modal','confirm-appointment') } else { $el.submit() }">
                @csrf

                {{-- STEP 1: Personal Info --}}
                <div class="w-1/4 shrink-0 px-1" id="step-1">
                    <div class="space-y-4">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" data-i18n="book.full_name">Full Name</label>
                            <div class="absolute inset-y-0 left-0 mt-6 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input id="full_name" type="text" name="full_name" value="{{ old('full_name', session('appointment_draft.full_name')) }}" required class="block w-full h-[48px] pl-11 pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] transition-all">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" data-i18n="book.national_id">National ID Number</label>
                            <div class="absolute inset-y-0 left-0 mt-6 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                            </div>
                            <input id="national_id_number" type="text" name="national_id_number" value="{{ old('national_id_number', session('appointment_draft.national_id_number')) }}" required class="block w-full h-[48px] pl-11 pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] transition-all">
                        </div>
                        <div class="pt-6">
                            <button type="button" onclick="nextStep(2)" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all" data-i18n="book.continue">Continue</button>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: Appointment Details --}}
                <div class="w-1/4 shrink-0 px-1" id="step-2">
                    <div class="space-y-4">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" data-i18n="book.preferred_date">Preferred Date</label>
                            <div class="absolute inset-y-0 left-0 mt-6 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <input id="preferred_date" type="date" name="preferred_date" value="{{ old('preferred_date', session('appointment_draft.preferred_date')) }}" required class="block w-full h-[48px] pl-11 pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 transition-all">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" data-i18n="book.time_slot">Time Slot</label>
                            <div class="absolute inset-y-0 left-0 mt-6 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <select id="time_slot" name="time_slot" required class="block w-full h-[48px] pl-11 pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 transition-all">
                                <option value="" data-i18n="book.select_time">Select a time slot</option>
                                @foreach(['9:00 AM','10:00 AM','11:00 AM','2:00 PM','3:00 PM'] as $slot)
                                    <option value="{{ $slot }}" {{ old('time_slot', session('appointment_draft.time_slot')) == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" data-i18n="book.doc_type">Document Type</label>
                            <div class="absolute inset-y-0 left-0 mt-6 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <select id="document_type" name="document_type" required class="block w-full h-[48px] pl-11 pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 transition-all">
                                <option value="" data-i18n="book.select_doc_type">Select document type</option>
                                @foreach(['Passport Renewal','New Passport','ID Card','Birth Certificate','Other'] as $dt)
                                    <option value="{{ $dt }}" {{ old('document_type', session('appointment_draft.document_type')) == $dt ? 'selected' : '' }} data-i18n="{{ ['Passport Renewal'=>'doc.passport_renewal', 'New Passport'=>'doc.new_passport', 'ID Card'=>'doc.id_card', 'Birth Certificate'=>'doc.birth_cert', 'Other'=>'doc.other'][$dt] }}">{{ $dt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" data-i18n="book.notes">Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3" class="block w-full pl-4 pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 transition-all">{{ old('notes', session('appointment_draft.notes')) }}</textarea>
                        </div>
                        <div class="pt-4 flex space-x-3">
                            <button type="button" onclick="nextStep(1)" class="w-1/3 h-[52px] bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-[10px] font-semibold transition-all" data-i18n="book.back">Back</button>
                            <button type="button" onclick="nextStep(3)" class="w-2/3 h-[52px] bg-brand text-white rounded-[10px] font-semibold shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all" data-i18n="book.continue">Continue</button>
                        </div>
                    </div>
                </div>

                {{-- STEP 3: Upload Documents --}}
                <div class="w-1/4 shrink-0 px-1" id="step-3">
                    <div class="mb-4 p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-[10px]">
                        <p class="text-sm font-semibold text-brand dark:text-indigo-300 mb-1" data-i18n="book.required_documents">Required Documents</p>
                        <p id="doc-type-label" class="text-xs text-indigo-600 dark:text-indigo-400" data-i18n="book.select_doc_first">Select a document type in Step 2 first.</p>
                    </div>
                    <div id="doc-upload-fields" class="space-y-4">
                        {{-- Dynamically rendered by JS --}}
                    </div>
                    <p id="upload-hint" class="text-xs text-amber-600 dark:text-amber-400 mt-3 hidden" data-i18n="book.upload_hint">Please upload all required documents to continue.</p>
                    <div class="pt-6 flex space-x-3">
                        <button type="button" onclick="nextStep(2)" class="w-1/3 h-[52px] bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-[10px] font-semibold transition-all" data-i18n="book.back">Back</button>
                        <button type="button" onclick="nextStep(4)" id="btn-to-review" class="w-2/3 h-[52px] bg-brand text-white rounded-[10px] font-semibold shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all" data-i18n="book.continue">Continue</button>
                    </div>
                </div>

                {{-- STEP 4: Review --}}
                <div class="w-1/4 shrink-0 px-1" id="step-4">
                    <div class="bg-gray-50 dark:bg-slate-800/50 rounded-[10px] border border-gray-200 dark:border-gray-700 p-5 mb-4">
                        <h3 class="text-sm font-semibold text-brand dark:text-indigo-400 mb-4 uppercase tracking-wider" data-i18n="book.summary">Summary</h3>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-2">
                            <div><p class="text-[11px] text-gray-500 uppercase tracking-wide" data-i18n="book.full_name">Full Name</p><p id="sum-name" class="font-medium text-gray-900 dark:text-white text-sm mt-0.5 truncate"></p></div>
                            <div><p class="text-[11px] text-gray-500 uppercase tracking-wide" data-i18n="book.national_id_short">National ID</p><p id="sum-id" class="font-medium text-gray-900 dark:text-white text-sm mt-0.5 truncate"></p></div>
                            <div><p class="text-[11px] text-gray-500 uppercase tracking-wide" data-i18n="book.doc_type">Document Type</p><p id="sum-doc" class="font-medium text-gray-900 dark:text-white text-sm mt-0.5 truncate"></p></div>
                            <div><p class="text-[11px] text-gray-500 uppercase tracking-wide" data-i18n="qr.appointment">Appointment</p><p id="sum-date" class="font-medium text-gray-900 dark:text-white text-sm mt-0.5 truncate"></p></div>
                        </div>
                    </div>
                    <div id="sum-files-section" class="bg-gray-50 dark:bg-slate-800/50 rounded-[10px] border border-gray-200 dark:border-gray-700 p-5 mb-4">
                        <h3 class="text-sm font-semibold text-brand dark:text-indigo-400 mb-3 uppercase tracking-wider" data-i18n="book.uploaded_documents">Uploaded Documents</h3>
                        <ul id="sum-files" class="space-y-1.5 text-sm text-gray-700 dark:text-gray-300"></ul>
                    </div>
                    <div class="flex items-start space-x-3 bg-indigo-50 dark:bg-indigo-900/20 text-brand dark:text-indigo-300 p-4 rounded-[10px] mb-5 border border-indigo-100 dark:border-indigo-800">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        <p class="text-sm" data-i18n="book.qr_notice">You will receive a unique QR tracking code after submission.</p>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" onclick="nextStep(3)" class="w-1/3 h-[52px] bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-[10px] font-semibold transition-all" data-i18n="book.back">Back</button>
                        <button type="submit" class="w-2/3 h-[52px] bg-accent text-white rounded-[10px] font-semibold shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all" data-i18n="book.submit">Submit Appointment</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- Confirm Modal --}}
    <x-modal name="confirm-appointment">
        <div class="p-6">
            <h2 class="text-xl font-bold font-outfit mb-2 text-gray-900 dark:text-white" data-i18n="book.confirm_title">Confirm Submission</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-5" data-i18n="book.confirm_body">Please confirm your appointment details are correct. All uploaded documents and details will be sent for review.</p>
            <div class="bg-gray-50 dark:bg-[#0f172a] p-4 rounded-[12px] mb-6 border border-gray-100 dark:border-gray-800">
                <p class="text-[13px] text-gray-500 dark:text-gray-400 font-semibold mb-1" id="modal-name"></p>
                <p class="text-[13px] text-gray-500 dark:text-gray-400 font-semibold" id="modal-datetime"></p>
            </div>
            <div class="flex items-center justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close-modal','confirm-appointment')" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 rounded-[10px] font-semibold transition-colors text-sm" data-i18n="book.go_back">Go Back</button>
                <button type="button" x-on:click="document.getElementById('appointment-form').__x.$data.confirmed = true; document.getElementById('appointment-form').submit()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-[10px] font-semibold shadow-md transition-colors text-sm" data-i18n="book.submit_now">Submit Now</button>
            </div>
        </div>
    </x-modal>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
let currentStep = 1;
const form = document.getElementById('appointment-form');
const isRtl = document.documentElement.dir === 'rtl';

const docRequirements = {
    'Passport Renewal':   [{name:'doc_current_passport',label:'Current Passport (scan/photo)'},{name:'doc_national_id',label:'National ID'},{name:'doc_passport_photo',label:'Passport-size Photo'},{name:'doc_fee_receipt',label:'Fee Receipt'}],
    'New Passport':       [{name:'doc_birth_certificate',label:'Birth Certificate'},{name:'doc_national_id',label:'National ID'},{name:'doc_passport_photo',label:'Passport-size Photo'}],
    'ID Card':            [{name:'doc_birth_certificate',label:'Birth Certificate'},{name:'doc_national_id',label:'National ID'},{name:'doc_passport_photo',label:'Passport-size Photo'}],
    'Birth Certificate':  [{name:'doc_hospital_record',label:'Hospital Birth Record'},{name:'doc_parent_national_id',label:"Parent's National ID"}],
    'Other':              [{name:'doc_national_id',label:'National ID'}],
};

function renderDocFields(docType) {
    const container = document.getElementById('doc-upload-fields');
    const label = document.getElementById('doc-type-label');
    const docs = docRequirements[docType] || [];
    label.textContent = docType ? `Required for "${docType}":` : 'Select a document type in Step 2 first.';
    container.innerHTML = '';
    docs.forEach(doc => {
        const div = document.createElement('div');
        div.className = 'rounded-[10px] border border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-slate-800/30';
        div.innerHTML = `
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                📎 ${doc.label} <span class="text-red-500">*</span>
            </label>
            <input type="file" name="${doc.name}" accept=".jpg,.jpeg,.png,.pdf" required
                class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-[8px] file:border-0 file:text-sm file:font-semibold file:bg-brand/10 file:text-brand dark:file:bg-indigo-900/30 dark:file:text-indigo-300 hover:file:bg-brand/20 transition-all" />
            <p class="text-xs text-gray-400 mt-1">JPG, PNG or PDF — max 5MB</p>`;
        container.appendChild(div);
    });
}

function validateDocUploads() {
    const fields = document.querySelectorAll('#doc-upload-fields input[type="file"]');
    return Array.from(fields).every(f => f.files && f.files.length > 0);
}

function validateStep(step) {
    if (step === 3) return true; // handled separately
    const container = document.getElementById(`step-${step}`);
    const inputs = container.querySelectorAll('input[required], select[required]');
    return Array.from(inputs).every(i => i.reportValidity());
}

function populateSummary() {
    document.getElementById('sum-name').textContent = document.getElementById('full_name').value || '—';
    document.getElementById('sum-id').textContent   = document.getElementById('national_id_number').value || '—';
    document.getElementById('sum-doc').textContent  = document.getElementById('document_type').value || '—';
    const date = document.getElementById('preferred_date').value;
    const time = document.getElementById('time_slot').value;
    const dt   = (date && time) ? `${date} at ${time}` : '—';
    document.getElementById('sum-date').textContent = dt;
    document.getElementById('modal-name').textContent     = document.getElementById('full_name').value || '—';
    document.getElementById('modal-datetime').textContent = dt;

    // List uploaded files
    const fileList = document.getElementById('sum-files');
    fileList.innerHTML = '';
    document.querySelectorAll('#doc-upload-fields input[type="file"]').forEach(f => {
        const li = document.createElement('li');
        li.className = 'flex items-center gap-2';
        li.innerHTML = `<span class="text-green-500">✓</span> <span class="font-medium">${f.closest('div').querySelector('label').textContent.replace('*','').trim()}</span>: <span class="text-gray-500 truncate max-w-[180px]">${f.files[0]?.name || '—'}</span>`;
        fileList.appendChild(li);
    });
}

function updateIndicators(target) {
    const pct = [0, 0, 33.33, 66.66, 100];
    document.getElementById('progress-line').style.width = pct[target] + '%';
    for (let i = 1; i <= 4; i++) {
        const ind   = document.getElementById(`indicator-${i}`);
        const num   = ind.querySelector('.step-num');
        const check = ind.querySelector('.step-check');
        const lbl   = ind.nextElementSibling;
        ind.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-white dark:bg-[#1e293b] border-2 border-gray-300 dark:border-gray-600 text-gray-400';
        lbl.className = 'text-xs font-semibold mt-2 text-center text-gray-400';
        num.classList.remove('hidden'); check.classList.add('hidden');
        if (i < target) {
            ind.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-accent text-white shadow-md border-0';
            num.classList.add('hidden'); check.classList.remove('hidden');
            lbl.className = 'text-xs font-semibold mt-2 text-center text-accent';
        } else if (i === target) {
            ind.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-brand text-white shadow-md border-0';
            lbl.className = 'text-xs font-semibold mt-2 text-center text-brand dark:text-indigo-400';
        }
    }
}

window.nextStep = function(target) {
    if (target > currentStep) {
        if (currentStep === 3) {
            if (!validateDocUploads()) {
                document.getElementById('upload-hint').classList.remove('hidden');
                return;
            }
            document.getElementById('upload-hint').classList.add('hidden');
        } else {
            if (!validateStep(currentStep)) return;
        }
        if (currentStep === 2) {
            const docType = document.getElementById('document_type').value;
            renderDocFields(docType);
        }
    }
    if (target === 4) populateSummary();
    currentStep = target;
    updateIndicators(target);
    const pct = (target - 1) * -25;
    form.style.transform = isRtl ? `translateX(${pct * -1}%)` : `translateX(${pct}%)`;
};

document.addEventListener('DOMContentLoaded', function() {
    const docTypeEl = document.getElementById('document_type');
    const saved = docTypeEl.value;
    if (saved) renderDocFields(saved);
});
</script>
@endsection
