<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pay Fees</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.1.1/dist/moyasar.css" />
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Details</h2>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-900 mb-2">Inspection Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-blue-700 font-medium">Type:</span>
                        <span class="text-blue-900 ml-2">{{ str_replace('-', ' ', $appointment->inspection_type->value ?? $appointment->inspection_type) }}</span>
                    </div>
                    <div>
                        <span class="text-blue-700 font-medium">Date:</span>
                        <span class="text-blue-900 ml-2">{{ $appointment->scheduled_at ? $appointment->scheduled_at->format('M d, Y') : 'Not scheduled' }}</span>
                    </div>
                    <div>
                        <span class="text-blue-700 font-medium">Provider:</span>
                        <span class="text-blue-900 ml-2">{{ $appointment->provider->name ?? 'Not selected' }}</span>
                    </div>
                    <div>
                        <span class="text-blue-700 font-medium">Amount:</span>
                        <span class="text-blue-900 ml-2 font-semibold">SAR {{ number_format($inspectionPrice, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="mysr-form"></div>
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
                    callback_url: '{{ route('appointments.fees.callback.controller') }}',
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
</body>
</html>
