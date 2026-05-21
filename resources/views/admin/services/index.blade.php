@extends('layouts.halzanin-app')

@section('title', 'Services Management')

@section('content')
<div class="max-w-5xl mx-auto pb-10 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between animate-fade-in">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gradient">Services Management</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Activate or deactivate citizen-facing services per ministry</p>
        </div>
        <a href="{{ url('/') }}#ministries" target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-slate-700 rounded-xl hover:border-brand hover:text-brand transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            View Portal
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Summary cards --}}
    <div class="grid grid-cols-3 gap-4 animate-fade-up" style="animation-delay:50ms">
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl border border-gray-100 dark:border-slate-800 p-5 text-center shadow-sm">
            <p class="text-3xl font-extrabold text-brand dark:text-blue-400 font-outfit">{{ $stats['total'] }}</p>
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Total Services</p>
        </div>
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl border border-gray-100 dark:border-slate-800 p-5 text-center shadow-sm">
            <p class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 font-outfit">{{ $stats['active'] }}</p>
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Active</p>
        </div>
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl border border-gray-100 dark:border-slate-800 p-5 text-center shadow-sm">
            <p class="text-3xl font-extrabold text-amber-500 dark:text-amber-400 font-outfit">{{ $stats['inactive'] }}</p>
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Inactive</p>
        </div>
    </div>

    {{-- Services grouped by ministry --}}
    @foreach($ministries as $ministry)
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up"
             style="animation-delay:{{ $loop->index * 80 + 100 }}ms">

            {{-- Ministry header --}}
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-800"
                 style="border-left: 4px solid {{ $ministry->color }};">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                     style="background: {{ $ministry->color }}18;">
                    @if($ministry->slug === 'civil-registry')
                        <svg class="w-4 h-4" fill="none" stroke="{{ $ministry->color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 00-9.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @elseif($ministry->slug === 'traffic-police')
                        <svg class="w-4 h-4" fill="none" stroke="{{ $ministry->color }}" stroke-width="2" viewBox="0 0 24 24"><rect x="7" y="2" width="10" height="20" rx="3"/><circle cx="12" cy="7" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="12" cy="17" r="2"/></svg>
                    @elseif($ministry->slug === 'electricity')
                        <svg class="w-4 h-4" fill="none" stroke="{{ $ministry->color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    @elseif($ministry->slug === 'water')
                        <svg class="w-4 h-4" fill="none" stroke="{{ $ministry->color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="{{ $ministry->color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $ministry->name }}</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 font-medium" style="font-family:'Noto Naskh Arabic',serif;">{{ $ministry->name_ku }}</p>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:{{ $ministry->color }}18; color:{{ $ministry->color }};">
                    {{ $ministry->services->where('is_active', true)->count() }} / {{ $ministry->services->count() }} active
                </span>
            </div>

            {{-- Services table --}}
            @if($ministry->services->isEmpty())
                <p class="px-6 py-5 text-sm text-gray-400 dark:text-gray-500 italic">No services configured for this ministry.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-gray-50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Kurdish Name</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Est. Days</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                            @foreach($ministry->services as $service)
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $service->name }}</div>
                                        @if($service->description)
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 max-w-xs truncate">{{ $service->description }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 hidden sm:table-cell">
                                        <span class="text-sm text-gray-500 dark:text-gray-400" style="font-family:'Noto Naskh Arabic',serif;">{{ $service->name_ku }}</span>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $service->estimated_days }} days</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($service->is_active)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-slate-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('services.show', $service->slug) }}" target="_blank"
                                               class="p-1.5 rounded-lg text-gray-400 hover:text-brand hover:bg-brand/5 transition-all"
                                               title="Preview public page">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <form method="POST" action="{{ route('admin.services.toggle', $service) }}" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all
                                                               {{ $service->is_active
                                                                    ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 border border-red-200 dark:border-red-800'
                                                                    : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 border border-emerald-200 dark:border-emerald-800' }}">
                                                    @if($service->is_active)
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        Deactivate
                                                    @else
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        Activate
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endforeach

</div>
@endsection
