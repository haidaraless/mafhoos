@php
    $title = 'Pay Fees';
@endphp

<x-layouts.app :title="$title">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.1.1/dist/moyasar.css" />
    
    <div class="grid grid-cols-3 content-start">
        <!-- Main Content -->
            <div class="col-span-2 grid grid-cols-1 content-start overflow-hidden">
                <!-- Header -->
                <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white border-b border-neutral-900">
                    <div class="flex items-start justify-between">
                        @svg('phosphor-credit-card', 'size-10 md:size-12 text-green-600')
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-2xl md:text-3xl text-neutral-800 font-bold">Pay Inspection Fee</h1>
                        <p class="text-neutral-600">Securely complete your inspection payment to finalize the appointment</p>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="col-span-1 pt-12">
                    <div class="mysr-form"></div>
                </div>
            </div>

            <!-- Appointment Summary Sidebar -->
            <div class="col-span-1 grid grid-cols-1 content-start border-l border-neutral-900 dark:border-white/10">
                <div class="flex flex-col gap-4 p-6">
                    @svg('phosphor-calendar-dots', 'size-9 text-violet-600')
                    <h3 class="text-2xl font-medium text-neutral-900 dark:text-white">Appointment Summary</h3>
                    
                    <!-- Appointment Number -->
                    <div class="flex items-center text-2xl font-normal text-neutral-600 dark:text-white/70">
                        @svg('phosphor-hash-light', 'size-7')
                        <span>{{ $appointment->number }}</span>
                    </div>
                </div>

                <!-- Appointment Details -->
                <div class="border-t border-neutral-900 dark:border-neutral-700 p-6 space-y-4">
                    <!-- Provider -->
                    @if($appointment->provider)
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                            @svg('phosphor-buildings', 'size-4 text-green-600')
                            <span>Inspection Center</span>
                        </div>
                        <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $appointment->provider->name }}</p>
                    </div>
                    @endif

                    <!-- Inspection Type -->
                    @if($appointment->inspection_type)
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                            @svg('phosphor-wrench', 'size-4 text-green-600')
                            <span>Inspection Type</span>
                        </div>
                        <p class="text-sm font-medium text-neutral-900 dark:text-white">
                            {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}
                        </p>
                    </div>
                    @endif

                    <!-- Date & Time -->
                    @if($appointment->scheduled_at)
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                            @svg('phosphor-calendar-blank', 'size-4 text-green-600')
                            <span>Date & Time</span>
                        </div>
                        <p class="text-sm font-medium text-neutral-900 dark:text-white">
                            {{ $appointment->scheduled_at->format('M j, Y') }} at {{ $appointment->scheduled_at->format('g:i A') }}
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Vehicle Details -->
                @if($appointment->vehicle)
                <div class="border-t border-neutral-900 dark:border-neutral-700 p-6">
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
                @endif

                <!-- Fee Summary -->
                <div class="border-t border-neutral-900 dark:border-neutral-700 p-6">
                    <h4 class="text-sm font-semibold text-neutral-900 dark:text-white mb-3">Fee Summary</h4>
                    <div class="space-y-3">
                        @if($appointment->inspection_type)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @svg('phosphor-clipboard-text', 'size-4 text-neutral-600 dark:text-white/70')
                                    <span class="text-sm text-neutral-700 dark:text-white/80">
                                        {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }} Inspection
                                    </span>
                                </div>
                                <span class="text-base font-bold text-neutral-900 dark:text-white">
                                    {{ number_format($inspectionPrice, 2) }} SAR
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="border-t border-neutral-900 dark:border-neutral-700 p-6">
                    <div class="flex flex-col gap-4">
                        <span class="text-4xl text-right font-medium text-neutral-900 dark:text-white">
                            {{ number_format($inspectionPrice, 2) }}
                            <span class="text-base font-medium text-neutral-500 dark:text-white/70">SAR</span>
                        </span>
                    </div>
                </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.1.1/dist/moyasar.umd.min.js"></script>
    <script>
        (function mountMoyasar() {
            function init() {
                if (!window.Moyasar) return;
                var el = document.querySelector('.mysr-form');
                if (!el) return;
                if (el.dataset.moyasarMounted === '1') return;
                el.dataset.moyasarMounted = '1';
                Moyasar.init({
                    element: '.mysr-form',
                    amount: {{ (int) round($inspectionPrice * 100) }},
                    currency: 'SAR',
                    description: 'Vehicle Inspection Fee - {{ str_replace('-', ' ', $appointment->inspection_type->value ?? $appointment->inspection_type) }}',
                    publishable_api_key: '{{ config('services.moyasar.publishable_key') }}',
                    callback_url: '{{ route('appointments.fees.callback') }}',
                    supported_networks: ['visa', 'mastercard', 'mada'],
                    methods: ['creditcard'],
                    metadata: {
                        appointment_id: '{{ $appointment->id }}',
                        inspection_type: '{{ $appointment->inspection_type->value ?? $appointment->inspection_type }}'
                    }
                });
            }
            document.addEventListener('DOMContentLoaded', init);
            window.addEventListener('load', init);
        })();
    </script>
</x-layouts.app>
