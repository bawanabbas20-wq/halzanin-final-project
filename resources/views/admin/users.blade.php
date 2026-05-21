@extends('layouts.halzanin-app')

@section('content')
    <div class="max-w-6xl mx-auto pb-10"
         x-data="{ pendingForm: null, pendingName: '', pendingRole: '', assignSubRoleUserId: null }">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6 animate-fade-in">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="User Management">User Management</h2>
                    <span class="px-2.5 py-1 bg-brand/10 dark:bg-brand/10 text-brand dark:text-blue-400 text-sm font-bold rounded-xl">
                        {{ $users->total() }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-i18n="admin.users_subtitle">Manage user roles and access levels</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
               class="text-sm font-semibold text-gray-500 hover:text-brand dark:text-gray-400 dark:hover:text-blue-400 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span data-i18n="Back to Dashboard">Back to Dashboard</span>
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6 animate-fade-in flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl mb-6 animate-fade-in flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Users Table --}}
        <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay: 100ms">
            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 dark:bg-[#1F1F1F]/80 border-b border-gray-100 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="User">User</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Email">Email</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Role">Role</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sub-Roles</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-i18n="Registered">Registered</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ltr:text-right rtl:text-left" data-i18n="Actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                        @forelse ($users as $index => $user)
                            @php
                                $isSelf = $user->id === auth()->id();

                                $roleConfig = [
                                    'citizen' => ['badge' => 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-300', 'avatar' => 'bg-gray-400 dark:bg-slate-600'],
                                    'staff'   => ['badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400', 'avatar' => 'bg-blue-500'],
                                    'admin'   => ['badge' => 'bg-brand/5 text-brand dark:bg-brand/10 dark:text-blue-400', 'avatar' => 'bg-brand dark:bg-blue-600'],
                                ];
                                $rc = $roleConfig[$user->role] ?? $roleConfig['citizen'];
                            @endphp

                            <tr class="hover:bg-gray-50/70 dark:hover:bg-slate-800/50 transition-colors {{ $isSelf ? 'opacity-80' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3 rtl:space-x-reverse">
                                        <div class="w-10 h-10 rounded-full ring-2 ring-white dark:ring-[#1F1F1F] ring-offset-2 ring-offset-white dark:ring-offset-[#1F1F1F] flex items-center justify-center font-bold text-white uppercase shrink-0 text-sm {{ $rc['avatar'] }}">
                                            {{ mb_substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                {{ $user->name }}
                                                @if($isSelf)
                                                    <span class="px-1.5 py-0.5 bg-gray-100 dark:bg-slate-700 text-[10px] text-gray-500 dark:text-gray-400 rounded uppercase tracking-wider font-semibold" data-i18n="You">You</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full capitalize {{ $rc['badge'] }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role === 'staff')
                                        <div class="flex flex-wrap gap-1 max-w-[180px]">
                                            @forelse($user->subRoles as $sr)
                                                <span class="px-2 py-0.5 bg-brand/5 dark:bg-brand/10 text-brand dark:text-blue-400 text-[10px] font-bold rounded-full">{{ $sr->name }}</span>
                                            @empty
                                                <span class="text-[11px] text-gray-400 dark:text-gray-500 italic">Full access</span>
                                            @endforelse
                                            @if($taskTypes->isNotEmpty())
                                                <button type="button"
                                                        x-on:click="assignSubRoleUserId = {{ $user->id }}; $dispatch('open-modal', 'assign-sub-role')"
                                                        class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-full hover:bg-emerald-100 transition-colors">
                                                    + Assign
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-[11px] text-gray-400 dark:text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 ltr:text-right rtl:text-left">
                                    @if($isSelf)
                                        <span class="text-[11px] text-gray-400 dark:text-gray-500 italic uppercase tracking-wider font-semibold" data-i18n="Cannot change own role">Cannot change own role</span>
                                    @else
                                        <div class="flex flex-col gap-2 items-end">
                                            <form method="POST"
                                                  action="{{ route('admin.users.update-role', $user->id) }}"
                                                  data-user-name="{{ $user->name }}"
                                                  class="inline-flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role"
                                                        class="block w-28 h-[34px] text-xs font-semibold ltr:pl-3 ltr:pr-8 rtl:pr-3 rtl:pl-8 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 transition-all">
                                                    <option value="citizen" {{ $user->role === 'citizen' ? 'selected' : '' }}>Citizen</option>
                                                    <option value="staff"   {{ $user->role === 'staff'   ? 'selected' : '' }}>Staff</option>
                                                    <option value="admin"   {{ $user->role === 'admin'   ? 'selected' : '' }}>Admin</option>
                                                </select>
                                                <button type="button"
                                                        x-on:click="
                                                            pendingForm = $el.closest('form');
                                                            pendingName = pendingForm.dataset.userName;
                                                            pendingRole = pendingForm.querySelector('[name=role]').value;
                                                            $dispatch('open-modal', 'confirm-role-update')
                                                        "
                                                        class="h-[34px] px-3 bg-brand text-white text-xs font-semibold rounded-xl hover:bg-brand-light transition-colors shadow-sm">
                                                    <span data-i18n="Update">Update</span>
                                                </button>
                                            </form>

                                            @if($user->role === 'staff')
                                            <form method="POST"
                                                  action="{{ route('admin.users.update-ministry', $user->id) }}"
                                                  class="inline-flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="ministry_id"
                                                        class="block w-36 h-[34px] text-xs font-semibold ltr:pl-3 ltr:pr-8 rtl:pr-3 rtl:pl-8 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 transition-all">
                                                    <option value="">No Ministry</option>
                                                    @foreach($ministries as $ministry)
                                                        <option value="{{ $ministry->id }}" {{ $user->ministry_id === $ministry->id ? 'selected' : '' }}>
                                                            {{ $ministry->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit"
                                                        class="h-[34px] px-3 bg-gray-600 text-white text-xs font-semibold rounded-xl hover:bg-gray-700 transition-colors shadow-sm">
                                                    Assign
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-32 h-32 mb-5 rounded-2xl bg-purple-50 dark:bg-purple-900/10 flex items-center justify-center p-4">
                                            <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                                <circle cx="75" cy="44" r="14" fill="#ede9fe" stroke="#c4b5fd" stroke-width="1.5" stroke-dasharray="4 3"/>
                                                <path d="M52 98 C53 78 75 78 75 78 C95 78 100 90 100 98" stroke="#c4b5fd" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-dasharray="4 3"/>
                                                <circle cx="48" cy="40" r="17" fill="white" stroke="#8b5cf6" stroke-width="2"/>
                                                <path d="M18 98 C20 74 48 74 48 74 C74 74 78 88 78 98" stroke="#8b5cf6" stroke-width="2" fill="none" stroke-linecap="round"/>
                                                <circle cx="98" cy="28" r="14" fill="#f5f3ff"/>
                                                <circle cx="96" cy="26" r="7" stroke="#7c3aed" stroke-width="2" fill="none"/>
                                                <line x1="101" y1="31" x2="106" y2="36" stroke="#7c3aed" stroke-width="2.5" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <p class="text-base font-bold text-gray-900 dark:text-white mb-1" data-i18n="No users found">No users found</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400" data-i18n="No registered users match the current criteria.">No registered users match the current criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-[#1F1F1F]/50">
                {{ $users->links() }}
            </div>
        </div>

        {{-- Role Update Confirmation Modal --}}
        <x-modal name="confirm-role-update" maxWidth="sm">
            <div class="p-6 bg-white dark:bg-[#1F1F1F]">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-11 h-11 rounded-full bg-brand/10 dark:bg-brand/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-900 dark:text-white font-outfit" data-i18n="Update User Role">Update User Role</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5" data-i18n="admin.update_role_desc">This will change the user's access level.</p>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-slate-800/50 rounded-xl px-4 py-3 mb-5 text-sm text-gray-700 dark:text-gray-300">
                    Change <span class="font-bold" x-text="pendingName"></span>'s role to
                    <span class="font-bold text-brand dark:text-blue-400 capitalize" x-text="pendingRole"></span>?
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-xl transition-colors">
                        <span data-i18n="Cancel">Cancel</span>
                    </button>
                    <button type="button" x-on:click="$dispatch('close'); if(pendingForm) pendingForm.submit()"
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-brand hover:bg-brand-light rounded-xl transition-all shadow-sm">
                        <span data-i18n="Update Role">Update Role</span>
                    </button>
                </div>
            </div>
        </x-modal>

        {{-- Assign Sub-Role Modal --}}
        <x-modal name="assign-sub-role" maxWidth="sm">
            <div class="p-6 bg-white dark:bg-[#1F1F1F]">
                <h2 class="text-base font-bold text-gray-900 dark:text-white font-outfit mb-4">Assign Sub-Role</h2>
                @if($subRoles->isNotEmpty())
                    <form method="POST"
                          :action="'/admin/sub-roles/assign/' + assignSubRoleUserId">
                        @csrf
                        <div class="space-y-2 mb-4">
                            @foreach($subRoles as $sr)
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-800/50 cursor-pointer transition-colors">
                                    <input type="radio" name="sub_role_id" value="{{ $sr->id }}" class="mt-0.5 text-brand focus:ring-brand">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $sr->name }}</p>
                                        @if($sr->description)
                                            <p class="text-[11px] text-gray-400 dark:text-gray-500">{{ $sr->description }}</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')"
                                    class="px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 rounded-xl transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors">
                                Assign
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-sm text-gray-500 mb-4">No sub-roles created yet. <a href="{{ route('admin.sub-roles.create') }}" class="text-brand font-semibold hover:underline">Create one first.</a></p>
                    <button type="button" x-on:click="$dispatch('close')" class="w-full py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Close</button>
                @endif
            </div>
        </x-modal>

    </div>
@endsection
