@extends('layouts.halzanin-app')

@section('title', 'Apply — ' . $service->name)

@php
    $color      = $service->ministry->color ?? '#1B4F8A';
    $colorLight = $color . '14';
    $colorBorder = $color . '30';
    $reqDocs    = $service->required_documents ?? [];
    $schema     = $service->form_schema ?? [];
@endphp

@section('content')
<div class="max-w-2xl mx-auto pb-12">

    {{-- ── Back ── --}}
    <div class="mb-5">
        <a href="{{ route('services.show', $service->slug) }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-400 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Service Details
        </a>
    </div>

    {{-- ── Service hero ── --}}
    <div class="rounded-2xl overflow-hidden shadow-md mb-6 animate-fade-in" style="border-top: 4px solid {{ $color }}; background: var(--card); border: 1px solid {{ $colorBorder }}; border-top: 4px solid {{ $color }};">
        <div class="px-6 py-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: {{ $colorLight }};">
                @if($service->ministry->slug === 'civil-registry')
                    <svg class="w-6 h-6" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 00-9.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                @elseif($service->ministry->slug === 'traffic-police')
                    <svg class="w-6 h-6" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><rect x="7" y="2" width="10" height="20" rx="3" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="7" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="12" cy="17" r="2"/></svg>
                @elseif($service->ministry->slug === 'electricity')
                    <svg class="w-6 h-6" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                @elseif($service->ministry->slug === 'water')
                    <svg class="w-6 h-6" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                @else
                    <svg class="w-6 h-6" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold uppercase tracking-widest mb-0.5" style="color: {{ $color }};">{{ $service->ministry->name }}</p>
                <h1 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-snug">{{ $service->name }}</h1>
                @if($service->name_ku)
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-0.5" style="font-family:'Noto Naskh Arabic',serif;">{{ $service->name_ku }}</p>
                @endif
            </div>
            <div class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold" style="background: {{ $colorLight }}; color: {{ $color }}; border: 1px solid {{ $colorBorder }};">
                <span class="w-1.5 h-1.5 rounded-full inline-block" style="background: {{ $color }};"></span>
                Est. {{ $service->estimated_days }} days
            </div>
        </div>
    </div>

    {{-- ── Required Documents notice ── --}}
    @if(!empty($reqDocs))
    <div class="rounded-xl mb-5 p-4 animate-fade-in" style="background: {{ $colorLight }}; border: 1px solid {{ $colorBorder }};">
        <div class="flex items-start gap-3">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold uppercase tracking-wider mb-2" style="color: {{ $color }};">Documents you need to upload below</p>
                <ul class="space-y-1">
                    @foreach($reqDocs as $doc)
                    <li class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="{{ $color }}" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
                        {{ $doc }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Validation errors ── --}}
    @if ($errors->any())
    <div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-4 mb-5">
        <div class="flex items-start gap-3">
            <svg class="w-4 h-4 mt-0.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-bold text-red-700 dark:text-red-400 mb-1">Please fix the following errors:</p>
                <ul class="text-sm text-red-600 dark:text-red-400 space-y-0.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('services.store', $service->slug) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- ── Section 1: Personal Details ── --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden animate-fade-up" style="animation-delay:50ms">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <span class="w-6 h-6 rounded-full text-white flex items-center justify-center text-xs font-bold flex-shrink-0" style="background: {{ $color }};">1</span>
                <h2 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">Personal Details</h2>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}"
                           class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium transition-colors outline-none"
                           style="--tw-ring-color: {{ $color }};"
                           onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $color }}22'"
                           onblur="this.style.borderColor='';this.style.boxShadow=''"
                           required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        National ID Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="national_id_number" value="{{ old('national_id_number') }}"
                           placeholder="Enter your national ID number"
                           class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium transition-colors outline-none"
                           onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $color }}22'"
                           onblur="this.style.borderColor='';this.style.boxShadow=''"
                           required>
                </div>
            </div>
        </div>

        {{-- ── Section 2: Service-specific fields ── --}}
        @if(!empty($schema))
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden animate-fade-up" style="animation-delay:100ms">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <span class="w-6 h-6 rounded-full text-white flex items-center justify-center text-xs font-bold flex-shrink-0" style="background: {{ $color }};">2</span>
                <h2 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">{{ $service->name }} — Details</h2>
            </div>
            <div class="px-6 py-5 space-y-4">
                @foreach($schema as $field)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                        {{ $field['label'] }}
                        @if($field['required'] ?? false) <span class="text-red-500">*</span> @endif
                    </label>
                    @if(isset($field['label_ku']))
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-1.5 -mt-0.5" style="font-family:'Noto Naskh Arabic',serif;" dir="rtl">{{ $field['label_ku'] }}</p>
                    @endif

                    @if($field['type'] === 'select')
                        <div class="relative">
                            <select name="form[{{ $field['name'] }}]"
                                    class="w-full h-11 px-4 pr-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium appearance-none transition-colors outline-none"
                                    onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $color }}22'"
                                    onblur="this.style.borderColor='';this.style.boxShadow=''"
                                    {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                <option value="">— Select —</option>
                                @foreach($field['options'] as $opt)
                                    <option value="{{ $opt }}" {{ old('form.' . $field['name']) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>

                    @elseif($field['type'] === 'textarea')
                        <textarea name="form[{{ $field['name'] }}]" rows="3"
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium resize-none transition-colors outline-none"
                                  onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $color }}22'"
                                  onblur="this.style.borderColor='';this.style.boxShadow=''"
                                  {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old('form.' . $field['name']) }}</textarea>

                    @elseif($field['type'] === 'date')
                        <input type="date" name="form[{{ $field['name'] }}]" value="{{ old('form.' . $field['name']) }}"
                               class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium transition-colors outline-none"
                               onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $color }}22'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''"
                               {{ ($field['required'] ?? false) ? 'required' : '' }}>

                    @elseif($field['type'] === 'number')
                        <input type="number" name="form[{{ $field['name'] }}]" value="{{ old('form.' . $field['name']) }}" min="0"
                               class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium transition-colors outline-none"
                               onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $color }}22'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''"
                               {{ ($field['required'] ?? false) ? 'required' : '' }}>

                    @else
                        <input type="text" name="form[{{ $field['name'] }}]" value="{{ old('form.' . $field['name']) }}"
                               class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium transition-colors outline-none"
                               onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $color }}22'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''"
                               {{ ($field['required'] ?? false) ? 'required' : '' }}>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Section 3: Appointment ── --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden animate-fade-up" style="animation-delay:150ms">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <span class="w-6 h-6 rounded-full text-white flex items-center justify-center text-xs font-bold flex-shrink-0" style="background: {{ $color }};">{{ empty($schema) ? '2' : '3' }}</span>
                <div class="flex-1 min-w-0">
                    <h2 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">Appointment</h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 normal-case font-normal">Choose a date and time for your in-person verification or document pickup visit.</p>
                </div>
            </div>
            <div class="px-6 py-5 space-y-5">

                {{-- Date picker --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Preferred Date <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="appointment_date" required
                                class="w-full h-11 px-4 pr-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium appearance-none transition-colors outline-none"
                                onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $color }}22'"
                                onblur="this.style.borderColor='';this.style.boxShadow=''">
                            <option value="">— Choose a date —</option>
                            @foreach($availableDates as $date)
                                <option value="{{ $date }}" {{ old('appointment_date') === $date ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Time slot picker --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Time Slot <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2" id="time-slot-grid">
                        @foreach($timeSlots as $slot)
                        <label class="block cursor-pointer">
                            <input type="radio" name="time_slot" value="{{ $slot }}" class="sr-only time-slot-radio"
                                   {{ old('time_slot') === $slot ? 'checked' : '' }}>
                            <div class="time-slot-btn text-center py-2.5 px-1 rounded-xl border text-sm font-semibold transition-all select-none"
                                 style="border-color: #E5E7EB; color: #6B7280; background: #F9FAFB;">
                                {{ $slot }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Section 4: Upload Documents ── --}}
        @if(!empty($reqDocs))
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden animate-fade-up" style="animation-delay:200ms">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <span class="w-6 h-6 rounded-full text-white flex items-center justify-center text-xs font-bold flex-shrink-0" style="background: {{ $color }};">{{ empty($schema) ? '3' : '4' }}</span>
                <div class="flex-1 min-w-0">
                    <h2 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">Upload Documents</h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 normal-case font-normal">Accepted: JPG, PNG, PDF — max 5 MB per file.</p>
                </div>
            </div>
            <div class="px-6 py-5 space-y-4">
                @foreach($reqDocs as $i => $doc)
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 p-4" style="background: var(--bg, #F9FAFB);">
                    <div class="flex items-start gap-2 mb-3">
                        <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 text-white text-xs font-bold" style="background: {{ $color }};">{{ $i + 1 }}</div>
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 leading-snug">{{ $doc }}</p>
                    </div>
                    <label class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-400 cursor-pointer transition-colors group"
                           style="background: white;" onmouseover="this.style.borderColor='{{ $color }}'" onmouseout="this.style.borderColor=''">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <span class="text-sm text-gray-500 dark:text-gray-400 flex-1">Click to upload or drag file here</span>
                        <input type="file" name="documents[]" accept=".jpg,.jpeg,.png,.pdf" class="hidden doc-upload"
                               onchange="showFileName(this)">
                    </label>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 px-1" id="file-name-{{ $i }}"></p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Submit row ── --}}
        <div class="flex items-center justify-between gap-4 pt-2 animate-fade-up" style="animation-delay:250ms">
            <a href="{{ route('services.show', $service->slug) }}"
               class="h-11 px-6 rounded-xl border border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:border-gray-400 dark:hover:border-gray-400 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                Cancel
            </a>
            <button type="submit" id="submit-btn"
                    class="h-11 px-8 rounded-xl text-white text-sm font-bold shadow-md flex items-center gap-2 transition-all"
                    style="background: {{ $color }}; box-shadow: 0 4px 14px {{ $color }}44;"
                    onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Submit Application
            </button>
        </div>

    </form>
</div>

<script>
(function() {
    const BRAND = '{{ $color }}';
    const BRAND_LIGHT = '{{ $colorLight }}';

    // Time slot selection
    document.querySelectorAll('.time-slot-radio').forEach(function(radio) {
        var btn = radio.nextElementSibling;

        // Restore state on page load (e.g. after validation failure)
        if (radio.checked) {
            applyChecked(btn);
        }

        radio.addEventListener('change', function() {
            // Reset all
            document.querySelectorAll('.time-slot-btn').forEach(function(b) {
                b.style.background = '';
                b.style.borderColor = '#E5E7EB';
                b.style.color = '#6B7280';
                b.style.boxShadow = '';
            });
            // Apply to selected
            if (radio.checked) applyChecked(btn);
        });
    });

    function applyChecked(btn) {
        btn.style.background = BRAND;
        btn.style.borderColor = BRAND;
        btn.style.color = '#ffffff';
        btn.style.boxShadow = '0 2px 8px ' + BRAND + '44';
    }

    // File name display
    window.showFileName = function(input) {
        var label = input.closest('label');
        var container = label.parentElement;
        var noteEl = container.querySelector('[id^="file-name-"]');
        if (input.files && input.files[0] && noteEl) {
            noteEl.textContent = input.files[0].name + ' (' + (input.files[0].size / 1024).toFixed(0) + ' KB)';
            noteEl.style.color = BRAND;
        }
    };

    // Submit loading state
    var form = document.querySelector('form');
    var btn  = document.getElementById('submit-btn');
    if (form && btn) {
        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Submitting…';
        });
    }
})();
</script>
@endsection
