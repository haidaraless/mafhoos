@php
    $title = 'Payment Successful';
@endphp

<x-layouts.app :title="$title">
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
        <!-- Success Card -->
        <div class="col-span-1 grid grid-cols-1 border-r border-neutral-900 dark:border-neutral-700">
            <div class="grid grid-cols-1 gap-6 border-b border-neutral-900 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between gap-6 text-neutral-800 dark:text-white">
                    <div class="w-10">
                        @svg('phosphor-check-circle', 'size-10 text-green-500')
                    </div>
                    <span class="text-xl font-normal">Success</span>
                </div>
                <span class="text-3xl font-extrabold">Payment Completed</span>
                <div class="flex flex-col gap-2">
                    <p class="text-base text-neutral-800 dark:text-white/70">
                        Your payment has been processed successfully. Your appointment has been confirmed and you will receive an email confirmation shortly.
                    </p>
                </div>
                <div class="flex items-center justify-center gap-6 mt-6">
                    <div class="flex items-center justify-center size-10 border border-green-500 dark:border-green-500 text-green-500 dark:text-white rounded-full">
                        @svg('phosphor-check', 'size-6')
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-6 lg:gap-8 p-6">
                <div class="w-1 h-16 bg-neutral-950 dark:bg-white"></div>
                <div class="flex flex-col gap-2">
                    <h2 class="text-3xl font-extrabold font-montserrat text-neutral-950 dark:text-white">Redirecting...</h2>
                    <p class="text-base text-neutral-800 dark:text-white/70">You will be redirected to your dashboard in <span id="countdown" class="font-bold text-green-600 dark:text-green-400">3</span> seconds.</p>
                </div>
                <div class="flex w-full mt-20">
                    <a href="{{ route('dashboard.vehicle-owner') }}"
                            class="inline-flex items-center justify-between w-full px-6 py-3 text-neutral-800 dark:text-white text-base font-medium font-montserrat border border-dashed border-neutral-800 dark:border-neutral-700 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                        <div class="flex items-center gap-2">
                            @svg('phosphor-house', 'size-5 text-blue-500')
                            <span>Go to Dashboard</span>
                        </div>
                        @svg('phosphor-arrow-right-light', 'size-6')
                    </a>
                </div>
            </div>
        </div>
        <div class="col-span-3 grid grid-cols-1 gap-8 p-8">
            <div class="grid grid-cols-1 gap-4 content-start">
                <div class="col-span-1 flex items-center gap-2">
                    @svg('phosphor-calendar-check', 'size-8 text-green-500')
                    <span class="text-2xl">{{ __('Appointment Confirmed') }}</span>
                </div>
                <div class="grid grid-cols-1 content-start pl-10">
                    @if(isset($appointment))
                        <div class="col-span-1 flex gap-4 border-b border-neutral-300 dark:border-neutral-700 pb-4">
                            <div class="flex flex-col text-neutral-900 dark:text-white">
                                <span class="text-2xl font-extrabold">{{ $appointment->scheduled_at->format('H:i A') }}</span>
                                <span class="text-lg font-normal">{{ $appointment->scheduled_at->format('M d, Y') }}</span>
                            </div>
                            <div class="grid grid-cols-1">
                                <span>{{ $appointment->provider->name ?? 'N/A' }}</span>
                                <span>{{ $appointment->vehicle->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 content-start">
                <div class="col-span-1 flex items-center gap-2">
                    @svg('phosphor-credit-card', 'size-8 text-blue-500')
                    <span class="text-2xl">{{ __('Payment Details') }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if(isset($fee))
                        <div class="group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 flex flex-col justify-between bg-white dark:bg-white/5">
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center size-10 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                                        @svg('phosphor-check-circle', 'size-6')
                                    </span>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">
                                    Paid
                                </span>
                            </div>
                            <div class="space-y-3">
                                <div class="text-xl md:text-2xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                                    {{ number_format($fee->amount, 2) }} SAR
                                </div>
                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                                    @svg('phosphor-credit-card', 'size-4 text-sky-500')
                                    <span>{{ ucfirst($fee->payment_method ?? 'Credit Card') }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-neutral-600 dark:text-white/70">
                                    @svg('phosphor-calendar-dots', 'size-4 text-violet-500')
                                    <span>Paid {{ $fee->paid_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let countdown = 3;
        const countdownElement = document.getElementById('countdown');
        const redirectUrl = '{{ route('dashboard.vehicle-owner') }}';

        const timer = setInterval(() => {
            countdown--;
            if (countdownElement) {
                countdownElement.textContent = countdown;
            }
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = redirectUrl;
            }
        }, 1000);
    </script>
</x-layouts.app>

