@extends('layouts.halzanin-app')

@section('content')
    @php
        $total = \App\Models\Application::count();
        $pending = \App\Models\Application::whereIn('current_status', ['submitted', 'received'])->count();
        $completed = \App\Models\Application::whereIn('current_status', ['approved', 'rejected'])->count();
    @endphp

    <div class="space-y-6 lg:space-y-8 max-w-4xl mx-auto">
        
        <!-- Top Section: Greeting -->
        <div class="animate-fade-in">
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">Welcome, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Here's the current overview of the application queue.</p>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
            <!-- Total -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 0ms">
                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <p class="text-3xl font-bold text-brand dark:text-white font-outfit">{{ $total }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Applications</p>
            </div>
            <!-- Pending Review -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 100ms">
                <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-3xl font-bold text-brand dark:text-white font-outfit">{{ $pending }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pending Review</p>
            </div>
            <!-- Completed -->
            <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-6 shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up" style="animation-delay: 200ms">
                <div class="w-10 h-10 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-3xl font-bold text-brand dark:text-white font-outfit">{{ $completed }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Completed</p>
            </div>
        </div>

        <!-- Action Section -->
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8 animate-fade-up flex flex-col items-center text-center" style="animation-delay: 300ms">
            <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-brand dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Application Queue</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md">Review, process, and update the status of all submitted citizen applications in real-time.</p>
            
            <a href="{{ route('staff.queue') }}" class="w-full sm:w-auto px-8 py-3 bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all inline-block">
                View Application Queue
            </a>
        </div>

    </div>
@endsection
