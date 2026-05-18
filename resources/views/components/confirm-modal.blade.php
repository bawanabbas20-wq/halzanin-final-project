@props([
    'name',
    'title'       => 'Are you sure?',
    'description' => 'This action cannot be undone.',
    'type'        => 'danger',   // danger | warning | info | success
    'confirmLabel' => 'Confirm',
    'cancelLabel'  => 'Cancel',
    'icon'         => null,      // override icon type
])

@php
$themes = [
    'danger'  => ['ring' => 'bg-red-100 dark:bg-red-900/30',    'icon' => 'text-red-600 dark:text-red-400',   'btn' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500'],
    'warning' => ['ring' => 'bg-amber-100 dark:bg-amber-900/30', 'icon' => 'text-amber-600 dark:text-amber-400', 'btn' => 'bg-amber-500 hover:bg-amber-600 focus:ring-amber-400'],
    'info'    => ['ring' => 'bg-blue-100 dark:bg-blue-900/30',  'icon' => 'text-blue-600 dark:text-blue-400',  'btn' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'],
    'success' => ['ring' => 'bg-green-100 dark:bg-green-900/30','icon' => 'text-green-600 dark:text-green-400','btn' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500'],
];
$theme = $themes[$type] ?? $themes['danger'];

$icons = [
    'danger'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
    'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
    'info'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'logout'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>',
    'trash'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>',
];
$resolvedIcon = $icons[$icon ?? $type] ?? $icons['danger'];
@endphp

<x-modal :name="$name" maxWidth="sm">
    <div class="p-6" x-data>
        {{-- Icon --}}
        <div class="flex items-start gap-4 mb-5">
            <div class="w-11 h-11 rounded-full {{ $theme['ring'] }} flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 {{ $theme['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $resolvedIcon !!}
                </svg>
            </div>
            <div class="flex-1 min-w-0 pt-0.5">
                <h3 class="text-base font-bold text-gray-900 dark:text-white leading-tight mb-1">{{ $title }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $description }}</p>
            </div>
        </div>

        {{-- Optional slot for extra content (e.g. reason textarea) --}}
        @if ($slot->isNotEmpty())
            <div class="mb-5 border-t border-gray-100 dark:border-gray-800 pt-4">
                {{ $slot }}
            </div>
        @endif

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <button type="button"
                x-on:click="$dispatch('close-modal', '{{ $name }}')"
                class="px-4 py-2 text-sm font-semibold rounded-[10px] bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                {{ $cancelLabel }}
            </button>

            {{-- The confirm button dispatches a custom event so the parent can listen and act --}}
            <button type="button"
                x-on:click="$dispatch('confirmed-{{ $name }}'); $dispatch('close-modal', '{{ $name }}')"
                class="px-4 py-2 text-sm font-semibold rounded-[10px] text-white transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $theme['btn'] }}">
                {{ $confirmLabel }}
            </button>
        </div>
    </div>
</x-modal>
