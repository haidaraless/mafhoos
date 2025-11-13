<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Enums\InspectionType;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\Fee;
use App\Services\InspectionFeeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class PayFeesController extends Controller
{
    protected InspectionFeeService $inspectionFeeService;

    public function __construct(InspectionFeeService $inspectionFeeService)
    {
        $this->inspectionFeeService = $inspectionFeeService;
    }

    public function show(Appointment $appointment): View
    {
        $inspectionPrice = $this->inspectionFeeService->getInspectionPrice($appointment->inspection_type);

        return view('appointments.fees', compact('appointment', 'inspectionPrice'));
    }

    public function callback(): RedirectResponse
    {
        $paymentId = request('id');

        if (!$paymentId) {
            return redirect()->route('appointments.fees.failure', [
                'error' => 'Missing payment reference.'
            ]);
        }

        try {
            // Use HTTP client to fetch payment from Moyasar API
            $response = Http::withBasicAuth(config('services.moyasar.secret_key'), '')
                ->get("https://api.moyasar.com/v1/payments/{$paymentId}");

            if (!$response->successful()) {
                return redirect()->route('appointments.fees.failure', [
                    'error' => 'Payment not found.'
                ]);
            }

            $payment = $response->json();

            $appointmentId = $payment['metadata']['appointment_id'] ?? null;

            if (!$appointmentId) {
                return redirect()->route('appointments.fees.failure', [
                    'error' => 'Invalid payment metadata.'
                ]);
            }

            $appointment = Appointment::find($appointmentId);

            if (!$appointment) {
                return redirect()->route('appointments.fees.failure', [
                    'error' => 'Appointment not found.'
                ]);
            }

            if ($payment['status'] === 'paid') {

                $fee = Fee::where('payment_id', $payment['id'])->first();
                
                if (!$fee) {
                    $inspectionPrice = $this->inspectionFeeService->getInspectionPrice($appointment->inspection_type);
                    $fee = Fee::create([
                        'appointment_id' => $appointment->id,
                        'description' => 'Vehicle Inspection Fee - ' . str_replace('-', ' ', $appointment->inspection_type->value ?? $appointment->inspection_type),
                        'amount' => $inspectionPrice,
                        'status' => 'paid',
                        'payment_id' => $payment['id'],
                        'payment_method' => $payment['source']['company'] ?? 'creditcard',
                        'paid_at' => now(),
                    ]);

                    Log::info('Fee created: ' . $fee->id);
                }

                // Update appointment status to confirmed
                $appointment->update([
                    'status' => AppointmentStatus::CONFIRMED,
                    'confirmed_at' => now(),
                ]);

                // Send confirmation email to the vehicle owner
                if ($appointment->vehicle && $appointment->vehicle->user) {
                    Mail::to($appointment->vehicle->user->email)
                        ->send(new AppointmentConfirmation($appointment, $fee));
                }

                Log::info('Payment completed successfully!');

                return redirect()->route('appointments.fees.success', [
                    'appointment' => $appointment->id,
                    'fee' => $fee->id
                ]);
            }

            Log::info('Payment failed.');

            return redirect()->route('appointments.fees.failure', [
                'error' => 'Payment failed.'
            ]);

        } catch (\Exception $e) {
            return redirect()->route('appointments.fees.failure', [
                'error' => 'Payment verification failed: ' . $e->getMessage()
            ]);
        }
    }

    public function success(): View
    {
        $appointmentId = request('appointment');
        $feeId = request('fee');

        $appointment = null;
        $fee = null;

        if ($appointmentId) {
            $appointment = Appointment::find($appointmentId);
        }

        if ($feeId) {
            $fee = Fee::find($feeId);
        }

        return view('payments.success', compact('appointment', 'fee'));
    }

    public function failure(): View
    {
        $errorMessage = request('error', 'Unfortunately, your payment could not be processed. Please try again or contact support if the problem persists.');

        return view('payments.failure', compact('errorMessage'));
    }
}


