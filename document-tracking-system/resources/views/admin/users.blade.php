@extends('layouts.halzanin-app')

@section('content')
    <div class="max-w-6xl mx-auto pb-10"
         x-data="{ pendingForm: null, pendingName: '', pendingRole: '', assignUserId: null, assignUserName: '' }">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6 animate-fade-in">
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit flex items-center">
                User Management
                <span class="ltr:ml-3 rtl:mr-3 px-2.5 py-1 bg-brand/10 dark:bg-indigo-900/30 text-brand dark:text-indigo-400 text-sm font-bold rounded-[8px]">
                    {{ $users->total() }}
                </span>
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-gray-500 hover:text-brand dark:text-gray-400 dark:hover:text-indigo-400 transition-colors flex items-center">
                <svg class="w-4 h-4 ltr:mr-1.5 rtl:ml-1.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-[10px] mb-6 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-[10px] mb-6 animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 100ms;">
            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-gray-50 dark:bg-slate-800 border-b border-gray-100 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sub-Roles</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Registered</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ltr:text-right rtl:text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                        @forelse ($users as $index => $user)
                            @php
                                $isSelf = $user->id === auth()->id();

                                $roleBadge = [
                                    'citizen' => 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-300',
                                    'staff'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'admin'   => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                ][$user->role] ?? 'bg-gray-100 text-gray-600';

                                $rowClass = $isSelf
                                    ? 'bg-gray-50/50 dark:bg-slate-800/30 opacity-80'
                                    : ($index % 2 === 0 ? 'bg-white dark:bg-[#1e293b]' : 'bg-[#f8fafc] dark:bg-slate-800/20');
                            @endphp

                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors {{ $rowClass }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white uppercase shrink-0 {{ $user->role === 'admin' ? 'bg-brand dark:bg-indigo-500' : ($user->role === 'staff' ? 'bg-blue-500' : 'bg-gray-400 dark:bg-slate-600') }}">
                                            {{ mb_substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white flex items-center">
                                                {{ $user->name }}
                                                @if($isSelf)
                                                    <span class="ltr:ml-2 rtl:mr-2 px-1.5 py-0.5 bg-gray-200 dark:bg-slate-700 text-[10px] text-gray-500 dark:text-gray-400 rounded uppercase tracking-wider">You</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $roleBadge }}">
                                        {{ $user->role }}
                                    </span>
                                </td>

                                <!-- Sub-Roles Column -->
                                <td class="px-6 py-4">
                                    @if($user->role === 'staff')
                                        <div class="flex flex-wrap gap-1.5">
                                            @forelse($user->subRoles as $sr)
                                                <div class="group flex items-center gap-1 px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-[11px] font-bold rounded-full">
                                                    {{ $sr->name }}
                                                    <form method="POST" action="{{ route('admin.sub-roles.unassign', [$user->id, $sr->id]) }}" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" title="Remove sub-role"
                                                                class="text-indigo-400 hover:text-red-500 transition-colors leading-none ml-0.5"
                                                                onclick="return confirm('Remove sub-role &quot;{{ $sr->name }}&quot; from {{ $user->name }}?')">
                                                            ×
                                                        </button>
                                                    </form>
                                                </div>
                                            @empty
                                                @if($subRoles->isEmpty())
                                                    <span class="text-xs text-gray-400 dark:text-gray-500 italic">No sub-roles defined</span>
                                                @else
                                                    <span class="text-xs text-gray-400 dark:text-gray-500 italic">Full access</span>
                                                @endif
                                            @endforelse

                                            @if($subRoles->isNotEmpty())
                                                <button type="button"
                                                        x-on:click="assignUserId = {{ $user->id }}; assignUserName = '{{ addslashes($user->name) }}'; $dispatch('open-modal', 'assign-sub-role')"
                                                        class="inline-flex items-center gap-0.5 px-2 py-0.5 bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 text-[11px] font-semibold rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-brand dark:hover:text-indigo-400 transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                                    Assign
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-300 dark:text-gray-700">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 ltr:text-right rtl:text-left">
                                    @if($isSelf)
                                        <span class="text-[11px] text-gray-400 dark:text-gray-500 italic uppercase tracking-wider font-semibold">Cannot change own role</span>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.update-role', $user->id) }}"
                                              data-user-name="{{ $user->name }}"
                                              class="inline-flex items-center space-x-2 rtl:space-x-reverse">
                                            @csrf
                                            @method('PATCH')
                                            <div class="relative">
                                                <select name="role"
                                                    class="block w-32 h-[34px] text-xs font-semibold ltr:pl-3 ltr:pr-8 rtl:pr-3 rtl:pl-8 rounded-[8px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 transition-all">
                                                    <option value="citizen" {{ $user->role === 'citizen' ? 'selected' : '' }}>Citizen</option>
                                                    <option value="staff"   {{ $user->role === 'staff'   ? 'selected' : '' }}>Staff</option>
                                                    <option value="admin"   {{ $user->role === 'admin'   ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </div>
                                            <button type="button"
                                                    x-on:click="
                                                        pendingForm = $el.closest('form');
                                                        pendingName = pendingForm.dataset.userName;
                                                        pendingRole = pendingForm.querySelector('[name=role]').value;
                                                        $dispatch('open-modal', 'confirm-role-update')
                                                    "
                                                    class="h-[34px] px-3 bg-brand text-white text-xs font-semibold rounded-[8px] hover:bg-brand-light transition-colors shadow-sm">
                                                Update
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-36 h-36 mb-5 rounded-2xl bg-purple-50 dark:bg-purple-900/10 flex items-center justify-center p-4">
                                            <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                                <circle cx="75" cy="44" r="14" fill="#ede9fe" stroke="#c4b5fd" stroke-width="1.5" stroke-dasharray="4 3"/>
                                                <path d="M52 98 C53 78 75 78 75 78 C95 78 100 90 100 98" stroke="#c4b5fd" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-dasharray="4 3"/>
                                                <circle cx="48" cy="40" r="17" fill="white" stroke="#8b5cf6" stroke-width="2"/>
                                                <path d="M18 98 C20 74 48 74 48 74 C74 74 78 88 78 98" stroke="#8b5cf6" stroke-width="2" fill="none" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <p class="text-base font-bold text-gray-900 dark:text-white mb-1">No users found</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No registered users match the current criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-800 bg-white dark:bg-[#1e293b]">
                {{ $users->links() }}
            </div>
        </div>

        {{-- Role Update Confirmation Modal --}}
        <x-modal name="confirm-role-update" maxWidth="sm">
            <div class="p-6 bg-white dark:bg-[#1e293b]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-11 h-11 rounded-full bg-brand/10 dark:bg-indigo-900/30 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-900 dark:text-white font-outfit">Update User Role</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">This will change the user's access level.</p>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-slate-800/50 rounded-[10px] px-4 py-3 mb-5 text-sm text-gray-700 dark:text-gray-300">
                    Change <span class="font-bold" x-text="pendingName"></span>'s role to
                    <span class="font-bold text-brand dark:text-indigo-400 capitalize" x-text="pendingRole"></span>?
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-[10px] transition-colors">
                        Cancel
                    </button>
                    <button type="button" x-on:click="$dispatch('close'); if(pendingForm) pendingForm.submit()"
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-brand hover:bg-brand-light rounded-[10px] transition-all shadow-sm">
                        Update Role
                    </button>
                </div>
            </div>
        </x-modal>

        {{-- Assign Sub-Role Modal --}}
        <x-modal name="assign-sub-role" maxWidth="md">
            <div class="p-6 bg-white dark:bg-[#1e293b]">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-900 dark:text-white font-outfit">Assign Sub-Role</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Assign a permission set to <strong x-text="assignUserName"></strong></p>
                    </div>
                </div>

                <form method="POST"
                      x-bind:action="$el.dataset.actionTemplate.replace('__USER_ID__', assignUserId)"
                      data-action-template="{{ route('admin.sub-roles.assign', ['userId' => '__USER_ID__']) }}">
                    @csrf

                    <div class="space-y-2 max-h-[320px] overflow-y-auto mb-5">
                        @foreach($subRoles as $sr)
                            <label class="flex items-start gap-4 p-4 rounded-[12px] border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-brand/50 dark:hover:border-indigo-500/50 transition-colors has-[:checked]:border-brand has-[:checked]:bg-brand/5 dark:has-[:checked]:bg-indigo-900/20">
                                <input type="radio" name="sub_role_id" value="{{ $sr->id }}" class="mt-0.5 accent-brand">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $sr->name }}</p>
                                    @if($sr->description)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $sr->description }}</p>
                                    @endif
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach($sr->permissions as $p)
                                            <span class="text-[10px] px-1.5 py-0.5 bg-brand/10 dark:bg-indigo-900/30 text-brand dark:text-indigo-400 rounded font-semibold">
                                                {{ str_replace('_', ' ', $p->permission) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" x-on:click="$dispatch('close')"
                                class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-[10px] transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-semibold text-white bg-brand hover:bg-indigo-700 rounded-[10px] transition-colors shadow-sm">
                            Assign Sub-Role
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>

    </div>
@endsection
