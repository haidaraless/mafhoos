<div class="grid grid-cols-1 content-start min-h-full bg-white dark:bg-neutral-900">
    @if($appointment)
        <div class="flex flex-col gap-3 p-6">
            @svg('phosphor-calendar-dots', 'size-8 text-violet-600')
            <h3 class="text-2xl text-neutral-900 dark:text-white">Appointment Details</h3>
            <div class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                @svg('phosphor-hash-light', 'size-4')
                <span class="font-medium">{{ $appointment->number }}</span>
            </div>
        </div>

        @php
            $paymentCompleted = $appointment->status && in_array($appointment->status->value, ['confirmed', 'completed']);
        @endphp

        <div class="grid grid-cols-1 content-start">
            <div class="col-span-1 flex items-center gap-2 px-6 py-2 {{ $appointment->provider_id ? 'text-green-700 dark:text-green-300' : 'text-neutral-500 dark:text-white/50' }} border-t border-neutral-200 dark:border-white/10">
                @svg(($appointment->provider_id) ? 'phosphor-check-circle' : 'phosphor-number-circle-one', 'size-4')
                <p class="text-sm font-medium">
                    {{  ($appointment->provider_id) ? __($appointment->provider->name) : __('Inspection Center') }}
                </p>
            </div>

            <!-- Step 2: Inspection Type -->
            <div class="col-span-1 flex items-center gap-2 px-6 py-2 {{ $appointment->inspection_type ? 'text-green-700 dark:text-green-300' : 'text-neutral-500 dark:text-white/50' }} border-t border-neutral-200 dark:border-white/10">
                @svg(($appointment->inspection_type) ? 'phosphor-check-circle' : 'phosphor-number-circle-two', 'size-4')
                <p class="text-sm font-medium">
                    {{  ($appointment->inspection_type) ? ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) : __('Inspection Type') }}
                </p>
            </div>

            <!-- Step 3: Date & Time -->
            <div class="col-span-1 flex items-center gap-2 px-6 py-2 {{ $appointment->scheduled_at ? 'text-green-700 dark:text-green-300' : 'text-neutral-500 dark:text-white/50' }} border-t border-neutral-200 dark:border-white/10">
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
            <div class="col-span-1 flex items-center gap-2 px-6 py-2 {{ $paymentCompleted ? 'text-green-700 dark:text-green-300' : 'text-neutral-500 dark:text-white/50' }} border-t border-neutral-200 dark:border-white/10">
                @svg($paymentCompleted ? 'phosphor-check-circle' : 'phosphor-number-circle-four', 'size-4')
                <p class="text-sm font-medium">
                    {{ 'Pay Inspection Fee' }}
                </p>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="border-t border-neutral-200 dark:border-white/10 px-6 pt-4 pb-6">
            <h4 class="text-sm font-semibold text-neutral-900 dark:text-white mb-3">Vehicle Details</h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between gap-4">
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

        <!-- Fee Summary & Action Button -->
        @if($appointment && $appointment->scheduled_at && ! $paymentCompleted)
            <div class="p-6 space-y-4">
                <!-- Fee Summary -->
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold text-neutral-900 dark:text-white">Fee Summary</h4>
                    
                    @if($appointment->inspection_type)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-white/5 rounded-lg border border-neutral-200 dark:border-neutral-700">
                            <div class="flex items-center gap-2">
                                @svg('phosphor-clipboard-text', 'size-4 text-neutral-600 dark:text-white/70')
                                <span class="text-sm text-neutral-700 dark:text-white/80">
                                    {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }} Inspection
                                </span>
                            </div>
                            <span class="text-base font-bold text-neutral-900 dark:text-white">
                                {{ number_format($this->getInspectionPrice($appointment->inspection_type), 2) }} SAR
                            </span>
                        </div>
                    @endif

                    <div class="flex flex-col gap-4 pt-4 ">
                        <span class="text-4xl text-right font-medium text-neutral-900 dark:text-white">
                            {{ number_format($this->getInspectionPrice($appointment->inspection_type ?? null), 2) }}
                            <span class="text-base font-medium text-neutral-500 dark:text-white/70">SAR</span>
                        </span>
                    </div>
                </div>

                <!-- Complete Appointment Button -->
                <a href="{{ route('appointments.fees.pay', $appointment->id) }}"
                    class="w-full flex items-center justify-between gap-2 bg-neutral-800 text-white text-base font-semibold py-4 px-6 rounded-full hover:bg-neutral-950 transition-all duration-200 shadow-md hover:shadow-lg">
                    <div class="flex items-center gap-2">
                        @svg('phosphor-credit-card', 'size-5')
                        <span>Complete Appointment & Pay</span>
                    </div>
                    @svg('phosphor-arrow-right', 'size-5')
                </a>
            </div>
        @endif
    @endif
</div>
