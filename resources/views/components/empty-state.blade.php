@props([
    'type' => 'no-documents',   // no-documents | no-results | no-uploads | approved | rejected
    'title' => null,
    'description' => null,
    'actionLabel' => null,
    'actionRoute' => null,
])

@php
$illustrations = [
    'no-documents' => [
        'bg'    => 'bg-indigo-50 dark:bg-indigo-900/20',
        'svg'   => <<<'SVG'
<svg viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
  <!-- Shadow -->
  <ellipse cx="80" cy="148" rx="48" ry="8" fill="#c7d2fe" opacity="0.35"/>
  <!-- Back document -->
  <rect x="58" y="28" width="62" height="82" rx="8" fill="#e0e7ff" transform="rotate(8 58 28)"/>
  <!-- Main document -->
  <rect x="38" y="22" width="68" height="90" rx="8" fill="white" stroke="#a5b4fc" stroke-width="1.5"/>
  <!-- Fold corner -->
  <path d="M88 22 L106 40 L88 40 Z" fill="#e0e7ff"/>
  <path d="M88 22 L106 40" stroke="#a5b4fc" stroke-width="1.5"/>
  <!-- Lines -->
  <rect x="50" y="52" width="44" height="5" rx="2.5" fill="#e0e7ff"/>
  <rect x="50" y="63" width="36" height="5" rx="2.5" fill="#e0e7ff"/>
  <rect x="50" y="74" width="28" height="5" rx="2.5" fill="#e0e7ff"/>
  <rect x="50" y="85" width="40" height="5" rx="2.5" fill="#e0e7ff"/>
  <!-- Plus circle badge -->
  <circle cx="112" cy="118" r="22" fill="#4f46e5"/>
  <circle cx="112" cy="118" r="22" fill="url(#plusGrad)"/>
  <line x1="112" y1="108" x2="112" y2="128" stroke="white" stroke-width="3" stroke-linecap="round"/>
  <line x1="102" y1="118" x2="122" y2="118" stroke="white" stroke-width="3" stroke-linecap="round"/>
  <defs>
    <radialGradient id="plusGrad" cx="0.35" cy="0.35">
      <stop offset="0%" stop-color="#818cf8"/>
      <stop offset="100%" stop-color="#4338ca"/>
    </radialGradient>
  </defs>
</svg>
SVG
    ],
    'no-results' => [
        'bg'    => 'bg-orange-50 dark:bg-orange-900/10',
        'svg'   => <<<'SVG'
<svg viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
  <!-- Shadow -->
  <ellipse cx="80" cy="148" rx="44" ry="7" fill="#fed7aa" opacity="0.4"/>
  <!-- Clipboard board -->
  <rect x="28" y="36" width="80" height="96" rx="9" fill="white" stroke="#e2e8f0" stroke-width="1.5"/>
  <!-- Clipboard clip -->
  <rect x="48" y="28" width="40" height="20" rx="10" fill="#dbeafe" stroke="#93c5fd" stroke-width="1.5"/>
  <rect x="58" y="33" width="20" height="10" rx="5" fill="white"/>
  <!-- Dashed lines -->
  <line x1="42" y1="62" x2="96" y2="62" stroke="#e2e8f0" stroke-width="3" stroke-linecap="round" stroke-dasharray="6 4"/>
  <line x1="42" y1="76" x2="88" y2="76" stroke="#e2e8f0" stroke-width="3" stroke-linecap="round" stroke-dasharray="6 4"/>
  <line x1="42" y1="90" x2="82" y2="90" stroke="#e2e8f0" stroke-width="3" stroke-linecap="round" stroke-dasharray="6 4"/>
  <!-- Search magnifier -->
  <circle cx="110" cy="112" r="22" fill="#fff7ed"/>
  <circle cx="106" cy="108" r="13" stroke="#f97316" stroke-width="2.5" fill="white"/>
  <line x1="115" y1="117" x2="126" y2="128" stroke="#f97316" stroke-width="3" stroke-linecap="round"/>
  <!-- X inside magnifier -->
  <line x1="101" y1="103" x2="111" y2="113" stroke="#f97316" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
  <line x1="111" y1="103" x2="101" y2="113" stroke="#f97316" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
</svg>
SVG
    ],
    'no-uploads' => [
        'bg'    => 'bg-sky-50 dark:bg-sky-900/10',
        'svg'   => <<<'SVG'
<svg viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
  <!-- Shadow -->
  <ellipse cx="80" cy="148" rx="44" ry="7" fill="#bae6fd" opacity="0.4"/>
  <!-- Cloud body -->
  <path d="M108 88 C108 72 96 60 80 60 C70 60 61 65 56 73 C52 71 47 71 43 74 C37 77 34 84 36 91 C38 98 45 103 53 103 H105 C113 103 120 96 120 88 Z" fill="#e0f2fe" stroke="#7dd3fc" stroke-width="1.5"/>
  <!-- Up arrow -->
  <line x1="80" y1="98" x2="80" y2="74" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round"/>
  <polyline points="72,82 80,74 88,82" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
  <!-- Document stack at bottom -->
  <rect x="50" y="112" width="60" height="32" rx="6" fill="#f0f9ff" stroke="#bae6fd" stroke-width="1.5"/>
  <rect x="42" y="118" width="60" height="26" rx="6" fill="white" stroke="#93c5fd" stroke-width="1.5"/>
  <line x1="52" y1="128" x2="92" y2="128" stroke="#bfdbfe" stroke-width="2.5" stroke-linecap="round"/>
  <line x1="52" y1="136" x2="80" y2="136" stroke="#bfdbfe" stroke-width="2.5" stroke-linecap="round"/>
</svg>
SVG
    ],
];

$data = $illustrations[$type] ?? $illustrations['no-documents'];
@endphp

<div class="flex flex-col items-center justify-center text-center py-8 px-4">
    <div class="w-44 h-44 mx-auto mb-6 rounded-2xl {{ $data['bg'] }} flex items-center justify-center p-5">
        {!! $data['svg'] !!}
    </div>

    @if($title)
        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $title }}</h4>
    @endif

    @if($description)
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto {{ $actionLabel ? 'mb-6' : '' }}">{{ $description }}</p>
    @endif

    @if($actionLabel && $actionRoute)
        <a href="{{ $actionRoute }}" class="inline-flex items-center px-5 py-2.5 bg-brand text-white text-sm font-semibold rounded-[10px] hover:bg-brand-light transition-colors shadow-sm">
            {{ $actionLabel }}
        </a>
    @endif
</div>
