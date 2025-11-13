<div class="grid sm:grid-cols-1 lg:grid-cols-4 gap-8 content-start">
    <!-- Filters -->
    <div class="lg:col-span-1 space-y-6">
        <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    @svg('phosphor-funnel', 'size-5 text-violet-500')
                    <span class="text-lg font-semibold text-neutral-900 dark:text-white">Filter Requests</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-semibold text-neutral-700 dark:text-white mb-1">Search</label>
                    <input
                        type="text"
                        id="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by ID, make, model, or VIN..."
                        class="w-full px-4 py-2.5 border border-neutral-300 dark:border-white/10 rounded-full bg-white dark:bg-transparent text-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-shadow">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="statusFilter" class="block text-sm font-semibold text-neutral-700 dark:text-white mb-1">Status</label>
                    <select
                        wire:model.live="statusFilter"
                        id="statusFilter"
                        class="w-full px-4 py-2.5 border border-neutral-300 dark:border-white/10 rounded-full bg-white dark:bg-transparent text-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-shadow">
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
                    <label for="typeFilter" class="block text-sm font-semibold text-neutral-700 dark:text-white mb-1">Type</label>
                    <select
                        wire:model.live="typeFilter"
                        id="typeFilter"
                        class="w-full px-4 py-2.5 border border-neutral-300 dark:border-white/10 rounded-full bg-white dark:bg-transparent text-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-shadow">
                        <option value="">All Types</option>
                        <option value="repair">Repair</option>
                        <option value="spare-parts">Spare Parts</option>
                    </select>
                </div>

                <!-- Vehicle Filter -->
                <div>
                    <label for="vehicleFilter" class="block text-sm font-semibold text-neutral-700 dark:text-white mb-1">Vehicle</label>
                    <select
                        wire:model.live="vehicleFilter"
                        id="vehicleFilter"
                        class="w-full px-4 py-2.5 border border-neutral-300 dark:border-white/10 rounded-full bg-white dark:bg-transparent text-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-shadow">
                        <option value="">All Vehicles</option>
                        @foreach($userVehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">
                                {{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($search || $statusFilter || $typeFilter || $vehicleFilter)
                <div class="mt-6">
                    <button
                        type="button"
                        wire:click="clearFilters"
                        class="inline-flex items-center justify-center w-full px-4 py-2 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-sm font-semibold rounded-full bg-white dark:bg-transparent hover:bg-neutral-50 dark:hover:bg-white/10 transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500">
                        @svg('phosphor-x', 'size-4 mr-2')
                        Clear Filters
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Quotation Requests -->
    <div class="lg:col-span-3 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                @svg('phosphor-calculator', 'size-8 text-fuchsia-500')
                <div>
                    <h2 class="text-2xl font-extrabold text-neutral-950 dark:text-white">Quotation Requests</h2>
                    <p class="text-sm text-neutral-600 dark:text-white/60">Track inspections, quotes, and follow-ups in one place.</p>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 rounded-full bg-neutral-100 dark:bg-white/10 px-4 py-2 text-sm font-medium text-neutral-600 dark:text-white/70">
                <span class="h-2 w-2 rounded-full bg-fuchsia-500"></span>
                <span>{{ $quotationRequests->count() }} results</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($quotationRequests as $quotationRequest)
                <div
                    wire:key="quotation-request-{{ $quotationRequest->id }}"
                    class="group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 bg-white dark:bg-white/5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                    @php
                        $statusValue = $quotationRequest->status->value;
                        $statusStyles = [
                            'open' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                            'quoted' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300',
                            'expired' => 'bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white',
                        ];
                        $statusClass = $statusStyles[$statusValue] ?? 'bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white';
                    @endphp
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            @if($quotationRequest->type->value === 'spare-parts')
                                <span class="inline-flex items-center justify-center size-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                                    @svg('phosphor-calculator', 'size-6')
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center size-12 rounded-2xl bg-green-500/10 text-green-600 dark:text-green-300">
                                    @svg('phosphor-wrench', 'size-6')
                                </span>
                            @endif

                            <div class="space-y-1">
                                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-white/50">Request #{{ $quotationRequest->id }}</span>
                                <h3 class="text-xl md:text-2xl font-extrabold text-neutral-900 dark:text-white">
                                    {{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }} Request
                                </h3>
                            </div>
                        </div>

                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst($quotationRequest->status->value) }}
                        </span>
                    </div>

                    <div class="mt-6 space-y-3 text-sm text-neutral-600 dark:text-white/70">
                        <div class="flex items-center gap-2">
                            @svg('phosphor-car', 'size-4 text-sky-500')
                            <span>
                                {{ $quotationRequest->inspection->appointment->vehicle->year }}
                                {{ $quotationRequest->inspection->appointment->vehicle->make }}
                                {{ $quotationRequest->inspection->appointment->vehicle->model }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            @svg('phosphor-qr-code', 'size-4 text-neutral-500')
                            <span class="font-mono text-xs md:text-sm">
                                {{ $quotationRequest->inspection->appointment->vehicle->vin }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            @svg('phosphor-calendar-dots', 'size-4 text-violet-500')
                            <span>Requested {{ $quotationRequest->created_at->format('M d, Y \\a\\t H:i') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl bg-neutral-50 dark:bg-white/5 px-4 py-3">
                        <div class="flex items-center justify-between text-sm text-neutral-700 dark:text-white">
                            <span class="font-semibold">Quotations</span>
                            <span>{{ $quotationRequest->quotations->count() }}</span>
                        </div>

                        @if($quotationRequest->quotations->count() > 0)
                            <div class="mt-3 grid grid-cols-2 gap-3 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                                <div>
                                    <span>Lowest</span>
                                    <div class="mt-1 text-sm font-semibold text-green-600 dark:text-green-300">
                                        SAR {{ number_format($quotationRequest->quotations->min('total'), 2) }}
                                    </div>
                                </div>
                                <div>
                                    <span>Highest</span>
                                    <div class="mt-1 text-sm font-semibold text-red-600 dark:text-red-300">
                                        SAR {{ number_format($quotationRequest->quotations->max('total'), 2) }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-3 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                                Awaiting first quote
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button
                            type="button"
                            wire:click="viewQuotationRequest('{{ $quotationRequest->id }}')"
                            class="w-full inline-flex items-center justify-between gap-6 px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full hover:bg-neutral-50 dark:hover:bg-white/10 transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500">
                            <span class="flex items-center gap-2">
                                @svg('phosphor-file-text', 'size-5 text-indigo-600')
                                View Details
                            </span>
                            @svg('phosphor-arrow-right-light', 'size-6')
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center border border-dashed border-neutral-300 dark:border-white/10 rounded-3xl bg-white dark:bg-white/5">
                    @svg('phosphor-invoice', 'size-12 mx-auto text-neutral-400 dark:text-white/40')
                    <h3 class="mt-4 text-lg font-semibold text-neutral-900 dark:text-white">No quotation requests found</h3>
                    <p class="mt-2 text-sm text-neutral-600 dark:text-white/70 max-w-md mx-auto">
                        @if($search || $statusFilter || $typeFilter || $vehicleFilter)
                            Try adjusting your filters to see more results.
                        @else
                            You haven't created any quotation requests yet. Start by booking an inspection.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        @if($quotationRequests->hasPages())
            <div class="pt-2">
                {{ $quotationRequests->links() }}
            </div>
        @endif
    </div>
</div>
