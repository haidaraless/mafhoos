<div class="h-full rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
    <div class="flex items-start gap-3">
        <x-phosphor-car class="text-zinc-500 size-6 shrink-0" />
        <div class="min-w-0">
            <div class="font-semibold truncate">{{ $vehicle->name ?? ($vehicle->make . ' ' . $vehicle->model) }}</div>
            <div class="text-sm text-zinc-500 truncate">
                {{ $vehicle->year }} • {{ $vehicle->make }} • {{ $vehicle->model }}
            </div>
            @if($vehicle->vin)
                <div class="text-xs text-zinc-400 mt-1 truncate">VIN: {{ $vehicle->vin }}</div>
            @endif
            <div class="mt-3 flex gap-2">
                <flux:button size="sm" variant="ghost" icon="wrench-screwdriver">{{ __('Create Inspection Appointment') }}</flux:button>
            </div>
        </div>
    </div>
</div>


