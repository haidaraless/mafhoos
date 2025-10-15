<?php

namespace App\Livewire\Providers;

use App\Models\AvailableTime;
use App\Models\Provider;
use Livewire\Component;

class AvailableTimeToggle extends Component
{
    public Provider $provider;
    public string $day;
    public string $time;

    public ?int $recordId = null;
    public bool $isSelected = false;

    public function mount(Provider $provider, string $day, string $time): void
    {
        $this->provider = $provider;
        $this->day = $day;
        $this->time = $time;

        $existing = AvailableTime::query()
            ->where('provider_id', $this->provider->id)
            ->where('day', $this->day)
            ->where('time', $this->time)
            ->first(['id']);

        if ($existing) {
            $this->recordId = $existing->id;
            $this->isSelected = true;
        }
    }

    public function toggle(): void
    {
        if ($this->isSelected && $this->recordId) {
            AvailableTime::query()->whereKey($this->recordId)->delete();
            $this->recordId = null;
            $this->isSelected = false;
            $this->dispatch('available-time-updated');
            return;
        }

        $created = AvailableTime::create([
            'provider_id' => $this->provider->id,
            'day' => $this->day,
            'time' => $this->time,
        ]);

        $this->recordId = $created->id;
        $this->isSelected = true;
        $this->dispatch('available-time-updated');
    }

    public function render()
    {
        return view('livewire.providers.available-time-toggle');
    }
}


