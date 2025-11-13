@php
    $title = 'Payment Failed';
@endphp

<x-layouts.app :title="$title">
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
        <!-- Failure Card -->
        <div class="col-span-1 grid grid-cols-1 border-r border-neutral-900 dark:border-neutral-700">
            <div class="grid grid-cols-1 gap-6 border-b border-neutral-900 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between gap-6 text-neutral-800 dark:text-white">
                    <div class="w-10">
                        @svg('phosphor-x-circle', 'size-10 text-red-500')
                    </div>
                    <span class="text-xl font-normal">Failed</span>
                </div>
                <span class="text-3xl font-extrabold">Payment Failed</span>
                <div class="flex flex-col gap-2">
                    <p class="text-base text-neutral-800 dark:text-white/70">
                        {{ $errorMessage ?? 'Unfortunately, your payment could not be processed. Please try again or contact support if the problem persists.' }}
                    </p>
                </div>
                <div class="flex items-center justify-center gap-6 mt-6">
                    <div class="flex items-center justify-center size-10 border border-red-500 dark:border-red-500 text-red-500 dark:text-white rounded-full">
                        @svg('phosphor-x', 'size-6')
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-6 lg:gap-8 p-6">
                <div class="w-1 h-16 bg-neutral-950 dark:bg-white"></div>
                <div class="flex flex-col gap-2">
                    <h2 class="text-3xl font-extrabold font-montserrat text-neutral-950 dark:text-white">What's next?</h2>
                    <p class="text-base text-neutral-800 dark:text-white/70">You can return to your dashboard and try again when you're ready.</p>
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
                    @svg('phosphor-warning-circle', 'size-8 text-red-500')
                    <span class="text-2xl">{{ __('Payment Information') }}</span>
                </div>
                <div class="grid grid-cols-1 content-start pl-10">
                    <div class="col-span-1 flex gap-4 border-b border-neutral-300 dark:border-neutral-700 pb-4">
                        <div class="flex flex-col text-neutral-900 dark:text-white">
                            <span class="text-lg font-normal">Your appointment has not been confirmed yet.</span>
                            <span class="text-base text-neutral-600 dark:text-white/70 mt-2">Please complete the payment to confirm your appointment.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 content-start">
                <div class="col-span-1 flex items-center gap-2">
                    @svg('phosphor-question', 'size-8 text-blue-500')
                    <span class="text-2xl">{{ __('Need Help?') }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 flex flex-col justify-between bg-white dark:bg-white/5">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center size-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-300">
                                    @svg('phosphor-arrow-clockwise', 'size-6')
                                </span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="text-xl md:text-2xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                                Try Again
                            </div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                                @svg('phosphor-info', 'size-4 text-sky-500')
                                <span>Return to your appointments and try paying again</span>
                            </div>
                        </div>
                    </div>
                    <div class="group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 flex flex-col justify-between bg-white dark:bg-white/5">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center size-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                                    @svg('phosphor-headset', 'size-6')
                                </span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="text-xl md:text-2xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                                Contact Support
                            </div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                                @svg('phosphor-envelope', 'size-4 text-sky-500')
                                <span>If you continue to experience issues, contact our support team</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

