<?php

namespace App\Livewire\Appointments;

use App\Enums\ProviderType;
use App\Models\Appointment;
use App\Models\Provider;
use Livewire\Component;

class SelectInspectionCenter extends Component
{
    public Appointment $appointment;
    public $centers;

    public function mount(): void
    {
        $this->centers = Provider::where('type', ProviderType::VEHICLE_INSPECTION_CENTER)->get();
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
}
