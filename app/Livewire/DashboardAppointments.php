<?php

namespace App\Livewire;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Enums\AccountType;

class DashboardAppointments extends Component
{
    public Collection $draftAppointments;
    public Collection $upcomingAppointments;
    public Collection $recentAppointments;
    public bool $canCreateAppointment = false;

    public function mount()
    {
        $this->loadAppointments();
        $this->canCreateAppointment = Auth::user()->currentAccount->type === AccountType::VEHICLE_OWNER;
    }

    public function loadAppointments()
    {
        $user = Auth::user();
        $currentAccount = $user?->currentAccount;
        
        if (!$currentAccount) {
            $this->draftAppointments = collect();
            $this->upcomingAppointments = collect();
            $this->recentAppointments = collect();
            return;
        }

        // Get all vehicles for the current account
        $vehicleIds = Vehicle::where('user_id', $currentAccount->user_id)->pluck('id');

        // Draft appointments: pending status (all pending appointments are considered drafts)
        $this->draftAppointments = Appointment::whereIn('vehicle_id', $vehicleIds)
            ->where('status', AppointmentStatus::PENDING)
            ->with(['vehicle', 'provider'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Upcoming appointments: confirmed status with future scheduled_at
        $this->upcomingAppointments = Appointment::whereIn('vehicle_id', $vehicleIds)
            ->where('status', AppointmentStatus::CONFIRMED)
            ->where('scheduled_at', '>', now())
            ->with(['vehicle', 'provider'])
            ->orderBy('scheduled_at', 'asc')
            ->get();

        // Recent appointments: completed or cancelled in the last 30 days
        $this->recentAppointments = Appointment::whereIn('vehicle_id', $vehicleIds)
            ->whereIn('status', [AppointmentStatus::COMPLETED, AppointmentStatus::CANCELLED])
            ->where('updated_at', '>=', now()->subDays(30))
            ->with(['vehicle', 'provider'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function continueDraftAppointment($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment) {
            $this->addError('appointment', 'Appointment not found.');
            return;
        }

        // Always start from the beginning to allow modification of any step
        // This ensures users can change inspection center, type, or date
        return $this->redirect(route('appointments.inspection-center.select', $appointment), true);
    }

    public function cancelDraftAppointment($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment) {
            $this->addError('appointment', 'Appointment not found.');
            return;
        }

        $appointment->update([
            'status' => AppointmentStatus::CANCELLED,
            'cancelled_at' => now()
        ]);

        $this->loadAppointments();
        $this->dispatch('appointment-cancelled', $appointmentId);
    }

    public function viewAppointment($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment) {
            $this->addError('appointment', 'Appointment not found.');
            return;
        }

        // Redirect to appointments index with the specific appointment
        return $this->redirect(route('appointments.index') . '?appointment=' . $appointmentId, true);
    }

    public function render()
    {
        return view('livewire.dashboard-appointments');
    }
}
