<div class="min-h-screen">
    <div class="max-w-7xl mx-auto py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Quotation Requests</h1>
                    <p class="text-gray-600">Browse and manage your vehicle quotation requests</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-600">
                        {{ $quotationRequests->total() }} request{{ $quotationRequests->total() !== 1 ? 's' : '' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" 
                           id="search"
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Search by ID, make, model, or VIN..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select wire:model.live="statusFilter" 
                            id="statusFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Statuses</option>
                        <option value="open">Open</option>
                        <option value="pending">Pending</option>
                        <option value="quoted">Quoted</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div>
                    <label for="typeFilter" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select wire:model.live="typeFilter" 
                            id="typeFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        <option value="repair">Repair</option>
                        <option value="spare-parts">Spare Parts</option>
                    </select>
                </div>

                <!-- Vehicle Filter -->
                <div>
                    <label for="vehicleFilter" class="block text-sm font-medium text-gray-700 mb-1">Vehicle</label>
                    <select wire:model.live="vehicleFilter" 
                            id="vehicleFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Vehicles</option>
                        @foreach($userVehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">
                                {{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Clear Filters Button -->
            @if($search || $statusFilter || $typeFilter || $vehicleFilter)
                <div class="mt-4">
                    <button wire:click="clearFilters" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                </div>
            @endif
        </div>

        <!-- Quotation Requests List -->
        <div class="space-y-4">
            @forelse($quotationRequests as $quotationRequest)
                <div class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }} Request #{{ $quotationRequest->id }}
                                </h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($quotationRequest->status->value === 'open') bg-blue-100 text-blue-800
                                    @elseif($quotationRequest->status->value === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($quotationRequest->status->value === 'quoted') bg-green-100 text-green-800
                                    @elseif($quotationRequest->status->value === 'cancelled') bg-red-100 text-red-800
                                    @elseif($quotationRequest->status->value === 'expired') bg-gray-100 text-gray-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($quotationRequest->status->value) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Vehicle:</span>
                                    <span class="text-sm text-gray-600 ml-2">
                                        {{ $quotationRequest->inspection->appointment->vehicle->year }} 
                                        {{ $quotationRequest->inspection->appointment->vehicle->make }} 
                                        {{ $quotationRequest->inspection->appointment->vehicle->model }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">VIN:</span>
                                    <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->vin }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Created:</span>
                                    <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->created_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>

                            <!-- Quotation Summary -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-6">
                                    <div>
                                        <span class="text-sm font-medium text-gray-700">Quotations:</span>
                                        <span class="text-sm text-gray-600 ml-1">{{ $quotationRequest->quotations->count() }}</span>
                                    </div>
                                    @if($quotationRequest->quotations->count() > 0)
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Lowest Quote:</span>
                                            <span class="text-sm font-semibold text-green-600 ml-1">
                                                SAR {{ number_format($quotationRequest->quotations->min('total'), 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Highest Quote:</span>
                                            <span class="text-sm font-semibold text-red-600 ml-1">
                                                SAR {{ number_format($quotationRequest->quotations->max('total'), 2) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <button wire:click="viewQuotationRequest('{{ $quotationRequest->id }}')"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    View Details
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No quotation requests found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if($search || $statusFilter || $typeFilter || $vehicleFilter)
                            Try adjusting your filters to see more results.
                        @else
                            You haven't created any quotation requests yet.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($quotationRequests->hasPages())
            <div class="mt-6">
                {{ $quotationRequests->links() }}
            </div>
        @endif
    </div>
</div>
