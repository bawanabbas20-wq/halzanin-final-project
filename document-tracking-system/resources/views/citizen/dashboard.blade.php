@extends('layouts.halzanin-app')

@section('content')
    @php
        $total     = $upcomingAppointments->count();
        $confirmed = $upcomingAppointments->where('status', 'confirmed')->count();
        $pending   = $upcomingAppointments->where('status', 'pending')->count();
    @endphp

    <div class="space-y-6 lg:space-y-8">

        <!-- Top Section: Greeting -->
        <div>
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">سڵاو، {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Here's your upcoming appointments at a glance</p>
        </div>

        <!-- Quick Action Card -->
        <div class="relative overflow-hidden rounded-[16px] bg-gradient-to-r from-brand to-[#312e81] shadow-lg animate-fade-up">
            <div class="absolute right-0 bottom-0 opacity-20 pointer-events-none">
                <svg width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                     stroke-linecap="round" stroke-linejoin="round" class="text-white transform translate-x-4 translate-y-4">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between relative z-10 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Ready to visit the directorate?</h3>
                    <p class="text-sm text-white/80">Book a new appointment in minutes</p>
                </div>
                <a href="{{ route('citizen.appointments.calendar') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-accent text-white font-semibold text-sm rounded-[10px] shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all whitespace-nowrap">
                    Book Appointment
                </a>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-3 gap-3 lg:gap-6">
            <!-- Total -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-4 lg:p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 0ms">
                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-brand dark:text-white font-outfit">{{ $total }}</p>
                <p class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">Upcoming</p>
            </div>
            <!-- Confirmed -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-4 lg:p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 100ms">
                <div class="w-10 h-10 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-brand dark:text-white font-outfit">{{ $confirmed }}</p>
                <p class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">Confirmed</p>
            </div>
            <!-- Pending -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-4 lg:p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 200ms">
                <div class="w-10 h-10 rounded-full bg-yellow-50 dark:bg-yellow-900/30 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-brand dark:text-white font-outfit">{{ $pending }}</p>
                <p class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">Pending</p>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div>
            <div class="flex items-center mb-4 space-x-2 rtl:space-x-reverse">
                <h3 class="text-lg font-bold text-brand dark:text-white font-outfit">Upcoming Appointments</h3>
                <span class="px-2 py-0.5 bg-brand/10 dark:bg-[#1e293b] text-brand dark:text-white text-xs font-bold rounded-full">{{ $total }}</span>
            </div>

            @if($upcomingAppointments->isEmpty())
                <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up">
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">No upcoming appointments</h4>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mb-5">Book an appointment to visit the directorate.</p>
                        <a href="{{ route('citizen.appointments.calendar') }}"
                           class="inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-semibold rounded-[10px] hover:bg-brand/90 transition">
                            Book Appointment
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @php
                        $statusColors = [
                            'pending'   => ['border' => 'border-yellow-400', 'badge' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'],
                            'confirmed' => ['border' => 'border-green-400',  'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'],
                            'completed' => ['border' => 'border-blue-400',   'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'],
                            'cancelled' => ['border' => 'border-red-400',    'badge' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'],
                        ];
                        $timeLabels = [
                            '09:00' => '9:00 AM', '10:00' => '10:00 AM', '11:00' => '11:00 AM',
                            '12:00' => '12:00 PM', '13:00' => '1:00 PM',
                        ];
                    @endphp

                    @foreach($upcomingAppointments as $index => $appt)
                        @php
                            $color = $statusColors[$appt->status] ?? $statusColors['pending'];
                            $delay = 50 * $index;
                        @endphp
                        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden ltr:border-l-4 rtl:border-r-4 {{ $color['border'] }} animate-fade-up"
                             style="animation-delay: {{ $delay }}ms">
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-semibold text-brand dark:text-indigo-400 text-sm">
                                            {{ \Carbon\Carbon::parse($appt->date)->format('D, M j, Y') }}
                                        </span>
                                    </div>
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $color['badge'] }}">
                                        {{ ucfirst($appt->status) }}
                                    </span>
                                </div>

                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <svg class="w-4 h-4 ltr:mr-1.5 rtl:ml-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $timeLabels[$appt->time_slot] ?? $appt->time_slot }}
                                    @if($appt->notes)
                                        <span class="ltr:ml-3 rtl:mr-3 text-xs text-gray-400">— {{ $appt->notes }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100 dark:border-gray-800 gap-3">
                                    <span class="text-xs text-gray-400 shrink-0">
                                        Booked {{ $appt->created_at->diffForHumans() }}
                                    </span>
                                    <div class="flex items-center gap-2">
                                        @if($appt->application)
                                            <a href="{{ route('citizen.applications.qr-receipt', $appt->application->id) }}"
                                               class="inline-flex items-center gap-1.5 py-1.5 px-3 text-xs font-semibold bg-brand/10 text-brand dark:bg-indigo-900/30 dark:text-indigo-300 rounded-[8px] hover:bg-brand/20 dark:hover:bg-indigo-900/50 transition whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                                View Receipt
                                            </a>
                                        @endif
                                        @if($appt->status === 'pending' || $appt->status === 'confirmed')
                                            <form method="POST"
                                                  action="{{ route('citizen.appointments.cancel', $appt) }}"
                                                  onsubmit="return confirm('Cancel this appointment?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="text-xs text-red-500 hover:text-red-700 font-medium transition">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
