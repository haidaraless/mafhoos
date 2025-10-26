<div class="min-h-screen">
    <div class="max-w-7xl mx-auto py-8">
    <!-- Header -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button wire:click="goBack" 
                        class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }} Quotation Request
                    </h1>
                    <p class="text-gray-600">Request #{{ $quotationRequest->id }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Vehicle Information -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Vehicle Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Year:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->year }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Make:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->make }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Model:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->model }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">VIN:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->vin }}</span>
                    </div>
                </div>
            </div>

            <!-- Inspection Details -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Inspection Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Inspection Number:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->number }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Inspection Date:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Inspection Type:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ ucfirst(string: str_replace('_', ' ', $quotationRequest->inspection->type->value)) }}</span>
                    </div>
                </div>
            </div>

            <!-- Damage Details (if available) -->
            @if($quotationRequest->inspection->damageSpareparts->count() > 0)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Damage Details</h2>
                    <div class="space-y-3">
                        @foreach($quotationRequest->inspection->damageSpareparts as $damageSparepart)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $damageSparepart->sparepart->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $damageSparepart->description }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-medium text-gray-700">Priority:</span>
                                        <span class="text-sm text-gray-600 ml-1">{{ ucfirst($damageSparepart->priority->value) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quotations -->
            @if($quotationRequest->quotations->count() > 0)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Quotations</h2>
                    <div class="space-y-4">
                        @foreach($quotationRequest->quotations as $quotation)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $quotation->provider->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $quotation->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-semibold text-gray-900">SAR {{ number_format($quotation->total, 2) }}</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ml-2
                                            @if($quotation->status === 'draft') bg-yellow-100 text-yellow-800
                                            @elseif($quotation->status === 'quoted') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($quotation->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($quotation->notes)
                                    <p class="text-sm text-gray-600 mb-3">{{ $quotation->notes }}</p>
                                @endif

                                @if($quotation->quotationSpareparts->count() > 0)
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <h4 class="font-medium text-gray-700 mb-2">Spare Parts Pricing:</h4>
                                        <div class="space-y-1">
                                            @foreach($quotation->quotationSpareparts as $quotationSparepart)
                                                <div class="flex justify-between items-center text-sm">
                                                    <span class="text-gray-700">{{ $quotationSparepart->damageSparepart->sparepart->name }}</span>
                                                    <span class="font-medium text-gray-900">SAR {{ number_format($quotationSparepart->price, 2) }}</span>
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
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Request Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Request Type:</span>
                        <span class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Created:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $quotationRequest->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Quotations:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $quotationRequest->quotations->count() }}</span>
                    </div>
                    @if($quotationRequest->quotations->count() > 0)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Lowest Quote:</span>
                            <span class="text-sm font-medium text-green-600">SAR {{ number_format($quotationRequest->quotations->min('total'), 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Highest Quote:</span>
                            <span class="text-sm font-medium text-red-600">SAR {{ number_format($quotationRequest->quotations->max('total'), 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vehicle Owner -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Vehicle Owner</h2>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Name:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->user->name }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Email:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $quotationRequest->inspection->appointment->vehicle->user->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>