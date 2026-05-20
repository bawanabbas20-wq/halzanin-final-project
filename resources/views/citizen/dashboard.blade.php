@extends('layouts.halzanin-app')

@section('content')
    @php
        $total     = $upcomingAppointments->count();
        $confirmed = $upcomingAppointments->where('status', 'confirmed')->count();
        $pending   = $upcomingAppointments->where('status', 'pending')->count();
    @endphp

    <div class="space-y-6 lg:space-y-8">

        {{-- ── Greeting ── --}}
        <div class="animate-fade-in">
            <h2 class="text-2xl font-bold font-outfit text-gradient">
                <span data-i18n="dashboard.greeting">Hello,</span>
                <span dir="auto" style="unicode-bidi:isolate">{{ explode(' ', auth()->user()->name)[0] }}</span><span style="unicode-bidi:isolate">!</span>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1" data-i18n="dashboard.subtitle">
                Here's your upcoming appointments at a glance
            </p>
        </div>

        {{-- ── Hero CTA ── --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand via-[#2d2a6e] to-[#A06B07] shadow-brand-btn animate-fade-up">
            {{-- decorative rings --}}
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full pointer-events-none"></div>
            <div class="absolute top-4 right-4 w-3 h-3 bg-accent rounded-full pulse-dot pointer-events-none"></div>

            <div class="relative z-10 p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                <div>
                    <p class="text-white/60 text-xs font-semibold uppercase tracking-widest mb-1" data-i18n="dashboard.kicker">Civic Services</p>
                    <h3 class="text-xl font-bold text-white mb-1.5" data-i18n="dashboard.ready">
                        Ready to visit the directorate?
                    </h3>
                    <p class="text-sm text-white/70" data-i18n="dashboard.book_subtitle">
                        Book a new appointment in minutes
                    </p>
                </div>
                <a href="{{ route('citizen.appointments.calendar') }}"
                   class="shrink-0 inline-flex items-center gap-2 px-5 py-3 bg-white text-brand font-bold text-sm rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span data-i18n="dashboard.book_btn">Book Appointment</span>
                </a>
            </div>
        </div>

        {{-- ── Stats Row ── --}}
        <div class="grid grid-cols-3 gap-3 lg:gap-5">
            @php
                $statItems = [
                    [
                        'value'   => $total,
                        'label'   => 'Upcoming',
                        'i18n'    => 'dashboard.stat_upcoming',
                        'delay'   => 0,
                        'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                        'ring'    => 'ring-gray-200 dark:ring-gray-700',
                        'icon_bg' => 'bg-gray-100 dark:bg-gray-800',
                        'icon_c'  => 'text-gray-500 dark:text-gray-400',
                    ],
                    [
                        'value'   => $confirmed,
                        'label'   => 'Confirmed',
                        'i18n'    => 'dashboard.stat_confirmed',
                        'delay'   => 80,
                        'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'ring'    => 'ring-green-100 dark:ring-green-900/30',
                        'icon_bg' => 'bg-green-50 dark:bg-green-900/30',
                        'icon_c'  => 'text-green-600 dark:text-green-400',
                    ],
                    [
                        'value'   => $pending,
                        'label'   => 'Pending',
                        'i18n'    => 'dashboard.stat_pending',
                        'delay'   => 160,
                        'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'ring'    => 'ring-amber-100 dark:ring-amber-900/30',
                        'icon_bg' => 'bg-amber-50 dark:bg-amber-900/30',
                        'icon_c'  => 'text-amber-500 dark:text-amber-400',
                    ],
                ];
            @endphp

            @foreach ($statItems as $s)
                <div class="bg-white dark:bg-[#1e293b] rounded-xl p-4 lg:p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover-lift animate-fade-up"
                     style="animation-delay: {{ $s['delay'] }}ms">
                    <div class="w-9 h-9 rounded-full ring-4 {{ $s['ring'] }} {{ $s['icon_bg'] }} {{ $s['icon_c'] }} flex items-center justify-center mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $s['icon'] !!}</svg>
                    </div>
                    <p class="text-2xl font-bold text-brand dark:text-white font-outfit">{{ $s['value'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate" data-i18n="{{ $s['i18n'] }}">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- ── Upcoming Appointments ── --}}
        <div class="animate-fade-up" style="animation-delay: 240ms">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-brand dark:text-white font-outfit" data-i18n="dashboard.upcoming">
                        Upcoming Appointments
                    </h3>
                    @if($total > 0)
                        <span class="px-2 py-0.5 bg-brand/10 dark:bg-amber-900/30 text-brand dark:text-amber-400 text-xs font-bold rounded-full">
                            {{ $total }}
                        </span>
                    @endif
                </div>
                <a href="{{ route('citizen.appointments.calendar') }}"
                   class="text-xs font-semibold text-brand dark:text-amber-400 hover:underline flex items-center gap-1">
                    <span data-i18n="dashboard.book_new">Book new</span>
                    <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if($upcomingAppointments->isEmpty())
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
                    <div class="flex flex-col items-center justify-center py-14 px-6 text-center">
                        <div class="w-16 h-16 bg-gray-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center mb-4 border border-gray-100 dark:border-slate-700">
                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1" data-i18n="dashboard.no_appointments">
                            No appointments yet
                        </h4>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-5" data-i18n="dashboard.empty_subtitle">
                            Book an appointment to visit the directorate.
                        </p>
                        <a href="{{ route('citizen.appointments.calendar') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand-light transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span data-i18n="dashboard.book_btn">Book Appointment</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-3">
                    @php
                        $statusConfig = [
                            'pending'   => ['border' => 'border-amber-400',  'badge' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',  'dot' => 'status-dot-yellow'],
                            'confirmed' => ['border' => 'border-emerald-400','badge' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400','dot' => 'status-dot-green'],
                            'completed' => ['border' => 'border-blue-400',   'badge' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',    'dot' => 'status-dot-blue'],
                            'cancelled' => ['border' => 'border-red-400',    'badge' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400',        'dot' => 'status-dot-red'],
                        ];
                        $timeLabels = [
                            '09:00' => '9:00 AM', '10:00' => '10:00 AM', '11:00' => '11:00 AM',
                            '12:00' => '12:00 PM', '13:00' => '1:00 PM',
                        ];
                    @endphp

                    @foreach($upcomingAppointments as $index => $appt)
                        @php
                            $cfg   = $statusConfig[$appt->status] ?? $statusConfig['pending'];
                            $delay = 50 + $index * 60;
                            $apptDate = \Carbon\Carbon::parse($appt->date);
                        @endphp

                        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800
                                    ltr:border-l-4 rtl:border-r-4 {{ $cfg['border'] }} hover-lift overflow-hidden animate-fade-up"
                             style="animation-delay: {{ $delay }}ms">

                            <div class="p-4 sm:p-5 flex items-start gap-4">
                                {{-- Date block --}}
                                <div class="shrink-0 w-12 text-center bg-brand/5 dark:bg-brand/20 rounded-xl py-2 px-1 border border-brand/10 dark:border-amber-800/40">
                                    <p class="text-[11px] font-bold text-brand/60 dark:text-amber-400/80 uppercase tracking-wide leading-none mb-0.5">
                                        {{ $apptDate->format('M') }}
                                    </p>
                                    <p class="text-2xl font-extrabold text-brand dark:text-white leading-none font-outfit">
                                        {{ $apptDate->format('d') }}
                                    </p>
                                    <p class="text-[10px] font-semibold text-gray-400 dark:text-gray-500 mt-0.5">
                                        {{ $apptDate->format('D') }}
                                    </p>
                                </div>

                                {{-- Details --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1.5">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <div class="w-2 h-2 rounded-full shrink-0 {{ $cfg['dot'] }}"></div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                                {{ $appt->document_type ?? 'Appointment' }}
                                            </p>
                                        </div>
                                        <span class="shrink-0 px-2.5 py-0.5 text-[11px] font-bold rounded-full capitalize {{ $cfg['badge'] }}"
                                              data-i18n="status.{{ $appt->status }}">
                                            {{ ucfirst($appt->status) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $timeLabels[$appt->time_slot] ?? $appt->time_slot }}
                                        </span>
                                        @if($appt->notes)
                                            <span class="truncate text-gray-400">{{ $appt->notes }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($appt->status === 'pending' || $appt->status === 'confirmed')
                                <div class="px-4 sm:px-5 py-2.5 bg-gray-50/70 dark:bg-slate-800/30 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                                    <span class="text-[11px] text-gray-400 dark:text-gray-500">
                                        <span data-i18n="dashboard.booked">Booked</span> {{ $appt->created_at->diffForHumans() }}
                                    </span>
                                    <form method="POST"
                                          action="{{ route('citizen.appointments.cancel', $appt) }}"
                                          onsubmit="return confirm('Cancel this appointment?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-[11px] font-semibold text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors flex items-center gap-1"
                                                data-i18n="common.cancel">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
