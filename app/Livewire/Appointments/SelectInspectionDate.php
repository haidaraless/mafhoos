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
    public $currentMonth;
    public $currentYear;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDate = now()->format('Y-m-d');
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

    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function selectDate($date)
    {
        // Prevent selecting past dates
        $selectedDate = Carbon::parse($date);
        $today = Carbon::today();
        
        if ($selectedDate->lt($today)) {
            return; // Don't allow selecting past dates
        }
        
        $this->selectedDate = $date;
        $this->selectedTime = ''; // Reset time when date changes
    }

    public function getCalendarDays()
    {
        $firstDay = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $startDate = $firstDay->copy()->startOfWeek(Carbon::SUNDAY);
        $endDate = $lastDay->copy()->endOfWeek(Carbon::SATURDAY);

        $days = [];
        $current = $startDate->copy();
        $today = Carbon::today();

        while ($current <= $endDate) {
            $dateString = $current->format('Y-m-d');
            $isPast = $current->lt($today);
            
            $days[] = [
                'date' => $dateString,
                'day' => $current->day,
                'isCurrentMonth' => $current->month == $this->currentMonth,
                'isSelected' => $dateString == $this->selectedDate,
                'isToday' => $current->isToday(),
                'isPast' => $isPast,
            ];
            $current->addDay();
        }

        return $days;
    }

    public function getMonthName()
    {
        return Carbon::create($this->currentYear, $this->currentMonth, 1)->format('F');
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

        return redirect()->route('appointments.fees.pay', $this->appointment);
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
