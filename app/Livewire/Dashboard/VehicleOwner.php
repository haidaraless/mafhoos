<?php

namespace App\Livewire\Dashboard;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Vehicle;
use App\Models\Inspection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\QuotationRequest;

class VehicleOwner extends Component
{
    public Collection $vehicles;
    public Collection $draftAppointments;
    public Collection $upcomingAppointments;
    public Collection $completedInspections;
    public Collection $quotationRequests;

    public function mount()
    {
        $this->loadVehicles();
        $this->loadAppointments();
        $this->loadCompletedInspections();
        $this->loadQuotationRequests();
    }

    public function loadVehicles()
    {
        $this->vehicles = Vehicle::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function loadAppointments()
    {
        // Draft appointments: pending status (all pending appointments are considered drafts)
        $this->draftAppointments = Appointment::pending()->whereIn('vehicle_id', $this->vehicles->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->get();

        // Upcoming appointments: confirmed status with future scheduled_at
        $this->upcomingAppointments = Appointment::confirmed()->whereIn('vehicle_id', $this->vehicles->pluck('id'))   
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    public function loadCompletedInspections()
    {
        $this->completedInspections = Inspection::whereIn('vehicle_id', $this->vehicles->pluck('id'))
            ->whereNotNull('completed_at')
            ->with(['vehicle', 'provider', 'appointment'])
            ->orderBy('completed_at', 'desc')
            ->get();
    }

    public function loadQuotationRequests()
    {
        $this->quotationRequests = QuotationRequest::whereHas('inspection.appointment.vehicle', function($q) {
            $q->where('user_id', Auth::user()->id);
        })
        ->orderBy('created_at', 'desc')
        ->with(['inspection.appointment.vehicle', 'status', 'type'])
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

    public function viewInspection($inspectionId)
    {
        return $this->redirect(route('inspections.view', $inspectionId), true);
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
        return view('livewire.dashboard.vehicle-owner');
    }
}
