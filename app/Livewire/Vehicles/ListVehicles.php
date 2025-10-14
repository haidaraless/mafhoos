<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ListVehicles extends Component
{
    use WithPagination;

    public int $perPage = 12;

    #[On('vehicle-created')]
    public function refreshVehicles(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $vehicles = Vehicle::query()
            ->where('user_id', Auth::id())
            ->latest('created_at')
            ->paginate($this->perPage);

        return view('livewire.vehicles.list-vehicles', [
            'vehicles' => $vehicles,
        ]);
    }
}


