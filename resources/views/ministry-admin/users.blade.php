@extends('layouts.halzanin-app')

@section('content')
@php $color = $ministry->color ?? '#1B4F8A'; @endphp

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="animate-fade-in">
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-2">
            <a href="{{ route('ministry_admin.dashboard') }}" class="hover:text-brand transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">My Staff</span>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <h2 class="text-2xl font-bold font-outfit text-gradient">My Staff</h2>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                  style="background:{{ $color }}15; color:{{ $color }}; border:1px solid {{ $color }}30;">
                <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $color }};"></span>
                {{ $ministry->name }}
            </span>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Add citizens as staff, assign sub-roles, and manage permissions within your directorate.</p>
    </div>

    {{-- Session feedback --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-sm text-emerald-700 dark:text-emerald-400">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-sm text-red-700 dark:text-red-400">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Add Staff ── --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up">
        <div class="h-1" style="background: {{ $color }};"></div>
        <div class="p-6">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Add a Staff Member</h3>
            <p class="text-xs text-gray-400 dark:text-gray-500 mb-4">Enter the email address of a registered citizen to promote them to staff in your directorate.</p>
            <form method="POST" action="{{ route('ministry_admin.users.promote') }}" class="flex gap-3 flex-wrap">
                @csrf
                <input type="email" name="email" required placeholder="citizen@example.com"
                       class="flex-1 min-w-0 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#141414] text-gray-900 dark:text-gray-100 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                <button type="submit"
                        class="px-5 py-2.5 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all whitespace-nowrap"
                        style="background: {{ $color }};">
                    + Add as Staff
                </button>
            </form>
            @error('email')
                <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- ── Staff Table ── --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay: 80ms">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-5 rounded-full" style="background: {{ $color }};"></div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Current Staff</h3>
            </div>
            <span class="text-xs font-bold px-2.5 py-0.5 rounded-full" style="background:{{ $color }}15; color:{{ $color }};">
                {{ $staff->count() }} member{{ $staff->count() !== 1 ? 's' : '' }}
            </span>
        </div>

        @if($staff->isEmpty())
            <div class="flex flex-col items-center justify-center py-14 px-6 text-center">
                <div class="w-14 h-14 bg-gray-50 dark:bg-[#252525] rounded-2xl flex items-center justify-center mb-4 border border-gray-100 dark:border-slate-700">
                    <svg class="w-7 h-7 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">No staff yet</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Use the form above to add your first staff member.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Staff Member</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sub-Roles</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ltr:text-right rtl:text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800/60">
                        @foreach($staff as $member)
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0"
                                             style="background: {{ $color }};">
                                            {{ mb_substr($member->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $member->name }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $member->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5 max-w-[220px]">
                                        @forelse($member->subRoles as $sr)
                                            <div class="flex items-center gap-1 group">
                                                <span class="px-2 py-0.5 bg-brand/5 dark:bg-brand/10 text-brand dark:text-blue-400 text-[10px] font-bold rounded-full">{{ $sr->name }}</span>
                                                <form method="POST" action="{{ route('ministry_admin.users.remove-sub-role', ['user' => $member->id, 'subRoleId' => $sr->id]) }}" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" title="Remove sub-role"
                                                            class="text-gray-300 hover:text-red-400 transition-colors text-[10px] leading-none opacity-0 group-hover:opacity-100">✕</button>
                                                </form>
                                            </div>
                                        @empty
                                            <span class="text-[11px] text-gray-400 dark:text-gray-500 italic">Full access</span>
                                        @endforelse

                                        {{-- Assign sub-role dropdown --}}
                                        @if($subRoles->isNotEmpty())
                                            <form method="POST" action="{{ route('ministry_admin.users.assign-sub-role', $member->id) }}" class="inline-flex items-center gap-1">
                                                @csrf
                                                <select name="sub_role_id"
                                                        class="h-[22px] text-[10px] font-semibold px-1.5 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-[#141414] dark:text-white focus:outline-none focus:border-brand">
                                                    <option value="">+ Role</option>
                                                    @foreach($subRoles as $sr)
                                                        <option value="{{ $sr->id }}">{{ $sr->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="text-[10px] px-2 py-0.5 rounded-lg font-bold text-white" style="background: {{ $color }};">Add</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-400 dark:text-gray-500">
                                    {{ $member->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 ltr:text-right rtl:text-left">
                                    <form method="POST"
                                          action="{{ route('ministry_admin.users.remove', $member->id) }}"
                                          onsubmit="return confirm('Remove {{ addslashes($member->name) }} from staff? They will become a citizen and lose all permissions.')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-xs font-semibold text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ── Available Sub-Roles (reference) ── --}}
    @if($subRoles->isNotEmpty())
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 animate-fade-up" style="animation-delay: 160ms">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Available Sub-Roles</h3>
        <div class="space-y-2.5">
            @foreach($subRoles as $sr)
                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-white/[0.02] rounded-xl">
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-brand/5 dark:bg-brand/10 text-brand dark:text-blue-400 shrink-0 mt-0.5">{{ $sr->name }}</span>
                    <div class="flex flex-wrap gap-1 mt-0.5">
                        @foreach($sr->permissions as $perm)
                            <span class="text-[10px] px-1.5 py-0.5 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded font-mono">{{ $perm->permission }}</span>
                        @endforeach
                        @if($sr->permissions->isEmpty())
                            <span class="text-[10px] text-gray-400 italic">No permissions defined</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-3">Sub-roles are defined by the system admin. Contact them to add new roles or permissions.</p>
    </div>
    @endif

</div>
@endsection
