<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Documents</h2>
            <a href="{{ route('citizen.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- Context banner --}}
            <div class="mb-6 bg-indigo-50 border border-indigo-200 rounded-lg px-5 py-4">
                <p class="text-sm text-indigo-700">
                    Uploading documents for application
                    <span class="font-bold font-mono tracking-widest">{{ $application->tracking_code }}</span>
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-4 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Requirements Checklist</h3>
                    <p class="mt-1 text-xs text-gray-500">Check each box to confirm you have prepared the document, then select the file. All 3 must be checked before you can submit.</p>
                </div>

                <form method="POST"
                      action="{{ route('citizen.documents.store', $application->id) }}"
                      enctype="multipart/form-data"
                      id="upload-form"
                      class="p-6 space-y-6">
                    @csrf

                    {{-- National ID --}}
                    <div class="border rounded-lg p-4 space-y-3">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" id="check_national_id" class="doc-check h-4 w-4 text-indigo-600 border-gray-300 rounded cursor-pointer">
                            <label for="check_national_id" class="font-medium text-gray-800 cursor-pointer">National ID</label>
                        </div>
                        <div id="file_national_id_wrap" class="hidden">
                            <x-input-label for="national_id_file" :value="__('Upload National ID (JPG, PNG, PDF — max 2MB)')" />
                            <input id="national_id_file" name="national_id_file" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <x-input-error :messages="$errors->get('national_id_file')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Passport Photo --}}
                    <div class="border rounded-lg p-4 space-y-3">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" id="check_passport_photo" class="doc-check h-4 w-4 text-indigo-600 border-gray-300 rounded cursor-pointer">
                            <label for="check_passport_photo" class="font-medium text-gray-800 cursor-pointer">Passport Photo</label>
                        </div>
                        <div id="file_passport_photo_wrap" class="hidden">
                            <x-input-label for="passport_photo" :value="__('Upload Passport Photo (JPG, PNG, PDF — max 2MB)')" />
                            <input id="passport_photo" name="passport_photo" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <x-input-error :messages="$errors->get('passport_photo')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Birth Certificate --}}
                    <div class="border rounded-lg p-4 space-y-3">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" id="check_birth_cert" class="doc-check h-4 w-4 text-indigo-600 border-gray-300 rounded cursor-pointer">
                            <label for="check_birth_cert" class="font-medium text-gray-800 cursor-pointer">Birth Certificate</label>
                        </div>
                        <div id="file_birth_cert_wrap" class="hidden">
                            <x-input-label for="birth_certificate" :value="__('Upload Birth Certificate (JPG, PNG, PDF — max 2MB)')" />
                            <input id="birth_certificate" name="birth_certificate" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <x-input-error :messages="$errors->get('birth_certificate')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <p id="checklist-hint" class="text-sm text-gray-400">Check all 3 boxes to enable submission.</p>
                        <x-primary-button id="submit-btn" disabled class="opacity-50 cursor-not-allowed">
                            Submit Documents
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checks   = document.querySelectorAll('.doc-check');
            const submitBtn = document.getElementById('submit-btn');
            const hint      = document.getElementById('checklist-hint');

            // Toggle file input visibility when checkbox changes
            const pairs = [
                { check: 'check_national_id',   wrap: 'file_national_id_wrap' },
                { check: 'check_passport_photo', wrap: 'file_passport_photo_wrap' },
                { check: 'check_birth_cert',     wrap: 'file_birth_cert_wrap' },
            ];

            pairs.forEach(({ check, wrap }) => {
                document.getElementById(check).addEventListener('change', function () {
                    const wrapEl = document.getElementById(wrap);
                    wrapEl.classList.toggle('hidden', !this.checked);
                    updateSubmitState();
                });
            });

            function updateSubmitState() {
                const allChecked = Array.from(checks).every(c => c.checked);
                submitBtn.disabled = !allChecked;
                submitBtn.classList.toggle('opacity-50', !allChecked);
                submitBtn.classList.toggle('cursor-not-allowed', !allChecked);
                hint.textContent = allChecked
                    ? 'All items confirmed — you can now submit.'
                    : 'Check all 3 boxes to enable submission.';
                hint.classList.toggle('text-green-600', allChecked);
                hint.classList.toggle('text-gray-400', !allChecked);
            }
        });
    </script>
</x-app-layout>
