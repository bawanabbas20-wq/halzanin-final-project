<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Book an Appointment
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Calendar --}}
                <div class="lg:col-span-2 bg-white shadow-sm rounded-xl p-6">

                    {{-- Month navigation --}}
                    <div class="flex items-center justify-between mb-6">
                        @php
                            $prevMonth = $current->copy()->subMonth();
                            $nextMonth = $current->copy()->addMonth();
                            $canGoPrev = $prevMonth->gte(now()->startOfMonth());
                            $canGoNext = $nextMonth->lte($maxDate->copy()->startOfMonth());
                        @endphp

                        @if($canGoPrev)
                            <a href="{{ route('citizen.appointments.calendar', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
                               class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        @else
                            <div class="p-2 text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </div>
                        @endif

                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $current->format('F Y') }}
                        </h3>

                        @if($canGoNext)
                            <a href="{{ route('citizen.appointments.calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
                               class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <div class="p-2 text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Day labels (Sun–Thu are work days; Fri–Sat off) --}}
                    <div class="grid grid-cols-7 mb-2">
                        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                            <div class="text-center text-xs font-semibold py-1
                                {{ in_array($day, ['Fri','Sat']) ? 'text-gray-400' : 'text-gray-600' }}">
                                {{ $day }}
                            </div>
                        @endforeach
                    </div>

                    {{-- Calendar grid --}}
                    @php
                        $startOfMonth = $current->copy()->startOfMonth();
                        $endOfMonth   = $current->copy()->endOfMonth();
                        $today        = now()->toDateString();
                        $startPad     = $startOfMonth->dayOfWeek; // 0=Sun
                        $totalDays    = $endOfMonth->day;
                        $maxSlots     = 5;
                    @endphp

                    <div class="grid grid-cols-7 gap-1">
                        {{-- Padding before first day --}}
                        @for($i = 0; $i < $startPad; $i++)
                            <div></div>
                        @endfor

                        @for($day = 1; $day <= $totalDays; $day++)
                            @php
                                $dateStr    = $current->format('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                $dayOfWeek  = date('N', strtotime($dateStr)); // 1=Mon…5=Fri,6=Sat,7=Sun
                                $isWeekend  = in_array($dayOfWeek, [5, 6]); // Fri=5, Sat=6
                                $isOffDay   = $isWeekend || in_array($dateStr, $offDates);
                                $isPast     = $dateStr < $today;
                                $isToday    = $dateStr === $today;
                                $booked     = $counts[$dateStr] ?? 0;
                                $isFull     = $booked >= $maxSlots;

                                // Color classes based on slot fill
                                if ($isOffDay) {
                                    $bgClass  = 'bg-gray-200 text-gray-400 cursor-not-allowed';
                                    $dotColor = '';
                                } elseif ($isPast) {
                                    $bgClass  = 'bg-gray-100 text-gray-400 cursor-not-allowed';
                                    $dotColor = '';
                                } elseif ($isFull) {
                                    $bgClass  = 'bg-red-500 text-white cursor-not-allowed';
                                    $dotColor = '';
                                } elseif ($booked === 0) {
                                    $bgClass  = 'bg-green-500 text-white cursor-pointer hover:bg-green-600';
                                    $dotColor = 'bg-white';
                                } elseif ($booked === 1) {
                                    $bgClass  = 'bg-green-400 text-white cursor-pointer hover:bg-green-500';
                                    $dotColor = 'bg-white';
                                } elseif ($booked === 2) {
                                    $bgClass  = 'bg-yellow-400 text-white cursor-pointer hover:bg-yellow-500';
                                    $dotColor = 'bg-white';
                                } elseif ($booked === 3) {
                                    $bgClass  = 'bg-orange-400 text-white cursor-pointer hover:bg-orange-500';
                                    $dotColor = 'bg-white';
                                } else {
                                    $bgClass  = 'bg-orange-500 text-white cursor-pointer hover:bg-orange-600';
                                    $dotColor = 'bg-white';
                                }

                                $isClickable = !$isOffDay && !$isPast && !$isFull;
                                $slotsLeft   = $maxSlots - $booked;
                            @endphp

                            <div class="relative rounded-lg p-1 text-center transition {{ $bgClass }}
                                        {{ $isToday ? 'ring-2 ring-offset-1 ring-blue-500' : '' }}"
                                 @if($isClickable)
                                     onclick="openBookingModal('{{ $dateStr }}', {{ $slotsLeft }})"
                                 @endif>
                                <span class="text-sm font-medium">{{ $day }}</span>
                                @if($isOffDay)
                                    <div class="text-xs opacity-70 leading-none" style="font-size:9px">off</div>
                                @elseif($isFull)
                                    <div class="text-xs opacity-90 leading-none" style="font-size:9px">full</div>
                                @elseif(!$isPast)
                                    <div class="text-xs opacity-90 leading-none" style="font-size:9px">{{ $slotsLeft }} left</div>
                                @endif
                            </div>
                        @endfor
                    </div>

                    {{-- Legend --}}
                    <div class="mt-5 flex flex-wrap gap-3 text-xs text-gray-600">
                        <div class="flex items-center gap-1"><span class="w-4 h-4 rounded bg-green-500 inline-block"></span> Available</div>
                        <div class="flex items-center gap-1"><span class="w-4 h-4 rounded bg-yellow-400 inline-block"></span> Filling up</div>
                        <div class="flex items-center gap-1"><span class="w-4 h-4 rounded bg-orange-500 inline-block"></span> Almost full</div>
                        <div class="flex items-center gap-1"><span class="w-4 h-4 rounded bg-red-500 inline-block"></span> Fully booked</div>
                        <div class="flex items-center gap-1"><span class="w-4 h-4 rounded bg-gray-200 inline-block"></span> Off day</div>
                    </div>
                </div>

                {{-- My upcoming appointments --}}
                <div class="bg-white shadow-sm rounded-xl p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">My Appointments</h3>

                    @if($myAppointments->isEmpty())
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm">No upcoming appointments</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($myAppointments as $appt)
                                <div class="border border-gray-100 rounded-lg p-3">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">
                                                {{ \Carbon\Carbon::parse($appt->date)->format('D, M j') }}
                                            </p>
                                            <p class="text-sm text-gray-500">{{ $appt->time_slot }}</p>
                                        </div>
                                        @php
                                            $statusColors = [
                                                'pending'   => 'bg-yellow-100 text-yellow-800',
                                                'confirmed' => 'bg-green-100 text-green-800',
                                                'completed' => 'bg-blue-100 text-blue-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="text-xs px-2 py-0.5 rounded-full {{ $statusColors[$appt->status] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($appt->status) }}
                                        </span>
                                    </div>
                                    @if($appt->status === 'pending' || $appt->status === 'confirmed')
                                        <form method="POST"
                                              action="{{ route('citizen.appointments.cancel', $appt) }}"
                                              onsubmit="return confirm('Cancel this appointment?')"
                                              class="mt-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-xs text-red-500 hover:text-red-700 transition">
                                                Cancel appointment
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Booking Modal --}}
    <div id="booking-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeBookingModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">
                <button onclick="closeBookingModal()"
                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <h3 class="text-lg font-semibold text-gray-800 mb-1">Book Appointment</h3>
                <p id="modal-date-label" class="text-sm text-gray-500 mb-5"></p>

                <div id="slots-loading" class="text-center py-6 hidden">
                    <div class="inline-block w-6 h-6 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-sm text-gray-500 mt-2">Loading available slots…</p>
                </div>

                <div id="slots-error" class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4"></div>

                <form id="booking-form" method="POST" action="{{ route('citizen.appointments.store') }}">
                    @csrf
                    <input type="hidden" name="date" id="modal-date-input">

                    <div id="slots-container" class="mb-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Select a time slot:</p>
                        <div id="slots-grid" class="grid grid-cols-3 gap-2"></div>
                        <input type="hidden" name="time_slot" id="selected-slot">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-700 block mb-1">Notes <span class="text-gray-400 font-normal">(optional)</span></label>
                        <textarea name="notes" rows="2" maxlength="500"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none"
                                  placeholder="Any additional information…"></textarea>
                    </div>

                    <button type="submit" id="submit-btn"
                            class="w-full bg-blue-600 text-white rounded-lg py-2 text-sm font-medium hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        Confirm Booking
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    const slotsUrl = "{{ route('citizen.appointments.slots') }}";

    function openBookingModal(date, slotsLeft) {
        document.getElementById('booking-modal').classList.remove('hidden');
        document.getElementById('modal-date-input').value = date;
        document.getElementById('selected-slot').value = '';
        document.getElementById('submit-btn').disabled = true;
        document.getElementById('slots-error').classList.add('hidden');
        document.getElementById('slots-container').classList.add('hidden');

        const d = new Date(date + 'T00:00:00');
        const label = d.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('modal-date-label').textContent = label + ' — ' + slotsLeft + ' slot(s) remaining';

        fetchSlots(date);
    }

    function closeBookingModal() {
        document.getElementById('booking-modal').classList.add('hidden');
    }

    async function fetchSlots(date) {
        document.getElementById('slots-loading').classList.remove('hidden');
        document.getElementById('slots-grid').innerHTML = '';

        try {
            const res = await fetch(slotsUrl + '?date=' + date);
            const data = await res.json();

            document.getElementById('slots-loading').classList.add('hidden');

            if (data.error) {
                const errEl = document.getElementById('slots-error');
                errEl.textContent = data.error;
                errEl.classList.remove('hidden');
                return;
            }

            renderSlots(data.slots);
        } catch (e) {
            document.getElementById('slots-loading').classList.add('hidden');
            const errEl = document.getElementById('slots-error');
            errEl.textContent = 'Failed to load slots. Please try again.';
            errEl.classList.remove('hidden');
        }
    }

    function renderSlots(slots) {
        const grid = document.getElementById('slots-grid');
        grid.innerHTML = '';
        document.getElementById('slots-container').classList.remove('hidden');

        const labels = {
            '09:00': '9:00 AM', '10:00': '10:00 AM', '11:00': '11:00 AM',
            '12:00': '12:00 PM', '13:00': '1:00 PM'
        };

        slots.forEach(slot => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = labels[slot] || slot;
            btn.className = 'py-2 px-3 text-sm border-2 border-gray-200 rounded-lg text-gray-700 hover:border-blue-400 hover:text-blue-600 transition font-medium';
            btn.onclick = () => selectSlot(btn, slot);
            grid.appendChild(btn);
        });

        if (slots.length === 0) {
            grid.innerHTML = '<p class="col-span-3 text-sm text-gray-500">No slots available for this date.</p>';
        }
    }

    function selectSlot(btn, slot) {
        document.querySelectorAll('#slots-grid button').forEach(b => {
            b.className = 'py-2 px-3 text-sm border-2 border-gray-200 rounded-lg text-gray-700 hover:border-blue-400 hover:text-blue-600 transition font-medium';
        });
        btn.className = 'py-2 px-3 text-sm border-2 border-blue-500 bg-blue-50 rounded-lg text-blue-700 transition font-medium';
        document.getElementById('selected-slot').value = slot;
        document.getElementById('submit-btn').disabled = false;
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeBookingModal();
    });
    </script>
</x-app-layout>
