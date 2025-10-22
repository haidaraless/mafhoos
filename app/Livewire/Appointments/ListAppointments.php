<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
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
        // Get the authenticated user's current account
        $user = Auth::user();
        $currentAccount = $user?->currentAccount;
        
        if (!$currentAccount) {
            abort(403, 'No account selected');
        }

        // Get the provider associated with the current account
        $this->provider = Provider::where('account_id', $currentAccount->id)->first();
        
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
