<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use Livewire\Component;

class AppointmentProgress extends Component
{
    public $appointmentId;
    public $autoQuotationRequest = false;

    protected $listeners = [
        'appointment-updated' => '$refresh',
        'appointment-scheduled' => '$refresh',
        'edit-appointment' => 'handleEditAppointment'
    ];

    public function mount(Appointment $appointment)
    {
        $this->appointmentId = $appointment->id;
        $this->autoQuotationRequest = $appointment->auto_quotation_request ?? false;
    }

    public function handleAppointmentCompleted()
    {
        // Redirect to PayFees page
        return $this->redirect(route('appointments.fees.pay', $this->appointmentId), true);
    }

    public function handleEditAppointment($appointmentId)
    {
        // Handle edit appointment logic
        $this->dispatch('edit-appointment-requested', $appointmentId);
    }

    public function updatedAutoQuotationRequest()
    {
        // Update the appointment with the new auto quotation request value
        $appointment = Appointment::find($this->appointmentId);
        if ($appointment) {
            $appointment->update([
                'auto_quotation_request' => $this->autoQuotationRequest
            ]);
        }
    }

    public function render()
    {
        $appointment = Appointment::with(['vehicle', 'provider'])->find($this->appointmentId);
        
        return view('livewire.appointments.appointment-progress', [
            'appointment' => $appointment
        ]);
    }
}
