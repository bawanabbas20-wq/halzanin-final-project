@extends('layouts.halzanin-app')

@section('content')
<div class="space-y-6 lg:space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between animate-fade-in">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gradient" data-i18n="vault.title">Document Vault</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1" data-i18n="vault.subtitle">Securely store your official documents.</p>
        </div>
        <a href="{{ route('citizen.vault.scan') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand text-white font-semibold text-sm rounded-xl shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-0.5 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span data-i18n="vault.scan">Scan Document</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl animate-fade-in flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($documents->isEmpty())
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up">
            <x-empty-state
                type="no-uploads"
                title="Your vault is empty"
                titleKey="vault.empty_title"
                description="Scan your passport or ID card to store it securely. Documents are encrypted and auto-delete after 100 days."
                descriptionKey="vault.empty_desc"
                actionLabel="Scan Document"
                actionKey="vault.scan"
                actionRoute="{{ route('citizen.vault.scan') }}"
            />
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 animate-fade-up" style="animation-delay: 100ms">
            @foreach ($documents as $index => $doc)
                @php
                    $daysLeft     = now()->diffInDays($doc->expires_at, false);
                    $isUrgent     = $daysLeft < 10;
                    $isWarning    = $daysLeft < 30 && !$isUrgent;
                    $barWidth     = min(100, max(0, ($daysLeft / 100) * 100));
                    $barColor     = $isUrgent ? 'bg-red-500' : ($isWarning ? 'bg-orange-400' : 'bg-emerald-500');
                    $expiresColor = $isUrgent ? 'text-red-500 dark:text-red-400' : 'text-orange-500 dark:text-orange-400';
                    $stripColor   = $isUrgent ? 'from-red-400 to-red-500' : ($isWarning ? 'from-orange-400 to-amber-400' : 'from-brand via-indigo-500 to-accent');
                @endphp
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col hover-lift animate-fade-up"
                     style="animation-delay: {{ $index * 80 }}ms">

                    {{-- Gradient top strip --}}
                    <div class="h-1 bg-gradient-to-r {{ $stripColor }}"></div>

                    <div class="p-5 flex flex-col flex-1">
                        {{-- Type badge + expiry --}}
                        <div class="flex items-start justify-between mb-3">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-indigo-50 text-brand dark:bg-indigo-900/30 dark:text-indigo-400">
                                {{ $doc->document_type }}
                            </span>
                            <div class="flex items-center gap-1 {{ $expiresColor }}">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs font-bold">
                                    <span data-i18n="vault.expires_in">Expires in</span> {{ max(0, $daysLeft) }}d
                                </span>
                            </div>
                        </div>

                        {{-- File name + scan date --}}
                        <h3 class="font-bold text-gray-900 dark:text-white mb-0.5 truncate">{{ $doc->original_name }}</h3>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-3">
                            <span data-i18n="vault.scanned">Scanned:</span> {{ $doc->created_at->format('M d, Y') }}
                        </p>

                        {{-- Expiry progress bar --}}
                        <div class="mb-4">
                            <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-slate-700 overflow-hidden">
                                <div class="h-full rounded-full {{ $barColor }} transition-all" style="width: {{ $barWidth }}%"></div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-auto space-y-2">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('citizen.vault.file', ['document' => $doc->id, 'format' => 'pdf']) }}"
                                   target="_blank"
                                   class="flex-1 inline-flex justify-center items-center gap-1.5 px-3 py-2 bg-gray-50 dark:bg-slate-700/50 hover:bg-gray-100 dark:hover:bg-slate-700 text-xs font-semibold text-gray-700 dark:text-gray-300 rounded-xl transition-colors border border-gray-200 dark:border-gray-600">
                                    <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <span data-i18n="vault.pdf">PDF</span>
                                </a>
                                <a href="{{ route('citizen.vault.file', ['document' => $doc->id, 'format' => 'image']) }}"
                                   target="_blank"
                                   class="flex-1 inline-flex justify-center items-center gap-1.5 px-3 py-2 bg-gray-50 dark:bg-slate-700/50 hover:bg-gray-100 dark:hover:bg-slate-700 text-xs font-semibold text-gray-700 dark:text-gray-300 rounded-xl transition-colors border border-gray-200 dark:border-gray-600">
                                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span data-i18n="vault.image">Image</span>
                                </a>
                            </div>
                            <form method="POST" action="{{ route('citizen.vault.destroy', $doc->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to permanently delete this document?')"
                                        class="w-full inline-flex justify-center items-center gap-1.5 px-3 py-2 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/10 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-xl transition-colors border border-red-100 dark:border-red-900/30"
                                        data-i18n="vault.delete_securely">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete Securely
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
