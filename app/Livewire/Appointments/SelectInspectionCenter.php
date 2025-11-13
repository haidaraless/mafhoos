<?php

namespace App\Livewire\Appointments;

use App\Enums\ProviderType;
use App\Models\Appointment;
use App\Models\City;
use App\Models\Provider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class SelectInspectionCenter extends Component
{
    public Appointment $appointment;
    public $centers;
    public ?string $userCity = null;

    public function mount(): void
    {
        $this->loadCenters();
    }

    public function selectCenter($providerId)
    {
        // Update the appointment with the selected provider
        $this->appointment->update([
            'provider_id' => $providerId
        ]);

        // Dispatch event to update progress component
        $this->dispatch('appointment-updated', $this->appointment->id);

        // Redirect to the inspection type selection page
        return $this->redirect(route('appointments.inspection-type.select', $this->appointment), true);
    }

    public function render()
    {
        return view('livewire.appointments.select-inspection-center');
    }

    protected function loadCenters(): void
    {
        $riyadhCity = City::where('name', 'Riyadh')->first();

        $query = Provider::query()
            ->with('city')
            ->where('city_id', $riyadhCity->id)
            ->where('type', ProviderType::VEHICLE_INSPECTION_CENTER);

        $cityName = $this->detectCityName();

        if ($cityName) {
            $query->whereHas('city', function ($builder) use ($cityName) {
                $builder->whereRaw('LOWER(name) = ?', [Str::lower($cityName)]);
            });

            $this->userCity = $cityName;
        }

        $this->centers = $query->get();
    }

    protected function detectCityName(): ?string
    {
        try {
            $location = Location::get(request()->ip());

            return $location?->cityName ? Str::of($location->cityName)->trim()->toString() : null;
        } catch (\Throwable $e) {
            Log::warning('Unable to detect user location', [
                'component' => static::class,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
