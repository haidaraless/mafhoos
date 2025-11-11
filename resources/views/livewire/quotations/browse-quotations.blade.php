<div class="grid grid-cols-1">
    <!-- Filters -->
    <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 mb-6 bg-white dark:bg-white/5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-neutral-700 dark:text-white mb-1">Search</label>
                <input type="text"
                       id="search"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Search by ID, make, model, or VIN..."
                       class="w-full px-3 py-2 border border-neutral-300 dark:border-white/10 rounded-full shadow-sm bg-white dark:bg-transparent text-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Status Filter -->
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-neutral-700 dark:text-white mb-1">Status</label>
                <select wire:model.live="statusFilter"
                        id="statusFilter"
                        class="w-full px-3 py-2 border border-neutral-300 dark:border-white/10 rounded-full shadow-sm bg-white dark:bg-transparent text-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
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
                <label for="typeFilter" class="block text-sm font-medium text-neutral-700 dark:text-white mb-1">Type</label>
                <select wire:model.live="typeFilter"
                        id="typeFilter"
                        class="w-full px-3 py-2 border border-neutral-300 dark:border-white/10 rounded-full shadow-sm bg-white dark:bg-transparent text-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
                    <option value="">All Types</option>
                    <option value="repair">Repair</option>
                    <option value="spare-parts">Spare Parts</option>
                </select>
            </div>

            <!-- Vehicle Filter -->
            <div>
                <label for="vehicleFilter" class="block text-sm font-medium text-neutral-700 dark:text-white mb-1">Vehicle</label>
                <select wire:model.live="vehicleFilter"
                        id="vehicleFilter"
                        class="w-full px-3 py-2 border border-neutral-300 dark:border-white/10 rounded-full shadow-sm bg-white dark:bg-transparent text-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
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
                        class="inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-sm font-medium rounded-full bg-white dark:bg-transparent hover:bg-neutral-50 transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500">
                    @svg('phosphor-x', 'size-4 mr-2')
                    Clear Filters
                </button>
            </div>
        @endif
    </div>

    <!-- Quotation Requests List -->
    <div class="space-y-4">
        @forelse($quotationRequests as $quotationRequest)
            <div class="group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 flex flex-col justify-between bg-white dark:bg-white/5 transition-all hover:-translate-y-0.5">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-xl md:text-2xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                                {{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }} Request #{{ $quotationRequest->id }}
                            </h3>
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold
                                    @if($quotationRequest->status->value === 'open') bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300
                                    @elseif($quotationRequest->status->value === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300
                                    @elseif($quotationRequest->status->value === 'quoted') bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300
                                    @elseif($quotationRequest->status->value === 'cancelled') bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300
                                    @elseif($quotationRequest->status->value === 'expired') bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white
                                    @else bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white
                                    @endif">
                                    {{ ucfirst($quotationRequest->status->value) }}
                                </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <span class="text-sm font-medium text-neutral-700 dark:text-white">Vehicle:</span>
                                <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">
                                        {{ $quotationRequest->inspection->appointment->vehicle->year }}
                                    {{ $quotationRequest->inspection->appointment->vehicle->make }}
                                    {{ $quotationRequest->inspection->appointment->vehicle->model }}
                                    </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-neutral-700 dark:text-white">VIN:</span>
                                <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->vin }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-neutral-700 dark:text-white">Created:</span>
                                <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->created_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>

                        <!-- Quotation Summary -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-6">
                                <div>
                                    <span class="text-sm font-medium text-neutral-700 dark:text-white">Quotations:</span>
                                    <span class="text-sm text-neutral-600 dark:text-white/70 ml-1">{{ $quotationRequest->quotations->count() }}</span>
                                </div>
                                @if($quotationRequest->quotations->count() > 0)
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Lowest Quote:</span>
                                        <span class="text-sm font-semibold text-green-600 dark:text-green-300 ml-1">
                                                SAR {{ number_format($quotationRequest->quotations->min('total'), 2) }}
                                            </span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Highest Quote:</span>
                                        <span class="text-sm font-semibold text-red-600 dark:text-red-300 ml-1">
                                                SAR {{ number_format($quotationRequest->quotations->max('total'), 2) }}
                                            </span>
                                    </div>
                                @endif
                            </div>

                            <a wire:click="viewQuotationRequest('{{ $quotationRequest->id }}')"
                               class="cursor-pointer inline-flex items-center justify-between gap-6 px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full hover:bg-neutral-50 dark:hover:bg-white/10 transition-colors">
                                <div class="flex items-center gap-2">
                                    @svg('phosphor-file-text', 'size-5 text-indigo-600')
                                    <span>View Details</span>
                                </div>
                                @svg('phosphor-arrow-right-light', 'size-6')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-12 text-center bg-white dark:bg-white/5">
                @svg('phosphor-invoice', 'size-12 mx-auto text-neutral-400 dark:text-white/40')
                <h3 class="mt-2 text-base font-medium text-neutral-900 dark:text-white">No quotation requests found</h3>
                <p class="mt-1 text-sm text-neutral-600 dark:text-white/70">
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
