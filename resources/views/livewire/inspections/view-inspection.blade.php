<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Inspection Report</h1>
                <p class="text-gray-600">Inspection #{{ $inspection->number }}</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Completed</div>
                <div class="text-lg font-semibold text-gray-900">
                    {{ $inspection->completed_at->format('M j, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Information -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Vehicle Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-500">Vehicle</label>
                <p class="text-gray-900">{{ $inspection->vehicle->make }} {{ $inspection->vehicle->model }} ({{ $inspection->vehicle->year }})</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">VIN</label>
                <p class="text-gray-900 font-mono">{{ $inspection->vehicle->vin ?? 'Not provided' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Inspection Type</label>
                <p class="text-gray-900">{{ ucfirst(str_replace('-', ' ', $inspection->type->value)) }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Provider</label>
                <p class="text-gray-900">{{ $inspection->provider->name }}</p>
            </div>
        </div>
    </div>

    <!-- Inspection Report -->
    @if($inspection->report)
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Inspection Report</h2>
            <div class="prose max-w-none">
                <p class="text-gray-700 whitespace-pre-line">{{ $inspection->report }}</p>
            </div>
        </div>
    @endif

    <!-- Damage Spareparts -->
    @if($inspection->damageSpareparts->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Damage Spareparts</h2>
            <div class="space-y-4">
                @foreach($inspection->damageSpareparts as $damageSparepart)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $damageSparepart->sparepart->name }}</h3>
                                @if($damageSparepart->sparepart->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $damageSparepart->sparepart->description }}</p>
                                @endif
                                @if($damageSparepart->sparepart->brand)
                                    <p class="text-xs text-gray-500 mt-1">Brand: {{ $damageSparepart->sparepart->brand }}</p>
                                @endif
                            </div>
                            <div class="ml-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($damageSparepart->priority->value === 'high') bg-red-100 text-red-800
                                    @elseif($damageSparepart->priority->value === 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($damageSparepart->priority->value) }} Priority
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Quotation Requests Section -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quotation Requests</h2>
            <div class="flex space-x-3">
                <button
                    wire:click="createQuotationRequest('spare-parts')"
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
                >
                    Request Spare Parts Quotation
                </button>
                <button
                    wire:click="createQuotationRequest('repair')"
                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200"
                >
                    Request Repair Quotation
                </button>
            </div>
        </div>

        @if($quotationRequests->count() > 0)
            <div class="space-y-4">
                @foreach($quotationRequests as $quotationRequest)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h3 class="font-medium text-gray-900">
                                        {{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }} Quotation
                                    </h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
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
                                <p class="text-sm text-gray-600 mt-1">
                                    Created {{ $quotationRequest->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="text-right">
                                @if($quotationRequest->providers->count() > 0)
                                    <p class="text-sm text-gray-600">
                                        {{ $quotationRequest->providers->count() }} provider(s) notified
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500">No providers notified yet</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mt-2">No Quotation Requests</h3>
                <p class="text-gray-600 mt-1">Create quotation requests to get quotes for spare parts or repairs.</p>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div class="flex justify-start">
        <a
            href="{{ route('dashboard.vehicle-owner') }}"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
        >
            ← Back to Dashboard
        </a>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>