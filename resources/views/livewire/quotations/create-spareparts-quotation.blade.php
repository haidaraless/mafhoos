<div>
    <!-- Quotation Request Info -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Spare Parts Quotation Request</h3>
                <p class="text-sm text-gray-600">Vehicle: {{ $quotationRequest->inspection->appointment->vehicle->year }} {{ $quotationRequest->inspection->appointment->vehicle->make }} {{ $quotationRequest->inspection->appointment->vehicle->model }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                {{ ucfirst($quotationRequest->status->value) }}
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-700">Inspection Number:</span>
                <span class="text-gray-600 ml-2">{{ $quotationRequest->inspection->number }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700">Request Date:</span>
                <span class="text-gray-600 ml-2">{{ $quotationRequest->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Create Quotation Button -->
    <div class="mb-6">
        <button wire:click="openModal" 
                class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
            Create Spare Parts Quotation
        </button>
    </div>

    <!-- Existing Quotations -->
    @if($quotations->count() > 0)
        <div class="space-y-4">
            <h4 class="text-lg font-semibold text-gray-900">Your Quotations</h4>
            @foreach($quotations as $quotation)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h5 class="font-medium text-gray-900">Quotation #{{ $quotation->id }}</h5>
                            <p class="text-sm text-gray-600">Created: {{ $quotation->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($quotation->status === 'draft') bg-yellow-100 text-yellow-800
                            @elseif($quotation->status === 'quoted') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($quotation->status) }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <span class="font-medium text-gray-700">Total Amount:</span>
                            <span class="text-lg font-semibold text-gray-900 ml-2">SAR {{ number_format($quotation->total, 2) }}</span>
                        </div>
                        @if($quotation->notes)
                            <div>
                                <span class="font-medium text-gray-700">Notes:</span>
                                <p class="text-gray-600 mt-1">{{ $quotation->notes }}</p>
                            </div>
                        @endif
                    </div>
                    
                    @if($quotation->quotationSpareparts->count() > 0)
                        <div class="mb-4">
                            <h6 class="font-medium text-gray-700 mb-2">Spare Parts Pricing:</h6>
                            <div class="space-y-2">
                                @foreach($quotation->quotationSpareparts as $quotationSparepart)
                                    <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded">
                                        <span class="text-sm text-gray-700">{{ $quotationSparepart->damageSparepart->sparepart->name }}</span>
                                        <span class="text-sm font-medium text-gray-900">SAR {{ number_format($quotationSparepart->price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if($quotation->status === 'draft')
                        <div class="flex items-center space-x-2">
                            <button wire:click="sendQuotation({{ $quotation->id }})" 
                                    wire:confirm="Are you sure you want to send this quotation to the vehicle owner?"
                                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                Send Quotation
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <!-- Create Quotation Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Create Spare Parts Quotation</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit="createQuotation">
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-3">Price Each Spare Part</h4>
                            <div class="space-y-3 max-h-60 overflow-y-auto">
                                @foreach($damageSpareparts as $damageSparepart)
                                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                        <div class="flex-1">
                                            <span class="font-medium text-gray-900">{{ $damageSparepart->sparepart->name }}</span>
                                            @if($damageSparepart->sparepart->part_number)
                                                <p class="text-sm text-gray-500">Part #: {{ $damageSparepart->sparepart->part_number }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-500">SAR</span>
                                            <input type="number" 
                                                   wire:model="sparepartPrices.{{ $damageSparepart->id }}" 
                                                   step="0.01" 
                                                   min="0.01"
                                                   class="w-24 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                                   placeholder="0.00">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('sparepartPrices.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-700">Total Amount:</span>
                                <span class="text-lg font-semibold text-gray-900">SAR {{ number_format($this->total, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea wire:model="notes" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                      placeholder="Add any additional notes about the spare parts or pricing"></textarea>
                            @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex items-center justify-end space-x-3">
                            <button type="button" 
                                    wire:click="closeModal"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 transition-colors duration-200">
                                Create Quotation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
