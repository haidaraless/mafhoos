<?php

namespace App\Livewire\Providers;

use App\Enums\Day;
use App\Enums\Time;
use App\Models\AvailableTime;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Enums\ProviderType;
use Livewire\Component;

class ManageAvailableTimes extends Component
{
    public Provider $provider;

    /** @var array<int, array{ id:int|null, day:string|null, time:string|null }> */
    public array $slots = [];

    public ?string $newDay = null;

    public function mount(): void
    {
        $this->provider = Provider::find(Auth::user()->currentAccount->accountable_id);

        if (is_null($this->provider)) {
            abort(403, 'You are not authorized to access this page');
        }

        if ($this->provider->type !== ProviderType::VEHICLE_INSPECTION_CENTER) {
            abort(403, 'You are not authorized to access this page');       
        }

        $this->loadSlots();
    }

    public function render()
    {
        return view('livewire.providers.manage-available-times', [
            'days' => array_map(fn (Day $d) => $d->value, Day::cases()),
            'times' => array_map(fn (Time $t) => $t->value, Time::cases()),
        ]);
    }

    public function updatedNewDay(string $day): void
    {
        $this->dispatch('day-updated', day: $day);
    }

    public function loadSlots(): void
    {
        $this->slots = $this->provider->availableTimes()
            ->orderBy('day')
            ->orderBy('time')
            ->get(['id', 'day', 'time'])
            ->map(fn (AvailableTime $t) => [
                'id' => $t->id,
                'day' => $t->day,
                'time' => $t->time,
            ])
            ->toArray();
    }

    public function addSlot(): void
    {
        $this->validate($this->rulesForNew());

        // prevent duplicate (day,time) for this provider
        $exists = $this->provider->availableTimes()
            ->where('day', $this->newDay)
            ->where('time', $this->newTime)
            ->exists();

        if ($exists) {
            $this->addError('newTime', __('This time slot already exists.'));
            return;
        }

        $created = $this->provider->availableTimes()->create([
            'day' => $this->newDay,
            'time' => $this->newTime,
        ]);

        $this->newDay = null;
        $this->newTime = null;

        $this->slots[] = [
            'id' => $created->id,
            'day' => $created->day,
            'time' => $created->time,
        ];
    }

    public function updateSlot(int $index): void
    {
        $slot = $this->slots[$index] ?? null;
        if (!$slot || !$slot['id']) {
            return;
        }

        $this->validate($this->rulesForIndex($index));

        // prevent duplicate (day,time) for this provider (excluding current id)
        $exists = $this->provider->availableTimes()
            ->where('day', $slot['day'])
            ->where('time', $slot['time'])
            ->where('id', '!=', $slot['id'])
            ->exists();

        if ($exists) {
            $this->addError("slots.$index.time", __('This time slot already exists.'));
            return;
        }

        $this->provider->availableTimes()->whereKey($slot['id'])->update([
            'day' => $slot['day'],
            'time' => $slot['time'],
        ]);
    }

    public function deleteSlot(int $index): void
    {
        $slot = $this->slots[$index] ?? null;
        if (!$slot) {
            return;
        }

        if (!empty($slot['id'])) {
            $this->provider->availableTimes()->whereKey($slot['id'])->delete();
        }

        unset($this->slots[$index]);
        $this->slots = array_values($this->slots);
    }

    protected function rulesForNew(): array
    {
        return [
            'newDay' => [
                'required',
                Rule::in(array_map(fn (Day $d) => $d->value, Day::cases())),
            ],
            'newTime' => [
                'required',
                Rule::in(array_map(fn (Time $t) => $t->value, Time::cases())),
            ],
        ];
    }

    protected function rulesForIndex(int $index): array
    {
        return [
            "slots.$index.day" => [
                'required',
                Rule::in(array_map(fn (Day $d) => $d->value, Day::cases())),
            ],
            "slots.$index.time" => [
                'required',
                Rule::in(array_map(fn (Time $t) => $t->value, Time::cases())),
            ],
        ];
    }
}


