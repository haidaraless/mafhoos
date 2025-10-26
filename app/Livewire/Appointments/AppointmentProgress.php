<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use Livewire\Component;

class AppointmentProgress extends Component
{
    public $appointmentId;

    protected $listeners = [
        'appointment-updated' => '$refresh',
        'appointment-scheduled' => '$refresh',
        'edit-appointment' => 'handleEditAppointment'
    ];

    public function mount(Appointment $appointment)
    {
        $this->appointmentId = $appointment->id;
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

    public function render()
    {
        $appointment = Appointment::with(['vehicle', 'provider'])->find($this->appointmentId);
        
        return view('livewire.appointments.appointment-progress', [
            'appointment' => $appointment
        ]);
    }
}
