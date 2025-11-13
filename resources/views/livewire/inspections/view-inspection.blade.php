<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
    <!-- Sidebar -->
    <div class="col-span-1 grid grid-cols-1 border-r border-neutral-900 dark:border-neutral-700">
        <!-- Header -->
        <div class="col-span-1 flex items-start justify-between w-full p-6 border-b border-neutral-900 dark:border-neutral-700">
            <div class="flex items-center gap-3">
                <div class="w-10">
                    @svg('phosphor-file-text', 'size-10 text-blue-500')
                </div>
                <div class="flex flex-col">
                    <h1 class="text-3xl font-extrabold text-neutral-800 dark:text-white">Inspection Report</h1>
                    <p class="text-base text-neutral-800 dark:text-white/70">Inspection #{{ $inspection->number }}</p>
                </div>
            </div>
        </div>

        <!-- Vehicle Information -->
        <div class="p-6 border-b border-neutral-900 dark:border-neutral-700">
            <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                @svg('phosphor-car', 'size-5')
                Vehicle Information
            </h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-car-simple-light', 'size-4')
                        <span>Vehicle</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $inspection->vehicle->make }} {{ $inspection->vehicle->model }} ({{ $inspection->vehicle->year }})</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-hash-light', 'size-4')
                        <span>VIN</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white font-mono text-xs">{{ $inspection->vehicle->vin ?? 'Not provided' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-wrench-light', 'size-4')
                        <span>Inspection Type</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ ucfirst(str_replace('-', ' ', $inspection->type->value)) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-building-light', 'size-4')
                        <span>Provider</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $inspection->provider->name }}</span>
                </div>
            </div>
        </div>
        
        <!-- Completion Date -->
        @if($inspection->completed_at)
            <div class="p-6 border-b border-neutral-900 dark:border-neutral-700">
                <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                    @svg('phosphor-check-circle', 'size-5')
                    Completion Date
                </h4>
                <div class="text-sm">
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $inspection->completed_at->format('M j, Y') }}</span>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Main Content -->
    <div class="col-span-3 grid grid-cols-1 gap-8 p-8">

        <!-- Inspection Report -->
        <div class="grid grid-cols-1 gap-4 content-start">
            @if($inspection->report)
                <div class="grid grid-cols-1 gap-4 content-start">
                    <div class="col-span-1 flex items-center gap-2">
                        @svg('phosphor-note', 'size-8 text-blue-500')
                        <span class="text-2xl">{{ __('Inspection Report') }}</span>
                    </div>
                    <div class="grid grid-cols-1 content-start pl-10">
                        <div class="prose max-w-none">
                            <p class="text-base text-neutral-800 dark:text-white whitespace-pre-line">{{ $inspection->report }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Damage Spareparts -->
            @if($inspection->damageSpareparts->count() > 0)
                <div class="grid grid-cols-1 gap-4 content-start">
                    <div class="col-span-1 flex items-center gap-2">
                        @svg('phosphor-wrench', 'size-8 text-orange-500')
                        <span class="text-2xl">{{ __('Damage Spareparts') }}</span>
                    </div>
                    <div class="grid grid-cols-1 content-start pl-10">
                        @foreach($inspection->damageSpareparts as $damageSparepart)
                            <div class="col-span-1 flex gap-4 border-b border-neutral-300 dark:border-neutral-700 pb-4">
                                <div class="flex flex-col text-neutral-900 dark:text-white">
                                    <span class="text-2xl font-extrabold">{{ $damageSparepart->sparepart->name }}</span>
                                    @if($damageSparepart->sparepart->description)
                                        <span class="text-lg font-normal">{{ $damageSparepart->sparepart->description }}</span>
                                    @endif
                                    @if($damageSparepart->sparepart->brand)
                                        <span class="text-base font-normal">Brand: {{ $damageSparepart->sparepart->brand }}</span>
                                    @endif
                                </div>
                                <div class="grid grid-cols-1">
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold
                                        @if($damageSparepart->priority->value === 'high') bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300
                                        @elseif($damageSparepart->priority->value === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300
                                        @else bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300
                                        @endif">
                                        {{ ucfirst($damageSparepart->priority->value) }} Priority
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quotation Requests Section -->
            <div class="grid grid-cols-1 gap-2 content-start">
                <div class="col-span-1 flex items-center gap-2">
                    @svg('phosphor-calculator', 'size-8 text-fuchsia-500')
                    <span class="text-2xl">{{ __('Quotation Requests') }}</span>
                </div>
                <div class="flex gap-3 pl-10 mb-4">
                    <button
                        wire:click="createQuotationRequest('spare-parts')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500/10 text-purple-600 dark:bg-purple-500/20 dark:text-purple-300 text-sm font-medium font-montserrat rounded-full hover:bg-purple-500/20 dark:hover:bg-purple-500/30 transition-colors duration-200"
                    >
                        <span>Request Spare Parts Quotation</span>
                        @svg('phosphor-plus', 'size-4')
                    </button>
                    <button
                        wire:click="createQuotationRequest('repair')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500/10 text-orange-600 dark:bg-orange-500/20 dark:text-orange-300 text-sm font-medium font-montserrat rounded-full hover:bg-orange-500/20 dark:hover:bg-orange-500/30 transition-colors duration-200"
                    >
                        <span>Request Repair Quotation</span>
                        @svg('phosphor-plus', 'size-4')
                    </button>
                </div>

                @if($quotationRequests->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pl-10">
                        @foreach($quotationRequests as $quotationRequest)
                            <div class="group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 flex flex-col justify-between bg-white dark:bg-white/5 transition-all hover:-translate-y-0.5">
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div class="flex items-center gap-3">
                                        @if ($quotationRequest->type->value === 'spare-parts')
                                            <span class="inline-flex items-center justify-center size-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                                                @svg('phosphor-calculator', 'size-6')
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center size-10 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                                                @svg('phosphor-wrench', 'size-6')
                                            </span>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold
                                        @if($quotationRequest->status->value === 'open') bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300
                                        @elseif($quotationRequest->status->value === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300
                                        @elseif($quotationRequest->status->value === 'quoted') bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300
                                        @elseif($quotationRequest->status->value === 'cancelled') bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300
                                        @else bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white
                                        @endif">
                                        {{ ucfirst($quotationRequest->status->value) }}
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    <div class="text-xl md:text-2xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                                        {{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }} Quotation
                                    </div>

                                    <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                                        @svg('phosphor-calendar-dots', 'size-4 text-violet-500')
                                        <span>Created {{ $quotationRequest->created_at->diffForHumans() }}</span>
                                    </div>

                                    @if($quotationRequest->providers->count() > 0)
                                        <div class="flex items-center gap-2 text-xs text-neutral-600 dark:text-white/70">
                                            @svg('phosphor-building', 'size-4 text-sky-500')
                                            <span>{{ $quotationRequest->providers->count() }} provider(s) notified</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex text-base text-neutral-500 dark:text-white/20 pl-10">
                        <span>{{ __('_________ No quotation requests yet') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-400 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50">
            @svg('phosphor-check-circle-light', 'size-5')
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="fixed bottom-4 right-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
