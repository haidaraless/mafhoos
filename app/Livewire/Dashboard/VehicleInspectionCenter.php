<?php

namespace App\Livewire\Dashboard;

use App\Enums\AppointmentStatus;
use App\Enums\FeeStatus;
use App\Enums\ProviderType;
use App\Models\Appointment;
use App\Models\Fee;
use App\Models\Inspection;
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

        $this->provider = Provider::find($currentAccount->accountable_id);
        
        // Only load appointments for vehicle inspection centers
        if ($this->provider->type !== ProviderType::VEHICLE_INSPECTION_CENTER) {
            $this->inspectionAppointments = collect();
            return;
        }

        // Get today's inspection appointments for this provider
        $this->inspectionAppointments = Appointment::where('provider_id', $this->provider->id)
            ->whereDate('scheduled_at', today())
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

    public function startInspection($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment || $appointment->provider_id !== $this->provider->id) {
            $this->addError('appointment', 'Appointment not found.');
            return;
        }

        // Create inspection record if it doesn't exist
        $inspection = Inspection::firstOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'number' => 'INS-' . $appointment->number,
                'type' => $appointment->inspection_type,
                'technician_id' => Auth::id(),
                'provider_id' => $appointment->provider_id,
                'vehicle_id' => $appointment->vehicle_id,
                'started_at' => now(),
            ]
        );

        // Redirect to the inspection report creation page
        return $this->redirect(route('inspections.report', $inspection), true);
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

    public function getAppointmentsByStatusProperty()
    {
        if (!isset($this->provider)) {
            return [];
        }

        $appointments = Appointment::where('provider_id', $this->provider->id)->get();
        
        $statusCounts = [
            'pending' => 0,
            'confirmed' => 0,
            'completed' => 0,
            'cancelled' => 0,
        ];

        foreach ($appointments as $appointment) {
            $status = $appointment->status->value;
            if (isset($statusCounts[$status])) {
                $statusCounts[$status]++;
            }
        }

        return $statusCounts;
    }

    public function getTotalFeesEarnedProperty()
    {
        if (!isset($this->provider)) {
            return 0;
        }

        return Fee::whereHas('appointment', function ($query) {
            $query->where('provider_id', $this->provider->id);
        })
        ->where('status', FeeStatus::PAID)
        ->sum('amount');
    }

    public function getTodayAppointmentsProperty()
    {
        if (!isset($this->provider)) {
            return 0;
        }

        return Appointment::where('provider_id', $this->provider->id)
            ->whereDate('created_at', today())
            ->count();
    }

    public function getYesterdayAppointmentsProperty()
    {
        if (!isset($this->provider)) {
            return 0;
        }

        return Appointment::where('provider_id', $this->provider->id)
            ->whereDate('created_at', today()->subDay())
            ->count();
    }

    public function getThisWeekAppointmentsProperty()
    {
        if (!isset($this->provider)) {
            return 0;
        }

        return Appointment::where('provider_id', $this->provider->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
    }

    public function getThisMonthAppointmentsProperty()
    {
        if (!isset($this->provider)) {
            return 0;
        }

        return Appointment::where('provider_id', $this->provider->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard.vehicle-inspection-center');
    }
}
