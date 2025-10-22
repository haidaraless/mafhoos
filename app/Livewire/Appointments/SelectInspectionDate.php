<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use Carbon\Carbon;
use Livewire\Component;

class SelectInspectionDate extends Component
{
    public Appointment $appointment;
    public $selectedDate = '';
    public $selectedTime = '';
    public $availableDates = [];

    public function mount()
    {
        $this->generateAvailableDates();
    }

    public function generateAvailableDates()
    {
        $this->availableDates = [];
        $today = Carbon::now();
        
        // Generate today and next 7 days
        for ($i = 0; $i < 8; $i++) {
            $date = $today->copy()->addDays($i);
            $this->availableDates[] = [
                'date' => $date->format('Y-m-d'),
                'day' => strtolower($date->format('l')),
                'display' => $date->format('M j, Y'),
                'isToday' => $i === 0,
                'isTomorrow' => $i === 1
            ];
        }
    }

    public function daySelected($data)
    {
        $this->selectedDate = $data['date'];
        $this->selectedTime = $data['time'];
    }

    public function confirmSelection()
    {
        if (!$this->selectedDate || !$this->selectedTime) {
            $this->addError('selection', 'Please select both date and time.');
            return;
        }

        // Create the datetime by combining the selected date with the time
        $scheduledAt = Carbon::parse($this->selectedDate . ' ' . $this->selectedTime);
        
        // Double-check if the time slot is still available
        $existingAppointment = Appointment::query()
            ->where('provider_id', $this->appointment->provider_id)
            ->whereDate('scheduled_at', $this->selectedDate)
            ->whereTime('scheduled_at', $this->selectedTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('id', '!=', $this->appointment->id) // Exclude current appointment
            ->first();

        if ($existingAppointment) {
            $this->addError('selection', 'This time slot has been booked by another user. Please select a different time.');
            return;
        }
        
        // Update the appointment
        $this->appointment->update([
            'scheduled_at' => $scheduledAt
        ]);

        // Dispatch events to update progress component
        $this->dispatch('appointment-updated', $this->appointment->id);
        $this->dispatch('appointment-scheduled', $this->appointment->id);
    }

    protected $listeners = ['day-selected' => 'daySelected'];

    public function refreshBookedTimes()
    {
        // This method can be called to refresh booked times across all day components
        $this->dispatch('refresh-booked-times');
    }

    public function render()
    {
        return view('livewire.appointments.select-inspection-date');
    }
}
