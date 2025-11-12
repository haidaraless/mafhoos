<?php

namespace App\Livewire\Appointments;

use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Appointments')]
class ListAppointments extends Component
{
    public Collection $appointments;
    public ?Provider $provider = null;
    public $selectedDate;
    public $currentMonth;
    public $currentYear;

    public function mount()
    {
        $this->provider = Provider::find( Auth::user()->currentAccount->accountable_id);
        
        if (!$this->provider) {
            abort(403, 'No provider account found');
        }

        // Set current date as selected
        $this->selectedDate = now()->format('Y-m-d');
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;

        // Load appointments for this provider
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $query = $this->provider->appointments()
            ->with(['vehicle.user', 'fees'])
            ->whereNotNull('scheduled_at');

        if ($this->selectedDate) {
            $query->whereDate('scheduled_at', $this->selectedDate);
        }

        $this->appointments = $query
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->loadAppointments();
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

    public function getAppointmentsForTime($hour)
    {
        return $this->appointments->filter(function ($appointment) use ($hour) {
            if (!$appointment->scheduled_at) {
                return false;
            }
            $appointmentHour = (int) $appointment->scheduled_at->format('H');
            return $appointmentHour == $hour;
        });
    }

    public function getCalendarDays()
    {
        $firstDay = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $startDate = $firstDay->copy()->startOfWeek(Carbon::SUNDAY);
        $endDate = $lastDay->copy()->endOfWeek(Carbon::SATURDAY);

        $days = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $days[] = [
                'date' => $current->format('Y-m-d'),
                'day' => $current->day,
                'isCurrentMonth' => $current->month == $this->currentMonth,
                'isSelected' => $current->format('Y-m-d') == $this->selectedDate,
                'isToday' => $current->isToday(),
            ];
            $current->addDay();
        }

        return $days;
    }

    public function getMonthName()
    {
        return Carbon::create($this->currentYear, $this->currentMonth, 1)->format('F');
    }

    public function render()
    {
        return view('livewire.appointments.list-appointments');
    }
}
