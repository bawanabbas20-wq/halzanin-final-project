@extends('layouts.halzanin-app')

@section('content')
    <div class="max-w-6xl mx-auto pb-10">
        
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
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 dark:bg-slate-800 border-b border-gray-100 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
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
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 ltr:text-right rtl:text-left">
                                    @if($isSelf)
                                        <span class="text-[11px] text-gray-400 dark:text-gray-500 italic uppercase tracking-wider font-semibold">Cannot change own role</span>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.update-role', $user->id) }}" class="inline-flex items-center space-x-2 rtl:space-x-reverse">
                                            @csrf
                                            @method('PATCH')
                                            <div class="relative">
                                                <select name="role"
                                                    class="block w-32 h-[34px] text-xs font-semibold ltr:pl-3 ltr:pr-8 rtl:pr-3 rtl:pl-8 rounded-[8px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all">
                                                    <option value="citizen" {{ $user->role === 'citizen' ? 'selected' : '' }}>Citizen</option>
                                                    <option value="staff"   {{ $user->role === 'staff'   ? 'selected' : '' }}>Staff</option>
                                                    <option value="admin"   {{ $user->role === 'admin'   ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </div>
                                            <button type="submit"
                                                class="h-[34px] px-3 bg-brand text-white text-xs font-semibold rounded-[8px] hover:bg-brand-light transition-colors shadow-sm">
                                                Update
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-800 bg-white dark:bg-[#1e293b]">
                {{ $users->links() }}
            </div>
        </div>

    </div>
@endsection
