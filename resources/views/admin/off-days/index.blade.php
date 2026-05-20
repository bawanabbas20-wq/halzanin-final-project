@extends('layouts.halzanin-app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between animate-fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gradient font-outfit" data-i18n="offdays.title">Off Days Management</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="offdays.subtitle">Configure holiday and closure dates.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Add off days form --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 100ms">
            <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
            <div class="p-6">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1" data-i18n="offdays.add">Add Off Days</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-5" data-i18n="offdays.add_desc">
                    Select one or multiple dates. Friday &amp; Saturday are always off and don't need to be added here.
                </p>

                <form method="POST" action="{{ route('admin.offdays.store') }}" id="off-days-form">
                    @csrf

                    <div class="mb-4">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">
                            <span data-i18n="offdays.selected">Selected dates:</span>
                            <span id="selected-count" class="ltr:ml-1 rtl:mr-1 text-brand dark:text-indigo-400">0</span>
                        </label>

                        {{-- Month navigation --}}
                        <div class="flex items-center justify-between mb-3">
                            <button type="button" onclick="pickerPrevMonth()"
                                    class="p-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-600 dark:text-gray-400 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <span id="picker-month-label" class="text-sm font-bold text-gray-800 dark:text-white"></span>
                            <button type="button" onclick="pickerNextMonth()"
                                    class="p-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-600 dark:text-gray-400 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-7 mb-1">
                            @foreach(['S','M','T','W','T','F','S'] as $h)
                                <div class="text-center text-xs text-gray-400 dark:text-gray-500 font-bold py-1">{{ $h }}</div>
                            @endforeach
                        </div>
                        <div id="picker-grid" class="grid grid-cols-7 gap-0.5"></div>
                    </div>

                    <input type="hidden" name="dates" id="dates-input">

                    <div id="selected-dates-list" class="mb-4 flex flex-wrap gap-1 min-h-6"></div>

                    <div class="mb-4">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-1">
                            <span data-i18n="offdays.reason">Reason</span>
                            <span class="text-gray-400 font-normal" data-i18n="offdays.optional">(optional)</span>
                        </label>
                        <input type="text" name="reason" maxlength="255"
                               class="w-full h-[44px] rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] text-sm transition-all px-3"
                               placeholder="e.g. National Holiday, Emergency closure…"
                               data-i18n-placeholder="offdays.reason_placeholder">
                    </div>

                    <button type="submit" id="add-btn"
                            class="w-full h-[48px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all opacity-40 cursor-not-allowed"
                            disabled
                            data-i18n="offdays.add_btn">
                        Add Selected Off Days
                    </button>
                </form>
            </div>
        </div>

        {{-- Existing off days list --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 200ms">
            <div class="h-1 bg-gradient-to-r from-indigo-400 via-purple-500 to-brand"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                        <span data-i18n="offdays.list_title">Off Days in</span> {{ $year }}
                    </h3>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.offdays', ['year' => $year - 1]) }}"
                           class="text-xs text-gray-500 dark:text-gray-400 hover:text-brand dark:hover:text-indigo-400 px-2.5 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition font-semibold">
                            {{ $year - 1 }}
                        </a>
                        <span class="text-xs font-bold text-brand dark:text-indigo-400 bg-brand/10 dark:bg-indigo-900/30 px-2.5 py-1 rounded-lg">{{ $year }}</span>
                        <a href="{{ route('admin.offdays', ['year' => $year + 1]) }}"
                           class="text-xs text-gray-500 dark:text-gray-400 hover:text-brand dark:hover:text-indigo-400 px-2.5 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition font-semibold">
                            {{ $year + 1 }}
                        </a>
                    </div>
                </div>

                @if($offDays->isEmpty())
                    <div class="text-center py-10 text-gray-400 dark:text-gray-500">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-[#252525] rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium"><span data-i18n="offdays.none_for">No custom off days for</span> {{ $year }}</p>
                        <p class="text-xs mt-1 text-gray-400 dark:text-gray-600" data-i18n="offdays.auto_note">Friday &amp; Saturday are automatically off every week.</p>
                    </div>
                @else
                    <div class="space-y-2 max-h-96 overflow-y-auto pr-1">
                        @foreach($offDays as $offDay)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-800/50 rounded-xl border border-gray-100 dark:border-slate-700 hover:border-red-200 dark:hover:border-red-900/50 transition-colors group">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                        {{ $offDay->date->format('D, M j, Y') }}
                                    </p>
                                    @if($offDay->reason)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $offDay->reason }}</p>
                                    @endif
                                </div>
                                <form method="POST"
                                      action="{{ route('admin.offdays.destroy', $offDay) }}"
                                      onsubmit="return confirm('Remove this off day?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-gray-300 dark:text-gray-600 hover:text-red-500 dark:hover:text-red-400 transition p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-3">
                        {{ $offDays->count() }} <span data-i18n="offdays.count_label">custom off day(s) this year</span>
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- Note about weekends --}}
    <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-2xl p-4 text-sm text-brand dark:text-indigo-300 flex items-start gap-3 animate-fade-up" style="animation-delay: 300ms">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p>
            <strong data-i18n="offdays.note">Note:</strong>
            <span data-i18n="offdays.note_desc"> Friday and Saturday are automatically marked as off days for all citizens. Only add dates here for additional holidays or emergency closures.</span>
        </p>
    </div>
