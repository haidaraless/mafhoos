<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pay Fees</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.1.1/dist/moyasar.css" />
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex flex-col font-montserrat text-neutral-800 bg-white antialiased dark:text-white dark:bg-neutral-950">
    <header class="container mx-auto flex items-center w-full h-36 px-10">
        <a href="{{ route('home') }}" wire:navigate>
            <span class="flex items-center gap-2 text-orange-600 font-medium uppercase">
                <x-app-logo-icon />
                <span class="text-2xl tracking-tighter font-medium uppercase">mafhoos</span>
            </span>
            <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </header>

    <main class="container mx-auto flex-1 overflow-hidden border border-neutral-900 rounded-4xl">
        <div class="grid grid-cols-3">
            <!-- Main Content -->
            <div class="col-span-2 grid grid-cols-1 overflow-hidden">
                <!-- Header -->
                <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white border-b border-neutral-300">
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

            <!-- Progress Sidebar -->
            @livewire('appointments.appointment-progress', ['appointment' => $appointment], key('progress-' . $appointment->id))
        </div>
    </main>

    <footer class="flex items-center mt-auto h-20">
        <div class="container mx-auto">
            <div class="flex items-center justify-between px-10">
                <span class="text-base tracking-tighter font-light">Mafhoos &copy; {{ date('Y') }}</span>
                <div class="flex items-center gap-4 text-base tracking-tighter font-light">
                    <a href="#" class="hover:text-orange-600 transition-all ease-in-out duration-300">About</a>
                    <a href="#" class="hover:text-orange-600 transition-all ease-in-out duration-300">Terms</a>
                    <a href="#" class="hover:text-orange-600 transition-all ease-in-out duration-300">Privacy</a>
                    @svg('phosphor-minus-light', 'size-5')
                    <a href="https://github.com/haidaraless/mafhoos" target="_blank" class="hover:text-orange-600 transition-all ease-in-out duration-300">v1.0.0</a>
                </div>
            </div>
        </div>
    </footer>

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
    @fluxScripts
</body>
</html>
