@extends('layouts.halzanin-app')

@section('content')
<div class="max-w-6xl mx-auto pb-10 space-y-8" x-data="{}">

    {{-- Header --}}
    <div class="flex items-center justify-between animate-fade-in">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gradient">Sub-Role Management</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Define granular permission sets and assign them to staff members</p>
        </div>
        <a href="{{ route('admin.sub-roles.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all hover:-translate-y-px">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create New Sub-Role
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Permissions Matrix --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay:100ms">
        <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <h3 class="font-bold text-gray-900 dark:text-white text-sm">Permissions Matrix</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-800/60">
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-48">Sub-Role</th>
                        @foreach($permissionsMap as $perm => $meta)
                            <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ $meta['label'] }}
                            </th>
                        @endforeach
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($subRoles as $subRole)
                        <tr class="hover:bg-gray-50/70 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-5 py-4">
                                <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $subRole->name }}</p>
                                @if($subRole->description)
                                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5 truncate max-w-[160px]">{{ $subRole->description }}</p>
                                @endif
                                <p class="text-[11px] text-indigo-500 dark:text-indigo-400 mt-1 font-semibold">{{ $subRole->users_count }} staff</p>
                            </td>
                            @foreach($permissionsMap as $perm => $meta)
                                <td class="px-3 py-4 text-center">
                                    @if($subRole->hasPermission($perm))
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-emerald-100 dark:bg-emerald-900/30 rounded-full">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                    @else
                                        <span class="inline-block w-5 h-0.5 bg-gray-200 dark:bg-slate-700 rounded mx-auto"></span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.sub-roles.edit', $subRole->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-brand dark:text-indigo-400 bg-brand/8 dark:bg-indigo-900/30 hover:bg-brand/15 rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.sub-roles.destroy', $subRole->id) }}"
                                          onsubmit="return confirm('Delete sub-role \'{{ addslashes($subRole->name) }}\'? This will unassign it from all staff.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-xl transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($permissionsMap) + 2 }}" class="px-6 py-14 text-center">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <p class="font-semibold text-gray-900 dark:text-white mb-1">No sub-roles yet</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Create your first sub-role to define granular permissions for staff.</p>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Summary row: staff count per permission --}}
                    @if($subRoles->isNotEmpty())
                        <tr class="bg-gray-50/80 dark:bg-slate-800/40">
                            <td class="px-5 py-3 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Staff covered</td>
                            @foreach($permissionsMap as $perm => $meta)
                                @php
                                    $count = $staffUsers->filter(fn($u) => $u->subRoles->contains(fn($sr) => $sr->hasPermission($perm)))->count();
                                @endphp
                                <td class="px-3 py-3 text-center">
                                    <span class="text-[11px] font-bold {{ $count > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500' }}">
                                        {{ $count }}
                                    </span>
                                </td>
                            @endforeach
                            <td></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Staff Assignment Panel --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay:200ms">
        <div class="h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <h3 class="font-bold text-gray-900 dark:text-white text-sm">Staff Assignments</h3>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-slate-800">
            @forelse($staffUsers as $staff)
                <div class="px-6 py-4" x-data="{ open: false }">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm uppercase">
                                {{ mb_substr($staff->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900 dark:text-white">{{ $staff->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ $staff->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap justify-end">
                            {{-- Assigned badges --}}
                            <div class="flex flex-wrap gap-1.5 justify-end">
                                @forelse($staff->subRoles as $sr)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-[11px] font-bold rounded-full">
                                        {{ $sr->name }}
                                        <form method="POST" action="{{ route('admin.sub-roles.unassign', [$staff->id, $sr->id]) }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="hover:text-red-500 transition-colors ml-0.5">×</button>
                                        </form>
                                    </span>
                                @empty
                                    <span class="text-[11px] text-gray-400 italic">No sub-roles (full access)</span>
                                @endforelse
                            </div>
                            {{-- Assign button --}}
                            @if($subRoles->isNotEmpty())
                                <button type="button" x-on:click="open = !open"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 rounded-xl transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Assign
                                </button>
                            @endif
                        </div>
                    </div>
                    {{-- Inline assign form --}}
                    <div x-show="open" x-transition class="mt-3 pl-12">
                        <form method="POST" action="{{ route('admin.sub-roles.assign', $staff->id) }}" class="flex items-center gap-2">
                            @csrf
                            <select name="sub_role_id" class="flex-1 h-[36px] text-sm rounded-xl border-gray-200 dark:border-gray-700 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0">
                                @foreach($subRoles as $sr)
                                    <option value="{{ $sr->id }}">{{ $sr->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-4 h-[36px] bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand-light transition-colors">
                                Assign
                            </button>
                            <button type="button" x-on:click="open = false" class="px-3 h-[36px] text-sm font-semibold text-gray-500 bg-gray-100 dark:bg-slate-700 rounded-xl hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-sm text-gray-400">No staff users found.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
