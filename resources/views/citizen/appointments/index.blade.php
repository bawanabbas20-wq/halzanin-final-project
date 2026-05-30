@extends('layouts.halzanin-app')

@section('content')
@php
    $ministryIcons = [
        'civil-registry'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>',
        'traffic-police'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>',
        'electricity'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
        'water'                 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c-4.97 5.93-7 9.18-7 12a7 7 0 0014 0c0-2.82-2.03-6.07-7-12z"/>',
        'business-registration' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
    ];
@endphp

<div class="max-w-3xl mx-auto space-y-6 animate-fade-up">

    {{-- Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-2">
            <a href="{{ route('citizen.dashboard') }}" class="hover:text-brand dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-3 h-3 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Book an Appointment</span>
        </div>
        <h2 class="text-2xl font-bold font-outfit text-gradient">Book an Appointment</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select a directorate and service to schedule your visit.</p>
    </div>

    {{-- Ministry + Service Cards --}}
    <div class="space-y-4">
        @foreach($ministries as $ministry)
            @php
                $iconPath    = $ministryIcons[$ministry->slug] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>';
                $activeCount = $ministry->services->where('is_active', true)->count();
            @endphp
            <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up"
                 style="animation-delay: {{ $loop->index * 80 }}ms; border-top: 3px solid {{ $ministry->color }};">

                {{-- Ministry Header --}}
                <div class="flex items-center gap-4 px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                         style="background: {{ $ministry->color }}18;">
                        <svg class="w-5 h-5" fill="none" stroke="{{ $ministry->color }}" viewBox="0 0 24 24">
                            {!! $iconPath !!}
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $ministry->name }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                            {{ $activeCount }} active service{{ $activeCount !== 1 ? 's' : '' }}
                        </p>
                    </div>
                </div>

                {{-- Services List --}}
                <div class="divide-y divide-gray-50 dark:divide-gray-800/60">
                    @forelse($ministry->services->sortBy('id') as $service)
                        @if($service->is_active)
                            <a href="{{ route('citizen.appointments.book', ['ministry' => $ministry->slug, 'service' => $service->slug]) }}"
                               class="group flex items-center gap-4 px-5 py-4 hover:bg-gray-50/80 dark:hover:bg-white/[0.03] transition-colors">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $service->name }}</p>
                                    @if($service->description)
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 truncate">{{ $service->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-3 mt-1.5">
                                        <span class="inline-flex items-center gap-1 text-[11px] text-gray-400 dark:text-gray-500">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            ~{{ $service->estimated_days }} days processing
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-[11px] text-gray-400 dark:text-gray-500">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            {{ count($service->required_documents ?? []) }} documents required
                                        </span>
                                    </div>
                                </div>
                                <span class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-all group-hover:shadow-sm"
                                      style="background: {{ $ministry->color }}12; color: {{ $ministry->color }}; border: 1px solid {{ $ministry->color }}30;">
                                    Book
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </a>
                        @else
                            <div class="flex items-center gap-4 px-5 py-4 opacity-50 cursor-not-allowed select-none">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">{{ $service->name }}</p>
                                    @if($service->description)
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 truncate">{{ $service->description }}</p>
                                    @endif
                                </div>
                                <span class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500">
                                    Coming Soon
                                </span>
                            </div>
                        @endif
                    @empty
                        <div class="px-5 py-4 text-xs text-gray-400 dark:text-gray-500 italic">No services available.</div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
