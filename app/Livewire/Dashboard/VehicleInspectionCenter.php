<?php

namespace App\Livewire\Dashboard;

use App\Enums\AppointmentStatus;
use App\Enums\ProviderType;
use App\Models\Appointment;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VehicleInspectionCenter extends Component
{
    public Collection $inspectionAppointments;
    public Provider $provider;

    public function mount()
    {
        $this->loadInspectionAppointments();
    }

    public function loadInspectionAppointments()
    {
        $user = Auth::user();
        $currentAccount = $user?->currentAccount;
        
        if (!$currentAccount || !$currentAccount->isProvider()) {
            $this->inspectionAppointments = collect();
            return;
        }

        $this->provider = $currentAccount->accountable;
        
        // Only load appointments for vehicle inspection centers
        if ($this->provider->type !== ProviderType::VEHICLE_INSPECTION_CENTER) {
            $this->inspectionAppointments = collect();
            return;
        }

        // Get all inspection appointments for this provider
        $this->inspectionAppointments = Appointment::where('provider_id', $this->provider->id)
            ->with(['vehicle', 'vehicle.user'])
            ->orderBy('scheduled_at', 'desc')
            ->get();
    }

    public function confirmAppointment($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment || $appointment->provider_id !== $this->provider->id) {
            $this->addError('appointment', 'Appointment not found.');
            return;
        }

        $appointment->update([
            'status' => AppointmentStatus::CONFIRMED,
            'confirmed_at' => now()
        ]);

        $this->loadInspectionAppointments();
        $this->dispatch('appointment-confirmed', $appointmentId);
    }

    public function completeAppointment($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment || $appointment->provider_id !== $this->provider->id) {
            $this->addError('appointment', 'Appointment not found.');
            return;
        }

        $appointment->update([
            'status' => AppointmentStatus::COMPLETED,
            'completed_at' => now()
        ]);

        $this->loadInspectionAppointments();
        $this->dispatch('appointment-completed', $appointmentId);
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment || $appointment->provider_id !== $this->provider->id) {
            $this->addError('appointment', 'Appointment not found.');
            return;
        }

        $appointment->update([
            'status' => AppointmentStatus::CANCELLED,
            'cancelled_at' => now()
        ]);

        $this->loadInspectionAppointments();
        $this->dispatch('appointment-cancelled', $appointmentId);
    }

    public function render()
    {
        return view('livewire.dashboard.vehicle-inspection-center');
    }
}
