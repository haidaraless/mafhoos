<div class="grid grid-cols-1 overflow-hidden">
    @if($quotations->count() === 0)
        <!-- Header Section -->
        <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white border-b border-neutral-300 dark:bg-neutral-900 dark:border-neutral-700">
            @svg('phosphor-calculator', 'size-10 md:size-12 text-purple-500')
            <div class="flex flex-col">
                <h1 class="text-2xl md:text-3xl text-neutral-800 dark:text-white font-bold">{{ __('Create Spare Parts Quotation') }}</h1>
                <p class="text-neutral-600 dark:text-white/70">{{ __('Enter prices for each spare part and any additional notes') }}</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-span-1 flex flex-col">
            @if (session()->has('message'))
                <div class="m-6 rounded-xl border border-green-300/60 dark:border-green-500/20 bg-green-50 dark:bg-green-500/10 px-4 py-3 text-green-800 dark:text-green-300">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="createQuotation" class="flex flex-col w-full">
            <!-- Spare Parts Pricing Section -->
            <div class="grid grid-cols-1 content-start border-b border-neutral-300 dark:border-neutral-700">
                <div class="col-span-1 h-8 flex items-center justify-between px-6 bg-neutral-50 dark:bg-neutral-800 border-b border-neutral-300 dark:border-white/10">
                    <span class="text-sm text-neutral-600 dark:text-white/70">Price Each Spare Part</span>
                    @svg('phosphor-package', 'size-4')
                </div>
                <div class="grid grid-cols-1 content-start max-h-96 overflow-y-auto">
                    @forelse($damageSpareparts as $damageSparepart)
                        <label for="sparepart-{{ $damageSparepart->id }}"
                               class="flex items-center justify-between gap-4 px-6 py-4 text-neutral-800 dark:text-white hover:text-purple-500 dark:hover:text-purple-300 bg-white dark:bg-neutral-900 hover:bg-white dark:hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer border-b border-neutral-300 dark:border-neutral-700 last:border-b-0">
                            <div class="flex flex-col flex-1">
                                <h4 class="text-lg text-neutral-800 dark:text-white font-medium">{{ $damageSparepart->sparepart->name }}</h4>
                                @if($damageSparepart->sparepart->part_number)
                                    <p class="text-sm text-neutral-500 dark:text-white/50">Part #: {{ $damageSparepart->sparepart->part_number }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-neutral-600 dark:text-white/70">SAR</span>
                                <input id="sparepart-{{ $damageSparepart->id }}" 
                                       name="sparepartPrices[{{ $damageSparepart->id }}]" 
                                       type="number" 
                                       wire:model="sparepartPrices.{{ $damageSparepart->id }}" 
                                       step="0.01" 
                                       min="0.01"
                                       placeholder="0.00"
                                       class="w-32 text-xl text-neutral-800 dark:text-white placeholder:text-neutral-400 font-semibold focus:outline-none focus:ring-0 focus:border-none bg-transparent" />
                            </div>
                        </label>
                    @empty
                        <div class="col-span-1 flex text-base text-neutral-500 dark:text-white/20 px-6 py-4">
                            <span>{{ __('No damage spareparts have been added yet') }}</span>
                        </div>
                    @endforelse
                </div>
                @error('sparepartPrices.*') 
                <div class="px-6 py-2">
                    <span class="text-xs text-rose-500 dark:text-rose-300">{{ $message }}</span>
                </div>
                @enderror
            </div>

            <!-- Total Amount Display -->
            <div class="flex items-center justify-between gap-4 px-6 py-4 text-neutral-800 dark:text-white bg-white dark:bg-neutral-900 border-b border-neutral-300 dark:border-neutral-700">
                <div class="flex items-center gap-4">
                    @svg('phosphor-calculator', 'size-10')
                    <div class="flex flex-col">
                        <h4 class="text-lg text-neutral-800 dark:text-white font-medium">Total Amount</h4>
                        <span class="text-2xl text-neutral-800 dark:text-white font-extrabold">SAR {{ number_format($this->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <label for="notes"
                   class="flex items-start gap-4 px-6 py-4 text-neutral-800 dark:text-white hover:text-purple-500 dark:hover:text-purple-300 bg-white dark:bg-neutral-900 hover:bg-white dark:hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer border-b border-neutral-300 dark:border-neutral-700">
                @svg('phosphor-note', 'size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-neutral-800 dark:text-white font-medium mb-2">Notes (Optional)</h4>
                    <textarea id="notes" name="notes" wire:model="notes" rows="4"
                              placeholder="Add any additional notes about the spare parts or pricing"
                              class="w-full text-base text-neutral-800 dark:text-white placeholder:text-neutral-400 font-normal focus:outline-none focus:ring-0 focus:border-none bg-transparent resize-none"></textarea>
                    @error('notes')
                    <span class="mt-0.5 text-xs text-rose-500 dark:text-rose-300">{{ $message }}</span>
                    @enderror
                </div>
            </label>

            <!-- Submit Button -->
            <button type="submit"
                    class="flex items-center gap-4 p-4 min-h-24 text-sm text-white bg-neutral-800 dark:bg-white dark:text-neutral-900 hover:bg-neutral-900 dark:hover:bg-white/90 transition-all ease-in-out duration-300 cursor-pointer"
                    wire:loading.attr="disabled" wire:target="createQuotation">
                <div class="flex flex-col w-full text-left">
                    <h4 class="text-2xl font-semibold">Create Quotation</h4>
                    <span wire:loading.remove wire:target="createQuotation" class="text-neutral-400 dark:text-neutral-500">Create a new spare parts quotation</span>
                    <span wire:loading wire:target="createQuotation" class="text-neutral-400 dark:text-neutral-500">Creating...</span>
                </div>
                <span wire:loading wire:target="createQuotation">
                    <svg class="animate-spin size-10 text-white dark:text-neutral-900 inline" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </span>
                <span wire:loading.remove wire:target="createQuotation">
                    @svg('phosphor-arrow-right-light', 'size-10')
                </span>
            </button>
            </form>
        </div>
    @else
        <!-- Header Section (when quotations exist) -->
        <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white border-b border-neutral-300 dark:bg-neutral-900 dark:border-neutral-700">
            @svg('phosphor-calculator', 'size-10 md:size-12 text-purple-500')
            <div class="flex flex-col">
                <h1 class="text-2xl md:text-3xl text-neutral-800 dark:text-white font-bold">{{ __('Your Spare Parts Quotation') }}</h1>
                <p class="text-neutral-600 dark:text-white/70">{{ __('Manage your quotation below') }}</p>
            </div>
        </div>

        <!-- Quotations Section -->
        <div class="col-span-1 flex flex-col">
            @if (session()->has('message'))
                <div class="m-6 rounded-xl border border-green-300/60 dark:border-green-500/20 bg-green-50 dark:bg-green-500/10 px-4 py-3 text-green-800 dark:text-green-300">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Existing Quotations -->
            @if($quotations->count() > 0)
                <div class="grid grid-cols-1 content-start border-t border-neutral-300 dark:border-neutral-700">
                <div class="col-span-1 h-8 flex items-center justify-between px-6 bg-neutral-50 dark:bg-neutral-800 border-b border-neutral-300 dark:border-white/10">
                    <span class="text-sm text-neutral-600 dark:text-white/70">Your Quotations</span>
                    @svg('phosphor-file-text', 'size-4')
                </div>
                <div class="grid grid-cols-1 content-start">
                    @foreach($quotations as $quotation)
                        <div class="col-span-1 group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 mx-6 my-4 bg-white dark:bg-white/5 transition-all hover:shadow-lg hover:-translate-y-0.5">
                            <div class="flex items-start justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="inline-flex items-center justify-center size-12 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-300">
                                            @svg('phosphor-file-text', 'size-6')
                                        </span>
                                        <div class="flex flex-col">
                                            <span class="text-lg font-extrabold text-neutral-800 dark:text-white">Quotation #{{ $quotation->number ?? substr($quotation->id, -8) }}</span>
                                            <span class="text-sm font-normal text-neutral-600 dark:text-white/70">Created: {{ $quotation->created_at->format('M d, Y \a\t g:i A') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="text-4xl md:text-5xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                                            SAR {{ number_format($quotation->total, 2) }}
                                        </div>
                                    </div>
                                    
                                    @if($quotation->quotationSpareparts->count() > 0)
                                        <div class="mt-4 p-4 border border-neutral-300 dark:border-white/10 rounded-lg bg-neutral-50 dark:bg-white/5">
                                            <h4 class="font-semibold text-neutral-700 dark:text-white mb-3 text-sm">Spare Parts Pricing:</h4>
                                            <div class="space-y-2">
                                                @foreach($quotation->quotationSpareparts as $quotationSparepart)
                                                    <div class="flex justify-between items-center text-sm py-2 px-3 border-b border-neutral-200 dark:border-white/10 last:border-b-0 bg-white dark:bg-white/5 rounded">
                                                        <span class="text-neutral-700 dark:text-white/90 font-medium">{{ $quotationSparepart->damageSparepart->sparepart->name }}</span>
                                                        <span class="font-semibold text-neutral-900 dark:text-white">SAR {{ number_format($quotationSparepart->price, 2) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($quotation->notes)
                                        <div class="mt-4 p-4 border-l-2 border-purple-500 bg-purple-50/50 dark:bg-purple-500/5 rounded-r-lg">
                                            <p class="text-sm text-neutral-700 dark:text-white/80 leading-relaxed">{{ $quotation->notes }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($quotation->status === 'quoted')
                                        <div class="mt-4 flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                                            @svg('phosphor-paper-plane-tilt', 'size-4 text-green-500')
                                            <span>Sent on {{ $quotation->updated_at->format('M d, Y \a\t g:i A') }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex flex-col items-end gap-4">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                                        @if($quotation->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300
                                        @elseif($quotation->status === 'quoted') bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300
                                        @else bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white
                                        @endif">
                                        {{ ucfirst($quotation->status) }}
                                    </span>
                                    
                                    @if($quotation->status === 'draft')
                                        <button wire:click="sendQuotation('{{ $quotation->id }}')" 
                                                class="inline-flex items-center gap-3 px-6 py-3 bg-green-500 text-white dark:bg-green-600 text-base font-semibold rounded-xl hover:bg-green-600 dark:hover:bg-green-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                            <span>Send Quotation</span>
                                            @svg('phosphor-paper-plane-tilt', 'size-5')
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    @endif
</div>
