<?php

namespace App\Livewire\Providers;

use App\Enums\Time;
use App\Models\Provider;
use Livewire\Attributes\On;
use Livewire\Component;

class AvailableTimeOfDay extends Component
{
    public Provider $provider;
    public string $day;
    public array $times;

    public function mount(): void
    {
        $this->times = array_map(fn (Time $t) => $t->value, Time::cases());
    }

    #[On('day-updated')]
    public function onDayUpdated(string $day): void
    {
        $this->day = $day;
    }

    public function render()
    {
        return view('livewire.providers.available-time-of-day');
    }
}
