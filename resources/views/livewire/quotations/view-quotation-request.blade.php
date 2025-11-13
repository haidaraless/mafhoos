<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
    <!-- Sidebar -->
    <div class="col-span-1 grid grid-cols-1 gap-6 content-start pt-6 px-6 border-r border-neutral-900 dark:border-neutral-700">
        <!-- Request Summary -->
        <div class="col-span-1 grid grid-cols-1 gap-6">
            <div class="col-span-1 flex items-center justify-between">
                <div class="w-10">
                    @if($quotationRequest->type->value === 'repair')
                        @svg('phosphor-wrench', 'size-10 text-orange-500')
                    @else
                        @svg('phosphor-calculator', 'size-10 text-purple-500')
                    @endif
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                @if($quotationRequest->status->value === 'open') bg-blue-500/10 text-blue-600 dark:bg-blue-500/20 dark:text-blue-300
                @elseif($quotationRequest->status->value === 'pending') bg-yellow-500/10 text-yellow-600 dark:bg-yellow-500/20 dark:text-yellow-300
                @elseif($quotationRequest->status->value === 'quoted') bg-green-500/10 text-green-600 dark:bg-green-500/20 dark:text-green-300
                @elseif($quotationRequest->status->value === 'cancelled') bg-red-500/10 text-red-600 dark:bg-red-500/20 dark:text-red-300
                @elseif($quotationRequest->status->value === 'expired') bg-neutral-200 dark:bg-white/10 text-neutral-600 dark:text-white/70
                @else bg-neutral-200 dark:bg-white/10 text-neutral-600 dark:text-white/70
                @endif">
                {{ ucfirst($quotationRequest->status->value) }}
            </span>
            </div>
            <div class="flex flex-col">
                <h1 class="text-3xl font-extrabold text-neutral-800 dark:text-white">
                    Quotation Request
                </h1>
            </div>
            <div class="space-y-2 text-sm">
                <p class="text-base text-neutral-800 dark:text-white/70">#{{ $quotationRequest->number ?? substr($quotationRequest->id, -8) }}</p>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-tag-light', 'size-4')
                        <span>Type</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-calendar-blank-light', 'size-4')
                        <span>Created</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->created_at->format('M j, Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-file-text-light', 'size-4')
                        <span>Quotations</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->quotations->where('status', 'quoted')->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Vehicle Information -->
        <div class="col-span-1">
            <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                @svg('phosphor-car', 'size-5')
                Vehicle Information
            </h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-calendar-blank-light', 'size-4')
                        <span>Year</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->inspection->appointment->vehicle->year }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-tag-light', 'size-4')
                        <span>Make</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->inspection->appointment->vehicle->make }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-car-simple-light', 'size-4')
                        <span>Model</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->inspection->appointment->vehicle->model }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-hash-light', 'size-4')
                        <span>VIN</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white font-mono text-xs">{{ $quotationRequest->inspection->appointment->vehicle->vin ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Inspection Details -->
        <div class="col-span-1">
            <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                @svg('phosphor-clipboard-text', 'size-5')
                Inspection Details
            </h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-hash-light', 'size-4')
                        <span>Inspection Number</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white font-mono">{{ $quotationRequest->inspection->number }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-calendar-dots-light', 'size-4')
                        <span>Inspection Date</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->inspection->created_at->format('M j, Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-wrench-light', 'size-4')
                        <span>Inspection Type</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $quotationRequest->inspection->type->value)) }}</span>
                </div>
            </div>
        </div>

        <!-- Quote Statistics -->
        @if($quotationRequest->quotations->where('status', 'quoted')->count() > 0)
            <div class="col-span-1">
                <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                    @svg('phosphor-chart-line', 'size-5')
                    Quote Statistics
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                            @svg('phosphor-arrow-down-light', 'size-4')
                            <span>Lowest</span>
                        </span>
                        <span class="font-medium text-green-600 dark:text-green-300">SAR {{ number_format($quotationRequest->quotations->where('status', 'quoted')->min('total'), 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                            @svg('phosphor-arrow-up-light', 'size-4')
                            <span>Highest</span>
                        </span>
                        <span class="font-medium text-red-600 dark:text-red-300">SAR {{ number_format($quotationRequest->quotations->where('status', 'quoted')->max('total'), 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                            @svg('phosphor-calculator-light', 'size-4')
                            <span>Average</span>
                        </span>
                        <span class="font-medium text-neutral-900 dark:text-white">SAR {{ number_format($quotationRequest->quotations->where('status', 'quoted')->avg('total'), 2) }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Vehicle Owner -->
        <div class="col-span-1">
            <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                @svg('phosphor-user', 'size-5')
                Vehicle Owner
            </h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-user-circle-light', 'size-4')
                        <span>Name</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $quotationRequest->inspection->appointment->vehicle->user->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-envelope-light', 'size-4')
                        <span>Email</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white text-xs">{{ $quotationRequest->inspection->appointment->vehicle->user->email }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="col-span-3 grid grid-cols-1 content-start">
        <!-- Damage Details -->
        <div class="grid grid-cols-2 content-start border-b border-neutral-900 dark:border-neutral-700">
            <div class="col-span-1 grid grid-cols-1 gap-4 content-start border-r border-neutral-900 dark:border-neutral-700">
                <div class="col-span-1 flex items-center gap-2 pt-8 px-8">
                    @svg('phosphor-clipboard-text', 'size-8 text-blue-500')
                    <span class="text-2xl">{{ __('Inspection Report') }}</span>
                </div>
                @if($quotationRequest->inspection->report)
                    <div class="grid grid-cols-1 content-start pl-10">
                        <textarea 
                            disabled 
                            class="w-full p-4 text-base text-neutral-800 dark:text-white bg-transparent resize-none border-0 focus:ring-0 focus:outline-none"
                            rows="6"
                        >{{ $quotationRequest->inspection->report }}</textarea>
                    </div>
                @endif
            </div>
            <div class="col-span-1 grid grid-cols-1 gap-4 content-start">
                <div class="col-span-1 flex items-center gap-2 pt-8 px-8">
                    @svg('phosphor-wrench', 'size-8 text-orange-500')
                    <span class="text-2xl">{{ __('Damage Spareparts') }}</span>
                </div>
                <div class="grid grid-cols-1 content-start">
                    @forelse($quotationRequest->inspection->damageSpareparts as $damageSparepart)
                        <div class="col-span-1 flex items-center justify-between gap-4 px-10 py-2 border-b border-neutral-300 dark:border-neutral-700 last:border-b-0">
                            <div class="flex flex-col text-neutral-900 dark:text-white">
                                <span class="text-2xl font-extrabold">{{ $damageSparepart->sparepart->name }}</span>
                                @if($damageSparepart->description)
                                    <span class="text-lg font-normal">{{ $damageSparepart->description }}</span>
                                @endif
                                @if($damageSparepart->sparepart->brand)
                                    <span class="text-base font-normal">{{ $damageSparepart->sparepart->brand }}</span>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold
                                    @if($damageSparepart->priority->value === 'high') bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300
                                    @elseif($damageSparepart->priority->value === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300
                                    @else bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300
                                    @endif">
                                    {{ ucfirst($damageSparepart->priority->value) }} Priority
                            </span>
                        </div>
                    @empty
                        <div class="col-span-1 flex text-base text-neutral-500 dark:text-white/20">
                            <span>{{ __('_________ No damage spareparts have been added yet') }}</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        @if (Auth::user()->currentAccount->isUser())
            <!-- Quotations -->
            <div class="grid grid-cols-1 gap-2 content-start">
                <div class="col-span-1 flex items-center gap-2 pt-8 px-8">
                    @svg('phosphor-file-text', 'size-8 text-fuchsia-500')
                    <span class="text-2xl">{{ __('Quotations') }}</span>
                </div>
                <div class="grid grid-cols-1 content-start">
                    @forelse($quotationRequest->quotations->where('status', 'quoted') as $quotation)
                        <div class="col-span-1 group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 flex flex-col justify-between bg-white dark:bg-white/5 transition-all hover:-translate-y-0.5">
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center size-10 rounded-xl bg-fuchsia-500/10 text-fuchsia-600 dark:text-fuchsia-300">
                                        @svg('phosphor-file-text', 'size-6')
                                    </span>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold
                                    @if($quotation->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300
                                    @elseif($quotation->status === 'quoted') bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300
                                    @else bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white
                                    @endif">
                                    {{ ucfirst($quotation->status) }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="text-xl md:text-2xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                                    {{ $quotation->provider->name }}
                                </div>

                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                                    @svg('phosphor-calendar-dots', 'size-4 text-violet-500')
                                    <span>{{ $quotation->created_at->format('M d, Y') }}</span>
                                </div>

                                <div class="text-2xl font-extrabold text-neutral-800 dark:text-white">
                                    SAR {{ number_format($quotation->total, 2) }}
                                </div>
                            </div>

                            @if($quotation->notes)
                                <div class="mt-4 p-3 border-l-2 border-neutral-300 dark:border-white/10 bg-neutral-50 dark:bg-white/5 rounded-r-lg">
                                    <p class="text-sm text-neutral-600 dark:text-white/70">{{ $quotation->notes }}</p>
                                </div>
                            @endif

                            @if($quotation->quotationSpareparts->count() > 0)
                                <div class="mt-4 p-4 border border-neutral-300 dark:border-white/10 rounded-lg bg-neutral-50 dark:bg-white/5">
                                    <h4 class="font-semibold text-neutral-700 dark:text-white mb-3 text-sm">Spare Parts Pricing:</h4>
                                    <div class="space-y-2">
                                        @foreach($quotation->quotationSpareparts as $quotationSparepart)
                                            <div class="flex justify-between items-center text-sm py-1 border-b border-neutral-200 dark:border-white/10 last:border-b-0">
                                                <span class="text-neutral-700 dark:text-white/90">{{ $quotationSparepart->damageSparepart->sparepart->name }}</span>
                                                <span class="font-semibold text-neutral-900 dark:text-white">SAR {{ number_format($quotationSparepart->price, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-1 flex text-base text-neutral-500 dark:text-white/20">
                            <span>{{ __('_________ No quotations have been provided yet') }}</span>
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            @livewire('quotations.provide-quotation', ['quotationRequest' => $quotationRequest], key('provide-'.$quotationRequest->id))
        @endif
    </div>
</div>
