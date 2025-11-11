<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Enums\InspectionType;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\Fee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class PayFeesController extends Controller
{
    public function show(Appointment $appointment): View
    {
        $inspectionPrice = $this->getInspectionPrice($appointment->inspection_type);

        return view('appointments.fees', compact('appointment', 'inspectionPrice'));
    }

    public function callback(): RedirectResponse
    {
        $paymentId = request('id');

        if (!$paymentId) {
            return redirect()->route('dashboard.vehicle-owner')->with('error', 'Missing payment reference.');
        }

        try {
            // Use HTTP client to fetch payment from Moyasar API
            $response = Http::withBasicAuth(config('services.moyasar.secret_key'), '')
                ->get("https://api.moyasar.com/v1/payments/{$paymentId}");

            if (!$response->successful()) {
                return redirect()->route('dashboard.vehicle-owner')->with('error', 'Payment not found.');
            }

            $payment = $response->json();

            $appointmentId = $payment['metadata']['appointment_id'] ?? null;

            if (!$appointmentId) {
                return redirect()->route('dashboard.vehicle-owner')->with('error', 'Invalid payment metadata.');
            }

            $appointment = Appointment::find($appointmentId);

            if (!$appointment) {
                return redirect()->route('dashboard.vehicle-owner')->with('error', 'Appointment not found.');
            }

            if ($payment['status'] === 'paid') {

                if (!Fee::where('payment_id', $payment['id'])->exists()) {
                    $inspectionPrice = $this->getInspectionPrice($appointment->inspection_type);
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

                return redirect()->route('dashboard.vehicle-owner')->with('success', 'Payment completed successfully! Your appointment has been confirmed and you will receive an email confirmation shortly.');
            }

            Log::info('Payment failed.');

            return redirect()->route('dashboard.vehicle-owner')->with('error', 'Payment failed.');

        } catch (\Exception $e) {
            return redirect()->route('dashboard.vehicle-owner')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    private function getInspectionPrice($inspectionType): float
    {
        $type = is_string($inspectionType) ? InspectionType::from($inspectionType) : $inspectionType;
        return match ($type) {
            InspectionType::UNDERCARRIAGE_INSPECTION => 150.00,
            InspectionType::ENGINE_INSPECTION => 200.00,
            InspectionType::COMPREHENSIVE_INSPECTION => 300.00,
        };
    }
}


