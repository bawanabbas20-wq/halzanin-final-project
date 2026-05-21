@extends('layouts.halzanin-app')

@section('title', 'Apply: ' . $service->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Back link --}}
    <a href="{{ route('services.show', $service->slug) }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Back to Service Details
    </a>

    {{-- Header --}}
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden shadow-sm"
         style="border-top: 4px solid {{ $service->ministry->color }}">
        <div class="px-6 py-5 flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: {{ $service->ministry->color }}18;">
                <svg class="w-6 h-6" fill="none" stroke="{{ $service->ministry->color }}" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $service->ministry->name }}</p>
                <h1 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $service->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $service->name_ku }}</p>
            </div>
        </div>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-4">
            <p class="text-sm font-bold text-red-700 dark:text-red-400 mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('services.store', $service->slug) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Personal details --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm space-y-5">
            <h2 class="text-sm font-extrabold uppercase tracking-wider text-gray-400">Personal Details</h2>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}"
                       class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    National ID Number <span class="text-red-500">*</span>
                </label>
                <input type="text" name="national_id_number" value="{{ old('national_id_number') }}"
                       class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition"
                       required>
            </div>
        </div>

        {{-- Service-specific fields --}}
        @if(!empty($service->form_schema))
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm space-y-5">
            <h2 class="text-sm font-extrabold uppercase tracking-wider text-gray-400">Service Details</h2>

            @foreach($service->form_schema as $field)
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    {{ $field['label'] }}
                    @if($field['required'] ?? false) <span class="text-red-500">*</span> @endif
                    @if(isset($field['label_ku']))
                        <span class="text-gray-400 font-normal text-xs ms-2" dir="rtl">{{ $field['label_ku'] }}</span>
                    @endif
                </label>

                @if($field['type'] === 'select')
                    <select name="form[{{ $field['name'] }}]"
                            class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition"
                            {{ ($field['required'] ?? false) ? 'required' : '' }}>
                        <option value="">— Select —</option>
                        @foreach($field['options'] as $opt)
                            <option value="{{ $opt }}" {{ old('form.' . $field['name']) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>

                @elseif($field['type'] === 'textarea')
                    <textarea name="form[{{ $field['name'] }}]" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition resize-none"
                              {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old('form.' . $field['name']) }}</textarea>

                @elseif($field['type'] === 'date')
                    <input type="date" name="form[{{ $field['name'] }}]" value="{{ old('form.' . $field['name']) }}"
                           class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition"
                           {{ ($field['required'] ?? false) ? 'required' : '' }}>

                @elseif($field['type'] === 'number')
                    <input type="number" name="form[{{ $field['name'] }}]" value="{{ old('form.' . $field['name']) }}" min="0"
                           class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition"
                           {{ ($field['required'] ?? false) ? 'required' : '' }}>

                @else
                    <input type="text" name="form[{{ $field['name'] }}]" value="{{ old('form.' . $field['name']) }}"
                           class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition"
                           {{ ($field['required'] ?? false) ? 'required' : '' }}>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Appointment --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm space-y-5">
            <h2 class="text-sm font-extrabold uppercase tracking-wider text-gray-400">Appointment</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 -mt-2">Choose a date and time slot for your in-person verification visit.</p>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    Preferred Date <span class="text-red-500">*</span>
                </label>
                <select name="appointment_date" required
                        class="w-full h-11 px-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                    <option value="">— Choose a date —</option>
                    @foreach($availableDates as $date)
                        <option value="{{ $date }}" {{ old('appointment_date') === $date ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    Time Slot <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-5 gap-2">
                    @foreach($timeSlots as $slot)
                        <label class="cursor-pointer">
                            <input type="radio" name="time_slot" value="{{ $slot }}" class="sr-only peer"
                                   {{ old('time_slot') === $slot ? 'checked' : '' }}>
                            <div class="text-center py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-600 dark:text-gray-400
                                        peer-checked:bg-brand-600 peer-checked:border-brand-600 peer-checked:text-white
                                        hover:border-brand-400 hover:text-brand-600 transition-all cursor-pointer select-none">
                                {{ $slot }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Documents upload --}}
        @if(!empty($service->required_documents))
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm space-y-4">
            <h2 class="text-sm font-extrabold uppercase tracking-wider text-gray-400">Upload Documents</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 -mt-2">Accepted: JPG, PNG, PDF — max 5 MB each.</p>

            <div class="space-y-2">
                @foreach($service->required_documents as $i => $doc)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $doc }}</label>
                    <input type="file" name="documents[]" accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full text-sm text-gray-500 dark:text-gray-400
                                  file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700
                                  dark:file:bg-brand-900/20 dark:file:text-brand-400
                                  hover:file:bg-brand-100 transition cursor-pointer">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Submit --}}
        <div class="flex items-center justify-between gap-4 pb-4">
            <a href="{{ route('services.show', $service->slug) }}"
               class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:border-gray-400 transition">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold shadow-md hover:shadow-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Submit Application
            </button>
        </div>
    </form>
</div>
@endsection
