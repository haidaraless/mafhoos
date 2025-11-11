<div class="grid grid-cols-1">
    <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white border-b border-neutral-300">
        @svg('phosphor-car-light', 'size-10 md:size-12 text-orange-500')
        <div class="flex flex-col">
            <h1 class="text-2xl md:text-3xl text-neutral-800 font-bold">Select Vehicle</h1>
            <p class="text-neutral-600">Choose a vehicle to continue with your appointment</p>
        </div>
    </div>
    
    @if($vehicles->count() > 0)
        <div class="grid grid-cols-1">
            @foreach($vehicles as $vehicle)
                <div class="flex items-center justify-between border-t border-neutral-300 dark:border-white/10 p-4 bg-white dark:bg-white/5 hover:-translate-y-2.5 transition-all duration-200 cursor-pointer {{ $appointment->vehicle_id === $vehicle->id ? 'border-blue-500 bg-blue-50 dark:bg-white/10' : '' }}"
                        wire:click="selectVehicle('{{ $vehicle->id }}')">
                    <div class="flex flex-col">
                        <div class="flex items-center mb-3">
                            @svg('phosphor-car', 'size-5 text-sky-500 mr-2')
                            <h3 class="text-lg font-semibold text-neutral-800 dark:text-white">{{ $vehicle->name ?? ($vehicle->make . ' ' . $vehicle->model) }}</h3>
                        </div>
                        <div class="space-y-2 text-sm text-neutral-600 dark:text-white/70 flex-grow">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span>{{ $vehicle->year }} • {{ $vehicle->make }} • {{ $vehicle->model }}</span>
                            </div>
                            @if($vehicle->vin)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-mono text-xs">VIN: {{ $vehicle->vin }}</span>
                                </div>
                            @endif
                            @if($vehicle->body_class)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>{{ $vehicle->body_class }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-end">
                        @if($appointment->vehicle_id === $vehicle->id)
                            @svg('phosphor-check-circle', 'size-7 text-green-600')
                        @else
                            @svg('phosphor-circle', 'size-7 text-neutral-400')
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Create New Vehicle Link -->
        <div class="py-6 border-t border-neutral-200 dark:border-white/10">
            <div class="text-center">
                <p class="text-neutral-600 dark:text-white/70 mb-4">Don't see your vehicle?</p>
                <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-neutral-900 border border-neutral-900 dark:border-white/20 text-neutral-800 hover:text-white dark:text-white text-sm font-medium rounded-full transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Vehicle
                </a>
            </div>
        </div>
    @else
        <div class="text-center p-8 border border-neutral-300 dark:border-white/10 rounded-2xl bg-white dark:bg-white/5">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">No Vehicles Found</h3>
            <p class="text-neutral-600 dark:text-white/70 mb-6">You don't have any vehicles yet. Add your first vehicle to get started.</p>
            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-neutral-800 text-white text-sm font-medium rounded-full hover:bg-neutral-900 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Vehicle
            </a>
        </div>
    @endif
</div>