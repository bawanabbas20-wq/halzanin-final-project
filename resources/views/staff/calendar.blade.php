@extends('layouts.halzanin-app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between animate-fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gradient font-outfit" data-i18n="cal.title">Appointments Calendar</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $current->format('F Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Calendar Card --}}
        <div class="lg:col-span-2 bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 100ms">
            <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
            <div class="p-6">

                {{-- Month navigation --}}
                @php
                    $prevMonth = $current->copy()->subMonth();
                    $nextMonth = $current->copy()->addMonth();
                @endphp
                <div class="flex items-center justify-between mb-6">
                    <a href="{{ route('staff.calendar', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
                       class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-600 dark:text-gray-400 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">{{ $current->format('F Y') }}</h3>
                    <a href="{{ route('staff.calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
                       class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-600 dark:text-gray-400 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                {{-- Day labels --}}
                <div class="grid grid-cols-7 mb-2">
                    @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                        <div class="text-center text-xs font-bold py-1 {{ in_array($day, ['Fri','Sat']) ? 'text-gray-300 dark:text-gray-600' : 'text-gray-500 dark:text-gray-400' }}" data-i18n="{{ $day }}">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>

                {{-- Calendar grid --}}
                @php
                    $startOfMonth = $current->copy()->startOfMonth();
                    $endOfMonth   = $current->copy()->endOfMonth();
                    $today        = now()->toDateString();
                    $startPad     = $startOfMonth->dayOfWeek;
                    $totalDays    = $endOfMonth->day;
                    $maxSlots     = 5;
                @endphp

                <div class="grid grid-cols-7 gap-1" id="calendar-grid">
                    @for($i = 0; $i < $startPad; $i++)
                        <div></div>
                    @endfor

                    @for($day = 1; $day <= $totalDays; $day++)
                        @php
                            $dateStr   = $current->format('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                            $dayOfWeek = date('N', strtotime($dateStr));
                            $isWeekend = in_array($dayOfWeek, [5, 6]);
                            $isOffDay  = $isWeekend || in_array($dateStr, $offDates);
                            $isToday   = $dateStr === $today;
                            $booked    = $counts[$dateStr] ?? 0;
                            $isFull    = $booked >= $maxSlots;

                            if ($isOffDay) {
                                $bgClass = 'bg-gray-100 dark:bg-slate-800 text-gray-400 dark:text-gray-600 cursor-default';
                            } elseif ($isFull) {
                                $bgClass = 'bg-red-500 text-white cursor-pointer hover:bg-red-600';
                            } elseif ($booked === 0) {
                                $bgClass = 'bg-emerald-500 text-white cursor-pointer hover:bg-emerald-600';
                            } elseif ($booked === 1) {
                                $bgClass = 'bg-emerald-400 text-white cursor-pointer hover:bg-emerald-500';
                            } elseif ($booked === 2) {
                                $bgClass = 'bg-yellow-400 text-white cursor-pointer hover:bg-yellow-500';
                            } elseif ($booked === 3) {
                                $bgClass = 'bg-orange-400 text-white cursor-pointer hover:bg-orange-500';
                            } else {
                                $bgClass = 'bg-orange-500 text-white cursor-pointer hover:bg-orange-600';
                            }
                        @endphp

                        <div class="calendar-day rounded-xl p-1 text-center transition select-none
                                    {{ $bgClass }}
                                    {{ $isToday ? 'ring-2 ring-offset-1 ring-brand dark:ring-indigo-400' : '' }}"
                             data-date="{{ $dateStr }}"
                             data-off="{{ $isOffDay ? '1' : '0' }}"
                             @if(!$isOffDay) onclick="selectDay(this)" @endif>
                            <span class="text-sm font-semibold">{{ $day }}</span>
                            @if($isOffDay)
                                <div style="font-size:9px" class="opacity-60 font-medium">off</div>
                            @elseif($booked > 0)
                                <div style="font-size:9px" class="opacity-90 font-medium">{{ $booked }}/5</div>
                            @endif
                        </div>
                    @endfor
                </div>

                {{-- Legend --}}
                <div class="mt-5 flex flex-wrap gap-3 text-xs text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-emerald-500 inline-block"></span> <span data-i18n="cal.open">Open</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-yellow-400 inline-block"></span> <span data-i18n="cal.filling">Filling</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-orange-500 inline-block"></span> <span data-i18n="cal.almost">Almost full</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-red-500 inline-block"></span> <span data-i18n="cal.full">Full</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-gray-300 dark:bg-slate-600 inline-block"></span> <span data-i18n="cal.off">Off day</span></div>
                </div>
            </div>
        </div>

        {{-- Day panel --}}
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 200ms">
            <div class="h-1 bg-gradient-to-r from-indigo-400 via-purple-500 to-brand"></div>
            <div class="p-6">
                <div id="panel-empty" class="text-center py-12 text-gray-400 dark:text-gray-500">
                    <div class="w-14 h-14 bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm" data-i18n="cal.click_day">Click a day to see appointments</p>
                </div>

                <div id="panel-content" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 id="panel-date" class="text-base font-bold text-gray-900 dark:text-white"></h3>
                        <span id="panel-count" class="text-xs bg-brand/10 dark:bg-indigo-900/30 text-brand dark:text-indigo-400 px-2.5 py-0.5 rounded-full font-semibold"></span>
                    </div>

                    <div id="panel-loading" class="text-center py-6 hidden">
                        <div class="inline-block w-6 h-6 border-2 border-brand border-t-transparent rounded-full animate-spin"></div>
                    </div>

                    <div id="panel-list" class="space-y-3"></div>

                    <div id="panel-none" class="hidden text-center py-6 text-gray-400 dark:text-gray-500 text-sm" data-i18n="cal.no_appointments">
                        No appointments for this day.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const dayUrl    = "{{ route('staff.appointments.day') }}";
const statusUrl = "{{ url('/staff/appointments') }}";

const statusLabels = {
    'pending':   { label: 'Pending',   cls: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' },
    'confirmed': { label: 'Confirmed', cls: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' },
    'completed': { label: 'Completed', cls: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' },
    'cancelled': { label: 'Cancelled', cls: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' },
};

const timeLabels = {
    '09:00': '9:00 AM', '10:00': '10:00 AM', '11:00': '11:00 AM',
    '12:00': '12:00 PM', '13:00': '1:00 PM'
};

let activeDay = null;

async function selectDay(el) {
    const date = el.dataset.date;

    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('ring-2', 'ring-brand', 'ring-offset-1'));
    el.classList.add('ring-2', 'ring-brand', 'ring-offset-1');

    document.getElementById('panel-empty').classList.add('hidden');
    document.getElementById('panel-content').classList.remove('hidden');
    document.getElementById('panel-loading').classList.remove('hidden');
    document.getElementById('panel-list').innerHTML = '';
    document.getElementById('panel-none').classList.add('hidden');

    const d = new Date(date + 'T00:00:00');
    document.getElementById('panel-date').textContent =
        d.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' });

    activeDay = date;

    try {
        const res = await fetch(dayUrl + '?date=' + date);
        const data = await res.json();
        document.getElementById('panel-loading').classList.add('hidden');
        renderAppointments(data.appointments);
    } catch (e) {
        document.getElementById('panel-loading').classList.add('hidden');
    }
}

function renderAppointments(appointments) {
    const list    = document.getElementById('panel-list');
    const countEl = document.getElementById('panel-count');
    countEl.textContent = appointments.length + ' appointment' + (appointments.length !== 1 ? 's' : '');

    if (appointments.length === 0) {
        document.getElementById('panel-none').classList.remove('hidden');
        return;
    }

    list.innerHTML = '';
    appointments.forEach(appt => {
        const s = statusLabels[appt.status] || { label: appt.status, cls: 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300' };
        const card = document.createElement('div');
        card.className = 'border border-gray-100 dark:border-slate-700 rounded-xl p-3 hover:border-brand/30 dark:hover:border-indigo-500/30 transition-colors';
        card.id = 'appt-' + appt.id;

        const docBadges = appt.documents && appt.documents.length > 0
            ? `<div class="mt-2 pt-2 border-t border-gray-100 dark:border-slate-700">
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Documents</p>
                <div class="flex flex-wrap gap-1.5">
                    ${appt.documents.map(d => {
                        if (d.source === 'vault') {
                            return `<span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 font-medium">📦 ${d.name} · Vault</span>`;
                        } else if (d.source === 'upload') {
                            const viewUrl = '/staff/documents/' + d.id + '/file';
                            return `<a href="${viewUrl}" target="_blank" class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium hover:bg-blue-200 dark:hover:bg-blue-900/50">📤 ${d.name} · View ↗</a>`;
                        } else {
                            return `<span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 font-medium">📋 ${d.name} · Bringing</span>`;
                        }
                    }).join('')}
                </div>
               </div>` : '';

        card.innerHTML = `
            <div class="flex items-start justify-between mb-2">
                <div>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">${timeLabels[appt.time_slot] || appt.time_slot}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">${appt.full_name || appt.citizen}</p>
                    ${appt.document_type ? `<p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium mt-0.5">${appt.document_type}</p>` : ''}
                    ${appt.notes ? `<p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 italic">${appt.notes}</p>` : ''}
                </div>
                <span id="badge-${appt.id}" class="text-[10px] px-2.5 py-0.5 rounded-full font-bold ${s.cls}">${s.label}</span>
            </div>
            <div class="flex gap-1.5 flex-wrap">
                ${buildStatusButtons(appt.id, appt.status)}
            </div>
            ${docBadges}
        `;
        list.appendChild(card);
    });
}

function buildStatusButtons(id, current) {
    const actions = [
        { status: 'confirmed', label: 'Confirm',  color: 'bg-emerald-500 hover:bg-emerald-600' },
        { status: 'completed', label: 'Complete', color: 'bg-blue-500 hover:bg-blue-600' },
        { status: 'cancelled', label: 'Cancel',   color: 'bg-red-500 hover:bg-red-600' },
    ].filter(a => a.status !== current);

    return actions.map(a =>
        `<button onclick="updateStatus(${id}, '${a.status}')"
                 class="text-xs text-white px-3 py-1 rounded-lg ${a.color} font-semibold transition">${a.label}</button>`
    ).join('');
}

async function updateStatus(id, status) {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const res = await fetch(`${statusUrl}/${id}/status`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ status }),
    });
    const data = await res.json();
    if (data.success) {
        const activeEl = document.querySelector('.calendar-day[data-date="' + activeDay + '"]');
        if (activeEl) selectDay(activeEl);
    }
}
</script>
@endsection
