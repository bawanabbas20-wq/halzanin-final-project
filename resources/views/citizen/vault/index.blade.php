@extends('layouts.halzanin-app')

@section('content')
<div class="space-y-6 lg:space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit" data-i18n="Document Vault">Document Vault</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1" data-i18n="Securely store your official documents.">Securely store your official documents.</p>
        </div>
        <a href="{{ route('citizen.vault.scan') }}" class="inline-flex items-center px-4 py-2 bg-brand text-white font-semibold text-sm rounded-[10px] shadow-sm hover:bg-brand-light transition-colors">
            <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span data-i18n="Scan Document">Scan Document</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-[10px] animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    @if($documents->isEmpty())
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 animate-fade-up">
            <x-empty-state
                type="no-uploads"
                title="Your vault is empty"
                description="Scan your passport or ID card to store it securely. Documents are encrypted and auto-delete after 100 days."
                actionLabel="Scan Document"
                actionRoute="{{ route('citizen.vault.scan') }}"
            />
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($documents as $doc)
                @php
                    $daysLeft = now()->diffInDays($doc->expires_at, false);
                    $expiresColor = $daysLeft < 10 ? 'text-red-500' : 'text-orange-500';
                @endphp
                <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-5 shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-indigo-50 text-brand dark:bg-indigo-900/30 dark:text-indigo-400">{{ $doc->document_type }}</span>
                            <span class="text-xs font-semibold {{ $expiresColor }}"><span data-i18n="Expires in">Expires in</span> {{ max(0, $daysLeft) }}d</span>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $doc->original_name }}</h3>
                        <p class="text-xs text-gray-500 mt-1"><span data-i18n="Scanned:">Scanned:</span> {{ $doc->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 flex flex-col space-y-2">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('citizen.vault.file', ['document' => $doc->id, 'format' => 'pdf']) }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-3 py-1.5 bg-gray-50 dark:bg-slate-700/50 hover:bg-gray-100 dark:hover:bg-slate-700 text-xs font-semibold text-gray-700 dark:text-gray-300 rounded-[8px] transition-colors border border-gray-200 dark:border-gray-600">
                                <span data-i18n="PDF">PDF</span>
                            </a>
                            <a href="{{ route('citizen.vault.file', ['document' => $doc->id, 'format' => 'image']) }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-3 py-1.5 bg-gray-50 dark:bg-slate-700/50 hover:bg-gray-100 dark:hover:bg-slate-700 text-xs font-semibold text-gray-700 dark:text-gray-300 rounded-[8px] transition-colors border border-gray-200 dark:border-gray-600">
                                <span data-i18n="Image">Image</span>
                            </a>
                        </div>
                        <form method="POST" action="{{ route('citizen.vault.destroy', $doc->id) }}" class="block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to permanently delete this document?')" class="w-full inline-flex justify-center items-center px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/10 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-[8px] transition-colors border border-red-100 dark:border-red-900/30" data-i18n="Delete Securely">
                                Delete Securely
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
