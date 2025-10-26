<?php

namespace App\Livewire\Appointments;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Appointments')]
class ListAppointments extends Component
{
    public Collection $appointments;
    public ?Provider $provider = null;

    public function mount()
    {
        $this->provider = Provider::find( Auth::user()->currentAccount->accountable_id);
        
        if (!$this->provider) {
            abort(403, 'No provider account found');
        }

        // Load appointments for this provider
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $this->appointments = $this->provider->appointments()
            ->with(['vehicle', 'fees'])
            ->orderBy('scheduled_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.appointments.list-appointments');
    }
}
