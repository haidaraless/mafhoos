<div class="grid grid-cols-1 gap-6 content-start">
    <div class="grid grid-cols-1 gap-2">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Inspection Report</h2>
        <div class="text-sm text-gray-600">
            <p><strong>Inspection Number:</strong> {{ $inspection->number }}</p>
            <p><strong>Vehicle:</strong> {{ $appointment->vehicle->make }} {{ $appointment->vehicle->model }} ({{ $appointment->vehicle->year }})</p>
            <p><strong>Owner:</strong> {{ $appointment->vehicle->user->name }}</p>
            <p><strong>Type:</strong> {{ $appointment->getInspectionType() }}</p>
        </div>
    </div>

    <div>
        <!-- Report Section -->
        <div class="mb-8">
            <label for="report" class="block text-sm font-medium text-gray-700 mb-2">
                Inspection Report
            </label>
            <textarea
                wire:model="report"
                id="report"
                rows="8"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter detailed inspection findings..."
                required
            ></textarea>
            @error('report') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Damage Spareparts Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Damage Spareparts</h3>
            
            <!-- Search Input -->
            <div class="mb-4">
                <label for="sparepart-search" class="block text-sm font-medium text-gray-700 mb-2">
                    Search Compatible Spareparts
                </label>
                <div class="text-xs text-gray-500 mb-2">
                    Showing only parts compatible with {{ $appointment->vehicle->make }} {{ $appointment->vehicle->model }} ({{ $appointment->vehicle->year }})
                </div>
                <input
                    type="text"
                    wire:model.live="sparepartSearch"
                    id="sparepart-search"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Type sparepart name to search..."
                />
                
                <!-- Search Results -->
                @if(count($sparepartSearchResults) > 0)
                    <div class="mt-2 bg-white border border-gray-300 rounded-md shadow-lg max-h-48 overflow-y-auto">
                        @foreach($sparepartSearchResults as $sparepart)
                            <button
                                type="button"
                                wire:click="selectSparepart('{{ $sparepart['id'] }}')"
                                class="w-full px-4 py-3 text-left hover:bg-gray-50 border-b border-gray-200 last:border-b-0 transition-colors cursor-pointer"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $sparepart['name'] }}</div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            {{ $sparepart['description'] ?? 'No description' }}
                                        </div>
                                        <div class="flex items-center space-x-2 mt-2">
                                            @if(isset($sparepart['category']))
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $sparepart['category'] }}</span>
                                            @endif
                                            @if(isset($sparepart['brand']))
                                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">{{ $sparepart['brand'] }}</span>
                                            @endif
                                            @if(isset($sparepart['availability']))
                                                <span class="px-2 py-1 text-xs font-medium {{ $sparepart['availability'] === 'In Stock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full">
                                                    {{ $sparepart['availability'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-shrink-0">
                                        <div class="text-xs text-green-600 font-medium">
                                            ✓ Compatible
                                        </div>
                                        @if(isset($sparepart['price_range']))
                                            <div class="text-xs text-gray-500 mt-1">
                                                ${{ $sparepart['price_range'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Damage Spareparts -->
            @if(count($this->damageSpareparts) > 0)
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h4 class="font-medium text-gray-900">Damage Spareparts ({{ count($this->damageSpareparts) }}):</h4>
                        <div class="flex items-center space-x-4 text-sm">
                            @php
                                $priorityCounts = [
                                    'high' => 0,
                                    'medium' => 0,
                                    'low' => 0
                                ];
                                foreach($this->damageSpareparts as $damageSparepart) {
                                    $priority = $damageSparepart->priority->value;
                                    $priorityCounts[$priority] = ($priorityCounts[$priority] ?? 0) + 1;
                                }
                            @endphp
                            @if($priorityCounts['high'] > 0)
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                    {{ $priorityCounts['high'] }} High Priority
                                </span>
                            @endif
                            @if($priorityCounts['medium'] > 0)
                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                    {{ $priorityCounts['medium'] }} Medium Priority
                                </span>
                            @endif
                            @if($priorityCounts['low'] > 0)
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    {{ $priorityCounts['low'] }} Low Priority
                                </span>
                            @endif
                        </div>
                    </div>
                    @foreach($this->damageSpareparts as $damageSparepart)
                        @php $sparepart = $damageSparepart->sparepart; @endphp
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">{{ $sparepart->name }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ $sparepart->description ?? 'No description' }}</div>
                                    @if($sparepart->brand)
                                        <div class="text-xs text-gray-400 mt-1">Brand: {{ $sparepart->brand }}</div>
                                    @endif
                                    @if($sparepart->category)
                                        <span class="inline-block mt-2 px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                            {{ $sparepart->category }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center space-x-3 ml-4">
                                    <!-- Priority Buttons -->
                                    <div class="flex flex-col space-y-2">
                                        <div class="text-xs font-medium text-gray-700">Priority:</div>
                                        <div class="flex space-x-1">
                                            <button
                                                type="button"
                                                wire:click="updatePriority('{{ $sparepart->id }}', 'low')"
                                                class="px-3 py-1 text-xs font-medium rounded-md transition-colors {{ $damageSparepart->priority->value === 'low' ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-700' }}"
                                            >
                                                Low
                                            </button>
                                            <button
                                                type="button"
                                                wire:click="updatePriority('{{ $sparepart->id }}', 'medium')"
                                                class="px-3 py-1 text-xs font-medium rounded-md transition-colors {{ $damageSparepart->priority->value === 'medium' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : 'bg-gray-100 text-gray-600 hover:bg-yellow-50 hover:text-yellow-700' }}"
                                            >
                                                Medium
                                            </button>
                                            <button
                                                type="button"
                                                wire:click="updatePriority('{{ $sparepart->id }}', 'high')"
                                                class="px-3 py-1 text-xs font-medium rounded-md transition-colors {{ $damageSparepart->priority->value === 'high' ? 'bg-red-100 text-red-800 border border-red-300' : 'bg-gray-100 text-gray-600 hover:bg-red-50 hover:text-red-700' }}"
                                            >
                                                High
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Remove Button -->
                                    <button
                                        type="button"
                                        wire:click="removeSparepart('{{ $sparepart->id }}')"
                                        class="px-3 py-2 text-sm font-medium text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 text-sm italic">No damage spareparts selected yet. Use the search above to add damaged spareparts.</div>
            @endif
        </div>


        <!-- Action Buttons -->
        <div class="flex justify-between items-center">
            <a
                href="{{ route('dashboard.vehicle-inspection-center') }}"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
            >
                Cancel
            </a>
            
            <div class="flex space-x-3">
                @if($inspection->completed_at)
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-md">Inspection Completed</span>
                @else
                    <button
                        type="button"
                        wire:click="saveReport"
                        class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Save Draft
                    </button>
                    <button
                        type="button"
                        wire:click="completeInspection"
                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                        Complete & Notify Owner
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>