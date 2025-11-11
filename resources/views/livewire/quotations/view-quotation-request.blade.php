<div class="min-h-screen">
    <div class="max-w-7xl mx-auto py-8">
    <!-- Header -->
    <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 mb-6 bg-white dark:bg-white/5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button wire:click="goBack" 
                        class="p-2 text-neutral-400 hover:text-neutral-600 dark:text-white/50 dark:hover:text-white transition-colors duration-200">
                    @svg('phosphor-arrow-left', 'size-6')
                </button>
                <div class="flex items-center gap-3">
                    @svg('phosphor-file-text', 'size-8 text-indigo-600')
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-extrabold text-neutral-800 dark:text-white">
                            {{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }} Quotation Request
                        </h1>
                        <p class="text-sm text-neutral-600 dark:text-white/70">Request #{{ $quotationRequest->id }}</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
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
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Vehicle Information -->
            <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                <h2 class="text-lg font-extrabold text-neutral-800 dark:text-white mb-4">Vehicle Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Year:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->year }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Make:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->make }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Model:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->model }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">VIN:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->vin }}</span>
                    </div>
                </div>
            </div>

            <!-- Inspection Details -->
            <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                <h2 class="text-lg font-extrabold text-neutral-800 dark:text-white mb-4">Inspection Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Inspection Number:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->number }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Inspection Date:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Inspection Type:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ ucfirst(string: str_replace('_', ' ', $quotationRequest->inspection->type->value)) }}</span>
                    </div>
                </div>
            </div>

            <!-- Damage Details (if available) -->
            @if($quotationRequest->inspection->damageSpareparts->count() > 0)
                <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                    <h2 class="text-lg font-extrabold text-neutral-800 dark:text-white mb-4">Damage Details</h2>
                    <div class="space-y-3">
                        @foreach($quotationRequest->inspection->damageSpareparts as $damageSparepart)
                            <div class="border border-neutral-300 dark:border-white/10 rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-neutral-900 dark:text-white">{{ $damageSparepart->sparepart->name }}</h3>
                                        <p class="text-sm text-neutral-600 dark:text-white/70">{{ $damageSparepart->description }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Priority:</span>
                                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-1">{{ ucfirst($damageSparepart->priority->value) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quotations -->
            @if($quotationRequest->quotations->count() > 0)
                <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                    <h2 class="text-lg font-extrabold text-neutral-800 dark:text-white mb-4">Quotations</h2>
                    <div class="space-y-4">
                        @foreach($quotationRequest->quotations as $quotation)
                            <div class="border border-neutral-300 dark:border-white/10 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <h3 class="font-medium text-neutral-900 dark:text-white">{{ $quotation->provider->name }}</h3>
                                        <p class="text-sm text-neutral-600 dark:text-white/70">{{ $quotation->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-semibold text-neutral-900 dark:text-white">SAR {{ number_format($quotation->total, 2) }}</span>
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold ml-2
                                            @if($quotation->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300
                                            @elseif($quotation->status === 'quoted') bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300
                                            @else bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white
                                            @endif">
                                            {{ ucfirst($quotation->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($quotation->notes)
                                    <p class="text-sm text-neutral-600 dark:text-white/70 mb-3">{{ $quotation->notes }}</p>
                                @endif

                                @if($quotation->quotationSpareparts->count() > 0)
                                    <div class="bg-neutral-50 dark:bg-white/10 rounded-lg p-3">
                                        <h4 class="font-medium text-neutral-700 dark:text-white mb-2">Spare Parts Pricing:</h4>
                                        <div class="space-y-1">
                                            @foreach($quotation->quotationSpareparts as $quotationSparepart)
                                                <div class="flex justify-between items-center text-sm">
                                                    <span class="text-neutral-700 dark:text-white/90">{{ $quotationSparepart->damageSparepart->sparepart->name }}</span>
                                                    <span class="font-medium text-neutral-900 dark:text-white">SAR {{ number_format($quotationSparepart->price, 2) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Request Summary -->
            <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                <h2 class="text-lg font-extrabold text-neutral-800 dark:text-white mb-4">Request Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-600 dark:text-white/70">Request Type:</span>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-600 dark:text_white/70">Created:</span>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-600 dark:text-white/70">Quotations:</span>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->quotations->count() }}</span>
                    </div>
                    @if($quotationRequest->quotations->count() > 0)
                        <div class="flex justify-between">
                            <span class="text-sm text-neutral-600 dark:text-white/70">Lowest Quote:</span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-300">SAR {{ number_format($quotationRequest->quotations->min('total'), 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-neutral-600 dark:text-white/70">Highest Quote:</span>
                            <span class="text-sm font-medium text-red-600 dark:text-red-300">SAR {{ number_format($quotationRequest->quotations->max('total'), 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vehicle Owner -->
            <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                <h2 class="text-lg font-extrabold text-neutral-800 dark:text-white mb-4">Vehicle Owner</h2>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Name:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->user->name }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-700 dark:text-white">Email:</span>
                        <span class="text-sm text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->user->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>