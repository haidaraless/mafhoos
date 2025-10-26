<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Spare Parts Catalog</h2>
            <p class="text-gray-600">Manage and search spare parts database</p>
        </div>
        <div class="flex space-x-3">
            <button
                wire:click="downloadSampleCsv"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Download Sample CSV
            </button>
            <button
                wire:click="showImportModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Import CSV
            </button>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-2xl font-bold text-blue-600">{{ $catalogStats['total_parts'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Total Parts</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-2xl font-bold text-green-600">{{ $catalogStats['makes'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Vehicle Makes</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-2xl font-bold text-purple-600">{{ $catalogStats['models'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Vehicle Models</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-2xl font-bold text-orange-600">{{ $catalogStats['categories'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Categories</div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Search & Filter</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <!-- Search Query -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input
                    type="text"
                    wire:model.live="searchQuery"
                    placeholder="Part name, number, or description..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <!-- Vehicle Make -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Make</label>
                <select
                    wire:model.live="selectedMake"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">All Makes</option>
                    @foreach($vehicleMakes as $make)
                        <option value="{{ $make }}">{{ $make }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Vehicle Model -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Model</label>
                <select
                    wire:model.live="selectedModel"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    {{ empty($selectedMake) ? 'disabled' : '' }}
                >
                    <option value="">All Models</option>
                    @foreach($vehicleModels as $model)
                        <option value="{{ $model }}">{{ $model }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category -->
<div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select
                    wire:model.live="selectedCategory"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Showing {{ count($searchResults) }} results
            </div>
            <button
                wire:click="clearFilters"
                class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 focus:outline-none"
            >
                Clear Filters
            </button>
        </div>
    </div>

    <!-- Search Results -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Search Results</h3>
        </div>
        
        @if(count($searchResults) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price Range</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Availability</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($searchResults as $part)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $part['part_number'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $part['name'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $part['description'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $part['brand'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $part['vehicle_make'] }} {{ $part['vehicle_model'] }}
                                    <div class="text-xs text-gray-400">{{ $part['year_range'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        {{ $part['category'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ $part['price_range'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 text-xs font-medium {{ $part['availability'] === 'In Stock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full">
                                        {{ $part['availability'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="text-gray-500 text-lg">No spare parts found</div>
                <div class="text-gray-400 text-sm mt-2">
                    Try adjusting your search criteria or import a CSV file
                </div>
            </div>
        @endif
    </div>

    <!-- Import Modal -->
    @if($showImportModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="hideImportModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Import Spare Parts Catalog</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">CSV File</label>
                        <input
                            type="file"
                            wire:model="csvFile"
                            accept=".csv,.txt"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                        @error('csvFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if($importProgress > 0)
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Progress</span>
                                <span>{{ $importProgress }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $importProgress }}%"></div>
                            </div>
                            <div class="text-sm text-gray-600 mt-2">{{ $importStatus }}</div>
                        </div>
                    @endif

                    <div class="flex justify-end space-x-3">
                        <button
                            wire:click="hideImportModal"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
                            {{ $importProgress > 0 && $importProgress < 100 ? 'disabled' : '' }}
                        >
                            Cancel
                        </button>
                        <button
                            wire:click="importCatalog"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            {{ $importProgress > 0 && $importProgress < 100 ? 'disabled' : '' }}
                        >
                            Import
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('import-completed', () => {
            setTimeout(() => {
                @this.call('hideImportModal');
            }, 2000);
        });
    });
</script>