</div>

<script>
const existingOffDates = @json($offDays->pluck('date')->map(fn($d) => $d->format('Y-m-d'))->toArray());
const selectedDates = new Set();

let pickerYear  = {{ now()->year }};
let pickerMonth = {{ now()->month }};

function pickerPrevMonth() {
    pickerMonth--;
    if (pickerMonth < 1) { pickerMonth = 12; pickerYear--; }
    renderPicker();
}

function pickerNextMonth() {
    pickerMonth++;
    if (pickerMonth > 12) { pickerMonth = 1; pickerYear++; }
    renderPicker();
}

function renderPicker() {
    const grid = document.getElementById('picker-grid');
    grid.innerHTML = '';

    const monthNames = ['January','February','March','April','May','June',
                        'July','August','September','October','November','December'];
    document.getElementById('picker-month-label').textContent = monthNames[pickerMonth - 1] + ' ' + pickerYear;

    const firstDay = new Date(pickerYear, pickerMonth - 1, 1).getDay();
    const daysInMonth = new Date(pickerYear, pickerMonth, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        grid.appendChild(document.createElement('div'));
    }

    for (let d = 1; d <= daysInMonth; d++) {
        const dateStr = pickerYear + '-' +
            String(pickerMonth).padStart(2, '0') + '-' +
            String(d).padStart(2, '0');

        const dayOfWeek = new Date(dateStr + 'T00:00:00').getDay();
        const isWeekend  = dayOfWeek === 5 || dayOfWeek === 6;
        const isExisting = existingOffDates.includes(dateStr);
        const isSelected = selectedDates.has(dateStr);

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = d;

        if (isWeekend) {
            btn.className = 'rounded-lg py-1 text-xs text-gray-300 dark:text-gray-600 bg-gray-100 dark:bg-slate-800/50 cursor-not-allowed font-medium';
            btn.title = 'Weekend (always off)';
        } else if (isExisting) {
            btn.className = 'rounded-lg py-1 text-xs text-white bg-gray-400 dark:bg-gray-600 cursor-not-allowed font-medium';
            btn.title = 'Already an off day';
        } else if (isSelected) {
            btn.className = 'rounded-lg py-1 text-xs text-white bg-brand font-bold';
            btn.onclick = () => toggleDate(dateStr);
        } else {
            btn.className = 'rounded-lg py-1 text-xs text-gray-700 dark:text-gray-300 hover:bg-brand/10 dark:hover:bg-indigo-900/30 hover:text-brand dark:hover:text-indigo-400 transition font-medium';
            btn.onclick = () => toggleDate(dateStr);
        }

        grid.appendChild(btn);
    }
}

function toggleDate(dateStr) {
    if (selectedDates.has(dateStr)) {
        selectedDates.delete(dateStr);
    } else {
        selectedDates.add(dateStr);
    }
    updateSelectedUI();
    renderPicker();
}

function updateSelectedUI() {
    const sorted = [...selectedDates].sort();
    document.getElementById('dates-input').value = sorted.join(',');
    document.getElementById('selected-count').textContent = sorted.length;

    const addBtn = document.getElementById('add-btn');
    addBtn.disabled = sorted.length === 0;
    addBtn.classList.toggle('opacity-40', sorted.length === 0);
    addBtn.classList.toggle('cursor-not-allowed', sorted.length === 0);

    const listEl = document.getElementById('selected-dates-list');
    listEl.innerHTML = '';
    sorted.forEach(d => {
        const tag = document.createElement('span');
        const dt = new Date(d + 'T00:00:00');
        tag.textContent = dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ' ×';
        tag.className = 'text-xs bg-brand/10 dark:bg-indigo-900/30 text-brand dark:text-indigo-400 px-2.5 py-0.5 rounded-full cursor-pointer hover:bg-brand/20 dark:hover:bg-indigo-900/50 transition font-semibold';
        tag.onclick = () => toggleDate(d);
        listEl.appendChild(tag);
    });
}

renderPicker();
</script>
@endsection
