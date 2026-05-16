@extends('layouts.halzanin-app')

@section('content')
    <div class="max-w-4xl mx-auto pb-10 space-y-6 lg:space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-center sm:items-start sm:justify-between gap-4 animate-fade-in">
            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                <!-- Avatar -->
                <div class="w-20 h-20 bg-brand dark:bg-indigo-500 rounded-full flex items-center justify-center text-3xl font-bold text-white uppercase shadow-sm ring-4 ring-white dark:ring-[#1e293b]">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                
                <div class="text-center sm:text-left sm:rtl:text-right">
                    <div class="flex items-center justify-center sm:justify-start space-x-3 rtl:space-x-reverse mb-1">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit">My Profile</h2>
                        @php
                            $roleBadge = [
                                'citizen' => 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-300',
                                'staff'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'admin'   => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                            ][auth()->user()->role] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $roleBadge }}">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage your account settings and preferences.</p>
                </div>
            </div>
        </div>

        <!-- Profile Info Card -->
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 p-6 sm:p-8 animate-fade-up" style="animation-delay: 100ms;">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 p-6 sm:p-8 animate-fade-up" style="animation-delay: 200ms;">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-red-100 dark:border-red-900/30 p-6 sm:p-8 animate-fade-up" style="animation-delay: 300ms;">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
@endsection
