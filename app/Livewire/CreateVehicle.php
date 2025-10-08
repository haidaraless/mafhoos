<?php

namespace App\Livewire;

use Livewire\Component;

class CreateVehicle extends Component
{
    public string $name = '';
    public string $brand = '';
    public string $model = '';

    public function store()
    {
        $this->validate();
    }

    public function render()
    {
        return view('livewire.create-vehicle');
    }
}
