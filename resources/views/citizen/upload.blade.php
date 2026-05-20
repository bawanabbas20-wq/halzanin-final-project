@extends('layouts.halzanin-app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between animate-fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gradient font-outfit" data-i18n="upload.title">Upload Documents</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="upload.subtitle">Provide the required files for your application.</p>
        </div>
        <a href="{{ route('citizen.dashboard') }}"
           class="flex items-center gap-1.5 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-brand dark:hover:text-indigo-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span data-i18n="common.back">Back</span>
        </a>
    </div>

    {{-- Context banner --}}
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-indigo-100 dark:border-indigo-900/40 overflow-hidden animate-fade-up" style="animation-delay: 100ms">
        <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
        <div class="p-5 flex items-center gap-4">
            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-0.5" data-i18n="upload.application">Application</p>
                <p class="font-bold font-mono text-brand dark:text-indigo-400 tracking-widest text-lg">{{ $application->tracking_code }}</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-4 animate-fade-up" style="animation-delay: 150ms">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="flex items-center gap-2 text-sm text-red-700 dark:text-red-400">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Upload Form --}}
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 200ms">
        <div class="h-1 bg-gradient-to-r from-indigo-400 via-purple-500 to-brand"></div>

        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider" data-i18n="upload.checklist">Requirements Checklist</h3>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" data-i18n="upload.checklist_desc">Check each box to confirm you have the document ready, then upload the file. All items must be checked to submit.</p>
        </div>

        <form method="POST"
              action="{{ route('citizen.documents.store', $application->id) }}"
              enctype="multipart/form-data"
              id="upload-form"
              class="p-6 space-y-4">
            @csrf

            @php
            $docItems = [
                ['id' => 'national_id', 'name' => 'national_id_file', 'label' => 'National ID', 'hint' => 'JPG, PNG or PDF — max 2MB'],
                ['id' => 'passport_photo', 'name' => 'passport_photo', 'label' => 'Passport Photo', 'hint' => 'JPG, PNG or PDF — max 2MB'],
                ['id' => 'birth_cert', 'name' => 'birth_certificate', 'label' => 'Birth Certificate', 'hint' => 'JPG, PNG or PDF — max 2MB'],
            ];
            @endphp

            @foreach($docItems as $item)
            <div class="doc-item rounded-[12px] border border-gray-200 dark:border-slate-700 p-4 transition-all duration-200 hover:border-brand/30 dark:hover:border-indigo-500/30">
                <div class="flex items-center gap-3 mb-0">
                    <input type="checkbox" id="check_{{ $item['id'] }}" data-wrap="file_{{ $item['id'] }}_wrap"
                           class="doc-check w-5 h-5 rounded text-brand border-gray-300 dark:border-gray-600 focus:ring-brand cursor-pointer shrink-0">
                    <label for="check_{{ $item['id'] }}" class="font-semibold text-gray-800 dark:text-white cursor-pointer select-none text-sm" data-i18n="upload.{{ $item['id'] }}">{{ $item['label'] }}</label>
                    <span class="ltr:ml-auto rtl:mr-auto">
                        <span class="doc-badge-pending inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span> <span data-i18n="common.pending">Pending</span>
                        </span>
                        <span class="doc-badge-ready hidden inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> <span data-i18n="common.ready">Ready</span>
                        </span>
                    </span>
                </div>
                <div id="file_{{ $item['id'] }}_wrap" class="hidden mt-3 pl-8">
                    <input id="{{ $item['id'] }}_file" name="{{ $item['name'] }}" type="file" accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-[8px] file:border-0 file:text-sm file:font-semibold file:bg-brand/10 file:text-brand dark:file:bg-indigo-900/30 dark:file:text-indigo-300 hover:file:bg-brand/20 transition-all cursor-pointer">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5" data-i18n="upload.file_help_2mb">{{ $item['hint'] }}</p>
                    <x-input-error :messages="$errors->get($item['name'])" class="mt-1" />
                </div>
            </div>
            @endforeach

            <div class="flex items-center justify-between pt-2">
                <div class="flex items-center gap-2">
                    <span id="checklist-hint" class="text-sm text-gray-400 dark:text-gray-500 transition-colors" data-i18n="upload.check_all">Check all 3 boxes to enable submission.</span>
                </div>
                <button id="submit-btn" type="submit" disabled
                        class="h-[48px] px-6 bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all opacity-40 cursor-not-allowed" data-i18n="upload.submit">
                    Submit Documents
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checks    = document.querySelectorAll('.doc-check');
    const submitBtn = document.getElementById('submit-btn');
    const hint      = document.getElementById('checklist-hint');

    checks.forEach(checkbox => {
        const wrapId = checkbox.dataset.wrap;
        checkbox.addEventListener('change', function () {
            const wrap = document.getElementById(wrapId);
            if (wrap) wrap.classList.toggle('hidden', !this.checked);

            const item = this.closest('.doc-item');
            const pendingBadge = item.querySelector('.doc-badge-pending');
            const readyBadge   = item.querySelector('.doc-badge-ready');
            pendingBadge.classList.toggle('hidden', this.checked);
            readyBadge.classList.toggle('hidden', !this.checked);

            updateSubmitState();
        });
    });

    function updateSubmitState() {
        const allChecked = Array.from(checks).every(c => c.checked);
        submitBtn.disabled = !allChecked;
        submitBtn.classList.toggle('opacity-40', !allChecked);
        submitBtn.classList.toggle('cursor-not-allowed', !allChecked);
        hint.textContent = allChecked
            ? 'All items confirmed — you can now submit.'
            : 'Check all 3 boxes to enable submission.';
        hint.classList.toggle('text-accent', allChecked);
        hint.classList.toggle('font-semibold', allChecked);
        hint.classList.toggle('text-gray-400', !allChecked);
        hint.classList.toggle('font-semibold', !allChecked);
    }
});
</script>
@endsection
