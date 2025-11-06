<div class="w-full">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="flex-1">

            <!-- Vehicle Selection -->
            <div class="bg-blue-400">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Select Vehicle</h2>
                    @if($appointment->vehicle_id)
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Current:</span> {{ $appointment->vehicle->name ?? ($appointment->vehicle->make . ' ' . $appointment->vehicle->model) }}
                        </div>
                    @endif
                </div>
                
                @if($vehicles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($vehicles as $vehicle)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 cursor-pointer {{ $appointment->vehicle_id === $vehicle->id ? 'border-blue-500 bg-blue-50' : '' }}"
                                 wire:click="selectVehicle('{{ $vehicle->id }}')">
                                <div class="flex flex-col h-full">
                                    <div class="flex items-center mb-3">
                                        <svg class="w-6 h-6 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $vehicle->name ?? ($vehicle->make . ' ' . $vehicle->model) }}</h3>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-600 flex-grow">
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
                                    <div class="mt-4 pt-3 border-t border-gray-100">
                                        @if($appointment->vehicle_id === $vehicle->id)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Selected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Click to Select
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Create New Vehicle Link -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Don't see your vehicle?</p>
                            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add New Vehicle
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center p-8 border border-neutral-200 rounded-lg">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Vehicles Found</h3>
                        <p class="text-gray-500 mb-6">You don't have any vehicles yet. Add your first vehicle to get started.</p>
                        <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Vehicle
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
