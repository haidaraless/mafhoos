@use('App\Enums\QuotationType')
<div>
    @if($showModal && $quotationRequest)
        <div class="fixed inset-0 bg-neutral-900/50 dark:bg-black/50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-10 mx-auto p-6 border border-neutral-300 dark:border-white/10 w-full max-w-4xl shadow-lg rounded-2xl bg-white dark:bg-white/5">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            @if ($quotationRequest->type === QuotationType::REPAIR)
                                @svg('phosphor-wrench', 'size-6 text-orange-600 dark:text-orange-300')
                            @else
                                @svg('phosphor-package', 'size-6 text-purple-600 dark:text-purple-300')
                            @endif
                            <h3 class="text-lg font-extrabold text-neutral-800 dark:text-white">
                                Create {{ $quotationRequest->type === QuotationType::REPAIR ? 'Repair' : 'Spare Parts' }} Quotation
                            </h3>
                        </div>
                        <button wire:click="closeModal" class="text-neutral-400 hover:text-neutral-600 dark:text-white/50 dark:hover:text-white transition-colors">
                            @svg('phosphor-x', 'size-6')
                        </button>
                    </div>
                    
                    <div class="mb-6 p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-neutral-50 dark:bg-white/5">
                        <h4 class="font-semibold text-neutral-800 dark:text-white mb-3">Quotation Request Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-neutral-700 dark:text-white">Vehicle:</span>
                                <span class="text-neutral-600 dark:text-white/70 ml-2">
                                    {{ $quotationRequest->inspection->appointment->vehicle->year }} 
                                    {{ $quotationRequest->inspection->appointment->vehicle->make }} 
                                    {{ $quotationRequest->inspection->appointment->vehicle->model }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium text-neutral-700 dark:text-white">Inspection Number:</span>
                                <span class="text-neutral-600 dark:text-white/70 ml-2">{{ $quotationRequest->inspection->number }}</span>
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
