@extends('layouts.halzanin-app')

@section('content')
    <div class="max-w-4xl mx-auto pb-10 space-y-6 lg:space-y-8">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-center sm:items-start sm:justify-between gap-4 animate-fade-in">
            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-5">
                {{-- Avatar --}}
                <div class="relative shrink-0">
                    <div class="w-20 h-20 bg-brand rounded-full flex items-center justify-center text-3xl font-bold text-white uppercase shadow-lg ring-4 ring-white dark:ring-[#1F1F1F]">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-accent rounded-full border-2 border-white dark:border-[#1F1F1F] flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>

                <div class="text-center sm:text-left rtl:sm:text-right">
                    <div class="flex items-center justify-center sm:justify-start gap-3 mb-1">
                        <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="profile.title">My Profile</h2>
                        @php
                            $roleBadge = [
                                'citizen' => 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-300',
                                'staff'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'admin'   => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                            ][auth()->user()->role] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $roleBadge }}" data-i18n="role.{{ auth()->user()->role }}">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400" data-i18n="profile.subtitle">Manage your account settings and preferences.</p>
                </div>
            </div>
        </div>

        {{-- Profile Info Card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 100ms">
            <div class="border-b border-stone-200 dark:border-slate-700"></div>
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Update Password Card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 200ms">
            <div class="border-b border-stone-200 dark:border-slate-700"></div>
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-red-100 dark:border-red-900/30 overflow-hidden animate-fade-up" style="animation-delay: 300ms">
            <div class="border-b border-stone-200 dark:border-slate-700"></div>
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>
@endsection
