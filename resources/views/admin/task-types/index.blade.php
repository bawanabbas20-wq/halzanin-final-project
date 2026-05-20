@extends('layouts.halzanin-app')

@section('content')
<div class="max-w-5xl mx-auto pb-10 space-y-6" x-data="{ showForm: false, deletingId: null }">

    <div class="flex items-center justify-between animate-fade-in">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gradient">Task Types</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Work categories for staff assignment</p>
        </div>
        <button x-on:click="showForm = !showForm"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-semibold rounded-xl shadow-brand-btn transition-all hover:-translate-y-px">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Task Type
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Create form --}}
    <div x-show="showForm" x-transition class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
        <form method="POST" action="{{ route('admin.task-types.store') }}" class="p-6 flex flex-col sm:flex-row gap-4 items-end">
            @csrf
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Name</label>
                <input type="text" name="name" required placeholder="e.g. NIC Processing" value="{{ old('name') }}"
                       class="block w-full h-[44px] px-4 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0">
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Color</label>
                <select name="color" class="block h-[44px] px-3 pr-8 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 text-sm">
                    @foreach(['indigo','green','blue','amber','rose','purple'] as $c)
                        <option value="{{ $c }}" {{ old('color') === $c ? 'selected' : '' }}>{{ ucfirst($c) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="h-[44px] px-6 bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand-light transition-colors shrink-0">Create</button>
        </form>
    </div>

    {{-- Task types list --}}
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay:100ms">
        <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-50 dark:bg-slate-800/60 border-b border-gray-100 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Staff Assigned</th>
                        <th class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($taskTypes as $tt)
                        <tr class="hover:bg-gray-50/70 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $tt->colorClasses() }}">{{ $tt->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $tt->staff_count }} staff member{{ $tt->staff_count !== 1 ? 's' : '' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('admin.task-types.destroy', $tt->id) }}"
                                      onsubmit="return confirm('Delete task type \'{{ addslashes($tt->name) }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700 dark:text-red-400 hover:underline transition-colors">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-10 text-center text-sm text-gray-400">No task types yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Staff Assignment --}}
    @if($staffUsers->isNotEmpty())
    <div class="bg-white dark:bg-[#1F1F1F] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay:200ms">
        <div class="h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800">
            <h3 class="font-bold text-gray-900 dark:text-white text-sm">Staff Task Type Assignments</h3>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-slate-800">
            @foreach($staffUsers as $staff)
            <div class="px-6 py-4 flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm uppercase shrink-0">
                        {{ mb_substr($staff->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900 dark:text-white">{{ $staff->name }}</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @forelse($staff->taskTypes as $tt)
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $tt->colorClasses() }}">{{ $tt->name }}</span>
                            @empty
                                <span class="text-[11px] text-gray-400 italic">No task types assigned</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.users.update-task-types', $staff->id) }}" class="flex items-center gap-2">
                    @csrf @method('PATCH')
                    @foreach($taskTypes as $tt)
                        <label class="inline-flex items-center gap-1 cursor-pointer">
                            <input type="checkbox" name="task_type_ids[]" value="{{ $tt->id }}"
                                   {{ $staff->taskTypes->contains('id', $tt->id) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-brand focus:ring-brand">
                            <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">{{ $tt->name }}</span>
                        </label>
                    @endforeach
                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold bg-brand text-white rounded-xl hover:bg-brand-light transition-colors">Save</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
