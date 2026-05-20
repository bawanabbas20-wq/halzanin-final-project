@extends('layouts.halzanin-app')

@section('content')
@php $existingPerms = $subRole->permissions->pluck('permission')->toArray(); @endphp
<div class="max-w-2xl mx-auto pb-10">

    <div class="flex items-center justify-between mb-6 animate-fade-in">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gradient">Edit Sub-Role</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update permissions for "{{ $subRole->name }}"</p>
        </div>
        <a href="{{ route('admin.sub-roles.index') }}"
           class="text-sm font-semibold text-gray-500 hover:text-brand dark:text-gray-400 dark:hover:text-indigo-400 transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
    </div>

    <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden animate-fade-up" style="animation-delay:100ms">
        <div class="h-1 bg-gradient-to-r from-brand via-indigo-500 to-accent"></div>
        <form method="POST" action="{{ route('admin.sub-roles.update', $subRole->id) }}" class="p-6 space-y-6">
            @csrf @method('PATCH')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Sub-Role Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $subRole->name) }}" required
                           class="block w-full h-[48px] px-4 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 transition-all">
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Description</label>
                    <textarea name="description" rows="2"
                              class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 transition-all resize-none">{{ old('description', $subRole->description) }}</textarea>
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Permissions</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($permissionsMap as $perm => $meta)
                        @php $checked = in_array($perm, old('permissions', $existingPerms)); @endphp
                        <label class="relative cursor-pointer select-none">
                            <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="peer sr-only" {{ $checked ? 'checked' : '' }}>
                            <div class="flex items-start gap-3 p-4 rounded-xl border-2 transition-all
                                        border-gray-200 dark:border-slate-700 bg-white dark:bg-[#0f172a]
                                        peer-checked:border-brand peer-checked:bg-brand/5 dark:peer-checked:bg-indigo-900/20 dark:peer-checked:border-indigo-500">
                                <div class="mt-0.5 w-5 h-5 rounded-md border-2 border-current flex items-center justify-center shrink-0 text-gray-300 dark:text-slate-600 peer-checked:text-brand transition-colors">
                                    <svg class="w-3 h-3 hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $meta['label'] }}</p>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">{{ $meta['desc'] }}</p>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100 dark:border-slate-800">
                <a href="{{ route('admin.sub-roles.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-xl transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-semibold rounded-xl shadow-sm transition-all hover:-translate-y-px">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.peer').forEach(cb => {
        const card = cb.nextElementSibling;
        const icon = card.querySelector('svg');
        const dot  = card.querySelector('div.mt-0\\.5');
        function refresh() {
            if (cb.checked) {
                dot.classList.add('text-brand','dark:text-indigo-400');
                dot.classList.remove('text-gray-300','dark:text-slate-600');
                icon.classList.remove('hidden');
            } else {
                dot.classList.remove('text-brand','dark:text-indigo-400');
                dot.classList.add('text-gray-300','dark:text-slate-600');
                icon.classList.add('hidden');
            }
        }
        refresh();
        cb.addEventListener('change', refresh);
    });
</script>
@endsection
