@use('App\Enums\QuotationType')
<div>
    @if($showModal && $quotationRequest)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            Create {{ $quotationRequest->type === QuotationType::REPAIR ? 'Repair' : 'Spare Parts' }} Quotation
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-2">Quotation Request Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Vehicle:</span>
                                <span class="text-gray-600 ml-2">
                                    {{ $quotationRequest->inspection->appointment->vehicle->year }} 
                                    {{ $quotationRequest->inspection->appointment->vehicle->make }} 
                                    {{ $quotationRequest->inspection->appointment->vehicle->model }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Inspection Number:</span>
                                <span class="text-gray-600 ml-2">{{ $quotationRequest->inspection->number }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($quotationRequest->type === QuotationType::REPAIR)
                        @livewire('quotations.create-repair-quotation', ['quotationRequest' => $quotationRequest])
                    @else
                        @livewire('quotations.create-spareparts-quotation', ['quotationRequest' => $quotationRequest])
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
