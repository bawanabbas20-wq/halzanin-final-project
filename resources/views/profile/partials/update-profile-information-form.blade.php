<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900 dark:text-white" data-i18n="profile.info">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" data-i18n="profile.info_desc">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1" data-i18n="profile.name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="block w-full h-[48px] rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="phone_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1" data-i18n="profile.phone">
                {{ __('Phone Number (WhatsApp)') }} 🇮🇶
            </label>
            <input id="phone_number" name="phone_number" type="tel" placeholder="07XX XXX XXXX" class="block w-full h-[48px] rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all" value="{{ old('phone_number', $user->phone_number) }}" autocomplete="tel" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" data-i18n="profile.phone_help">Required to receive WhatsApp updates about your applications.</p>
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1" data-i18n="profile.email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="block w-full h-[48px] rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-300" data-i18n="profile.unverified">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-brand dark:text-indigo-400 hover:text-brand-light rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand" data-i18n="profile.resend">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400" data-i18n="profile.verification_sent">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 h-[48px] bg-brand text-white rounded-[10px] font-semibold font-outfit shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all" data-i18n="profile.save_changes">
                {{ __('Save Changes') }}
            </button>
        </div>
    </form>
</section>
