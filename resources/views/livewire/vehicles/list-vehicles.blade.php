<div class="flex w-full flex-col gap-4">
    @if($vehicles->isEmpty())
        <flux:callout icon="car" heading="{{ __('No vehicles yet') }}" subtitle="{{ __('Add your first vehicle to get started.') }}" />
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($vehicles as $vehicle)
                <livewire:vehicles.vehicle-card :vehicle="$vehicle" :key="$vehicle->id" />
            @endforeach
        </div>

        <div>
            {{ $vehicles->links() }}
        </div>
    @endif
</div>


