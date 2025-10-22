<?php

namespace App\Livewire\Vehicles;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Vehicle;
use Livewire\Component;

class VehicleCard extends Component
{
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    public function createAppointment()
    {
        $appointment = Appointment::create([
            'vehicle_id' => $this->vehicle->id,
            'status' => AppointmentStatus::PENDING->value,
        ]);

        return $this->redirect(route('appointments.inspection-center.select', $appointment), true);
    }

    public function render()
    {
        return view('livewire.vehicles.vehicle-card');
    }
}


