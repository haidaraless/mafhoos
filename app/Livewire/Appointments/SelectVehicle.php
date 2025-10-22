<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SelectVehicle extends Component
{
    public Appointment $appointment;
    public $vehicles;

    public function mount(): void
    {
        $this->vehicles = Vehicle::where('user_id', Auth::id())->get();
    }

    public function selectVehicle($vehicleId)
    {
        // Update the appointment with the selected vehicle
        $this->appointment->update([
            'vehicle_id' => $vehicleId
        ]);

        // Dispatch event to update progress component
        $this->dispatch('appointment-updated', $this->appointment->id);

        // Redirect to the inspection center selection page
        return $this->redirect(route('appointments.inspection-center.select', $this->appointment), true);
    }

    public function render()
    {
        return view('livewire.appointments.select-vehicle');
    }
}
