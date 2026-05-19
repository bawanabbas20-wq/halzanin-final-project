@extends('layouts.halzanin-app')

@section('content')
    <div class="space-y-6 lg:space-y-8 max-w-5xl mx-auto pb-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
            <div>
                <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">Off Days Management</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage extra closure dates beyond the regular Friday and Saturday off days.</p>
            </div>
            <span class="text-sm font-semibold text-gray-500 dark:text-gray-400 bg-white dark:bg-slate-800 px-4 py-2 rounded-full border border-gray-100 dark:border-slate-700 shadow-sm">
                {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
            </span>
        </div>

        <div class="space-y-6">

            {{-- Flash --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Add off days form --}}
                <div class="bg-white dark:bg-[#1e293b] shadow-sm border border-gray-100 dark:border-slate-800 rounded-[16px] p-6">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-1">Add Off Days</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-5">
                        Select one or multiple dates. Friday &amp; Saturday are always off and don't need to be added here.
                    </p>

                    <form method="POST" action="{{ route('admin.offdays.store') }}" id="off-days-form">
                        @csrf

                        {{-- Date picker (multi-select visual calendar) --}}
                        <div class="mb-4">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-2">
                                Selected dates: <span id="selected-count" class="text-blue-600">0</span>
                            </label>

                            {{-- Month navigation for picker --}}
                            <div class="flex items-center justify-between mb-3">
                                <button type="button" onclick="pickerPrevMonth()"
                                         class="p-1.5 rounded hover:bg-gray-100 text-gray-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <span id="picker-month-label" class="text-sm font-medium text-gray-700 dark:text-gray-300"></span>
                                <button type="button" onclick="pickerNextMonth()"
                                        class="p-1.5 rounded hover:bg-gray-100 text-gray-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-7 mb-1">
                                @foreach(['S','M','T','W','T','F','S'] as $h)
                                    <div class="text-center text-xs text-gray-400 font-medium py-1">{{ $h }}</div>
                                @endforeach
                            </div>

                            <div id="picker-grid" class="grid grid-cols-7 gap-0.5"></div>
                        </div>

                        {{-- Hidden input for selected dates --}}
                        <input type="hidden" name="dates" id="dates-input">

                        {{-- Selected dates display --}}
                        <div id="selected-dates-list" class="mb-4 flex flex-wrap gap-1 min-h-6"></div>

                        <div class="mb-4">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">
                                Reason <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <input type="text" name="reason" maxlength="255"
                                   class="w-full border border-gray-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                   placeholder="e.g. National Holiday, Emergency closure…">
                        </div>

                        <button type="submit" id="add-btn"
                                class="w-full bg-blue-600 text-white rounded-lg py-2 text-sm font-medium hover:bg-blue-700 transition disabled:opacity-40 disabled:cursor-not-allowed"
                                disabled>
                            Add Selected Off Days
                        </button>
                    </form>
                </div>

                {{-- Existing off days list --}}
                <div class="bg-white dark:bg-[#1e293b] shadow-sm border border-gray-100 dark:border-slate-800 rounded-[16px] p-6">
                    {{-- Year filter --}}
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Off Days in {{ $year }}</h3>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.off-days', ['year' => $year - 1]) }}"
                               class="text-xs text-gray-500 hover:text-gray-700 px-2 py-1 rounded hover:bg-gray-100 transition">
                                {{ $year - 1 }}
                            </a>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">{{ $year }}</span>
                            <a href="{{ route('admin.off-days', ['year' => $year + 1]) }}"
                               class="text-xs text-gray-500 hover:text-gray-700 px-2 py-1 rounded hover:bg-gray-100 transition">
                                {{ $year + 1 }}
                            </a>
                        </div>
                    </div>

                    @if($offDays->isEmpty())
                        <div class="text-center py-10 text-gray-400 dark:text-gray-500">
                            <svg class="w-10 h-10 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm">No custom off days for {{ $year }}</p>
                            <p class="text-xs mt-1">Friday &amp; Saturday are automatically off every week.</p>
                        </div>
                    @else
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($offDays as $offDay)
                                <div class="flex items-center justify-between p-2.5 bg-gray-50 dark:bg-slate-800/70 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                                            {{ $offDay->date->format('D, M j, Y') }}
                                        </p>
                                        @if($offDay->reason)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $offDay->reason }}</p>
                                        @endif
                                    </div>
                                    <form method="POST"
                                          action="{{ route('admin.offdays.destroy', $offDay) }}"
                                          onsubmit="return confirm('Remove this off day?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-400 hover:text-red-600 transition p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-xs text-gray-400 mt-3">{{ $offDays->count() }} custom off day(s) this year</p>
                    @endif
                </div>
            </div>

            {{-- Note about weekends --}}
            <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/60 rounded-[14px] p-4 text-sm text-indigo-700 dark:text-indigo-300">
                <strong>Note:</strong> Friday and Saturday are automatically marked as off days for all citizens.
                Only add dates here for additional holidays or emergency closures.
            </div>
        </div>
    </div>

    <script>
    // Existing off dates from DB (to mark in picker)
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

            const dayOfWeek = new Date(dateStr + 'T00:00:00').getDay(); // 0=Sun, 5=Fri, 6=Sat
            const isWeekend = dayOfWeek === 5 || dayOfWeek === 6;
            const isExisting = existingOffDates.includes(dateStr);
            const isSelected = selectedDates.has(dateStr);

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = d;

            if (isWeekend) {
                btn.className = 'rounded py-1 text-xs text-gray-400 bg-gray-100 cursor-not-allowed';
                btn.title = 'Weekend (always off)';
            } else if (isExisting) {
                btn.className = 'rounded py-1 text-xs text-white bg-gray-500 cursor-not-allowed';
                btn.title = 'Already an off day';
            } else if (isSelected) {
                btn.className = 'rounded py-1 text-xs text-white bg-blue-600 font-semibold';
                btn.onclick = () => toggleDate(dateStr);
            } else {
                btn.className = 'rounded py-1 text-xs text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition';
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
        document.getElementById('add-btn').disabled = sorted.length === 0;

        const listEl = document.getElementById('selected-dates-list');
        listEl.innerHTML = '';
        sorted.forEach(d => {
            const tag = document.createElement('span');
            const dt = new Date(d + 'T00:00:00');
            tag.textContent = dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ' ×';
            tag.className = 'text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full cursor-pointer hover:bg-blue-200 transition';
            tag.onclick = () => toggleDate(d);
            listEl.appendChild(tag);
        });
    }

    renderPicker();
    </script>
@endsection
