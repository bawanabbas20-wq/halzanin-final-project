@extends('layouts.halzanin-app')

@section('content')
    <div class="w-full max-w-[560px] mx-auto">
        <div class="bg-white dark:bg-[#1e293b] rounded-[16px] p-6 lg:p-8 shadow-[0_10px_15px_rgba(0,0,0,0.08)] relative overflow-hidden">
            
            <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit text-center mb-8">Book Appointment</h2>

            <!-- Step Indicator -->
            <div class="relative flex justify-between mb-10">
                <!-- Lines -->
                <div class="absolute top-4 left-0 w-full h-0.5 bg-gray-200 dark:bg-gray-700 -z-10"></div>
                <div id="progress-line" class="absolute top-4 left-0 h-0.5 bg-accent transition-all duration-300 -z-10 w-0"></div>

                <!-- Step 1 Indicator -->
                <div class="flex flex-col items-center w-1/3">
                    <div id="indicator-1" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-brand text-white shadow-md">
                        <span class="step-num">1</span>
                        <svg class="step-check hidden w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-xs font-semibold mt-2 text-brand dark:text-indigo-400 text-center">Personal Info</span>
                </div>

                <!-- Step 2 Indicator -->
                <div class="flex flex-col items-center w-1/3">
                    <div id="indicator-2" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-white dark:bg-[#1e293b] border-2 border-gray-300 dark:border-gray-600 text-gray-400">
                        <span class="step-num">2</span>
                        <svg class="step-check hidden w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-xs font-semibold mt-2 text-gray-400 text-center">Appointment<br>Details</span>
                </div>

                <!-- Step 3 Indicator -->
                <div class="flex flex-col items-center w-1/3">
                    <div id="indicator-3" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-white dark:bg-[#1e293b] border-2 border-gray-300 dark:border-gray-600 text-gray-400">
                        <span class="step-num">3</span>
                    </div>
                    <span class="text-xs font-semibold mt-2 text-gray-400 text-center">Review</span>
                </div>
            </div>

            <!-- Form Wrapper -->
            <div class="relative overflow-hidden w-full">
                <form method="POST" action="{{ route('citizen.appointment.store') }}" id="appointment-form" 
                      class="flex transition-transform duration-300 ease-in-out w-[300%]"
                      x-data="{ confirmed: false }" 
                      @submit.prevent="if(!confirmed) { $dispatch('open-modal', 'confirm-appointment') } else { $el.submit() }">
                    @csrf

                    <!-- STEP 1: Personal Info -->
                    <div class="w-1/3 shrink-0 px-1" id="step-1">
                        <div class="space-y-4">
                            <!-- Full Name -->
                            <div class="relative">
                                <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 mt-6 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input id="full_name" type="text" name="full_name" value="{{ old('full_name', session('appointment_draft.full_name')) }}" required
                                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all">
                                <x-input-error :messages="$errors->get('full_name')" class="mt-1" />
                            </div>

                            <!-- National ID -->
                            <div class="relative">
                                <label for="national_id_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">National ID Number</label>
                                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 mt-6 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <input id="national_id_number" type="text" name="national_id_number" value="{{ old('national_id_number', session('appointment_draft.national_id_number')) }}" required
                                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all">
                                <x-input-error :messages="$errors->get('national_id_number')" class="mt-1" />
                            </div>

                            <div class="pt-6">
                                <button type="button" onclick="nextStep(2)" class="w-full h-[52px] bg-brand text-white rounded-[10px] font-semibold shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all">
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Appointment Details -->
                    <div class="w-1/3 shrink-0 px-1" id="step-2">
                        <div class="space-y-4">
                            <!-- Preferred Date -->
                            <div class="relative">
                                <label for="preferred_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Preferred Date</label>
                                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 mt-6 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input id="preferred_date" type="date" name="preferred_date" value="{{ old('preferred_date', session('appointment_draft.preferred_date')) }}" required
                                       class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all">
                                <x-input-error :messages="$errors->get('preferred_date')" class="mt-1" />
                            </div>

                            <!-- Time Slot -->
                            <div class="relative">
                                <label for="time_slot" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Time Slot</label>
                                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 mt-6 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <select id="time_slot" name="time_slot" required class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all">
                                    <option value="">Select a time slot</option>
                                    @foreach(['9:00 AM', '10:00 AM', '11:00 AM', '2:00 PM', '3:00 PM'] as $slot)
                                        <option value="{{ $slot }}" {{ old('time_slot', session('appointment_draft.time_slot')) == $slot ? 'selected' : '' }}>
                                            {{ $slot }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('time_slot')" class="mt-1" />
                            </div>

                            <!-- Document Type -->
                            <div class="relative">
                                <label for="document_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Document Type</label>
                                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 mt-6 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <select id="document_type" name="document_type" required class="block w-full h-[48px] ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all">
                                    <option value="">Select document type</option>
                                    @foreach(['Passport Renewal', 'New Passport', 'ID Card', 'Birth Certificate', 'Other'] as $docType)
                                        <option value="{{ $docType }}" {{ old('document_type', session('appointment_draft.document_type')) == $docType ? 'selected' : '' }}>
                                            {{ $docType }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('document_type')" class="mt-1" />
                            </div>

                            <!-- Notes -->
                            <div class="relative">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes (Optional)</label>
                                <div class="absolute top-0 ltr:left-0 rtl:right-0 mt-9 flex items-center ltr:pl-4 rtl:pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </div>
                                <textarea id="notes" name="notes" rows="3" class="block w-full ltr:pl-11 rtl:pr-11 rtl:pl-4 ltr:pr-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0 focus:shadow-[0_0_0_3px_#e0e7ff] dark:focus:shadow-[0_0_0_3px_rgba(49,46,129,0.5)] transition-all">{{ old('notes', session('appointment_draft.notes')) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                            </div>

                            <div class="pt-6 flex space-x-3 rtl:space-x-reverse">
                                <button type="button" onclick="nextStep(1)" class="w-1/3 h-[52px] bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-[10px] font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                                    Back
                                </button>
                                <button type="button" onclick="nextStep(3)" class="w-2/3 h-[52px] bg-brand text-white rounded-[10px] font-semibold shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all">
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Review -->
                    <div class="w-1/3 shrink-0 px-1" id="step-3">
                        
                        <div class="bg-gray-50 dark:bg-slate-800/50 rounded-[10px] border border-gray-200 dark:border-gray-700 p-5 mb-6">
                            <h3 class="text-sm font-semibold text-brand dark:text-indigo-400 mb-4 uppercase tracking-wider">Summary</h3>
                            
                            <div class="grid grid-cols-2 gap-y-4 gap-x-2">
                                <div>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 uppercase tracking-wide">Full Name</p>
                                    <p id="sum-name" class="font-medium text-gray-900 dark:text-white text-sm mt-0.5 truncate"></p>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 uppercase tracking-wide">National ID</p>
                                    <p id="sum-id" class="font-medium text-gray-900 dark:text-white text-sm mt-0.5 truncate"></p>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 uppercase tracking-wide">Document Type</p>
                                    <p id="sum-doc" class="font-medium text-gray-900 dark:text-white text-sm mt-0.5 truncate"></p>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 uppercase tracking-wide">Appointment</p>
                                    <p id="sum-date" class="font-medium text-gray-900 dark:text-white text-sm mt-0.5 truncate"></p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 rtl:space-x-reverse bg-indigo-50 dark:bg-indigo-900/20 text-brand dark:text-indigo-300 p-4 rounded-[10px] mb-6 border border-indigo-100 dark:border-indigo-800">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            <p class="text-sm">You will receive a unique QR tracking code after submission.</p>
                        </div>

                        <div class="flex items-center justify-end mb-2">
                            <span id="draft-status" class="text-xs text-gray-500"></span>
                        </div>

                        <div class="flex space-x-3 rtl:space-x-reverse">
                            <button type="button" onclick="nextStep(2)" class="w-1/3 h-[52px] bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-[10px] font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                                Back
                            </button>
                            <button type="submit" class="w-2/3 h-[52px] bg-accent text-white rounded-[10px] font-semibold shadow-brand-btn hover:shadow-brand-btn-hover hover:-translate-y-[1px] transition-all">
                                Submit Appointment
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- Confirm Submission Modal (Outside transformed container) -->
        <x-modal name="confirm-appointment">
            <div class="p-6">
                <h2 class="text-xl font-bold font-outfit mb-2 text-gray-900 dark:text-white">Confirm Submission</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-5">
                    Please confirm your appointment details are correct. You will receive a QR tracking code after submission.
                </p>
                
                <div class="bg-gray-50 dark:bg-[#0f172a] p-4 rounded-[12px] mb-6 border border-gray-100 dark:border-gray-800">
                    <p class="text-[13px] text-gray-500 dark:text-gray-400 font-semibold mb-1" id="modal-name"></p>
                    <p class="text-[13px] text-gray-500 dark:text-gray-400 font-semibold" id="modal-datetime"></p>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close-modal', 'confirm-appointment')" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 rounded-[10px] font-semibold transition-colors text-sm">
                        Go Back
                    </button>
                    <!-- Instead of $el.closest('form'), we use document.getElementById to submit the real form directly -->
                    <button type="button" x-on:click="document.getElementById('appointment-form').__x.$data.confirmed = true; document.getElementById('appointment-form').submit()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-[10px] font-semibold shadow-md transition-colors text-sm">
                        Submit Now
                    </button>
                </div>
            </div>
        </x-modal>

    </div>

    <!-- JS Logic -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let currentStep = 1;
        const form = document.getElementById('appointment-form');
        const isRtl = document.documentElement.dir === 'rtl';

        function validateStep(step) {
            const container = document.getElementById(`step-${step}`);
            const inputs = container.querySelectorAll('input[required], select[required]');
            let isValid = true;
            inputs.forEach(input => {
                if (!input.reportValidity()) {
                    isValid = false;
                }
            });
            return isValid;
        }

        function populateSummary() {
            document.getElementById('sum-name').textContent = document.getElementById('full_name').value || '—';
            document.getElementById('sum-id').textContent = document.getElementById('national_id_number').value || '—';
            document.getElementById('sum-doc').textContent = document.getElementById('document_type').value || '—';
            
            const date = document.getElementById('preferred_date').value;
            const time = document.getElementById('time_slot').value;
            const datetimeStr = (date && time) ? `${date} at ${time}` : '—';
            
            document.getElementById('sum-date').textContent = datetimeStr;
            
            // Populate Modal Summary
            const modalNameEl = document.getElementById('modal-name');
            const modalDatetimeEl = document.getElementById('modal-datetime');
            if (modalNameEl) modalNameEl.textContent = document.getElementById('full_name').value || '—';
            if (modalDatetimeEl) modalDatetimeEl.textContent = datetimeStr;
        }

        function updateIndicators(targetStep) {
            // Update Line
            const line = document.getElementById('progress-line');
            if (targetStep === 1) line.style.width = '0%';
            if (targetStep === 2) line.style.width = '50%';
            if (targetStep === 3) line.style.width = '100%';

            for (let i = 1; i <= 3; i++) {
                const ind = document.getElementById(`indicator-${i}`);
                const num = ind.querySelector('.step-num');
                const check = ind.querySelector('.step-check');
                const label = ind.nextElementSibling;

                // Reset all
                ind.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-white dark:bg-[#1e293b] border-2 border-gray-300 dark:border-gray-600 text-gray-400';
                label.className = 'text-xs font-semibold mt-2 text-center text-gray-400';
                if(num) num.classList.remove('hidden');
                if(check) check.classList.add('hidden');

                if (i < targetStep) {
                    // Completed
                    ind.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-accent text-white shadow-md border-0';
                    if(num) num.classList.add('hidden');
                    if(check) check.classList.remove('hidden');
                    label.className = 'text-xs font-semibold mt-2 text-center text-accent';
                } else if (i === targetStep) {
                    // Current
                    ind.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors bg-brand text-white shadow-md border-0';
                    label.className = 'text-xs font-semibold mt-2 text-center text-brand dark:text-indigo-400';
                }
            }
        }

        window.nextStep = function(target) {
            // Validating when moving forward
            if (target > currentStep) {
                if (!validateStep(currentStep)) return;
            }

            if (target === 3) {
                populateSummary();
            }

            currentStep = target;
            updateIndicators(target);

            // Translate form
            const percentage = (target - 1) * -33.3333;
            // Handle RTL properly
            if (isRtl) {
                form.style.transform = `translateX(${percentage * -1}%)`;
            } else {
                form.style.transform = `translateX(${percentage}%)`;
            }
        };

        // Initialize sticky draft logic
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = form.querySelectorAll('input, select, textarea');
            const statusIndicator = document.getElementById('draft-status');
            let debounceTimer;
            let isSubmitting = false;

            form.addEventListener('submit', () => isSubmitting = true);

            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    if (isSubmitting) return;
                    statusIndicator.textContent = 'Saving draft...';
                    
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        saveDraft();
                    }, 300);
                });
            });

            function saveDraft() {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                
                axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                axios.post('{{ route('citizen.appointment.save-draft') }}', data)
                    .then(response => {
                        if (response.data.success) {
                            showToast('info', '', 'Draft saved', 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error saving draft:', error);
                    });
            }
        });
    </script>
@endsection
