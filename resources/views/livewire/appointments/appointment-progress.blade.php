<div class="grid grid-cols-1 content-start min-h-full border-l border-neutral-900 dark:border-white/10">
    @if($appointment)
        <div class="flex flex-col gap-3 p-6">
            
            @svg('phosphor-calendar-dots', 'size-8 text-violet-600')
            <h3 class="text-2xl">Appointment Details</h3>
            <div class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                @svg('phosphor-hash-light', 'size-4')
                <span class="font-medium">{{ $appointment->number }}</span>
            </div>
        </div>

        @php
            $paymentCompleted = $appointment->status && in_array($appointment->status->value, ['confirmed', 'completed']);
        @endphp

        <div class="grid grid-cols-1">
            <div class="col-span-1 flex items-center gap-2 px-6 py-1 {{ $appointment->provider_id ? 'text-green-700' : 'text-neutral-500' }} border-t border-neutral-300 dark:border-white/10">
                @svg(($appointment->provider_id) ? 'phosphor-check-circle' : 'phosphor-number-circle-one', 'size-4')
                <p class="text-sm font-medium">
                    {{  ($appointment->provider_id) ? __($appointment->provider->name) : __('Inspection Center') }}
                </p>
            </div>

            <!-- Step 2: Inspection Type -->
            <div class="col-span-1 flex items-center gap-2 px-6 py-1 {{ $appointment->inspection_type ? 'text-green-700' : 'text-neutral-500' }} border-t border-neutral-300 dark:border-white/10">
                @svg(($appointment->inspection_type) ? 'phosphor-check-circle' : 'phosphor-number-circle-two', 'size-4')
                <p class="text-sm font-medium">
                    {{  ($appointment->inspection_type) ? ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) : __('Inspection Type') }}
                </p>
            </div>

            <!-- Step 3: Date & Time -->
            <div class="col-span-1 flex items-center gap-2 px-6 py-1 {{ $appointment->scheduled_at ? 'text-green-700' : 'text-neutral-500' }} border-t border-neutral-300 dark:border-white/10">
                @svg(($appointment->scheduled_at) ? 'phosphor-check-circle' : 'phosphor-number-circle-three', 'size-4')
                <p class="text-sm font-medium">
                    @if($appointment->scheduled_at)
                        {{ $appointment->scheduled_at->format('M j, Y') }} {{ $appointment->scheduled_at->format('g:i A') }}
                    @else
                        {{ 'Date & Time' }}
                    @endif
                </p>
            </div>

            <!-- Step 4: Pay Inspection Fee -->
            <div class="col-span-1 flex items-center gap-2 px-6 py-1 {{ $paymentCompleted ? 'text-green-700' : 'text-neutral-500' }} border-t border-neutral-300 dark:border-white/10">
                @svg($paymentCompleted ? 'phosphor-check-circle' : 'phosphor-number-circle-four', 'size-4')
                <p class="text-sm font-medium">
                    {{ 'Pay Inspection Fee' }}
                </p>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="border-t border-neutral-200 dark:border-white/10 px-6 pt-4">
            <h4 class="text-sm font-semibold text-neutral-900 dark:text-white mb-3">Vehicle Details</h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-car-light', 'size-4')
                        <span>Vehicle</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-calendar-blank-light', 'size-4')
                        <span>Year & Make</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->year }} {{ $appointment->vehicle->make }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-tag-light', 'size-4')
                        <span>Model</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->model }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if($appointment && $appointment->scheduled_at && ! $paymentCompleted)
            <div class="p-6">
                <!-- Auto Quotation Request Checkbox -->
                <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input
                                wire:model.live="autoQuotationRequest"
                                type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                id="auto_quotation_request"
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="auto_quotation_request" class="font-medium text-gray-900">
                                Auto Quotation Request
                            </label>
                            <p class="text-gray-600 text-xs mt-1">
                                Automatically create quotation requests for damaged parts after inspection completion
                            </p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('appointments.fees.pay', $appointment->id) }}"
                    class="w-full bg-green-600 text-white text-sm font-medium py-2 px-4 rounded-lg hover:bg-green-700 transition-colors duration-200">
                    Complete Appointment
                </a>
            </div>
        @endif

        <!-- Progress Bar -->
        <div class="mt-auto p-6">
            @php
                $completedSteps = 0;
                $totalSteps = 4;
                if ($appointment->provider_id) $completedSteps++;
                if ($appointment->inspection_type) $completedSteps++;
                if ($appointment->scheduled_at) $completedSteps++;
                if ($paymentCompleted) $completedSteps++;
                $progressPercentage = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;
            @endphp

            <div class="flex items-center justify-between mb-2 text-base text-neutral-700 dark:text-white/70 font-medium">
                <span>Progress</span>
                <span>{{ $completedSteps }}/{{ $totalSteps }}</span>
            </div>
            <div class="w-full bg-neutral-200 dark:bg-white/10 rounded-full h-2">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-2 rounded-full transition-all duration-300" style="width: {{ $progressPercentage }}%"></div>
            </div>
        </div>
    @endif
</div>
