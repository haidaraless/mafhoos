<?php

namespace App\Livewire\Providers;

use Livewire\Component;

class ProviderSignup extends Component
{
    public function render()
    {
        return view('livewire.providers.provider-signup')->layout('layouts.auth.simple');
    }
}
