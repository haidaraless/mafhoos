<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\AvailableTime;
use Carbon\Carbon;
use Livewire\Component;

class DaySelector extends Component
{
    public $date;
    public $dayName;
    public $displayDate;
    public $availableTimes = [];
    public $bookedTimes = [];
    public $isSelected = false;
    public $selectedTime = '';
    public $appointmentId;
    public $providerId;

    public function mount($date, $appointmentId)
    {
        $this->date = $date;
        $this->appointmentId = $appointmentId;
        $this->dayName = strtolower(Carbon::parse($date)->format('l'));
        $this->displayDate = Carbon::parse($date);
        
        // Get provider ID from appointment
        $appointment = Appointment::find($appointmentId);
        $this->providerId = $appointment->provider_id;
        
        $this->loadAvailableTimes();
        $this->loadBookedTimes();
    }

    public function loadAvailableTimes()
    {
        $this->availableTimes = AvailableTime::query()
            ->where('provider_id', $this->providerId)
            ->where('day', $this->dayName)
            ->orderBy('time')
            ->get()
            ->pluck('time')
            ->toArray();
    }

    public function loadBookedTimes()
    {
        // Get all appointments for this provider on this specific date
        $appointments = Appointment::query()
            ->where('provider_id', $this->providerId)
            ->whereDate('scheduled_at', $this->date)
            ->whereIn('status', ['pending', 'confirmed']) // Only count active appointments
            ->get();

        $this->bookedTimes = $appointments->map(function ($appointment) {
            return [
                'time' => $appointment->scheduled_at->format('H:i'),
                'status' => $appointment->status,
                'appointment_id' => $appointment->id
            ];
        })->toArray();
    }

    public function isTimeBooked($time)
    {
        return collect($this->bookedTimes)->contains('time', $time);
    }

    public function isTimeInPast($time)
    {
        $dateTime = Carbon::parse($this->date . ' ' . $time);
        $now = Carbon::now();
        
        // For today's date, any time before or equal to current time is past
        if ($dateTime->isToday()) {
            // Use lte (less than or equal) to include current time as past
            return $dateTime->lte($now);
        }
        
        // For future dates, all times are available
        return false;
    }

    public function isTimeAvailable($time)
    {
        return !$this->isTimeBooked($time) && !$this->isTimeInPast($time);
    }

    public function selectTime($time)
    {
        // Check if time is booked
        if ($this->isTimeBooked($time)) {
            $this->addError('time', 'This time slot is already booked.');
            return;
        }

        // Check if time is in the past
        if ($this->isTimeInPast($time)) {
            $this->addError('time', 'This time slot is no longer available as it has already passed.');
            return;
        }

        $this->selectedTime = $time;
        $this->isSelected = true;
        
        // Dispatch event to parent component
        $this->dispatch('day-selected', [
            'date' => $this->date,
            'time' => $time,
            'dayName' => $this->dayName
        ]);
    }

    protected $listeners = ['refresh-booked-times' => 'loadBookedTimes'];

    public function render()
    {
        return view('livewire.appointments.day-selector');
    }
}
