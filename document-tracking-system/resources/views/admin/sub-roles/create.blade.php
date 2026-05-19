@extends('layouts.halzanin-app')

@section('content')
@php
    $permMeta = \App\Models\SubRole::PERMISSIONS;

    $permIcons = [
        'view_queue'                => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
        'confirm_appointments'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        'scan_qr_checkin'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>',
        'update_application_status' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
        'view_documents'            => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>',
        'verify_documents'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        'view_analytics'            => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
        'manage_off_days'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>',
    ];
@endphp
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-4 animate-fade-in">
        <a href="{{ route('admin.sub-roles.index') }}" class="p-2 rounded-[10px] text-gray-400 hover:text-brand dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">Create Sub-Role</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Define a named permission set for staff members</p>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-[10px]">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.sub-roles.store') }}" class="space-y-6">
        @csrf

        <!-- Basic Info -->
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-6 animate-fade-up" style="animation-delay:100ms">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 font-outfit">Basic Information</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Sub-Role Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g. Document Verifier, Reception Staff"
                           class="block w-full rounded-[10px] border-gray-200 dark:border-gray-700 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 text-sm h-[44px] px-4 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="2" placeholder="Optional description of this sub-role's responsibilities..."
                              class="block w-full rounded-[10px] border-gray-200 dark:border-gray-700 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 text-sm px-4 py-3 transition-colors resize-none">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Permissions Grid -->
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 p-6 animate-fade-up" style="animation-delay:150ms">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 font-outfit">Permissions</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Select which actions this sub-role is allowed to perform</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($allPermissions as $perm)
                    @php
                        $meta  = $permMeta[$perm];
                        $icon  = $permIcons[$perm];
                        $old   = old('permissions', []);
                        $checked = in_array($perm, $old);
                    @endphp
                    <label class="permission-card relative flex items-start gap-4 p-4 rounded-[12px] border-2 cursor-pointer transition-all select-none
                                  {{ $checked ? 'border-brand bg-brand/5 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f172a] hover:border-gray-300 dark:hover:border-gray-600' }}"
                           data-perm="{{ $perm }}">
                        <input type="checkbox" name="permissions[]" value="{{ $perm }}"
                               class="sr-only perm-checkbox" {{ $checked ? 'checked' : '' }}>

                        <!-- Icon -->
                        <div class="shrink-0 w-10 h-10 rounded-[10px] flex items-center justify-center transition-colors
                                    {{ $checked ? 'bg-brand text-white' : 'bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-gray-400' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                        </div>

                        <!-- Text -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold {{ $checked ? 'text-brand dark:text-indigo-400' : 'text-gray-900 dark:text-white' }}">{{ $meta['label'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $meta['desc'] }}</p>
                        </div>

                        <!-- Checkmark -->
                        <div class="shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all
                                    {{ $checked ? 'border-brand bg-brand' : 'border-gray-300 dark:border-gray-600' }}">
                            @if($checked)
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 animate-fade-up" style="animation-delay:200ms">
            <a href="{{ route('admin.sub-roles.index') }}"
               class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-[10px] transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-brand hover:bg-indigo-700 rounded-[10px] shadow-sm transition-colors">
                Create Sub-Role
            </button>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.permission-card').forEach(card => {
    card.addEventListener('click', function() {
        const cb    = this.querySelector('.perm-checkbox');
        cb.checked  = !cb.checked;

        const icon  = this.querySelector('.shrink-0.w-10');
        const title = this.querySelector('p.font-bold');
        const check = this.querySelector('.shrink-0.w-5');

        if (cb.checked) {
            this.classList.add('border-brand', 'bg-brand/5', 'dark:bg-indigo-900/20');
            this.classList.remove('border-gray-200', 'dark:border-gray-700', 'bg-white', 'dark:bg-[#0f172a]', 'hover:border-gray-300', 'dark:hover:border-gray-600');
            icon.classList.add('bg-brand', 'text-white');
            icon.classList.remove('bg-gray-100', 'dark:bg-slate-800', 'text-gray-500', 'dark:text-gray-400');
            title.classList.add('text-brand', 'dark:text-indigo-400');
            title.classList.remove('text-gray-900', 'dark:text-white');
            check.classList.add('border-brand', 'bg-brand');
            check.classList.remove('border-gray-300', 'dark:border-gray-600');
            check.innerHTML = '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
        } else {
            this.classList.remove('border-brand', 'bg-brand/5', 'dark:bg-indigo-900/20');
            this.classList.add('border-gray-200', 'dark:border-gray-700', 'bg-white', 'dark:bg-[#0f172a]', 'hover:border-gray-300', 'dark:hover:border-gray-600');
            icon.classList.remove('bg-brand', 'text-white');
            icon.classList.add('bg-gray-100', 'dark:bg-slate-800', 'text-gray-500', 'dark:text-gray-400');
            title.classList.remove('text-brand', 'dark:text-indigo-400');
            title.classList.add('text-gray-900', 'dark:text-white');
            check.classList.remove('border-brand', 'bg-brand');
            check.classList.add('border-gray-300', 'dark:border-gray-600');
            check.innerHTML = '';
        }
    });
});
</script>
@endsection
