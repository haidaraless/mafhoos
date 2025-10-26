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

    <form wire:submit.prevent="saveReport">
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
                    Search Spareparts
                </label>
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
                                class="w-full px-4 py-2 text-left hover:bg-gray-50 border-b border-gray-200 last:border-b-0"
                            >
                                <div class="font-medium">{{ $sparepart['name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $sparepart['description'] ?? 'No description' }}</div>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Selected Spareparts -->
            @if(count($selectedSpareparts) > 0)
                <div class="space-y-3">
                    <h4 class="font-medium text-gray-900">Selected Spareparts:</h4>
                    @foreach($this->selectedSpareparts as $sparepart)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <div class="font-medium">{{ $sparepart->name }}</div>
                                <div class="text-sm text-gray-500">{{ $sparepart->description ?? 'No description' }}</div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <!-- Priority Select -->
                                <select
                                    wire:change="updatePriority('{{ $sparepart->id }}', $event.target.value)"
                                    class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="low" {{ ($sparepartPriorities[$sparepart->id] ?? 'medium') === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ ($sparepartPriorities[$sparepart->id] ?? 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ ($sparepartPriorities[$sparepart->id] ?? 'medium') === 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                
                                <!-- Remove Button -->
                                <button
                                    type="button"
                                    wire:click="removeSparepart('{{ $sparepart->id }}')"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 text-sm italic">No spareparts selected yet. Use the search above to add damaged spareparts.</div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4">
            <a
                href="{{ route('dashboard.vehicle-inspection-center') }}"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Save Report
            </button>
        </div>
    </form>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>