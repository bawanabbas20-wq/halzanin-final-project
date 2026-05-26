@extends('layouts.halzanin-app')

@section('title', 'Apply — ' . $service->name)

@php
    $color      = $service->ministry->color ?? '#1B4F8A';
    $colorLight = $color . '14';
    $colorBorder = $color . '30';
    $reqDocs    = $service->required_documents ?? [];
    $schema     = $service->form_schema ?? [];

    // Determine step count for progress bar
    $steps = ['Personal Details'];
    if (!empty($schema)) $steps[] = $service->name . ' Details';
    $steps[] = 'Appointment';
    if (!empty($reqDocs)) $steps[] = 'Upload Documents';
    $totalSteps = count($steps);
@endphp

@section('content')
{{-- Scoped styles injected inline since the layout has no @stack('head') --}}
<style>
/* ── Apply page styles ─────────────────────────────────── */
.ap-wrap { max-width: 680px; margin: 0 auto; padding-bottom: 4rem; }

/* ── Back link ─────────────────────────────────────────── */
.ap-back {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .8rem; font-weight: 600; color: #9ca3af;
    text-decoration: none; margin-bottom: 1.5rem;
    transition: color .15s;
}
.ap-back:hover { color: #374151; }
html.dark .ap-back:hover { color: #d1d5db; }

/* ── Service hero strip ────────────────────────────────── */
.ap-hero {
    border-radius: 16px; overflow: hidden;
    margin-bottom: 1.5rem;
    border: 1px solid {{ $colorBorder }};
    border-top: 4px solid {{ $color }};
    background: var(--card, #fff);
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.ap-hero-inner { display: flex; align-items: center; gap: 1rem; padding: 1.1rem 1.25rem; }
.ap-hero-icon {
    width: 46px; height: 46px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: {{ $colorLight }};
}
.ap-hero-icon svg { width: 22px; height: 22px; }
.ap-hero-body { flex: 1; min-width: 0; }
.ap-hero-ministry { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; margin-bottom: .2rem; color: {{ $color }}; }
.ap-hero-name { font-size: 1.1rem; font-weight: 800; color: var(--text, #111); letter-spacing: -.01em; line-height: 1.2; }
.ap-hero-name-ku { font-family: 'Noto Naskh Arabic', serif; font-size: .85rem; color: #9ca3af; margin-top: .15rem; direction: rtl; }
.ap-hero-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .25rem .7rem; border-radius: 20px; font-size: .7rem; font-weight: 700;
    background: {{ $colorLight }}; color: {{ $color }}; border: 1px solid {{ $colorBorder }};
    white-space: nowrap;
}

/* ── Progress stepper ──────────────────────────────────── */
.ap-progress {
    background: var(--card, #fff);
    border: 1px solid var(--border, rgba(0,0,0,0.09));
    border-radius: 14px; padding: 1.1rem 1.25rem 1rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 1px 8px rgba(0,0,0,0.05);
}
html.dark .ap-progress { background: var(--dark-card, #1a1b26); border-color: rgba(255,255,255,0.08); }
.ap-progress-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #9ca3af; margin-bottom: .65rem; }
.ap-steps-row { display: flex; align-items: flex-start; gap: 0; }
.ap-step-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; position: relative; }
.ap-step-wrap:not(:last-child)::after {
    content: ''; position: absolute; top: 13px; left: 50%; right: -50%;
    height: 2px; background: #e5e7eb; z-index: 0;
}
html.dark .ap-step-wrap:not(:last-child)::after { background: rgba(255,255,255,0.08); }
.ap-step-circle {
    width: 26px; height: 26px; border-radius: 50%; font-size: .7rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    position: relative; z-index: 1; flex-shrink: 0;
    margin-bottom: .35rem;
    background: #f3f4f6; border: 2px solid #e5e7eb; color: #9ca3af;
}
html.dark .ap-step-circle { background: #374151; border-color: #4b5563; color: #9ca3af; }
.ap-step-circle.active { background: {{ $color }}; border-color: {{ $color }}; color: #fff; }
.ap-step-lbl { font-size: .62rem; font-weight: 600; color: #9ca3af; text-align: center; line-height: 1.3; max-width: 72px; }
.ap-step-lbl.active { color: {{ $color }}; font-weight: 700; }

/* ── Required docs notice ──────────────────────────────── */
.ap-docs-notice {
    border-radius: 12px; padding: 1rem 1.1rem;
    margin-bottom: 1.25rem;
    background: {{ $colorLight }}; border: 1px solid {{ $colorBorder }};
}
.ap-docs-notice-head { display: flex; align-items: center; gap: .6rem; margin-bottom: .65rem; }
.ap-docs-notice-title { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: {{ $color }}; }
.ap-docs-list { list-style: none; display: flex; flex-direction: column; gap: .35rem; }
.ap-docs-list li { display: flex; align-items: baseline; gap: .5rem; font-size: .84rem; color: #374151; }
html.dark .ap-docs-list li { color: #d1d5db; }
.ap-docs-list li::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: {{ $color }}; flex-shrink: 0; margin-top: .35em; }

/* ── Error box ─────────────────────────────────────────── */
.ap-errors { border-radius: 12px; padding: 1rem 1.1rem; margin-bottom: 1.25rem; background: #fef2f2; border: 1px solid #fecaca; }
html.dark .ap-errors { background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.3); }
.ap-errors-head { display: flex; align-items: center; gap: .5rem; margin-bottom: .5rem; }
.ap-errors-title { font-size: .82rem; font-weight: 700; color: #dc2626; }
html.dark .ap-errors-title { color: #f87171; }
.ap-errors-list { list-style: disc; padding-left: 1.2rem; font-size: .82rem; color: #dc2626; }
html.dark .ap-errors-list { color: #f87171; }

/* ── Section cards ─────────────────────────────────────── */
.ap-section {
    background: var(--card, #fff);
    border: 1px solid var(--border, rgba(0,0,0,0.09));
    border-radius: 16px; overflow: hidden;
    box-shadow: 0 1px 8px rgba(0,0,0,0.05);
    margin-bottom: 1rem;
}
html.dark .ap-section { background: var(--dark-card, #1a1b26); border-color: rgba(255,255,255,0.08); }
.ap-section-head {
    display: flex; align-items: center; gap: .75rem;
    padding: .9rem 1.25rem; border-bottom: 1px solid var(--border, rgba(0,0,0,0.09));
    background: var(--surface2, #f9fafb);
}
html.dark .ap-section-head { background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.07); }
.ap-section-num {
    width: 26px; height: 26px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 800; color: #fff;
    background: {{ $color }};
}
.ap-section-title { font-size: .82rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--text, #111); flex: 1; }
html.dark .ap-section-title { color: #e8e9f5; }
.ap-section-hint { font-size: .72rem; color: #9ca3af; font-weight: 400; text-transform: none; letter-spacing: 0; }
.ap-section-body { padding: 1.25rem; display: flex; flex-direction: column; gap: 1rem; }

/* ── Form fields ───────────────────────────────────────── */
.ap-field { display: flex; flex-direction: column; gap: .4rem; }
.ap-label { font-size: .82rem; font-weight: 600; color: #374151; display: flex; align-items: center; gap: .3rem; }
html.dark .ap-label { color: #d1d5db; }
.ap-label-ku { font-family: 'Noto Naskh Arabic', serif; font-size: .78rem; color: #9ca3af; direction: rtl; margin-top: -.15rem; }
.ap-hint { font-size: .74rem; color: #9ca3af; line-height: 1.4; }
.ap-req { color: #ef4444; }
.ap-input, .ap-select, .ap-textarea {
    width: 100%; height: 44px; padding: 0 .9rem;
    border-radius: 10px; border: 1.5px solid #e5e7eb;
    background: #f9fafb; color: #111;
    font-size: .88rem; font-weight: 500; font-family: 'Inter', sans-serif;
    transition: border-color .2s, box-shadow .2s; outline: none;
    appearance: none;
}
html.dark .ap-input, html.dark .ap-select, html.dark .ap-textarea {
    background: #1e1f2e; border-color: rgba(255,255,255,0.1); color: #e8e9f5;
}
.ap-input:focus, .ap-select:focus, .ap-textarea:focus {
    border-color: {{ $color }}; box-shadow: 0 0 0 3px {{ $colorLight }};
}
.ap-textarea { height: auto; padding: .7rem .9rem; resize: vertical; min-height: 88px; }
.ap-select-wrap { position: relative; }
.ap-select-wrap svg { position: absolute; right: .75rem; top: 50%; transform: translateY(-50%); pointer-events: none; width: 16px; height: 16px; color: #9ca3af; }
.ap-select { padding-right: 2.2rem; }

/* ── Time slot grid ────────────────────────────────────── */
.ap-time-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: .5rem; }
@media (max-width: 480px) { .ap-time-grid { grid-template-columns: repeat(3, 1fr); } }
.ap-time-label { display: block; cursor: pointer; }
.ap-time-radio { display: none; }
.ap-time-btn {
    padding: .6rem .3rem; border-radius: 10px; text-align: center;
    font-size: .82rem; font-weight: 600; transition: all .18s;
    border: 1.5px solid #e5e7eb; color: #6b7280; background: #f9fafb;
    user-select: none; white-space: nowrap;
}
html.dark .ap-time-btn { border-color: rgba(255,255,255,0.1); color: #9ca3af; background: #1e1f2e; }
.ap-time-radio:checked + .ap-time-btn {
    background: {{ $color }}; border-color: {{ $color }}; color: #fff;
    box-shadow: 0 2px 8px {{ $colorBorder }};
}

/* ── Upload area ───────────────────────────────────────── */
.ap-upload-item {
    border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;
    background: var(--surface2, #f9fafb);
}
html.dark .ap-upload-item { border-color: rgba(255,255,255,0.08); background: rgba(255,255,255,0.03); }
.ap-upload-header {
    display: flex; align-items: center; gap: .6rem;
    padding: .65rem 1rem; border-bottom: 1px solid #e5e7eb;
}
html.dark .ap-upload-header { border-color: rgba(255,255,255,0.07); }
.ap-upload-num {
    width: 22px; height: 22px; border-radius: 50%; flex-shrink: 0;
    font-size: .65rem; font-weight: 800; color: #fff;
    display: flex; align-items: center; justify-content: center;
    background: {{ $color }};
}
.ap-upload-name { font-size: .84rem; font-weight: 600; color: #374151; }
html.dark .ap-upload-name { color: #d1d5db; }
.ap-upload-label {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem 1rem; cursor: pointer; transition: background .18s;
}
.ap-upload-label:hover { background: rgba(0,0,0,0.025); }
html.dark .ap-upload-label:hover { background: rgba(255,255,255,0.04); }
.ap-upload-icon { color: #9ca3af; flex-shrink: 0; }
.ap-upload-text { font-size: .82rem; color: #9ca3af; flex: 1; }
.ap-upload-badge {
    font-size: .68rem; font-weight: 600; color: #9ca3af;
    padding: .15rem .5rem; border-radius: 6px; background: #e5e7eb; white-space: nowrap;
}
html.dark .ap-upload-badge { background: rgba(255,255,255,0.08); }
.ap-file-name { font-size: .75rem; padding: .25rem 1rem .5rem; }

/* ── Confirmation summary ──────────────────────────────── */
.ap-confirm {
    border-radius: 14px; padding: 1.1rem 1.25rem;
    background: {{ $colorLight }}; border: 1px solid {{ $colorBorder }};
    margin-bottom: 1rem;
}
.ap-confirm-title { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: {{ $color }}; margin-bottom: .65rem; }
.ap-confirm-items { display: flex; flex-direction: column; gap: .45rem; }
.ap-confirm-row { display: flex; align-items: flex-start; gap: .65rem; font-size: .84rem; }
.ap-confirm-ico { font-size: .88rem; flex-shrink: 0; }
.ap-confirm-text { color: #374151; }
html.dark .ap-confirm-text { color: #d1d5db; }

/* ── Submit row ────────────────────────────────────────── */
.ap-submit-row {
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; flex-wrap: wrap; padding-top: .5rem;
}
.ap-cancel {
    display: inline-flex; align-items: center; gap: .4rem;
    height: 44px; padding: 0 1.1rem; border-radius: 10px;
    border: 1.5px solid #e5e7eb; color: #6b7280;
    font-size: .84rem; font-weight: 600; text-decoration: none;
    transition: border-color .18s, color .18s;
}
html.dark .ap-cancel { border-color: rgba(255,255,255,0.12); color: #9ca3af; }
.ap-cancel:hover { border-color: #9ca3af; color: #374151; }
html.dark .ap-cancel:hover { color: #d1d5db; }
.ap-submit {
    display: inline-flex; align-items: center; gap: .5rem;
    height: 44px; padding: 0 1.75rem; border-radius: 10px;
    font-size: .9rem; font-weight: 700; color: #fff; cursor: pointer; border: none;
    transition: opacity .18s, transform .18s;
    background: {{ $color }};
    box-shadow: 0 4px 14px {{ $colorBorder }};
}
.ap-submit:hover { opacity: .9; transform: translateY(-1px); }
.ap-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

/* ── Dark card variable ─────────────────────────────────── */
html.dark { --dark-card: #14151e; }
</style>
<div class="ap-wrap">

    {{-- ── Back ── --}}
    <a href="{{ route('services.show', $service->slug) }}" class="ap-back" aria-label="Back to service details">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Back to Service Details
    </a>

    {{-- ── Service hero strip ── --}}
    <div class="ap-hero" role="banner" aria-label="Service being applied for">
        <div class="ap-hero-inner">
            <div class="ap-hero-icon" aria-hidden="true">
                @if($service->ministry->slug === 'civil-registry')
                    <svg fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 00-9.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                @elseif($service->ministry->slug === 'traffic-police')
                    <svg fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><rect x="7" y="2" width="10" height="20" rx="3" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="7" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="12" cy="17" r="2"/></svg>
                @elseif($service->ministry->slug === 'electricity')
                    <svg fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                @elseif($service->ministry->slug === 'water')
                    <svg fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                @else
                    <svg fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                @endif
            </div>
            <div class="ap-hero-body">
                <p class="ap-hero-ministry">{{ $service->ministry->name }}</p>
                <h1 class="ap-hero-name">{{ $service->name }}</h1>
                @if($service->name_ku)
                    <p class="ap-hero-name-ku">{{ $service->name_ku }}</p>
                @endif
            </div>
            <div class="ap-hero-badge" aria-label="Estimated processing time">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                Est. {{ $service->estimated_days }} days
            </div>
        </div>
    </div>

    {{-- ── Progress stepper ── --}}
    <div class="ap-progress" role="navigation" aria-label="Application progress">
        <p class="ap-progress-label">Application steps</p>
        <div class="ap-steps-row" role="list">
            @foreach($steps as $i => $step)
            <div class="ap-step-wrap" role="listitem" aria-label="Step {{ $i + 1 }}: {{ $step }}">
                <div class="ap-step-circle {{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'step' : 'false' }}">{{ $i + 1 }}</div>
                <span class="ap-step-lbl {{ $i === 0 ? 'active' : '' }}">{{ $step }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Required documents notice ── --}}
    @if(!empty($reqDocs))
    <div class="ap-docs-notice" role="note" aria-label="Documents you will need to upload">
        <div class="ap-docs-notice-head">
            <svg width="15" height="15" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="ap-docs-notice-title">Have these documents ready to upload</p>
        </div>
        <ul class="ap-docs-list" aria-label="Required documents checklist">
            @foreach($reqDocs as $doc)
            <li>{{ $doc }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ── Validation errors ── --}}
    @if ($errors->any())
    <div class="ap-errors" role="alert" aria-live="polite">
        <div class="ap-errors-head">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="ap-errors-title">Please fix the following errors before submitting:</p>
        </div>
        <ul class="ap-errors-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('services.store', $service->slug) }}" enctype="multipart/form-data" id="apply-form" novalidate>
        @csrf

        {{-- ── Section 1: Personal Details ── --}}
        <div class="ap-section" id="step-1">
            <div class="ap-section-head">
                <div class="ap-section-num" aria-hidden="true">1</div>
                <div>
                    <p class="ap-section-title">Personal Details</p>
                    <p class="ap-section-hint">Your information as it appears on your National ID</p>
                </div>
            </div>
            <div class="ap-section-body">
                <div class="ap-field">
                    <label class="ap-label" for="full_name">
                        Full name <span class="ap-req" aria-label="required">*</span>
                    </label>
                    <p class="ap-hint">Enter your name exactly as it appears on your National ID card.</p>
                    <input
                        type="text" id="full_name" name="full_name"
                        value="{{ old('full_name', auth()->user()->name) }}"
                        class="ap-input" required autocomplete="name"
                        aria-describedby="full_name_hint"
                        onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $colorLight }}'"
                        onblur="this.style.borderColor='';this.style.boxShadow=''">
                </div>
                <div class="ap-field">
                    <label class="ap-label" for="national_id_number">
                        National ID number <span class="ap-req" aria-label="required">*</span>
                    </label>
                    <p class="ap-hint">The unique number printed on your Iraqi National ID card (Hawiyya). Do not enter spaces or dashes.</p>
                    <input
                        type="text" id="national_id_number" name="national_id_number"
                        value="{{ old('national_id_number') }}"
                        placeholder="e.g. 1234567890"
                        class="ap-input" required autocomplete="off"
                        inputmode="numeric"
                        onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $colorLight }}'"
                        onblur="this.style.borderColor='';this.style.boxShadow=''">
                </div>
            </div>
        </div>

        {{-- ── Section 2: Service-specific fields ── --}}
        @if(!empty($schema))
        <div class="ap-section" id="step-2">
            <div class="ap-section-head">
                <div class="ap-section-num" aria-hidden="true">2</div>
                <div>
                    <p class="ap-section-title">{{ $service->name }} — Details</p>
                    <p class="ap-section-hint">Information specific to this service application</p>
                </div>
            </div>
            <div class="ap-section-body">
                @foreach($schema as $field)
                <div class="ap-field">
                    <label class="ap-label" for="field_{{ $field['name'] }}">
                        {{ $field['label'] }}
                        @if($field['required'] ?? false)<span class="ap-req" aria-label="required">*</span>@endif
                    </label>
                    @if(isset($field['label_ku']))
                        <p class="ap-label-ku">{{ $field['label_ku'] }}</p>
                    @endif
                    @if(isset($field['hint']))
                        <p class="ap-hint">{{ $field['hint'] }}</p>
                    @endif

                    @if($field['type'] === 'select')
                        <div class="ap-select-wrap">
                            <select id="field_{{ $field['name'] }}" name="form[{{ $field['name'] }}]"
                                    class="ap-select"
                                    onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $colorLight }}'"
                                    onblur="this.style.borderColor='';this.style.boxShadow=''"
                                    {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                <option value="">— Select an option —</option>
                                @foreach($field['options'] as $opt)
                                    <option value="{{ $opt }}" {{ old('form.' . $field['name']) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>

                    @elseif($field['type'] === 'textarea')
                        <textarea id="field_{{ $field['name'] }}" name="form[{{ $field['name'] }}]" rows="3"
                                  class="ap-textarea"
                                  onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $colorLight }}'"
                                  onblur="this.style.borderColor='';this.style.boxShadow=''"
                                  {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old('form.' . $field['name']) }}</textarea>

                    @elseif($field['type'] === 'date')
                        <input type="date" id="field_{{ $field['name'] }}" name="form[{{ $field['name'] }}]"
                               value="{{ old('form.' . $field['name']) }}"
                               class="ap-input"
                               onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $colorLight }}'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''"
                               {{ ($field['required'] ?? false) ? 'required' : '' }}>

                    @elseif($field['type'] === 'number')
                        <input type="number" id="field_{{ $field['name'] }}" name="form[{{ $field['name'] }}]"
                               value="{{ old('form.' . $field['name']) }}" min="0"
                               class="ap-input"
                               onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $colorLight }}'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''"
                               {{ ($field['required'] ?? false) ? 'required' : '' }}>

                    @else
                        <input type="text" id="field_{{ $field['name'] }}" name="form[{{ $field['name'] }}]"
                               value="{{ old('form.' . $field['name']) }}"
                               class="ap-input"
                               onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $colorLight }}'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''"
                               {{ ($field['required'] ?? false) ? 'required' : '' }}>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Section 3: Appointment ── --}}
        <div class="ap-section" id="step-appt">
            <div class="ap-section-head">
                <div class="ap-section-num" aria-hidden="true">{{ empty($schema) ? '2' : '3' }}</div>
                <div>
                    <p class="ap-section-title">Appointment</p>
                    <p class="ap-section-hint">Choose a date and time to bring your original documents to the service centre</p>
                </div>
            </div>
            <div class="ap-section-body">

                {{-- Date --}}
                <div class="ap-field">
                    <label class="ap-label" for="appointment_date">
                        Preferred date <span class="ap-req" aria-label="required">*</span>
                    </label>
                    <p class="ap-hint">Working days: Sunday – Thursday. Dates at least 2 business days ahead are shown.</p>
                    <div class="ap-select-wrap">
                        <select id="appointment_date" name="appointment_date" class="ap-select" required
                                onfocus="this.style.borderColor='{{ $color }}';this.style.boxShadow='0 0 0 3px {{ $colorLight }}'"
                                onblur="this.style.borderColor='';this.style.boxShadow=''">
                            <option value="">— Choose a date —</option>
                            @foreach($availableDates as $date)
                                <option value="{{ $date }}" {{ old('appointment_date') === $date ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                                </option>
                            @endforeach
                        </select>
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Time slot --}}
                <div class="ap-field">
                    <p class="ap-label" id="timeslot-label">
                        Time slot <span class="ap-req" aria-label="required">*</span>
                    </p>
                    <p class="ap-hint">All times are in Iraq Standard Time (GMT+3). Arrive 10 minutes before your slot.</p>
                    <div class="ap-time-grid" role="radiogroup" aria-labelledby="timeslot-label" id="time-slot-grid">
                        @foreach($timeSlots as $slot)
                        <label class="ap-time-label">
                            <input type="radio" name="time_slot" value="{{ $slot }}" class="ap-time-radio"
                                   {{ old('time_slot') === $slot ? 'checked' : '' }}>
                            <div class="ap-time-btn">{{ $slot }}</div>
                        </label>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Section 4: Upload Documents ── --}}
        @if(!empty($reqDocs))
        <div class="ap-section" id="step-docs">
            <div class="ap-section-head">
                <div class="ap-section-num" aria-hidden="true">{{ empty($schema) ? '3' : '4' }}</div>
                <div>
                    <p class="ap-section-title">Upload Documents</p>
                    <p class="ap-section-hint">Clear scans or photos — JPG, PNG, PDF — max 5 MB each</p>
                </div>
            </div>
            <div class="ap-section-body" style="gap:.75rem;">
                @foreach($reqDocs as $i => $doc)
                <div class="ap-upload-item">
                    <div class="ap-upload-header">
                        <div class="ap-upload-num" aria-hidden="true">{{ $i + 1 }}</div>
                        <p class="ap-upload-name">{{ $doc }}</p>
                    </div>
                    <label class="ap-upload-label" aria-label="Upload {{ $doc }}">
                        <svg class="ap-upload-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <span class="ap-upload-text">Click to upload or drag file here</span>
                        <span class="ap-upload-badge">JPG · PNG · PDF</span>
                        <input type="file" name="documents[]" accept=".jpg,.jpeg,.png,.pdf" class="sr-only doc-upload"
                               onchange="showFileName(this, {{ $i }})">
                    </label>
                    <p class="ap-file-name" id="file-name-{{ $i }}" aria-live="polite" style="color:#9ca3af;"></p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Submission summary ── --}}
        <div class="ap-confirm" role="note" aria-label="What happens after you submit">
            <p class="ap-confirm-title">What happens after you submit</p>
            <div class="ap-confirm-items">
                <div class="ap-confirm-row">
                    <span class="ap-confirm-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.15em"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></span>
                    <p class="ap-confirm-text">A confirmation email with your reference code and QR receipt will be sent immediately.</p>
                </div>
                <div class="ap-confirm-row">
                    <span class="ap-confirm-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.15em"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></span>
                    <p class="ap-confirm-text">You will receive notifications when your application status changes — check your dashboard anytime.</p>
                </div>
                <div class="ap-confirm-row">
                    <span class="ap-confirm-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.15em"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></span>
                    <p class="ap-confirm-text">Bring your original documents and QR receipt to your appointment. Estimated processing: <strong>{{ $service->estimated_days }} working days</strong>.</p>
                </div>
                <div class="ap-confirm-row">
                    <span class="ap-confirm-ico" aria-hidden="true"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-.15em"><path stroke-linecap="round" stroke-linejoin="round" d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg></span>
                    <p class="ap-confirm-text">This service is <strong>free of charge</strong>. You will never be asked to pay.</p>
                </div>
            </div>
        </div>

        {{-- ── Submit row ── --}}
        <div class="ap-submit-row">
            <a href="{{ route('services.show', $service->slug) }}" class="ap-cancel" aria-label="Cancel and return to service details">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                Cancel
            </a>
            <button type="submit" id="submit-btn" class="ap-submit" aria-label="Submit your application">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Submit Application
            </button>
        </div>

    </form>
</div>

<script>
(function() {
    const BRAND = '{{ $color }}';
    const BRAND_LIGHT = '{{ $colorLight }}';

    // ── Time slot highlight (restore on page-reload after error) ──
    document.querySelectorAll('.ap-time-radio').forEach(function(radio) {
        if (radio.checked) {
            radio.nextElementSibling.style.background = BRAND;
            radio.nextElementSibling.style.borderColor = BRAND;
            radio.nextElementSibling.style.color = '#fff';
        }
        radio.addEventListener('change', function() {
            document.querySelectorAll('.ap-time-btn').forEach(function(b) {
                b.style.background = '';
                b.style.borderColor = '';
                b.style.color = '';
                b.style.boxShadow = '';
            });
            if (radio.checked) {
                radio.nextElementSibling.style.background = BRAND;
                radio.nextElementSibling.style.borderColor = BRAND;
                radio.nextElementSibling.style.color = '#fff';
                radio.nextElementSibling.style.boxShadow = '0 2px 8px ' + BRAND + '44';
            }
        });
    });

    // ── File name display ──────────────────────────────────
    window.showFileName = function(input, idx) {
        var el = document.getElementById('file-name-' + idx);
        if (el && input.files && input.files[0]) {
            var f = input.files[0];
            el.textContent = '✓ ' + f.name + ' (' + (f.size / 1024).toFixed(0) + ' KB)';
            el.style.color = BRAND;
            // Update upload label text
            var label = input.closest('label');
            var txt = label.querySelector('.ap-upload-text');
            if (txt) txt.textContent = f.name;
        }
    };

    // ── Submit loading state ───────────────────────────────
    var form = document.getElementById('apply-form');
    var btn  = document.getElementById('submit-btn');
    if (form && btn) {
        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.innerHTML =
                '<svg class="ap-spin" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true" style="animation:spin .8s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>'
                + ' Submitting…';
        });
    }

    // ── Progress stepper — mark active on scroll ───────────
    // (visual only: first step is always highlighted since form is single-page)
})();
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
.sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
</style>
@endsection
