@props(['inputId' => 'password'])
{{-- Password Strength Indicator — attach to any password input via inputId prop --}}

<div id="pw-strength-{{ $inputId }}" class="hidden mt-3 space-y-2">
    {{-- 4-segment bar + label --}}
    <div class="flex items-center gap-3">
        <div class="flex flex-1 gap-1.5">
            <div class="pw-bar h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-slate-700 transition-colors duration-300"></div>
            <div class="pw-bar h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-slate-700 transition-colors duration-300"></div>
            <div class="pw-bar h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-slate-700 transition-colors duration-300"></div>
            <div class="pw-bar h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-slate-700 transition-colors duration-300"></div>
        </div>
        <span id="pw-label-{{ $inputId }}" class="text-[11px] font-bold w-14 text-right shrink-0"></span>
    </div>

    {{-- Requirements checklist --}}
    <ul class="grid grid-cols-2 gap-x-3 gap-y-1 pt-0.5">
        @foreach([
            'length'  => '8+ characters',
            'upper'   => 'Uppercase letter',
            'lower'   => 'Lowercase letter',
            'number'  => 'Number',
            'special' => 'Special character',
        ] as $key => $label)
        <li data-req="{{ $key }}"
            class="pw-req flex items-center gap-1.5 text-[11px] text-gray-400 dark:text-gray-500 transition-colors">
            <svg class="req-icon w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" stroke-width="2"/>
            </svg>
            <span>{{ $label }}</span>
        </li>
        @endforeach
    </ul>
</div>

<script>
(function () {
    const inputId   = @js($inputId);
    const input     = document.getElementById(inputId);
    const container = document.getElementById('pw-strength-' + inputId);
    const label     = document.getElementById('pw-label-' + inputId);
    const bars      = container.querySelectorAll('.pw-bar');
    const reqs      = container.querySelectorAll('.pw-req');

    if (!input) return;

    const LEVELS = [
        { bars: 1, barColor: 'bg-red-500',    labelText: 'Too weak', labelColor: 'text-red-500'    },
        { bars: 1, barColor: 'bg-red-500',    labelText: 'Too weak', labelColor: 'text-red-500'    },
        { bars: 2, barColor: 'bg-orange-400', labelText: 'Weak',     labelColor: 'text-orange-400' },
        { bars: 3, barColor: 'bg-yellow-500', labelText: 'Fair',     labelColor: 'text-yellow-500' },
        { bars: 4, barColor: 'bg-blue-500',   labelText: 'Good',     labelColor: 'text-blue-500'   },
        { bars: 4, barColor: 'bg-green-500',  labelText: 'Strong!',  labelColor: 'text-green-500'  },
    ];

    const CHECK_PATH  = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>';
    const CIRCLE_PATH = '<circle cx="12" cy="12" r="9" stroke-width="2"/>';

    function evaluate(val) {
        return {
            length:  val.length >= 8,
            upper:   /[A-Z]/.test(val),
            lower:   /[a-z]/.test(val),
            number:  /[0-9]/.test(val),
            special: /[^A-Za-z0-9]/.test(val),
        };
    }

    input.addEventListener('input', function () {
        const val = this.value;
        if (!val) { container.classList.add('hidden'); return; }
        container.classList.remove('hidden');

        const checks = evaluate(val);
        const score  = Object.values(checks).filter(Boolean).length;
        const level  = LEVELS[score];

        bars.forEach(function (bar, i) {
            bar.className = 'pw-bar h-1.5 flex-1 rounded-full transition-colors duration-300 ' +
                (i < level.bars ? level.barColor : 'bg-gray-200 dark:bg-slate-700');
        });

        label.textContent = level.labelText;
        label.className   = 'text-[11px] font-bold w-14 text-right shrink-0 transition-colors ' + level.labelColor;

        reqs.forEach(function (req) {
            const met  = checks[req.dataset.req];
            const icon = req.querySelector('.req-icon');
            icon.innerHTML = met ? CHECK_PATH : CIRCLE_PATH;
            req.className  = 'pw-req flex items-center gap-1.5 text-[11px] transition-colors ' +
                (met ? 'text-green-500 dark:text-green-400' : 'text-gray-400 dark:text-gray-500');
        });
    });
})();
</script>
