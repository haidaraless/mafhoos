<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Enums\InspectionType;
use App\Enums\ProviderType;
use App\Enums\QuotationRequestStatus;
use App\Enums\QuotationType;
use App\Models\Account;
use App\Models\Appointment;
use App\Models\Inspection;
use App\Models\Provider;
use App\Models\Quotation;
use App\Models\QuotationRequest;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create a technician user with Saudi details
        $technician = User::query()->firstOrCreate(
            ['email' => 'khalid.alm@mafhoos.sa'],
            [
                'name' => 'Khalid Al-Mutairi',
                'email' => 'khalid.alm@mafhoos.sa',
                'password' => bcrypt('Mafhoos@123'),
            ]
        );

        $saudiOwners = [
            ['name' => 'Abdullah Al-Qahtani', 'email' => 'abdullah.alqahtani@mail.sa'],
            ['name' => 'Faisal Al-Shehri', 'email' => 'faisal.alshehri@mail.sa'],
            ['name' => 'Nouf Al-Harbi', 'email' => 'nouf.alharbi@mail.sa'],
            ['name' => 'Bandar Al-Shammari', 'email' => 'bandar.alshammari@mail.sa'],
            ['name' => 'Dana Al-Otaibi', 'email' => 'dana.alotaibi@mail.sa'],
            ['name' => 'Saad Al-Dossary', 'email' => 'saad.aldossary@mail.sa'],
            ['name' => 'Laila Al-Mutairi', 'email' => 'laila.almutairi@mail.sa'],
            ['name' => 'Majed Al-Juhani', 'email' => 'majed.aljuhani@mail.sa'],
            ['name' => 'Huda Al-Qahtani', 'email' => 'huda.alqahtani@mail.sa'],
            ['name' => 'Turki Al-Mutlaq', 'email' => 'turki.almutlaq@mail.sa'],
            ['name' => 'Rawan Al-Salem', 'email' => 'rawan.alsalem@mail.sa'],
            ['name' => 'Nasser Al-Ghamdi', 'email' => 'nasser.alghamdi@mail.sa'],
            ['name' => 'Reem Al-Anazi', 'email' => 'reem.alanazi@mail.sa'],
            ['name' => 'Badr Al-Olayan', 'email' => 'badr.alolayan@mail.sa'],
            ['name' => 'Amal Al-Sharif', 'email' => 'amal.alsharif@mail.sa'],
        ];

        // Create vehicle owners and their accounts, and vehicles
        $vehicles = collect();
        foreach ($saudiOwners as $owner) {
            $user = User::query()->firstOrCreate(
                ['email' => $owner['email']],
                [
                    'name' => $owner['name'],
                    'email' => $owner['email'],
                    'password' => bcrypt('Mafhoos@123'),
                ]
            );

            // Create account for user if missing and set as current
            if (! $user->current_account_id) {
                $account = Account::query()->firstOrCreate([
                    'accountable_id' => $user->id,
                    'accountable_type' => User::class,
                ]);
                $user->current_account_id = $account->id;
                $user->save();
            }

            // Each user gets 1-2 vehicles
            $numVehicles = rand(1, 2);
            for ($v = 1; $v <= $numVehicles; $v++) {
                $vehicle = Vehicle::factory()->create([
                    'user_id' => $user->id,
                ]);
                $vehicles->push($vehicle);
            }
        }

        // Providers by type
        $inspectionProviders = Provider::query()->where('type', ProviderType::VEHICLE_INSPECTION_CENTER->value)->get();
        $repairProviders = Provider::query()->where('type', ProviderType::AUTO_REPAIR_WORKSHOP->value)->get();
        $spareProviders = Provider::query()->where('type', ProviderType::SPARE_PARTS_SUPPLIER->value)->get();

        // Appointments per vehicle
        $appointments = collect();
        foreach ($vehicles as $vehicle) {
            if ($inspectionProviders->isEmpty()) {
                continue;
            }
            $provider = $inspectionProviders->random();
            $inspectionType = collect(InspectionType::cases())->random();
            $scheduledAt = Carbon::now('Asia/Riyadh')->addDays(rand(0, 10))->addHours(rand(8, 18));

            $appointment = Appointment::create([
                'user_id' => $vehicle->user_id,
                'status' => AppointmentStatus::CONFIRMED->value,
                'vehicle_id' => $vehicle->id,
                'provider_id' => $provider->id,
                'inspection_type' => $inspectionType->value,
                'scheduled_at' => $scheduledAt,
                'confirmed_at' => $scheduledAt->copy()->subDay(),
            ]);
            $appointments->push($appointment);
        }

        // Inspections for the appointments
        $inspections = collect();
        foreach ($appointments as $appointment) {
            $startedAt = Carbon::parse($appointment->scheduled_at)->addMinutes(rand(0, 30));
            $completedAt = $startedAt->copy()->addMinutes(rand(30, 90));
            $inspection = Inspection::create([
                'number' => 'INSP-' . Str::upper(Str::random(8)),
                'type' => $appointment->inspection_type,
                'report' => 'Comprehensive inspection report issued in Saudi Arabia for vehicle ' . $appointment->vehicle_id,
                'technician_id' => $technician->id,
                'provider_id' => $appointment->provider_id,
                'appointment_id' => $appointment->id,
                'vehicle_id' => $appointment->vehicle_id,
                'started_at' => $startedAt,
                'completed_at' => $completedAt,
            ]);
            $inspections->push($inspection);
        }

        // Quotation Requests per inspection (one of each type)
        $requests = collect();
        foreach ($inspections as $inspection) {
            foreach ([QuotationType::SPARE_PARTS, QuotationType::REPAIR] as $qType) {
                $request = QuotationRequest::create([
                    'type' => $qType->value,
                    'inspection_id' => $inspection->id,
                    'status' => QuotationRequestStatus::OPEN->value,
                ]);
                $requests->push($request);
            }
        }

        // Quotations for each request (3 providers each)
        foreach ($requests as $request) {
            $pool = $request->type === QuotationType::SPARE_PARTS->value ? $spareProviders : $repairProviders;
            if ($pool->count() < 3) {
                $providers = $pool; // use whatever is available
            } else {
                $providers = $pool->random(3);
            }

            foreach ($providers as $provider) {
                Quotation::create([
                    'provider_id' => $provider->id,
                    'quotation_request_id' => $request->id,
                    'type' => $request->type,
                    'total' => rand(500, 5000),
                ]);
            }
        }
    }
}


