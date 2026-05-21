<x-halzanin-auth-layout>
    <x-slot name="illustration">
        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl">
            <path d="M80 260C30 260 10 210 25 145C40 80 100 30 180 25C260 20 330 70 355 140C380 210 310 260 230 260C180 260 130 260 80 260Z" fill="#312e81" opacity="0.25"/>
            <!-- Envelope -->
            <rect x="100" y="90" width="200" height="140" rx="12" fill="#fff" stroke="#1B4F8A" stroke-width="4"/>
            <path d="M100 102l100 72 100-72" stroke="#1B4F8A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            <!-- Shield checkmark -->
            <circle cx="280" cy="200" r="36" fill="#1B4F8A"/>
            <path d="M265 200l10 10 20-20" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            <!-- Dots -->
            <circle cx="80" cy="80" r="10" fill="#059669" opacity="0.7"/>
            <circle cx="330" cy="55" r="14" fill="#059669" opacity="0.5"/>
        </svg>
    </x-slot>

    <div class="w-full">
        <h2 class="text-[22px] font-bold text-brand dark:text-white mb-2 font-outfit">Check your email</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            We sent a 6-digit code to <strong class="text-gray-700 dark:text-gray-200">{{ Auth::user()->email }}</strong>.<br>
            Enter it below to verify your account.
        </p>

        @if(session('resent'))
            <div class="mb-4 p-3 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-sm">
                A new code has been sent to your email.
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-sm">
                {{ $errors->first('otp') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify.submit') }}" id="otp-form" class="space-y-6">
            @csrf

            <!-- 6 digit inputs -->
            <div class="flex gap-2 justify-center" id="otp-inputs">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" inputmode="numeric" maxlength="1" pattern="\d"
                           class="otp-digit w-12 h-14 text-center text-2xl font-bold rounded-xl border-2 border-gray-300 dark:border-gray-600 dark:bg-[#141414] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_rgba(27,79,138,0.2)] transition-all duration-150"
                           autocomplete="off" />
                @endfor
                <input type="hidden" name="otp" id="otp-hidden">
            </div>

            <button type="submit" id="verify-btn"
                    class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-[#1F1F1F] disabled:opacity-50 disabled:cursor-not-allowed disabled:translate-y-0"
                    disabled>
                Verify
            </button>
        </form>

        <!-- Resend -->
        <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Didn't receive the code?
            <form method="POST" action="{{ route('otp.resend') }}" class="inline" id="resend-form">
                @csrf
                <button type="submit" id="resend-btn"
                        class="font-semibold text-brand dark:text-indigo-400 hover:underline disabled:opacity-40 disabled:no-underline disabled:cursor-not-allowed">
                    Resend code <span id="resend-timer" class="text-gray-400 font-normal"></span>
                </button>
            </form>
        </div>
    </div>

    <script>
    (function () {
        var inputs   = document.querySelectorAll('.otp-digit');
        var hidden   = document.getElementById('otp-hidden');
        var btn      = document.getElementById('verify-btn');
        var resendBtn = document.getElementById('resend-btn');
        var timerEl  = document.getElementById('resend-timer');

        // Auto-advance and collect value
        inputs.forEach(function (inp, idx) {
            inp.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(-1);
                if (this.value && idx < inputs.length - 1) {
                    inputs[idx + 1].focus();
                }
                syncHidden();
            });

            inp.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value && idx > 0) {
                    inputs[idx - 1].focus();
                }
            });

            inp.addEventListener('paste', function (e) {
                e.preventDefault();
                var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
                pasted.split('').forEach(function (ch, i) {
                    if (inputs[i]) inputs[i].value = ch;
                });
                syncHidden();
                var last = Math.min(pasted.length, inputs.length - 1);
                inputs[last].focus();
            });
        });

        function syncHidden() {
            var val = '';
            inputs.forEach(function (i) { val += i.value; });
            hidden.value = val;
            btn.disabled = val.length < 6;
        }

        // Resend countdown — 60 seconds
        var countdown = 60;
        resendBtn.disabled = true;

        var timer = setInterval(function () {
            countdown--;
            timerEl.textContent = '(' + countdown + 's)';
            if (countdown <= 0) {
                clearInterval(timer);
                timerEl.textContent = '';
                resendBtn.disabled = false;
            }
        }, 1000);

        timerEl.textContent = '(60s)';
        inputs[0].focus();
    })();
    </script>
</x-halzanin-auth-layout>
