<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-600 dark:text-red-400" data-i18n="Delete Account">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-sm text-red-500/80 dark:text-red-400/80" data-i18n="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 h-[48px] bg-red-600 text-white rounded-[10px] font-semibold font-outfit shadow-sm hover:bg-red-700 hover:-translate-y-[1px] transition-all"
        data-i18n="Delete Account"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white dark:bg-[#1e293b]">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900 dark:text-white" data-i18n="Are you sure you want to delete your account?">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" data-i18n="Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only" data-i18n="Password">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-3/4 h-[48px] rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-red-500 focus:ring-0 focus:shadow-[0_0_0_3px_rgba(239,68,68,0.2)] transition-all"
                    placeholder="{{ __('Password') }}"
                    data-i18n-placeholder="Password"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600" />
            </div>

            <div class="mt-6 flex justify-end space-x-3 rtl:space-x-reverse">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors" data-i18n="Cancel">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-6 h-[42px] bg-red-600 text-white rounded-[10px] font-semibold font-outfit shadow-sm hover:bg-red-700 transition-all" data-i18n="Delete Account">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
