@extends('layouts.halzanin-app')

@section('content')
@php
    $permLabels = \App\Models\SubRole::PERMISSIONS;
@endphp
<div class="max-w-full mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
        <div>
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">Sub-Role Management</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Manage granular staff permissions through sub-roles</p>
        </div>
        <a href="{{ route('admin.sub-roles.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-[10px] shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create New Sub-Role
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-[10px]">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-[10px]">
            {{ session('error') }}
        </div>
    @endif

    <!-- Permissions Matrix -->
    <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-up" style="animation-delay:100ms">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse min-w-[900px]">
                <thead class="bg-gray-50 dark:bg-slate-800 border-b border-gray-100 dark:border-slate-700">
                    <tr>
                        <th class="px-5 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left min-w-[160px]">Sub-Role</th>
                        @foreach($allPermissions as $perm)
                            <th class="px-3 py-4 text-center">
                                <div class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider leading-tight">
                                    {{ str_replace('_', ' ', $perm) }}
                                </div>
                            </th>
                        @endforeach
                        <th class="px-5 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($subRoles as $index => $subRole)
                        @php
                            $grantedPerms = $subRole->permissions->pluck('permission')->toArray();
                            $rowClass = $index % 2 === 0 ? 'bg-white dark:bg-[#1e293b]' : 'bg-gray-50/50 dark:bg-slate-800/20';
                        @endphp
                        <tr class="{{ $rowClass }} hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-colors">
                            <td class="px-5 py-4">
                                <div class="font-bold text-gray-900 dark:text-white">{{ $subRole->name }}</div>
                                @if($subRole->description)
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 truncate max-w-[140px]">{{ $subRole->description }}</div>
                                @endif
                                <div class="text-xs text-brand dark:text-indigo-400 font-semibold mt-1">{{ $subRole->users_count }} user{{ $subRole->users_count !== 1 ? 's' : '' }}</div>
                            </td>
                            @foreach($allPermissions as $perm)
                                <td class="px-3 py-4 text-center">
                                    @if(in_array($perm, $grantedPerms))
                                        <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700 font-bold text-lg leading-none">—</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.sub-roles.edit', $subRole->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-[8px] border border-brand text-brand dark:border-indigo-400 dark:text-indigo-400 hover:bg-brand/5 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.sub-roles.destroy', $subRole->id) }}"
                                          onsubmit="return confirm('Delete sub-role &quot;{{ $subRole->name }}&quot;? This will unassign it from all users.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-[8px] border border-red-300 text-red-500 dark:border-red-800 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($allPermissions) + 2 }}" class="px-6 py-16 text-center">
                                <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-brand/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <p class="text-base font-bold text-gray-900 dark:text-white mb-1">No sub-roles yet</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Create your first sub-role to restrict staff access by function.</p>
                                <a href="{{ route('admin.sub-roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-[10px] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Create Sub-Role
                                </a>
                            </td>
                        </tr>
                    @endforelse

                    <!-- Footer row: staff count per permission -->
                    @if($subRoles->isNotEmpty())
                        <tr class="bg-brand/5 dark:bg-indigo-900/10 border-t-2 border-brand/20 dark:border-indigo-900/40">
                            <td class="px-5 py-3">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Staff with permission</span>
                            </td>
                            @foreach($allPermissions as $perm)
                                <td class="px-3 py-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold
                                        {{ $permissionCounts[$perm] > 0 ? 'bg-brand/10 text-brand dark:bg-indigo-900/30 dark:text-indigo-400' : 'bg-gray-100 text-gray-400 dark:bg-gray-800' }}">
                                        {{ $permissionCounts[$perm] }}
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

</div>
@endsection
