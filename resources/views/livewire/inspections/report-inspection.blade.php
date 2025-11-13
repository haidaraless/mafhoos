<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    <!-- Main Content - Form Only -->
    <div class="col-span-2 grid grid-cols-1 gap-8 content-start border-r border-neutral-900 dark:border-neutral-700">
        <!-- Back Button -->
        <div class="flex items-center gap-2 px-8 py-2 border-b border-neutral-900 dark:border-neutral-700">
            <a href="{{ route('dashboard.vehicle-inspection-center') }}" class="inline-flex items-center gap-2 text-sm font-medium text-neutral-900 dark:text-white hover:text-orange-500 transition-colors duration-200">
                @svg('phosphor-arrow-left', 'size-5')
                Back to Dashboard
            </a>
        </div>
        
        <!-- Report Section -->
        <div class="grid grid-cols-1 gap-4 content-start px-8">
            <div class="col-span-1 flex items-center gap-2">
                @svg('phosphor-note', 'size-8 text-orange-500')
                <span class="text-2xl">{{ __('Inspection Report') }}</span>
            </div>
            <div class="grid grid-cols-1 content-start pl-10">
                <div class="w-full">
                    <label for="report" class="block text-base font-semibold text-neutral-900 dark:text-white mb-4">
                        Report Details
                    </label>
                    <textarea
                        wire:model="report"
                        id="report"
                        rows="5"
                        class="w-full px-4 py-3.5 border border-neutral-300 dark:border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white dark:bg-white/5 text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-white/40 text-sm leading-relaxed resize-none transition-all duration-200"
                        placeholder="Enter detailed inspection findings, observations, and recommendations..."
                        required
                    ></textarea>
                    @error('report') 
                        <span class="text-red-500 dark:text-red-400 text-sm mt-2 flex items-center gap-1.5">
                            @svg('phosphor-warning-light', 'size-4')
                            {{ $message }}
                        </span> 
                    @enderror
                </div>
            </div>

            <!-- Damage Spareparts Section -->
            <div class="grid grid-cols-1 gap-4 content-start">
                <div class="col-span-1 flex items-center gap-2">
                    @svg('phosphor-wrench', 'size-8 text-orange-500')
                    <span class="text-2xl">{{ __('Damage Spareparts') }}</span>
                </div>
                <div class="grid grid-cols-1 content-start pl-10">
                
                    <!-- Search Input -->
                    <div class="mb-6">
                        <label for="sparepart-search" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            Search Compatible Spareparts
                        </label>
                        <div class="flex items-center gap-2 text-xs text-neutral-500 dark:text-white/60 mb-3 px-1">
                            @svg('phosphor-info-light', 'size-4')
                            <span>Showing only parts compatible with <strong>{{ $appointment->vehicle->make }} {{ $appointment->vehicle->model }} ({{ $appointment->vehicle->year }})</strong></span>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                @svg('phosphor-magnifying-glass-light', 'size-5 text-neutral-400 dark:text-white/40')
                            </div>
                            <input
                                type="text"
                                wire:model.live="sparepartSearch"
                                id="sparepart-search"
                                class="w-full pl-12 pr-4 py-3.5 border border-neutral-300 dark:border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white dark:bg-white/5 text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-white/40 text-sm transition-all duration-200"
                                placeholder="Type sparepart name to search..."
                            />
                        </div>
                        
                        <!-- Search Results -->
                        @if(count($sparepartSearchResults) > 0)
                            <div class="mt-4 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-white/10 rounded-lg shadow-lg max-h-72 overflow-y-auto divide-y divide-neutral-200 dark:divide-white/10">
                            @foreach($sparepartSearchResults as $sparepart)
                                <button
                                    type="button"
                                    wire:click="selectSparepart('{{ $sparepart['id'] }}')"
                                    class="w-full px-4 py-4 text-left hover:bg-neutral-50 dark:hover:bg-white/5 transition-colors cursor-pointer group"
                                >
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-neutral-900 dark:text-white group-hover:text-orange-500 dark:group-hover:text-orange-400 transition-colors">
                                                {{ $sparepart['name'] }}
                                            </div>
                                            @if(isset($sparepart['description']))
                                                <div class="text-sm text-neutral-600 dark:text-white/70 mt-1.5 line-clamp-2">
                                                    {{ $sparepart['description'] }}
                                                </div>
                                            @endif
                                            <div class="flex items-center flex-wrap gap-2 mt-3">
                                                @if(isset($sparepart['category']))
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full">
                                                        @svg('phosphor-tag-light', 'size-3')
                                                        {{ $sparepart['category'] }}
                                                    </span>
                                                @endif
                                                @if(isset($sparepart['brand']))
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium bg-neutral-100 dark:bg-white/10 text-neutral-700 dark:text-white/80 rounded-full">
                                                        @svg('phosphor-star-light', 'size-3')
                                                        {{ $sparepart['brand'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Damage Spareparts List -->
                    @if(count($this->damageSpareparts) > 0)
                        <div class="space-y-4 mt-6">
                            <div class="flex items-center justify-between">
                                <h4 class="font-semibold text-neutral-900 dark:text-white">Selected Spareparts ({{ count($this->damageSpareparts) }}):</h4>
                            <div class="flex items-center flex-wrap gap-2 text-sm">
                                @php
                                    $priorityCounts = [
                                        'high' => 0,
                                        'medium' => 0,
                                        'low' => 0
                                    ];
                                    foreach($this->damageSpareparts as $damageSparepart) {
                                        $priority = $damageSparepart->priority->value;
                                        $priorityCounts[$priority] = ($priorityCounts[$priority] ?? 0) + 1;
                                    }
                                @endphp
                                @if($priorityCounts['high'] > 0)
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-full">
                                        {{ $priorityCounts['high'] }} High
                                    </span>
                                @endif
                                @if($priorityCounts['medium'] > 0)
                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full">
                                        {{ $priorityCounts['medium'] }} Medium
                                    </span>
                                @endif
                                @if($priorityCounts['low'] > 0)
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full">
                                        {{ $priorityCounts['low'] }} Low
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                            @foreach($this->damageSpareparts as $damageSparepart)
                                @php $sparepart = $damageSparepart->sparepart; @endphp
                                <div class="w-full flex flex-col md:flex-row md:items-start md:justify-between gap-4 border-b border-neutral-300 dark:border-neutral-700 pb-4">
                                    <div class="flex flex-col text-neutral-900 dark:text-white flex-1">
                                        <span class="text-2xl font-extrabold">{{ $sparepart->name }}</span>
                                        @if($sparepart->description)
                                            <span class="text-lg font-normal">{{ $sparepart->description }}</span>
                                        @endif
                                        <div class="flex items-center gap-2 mt-1">
                                            @if($sparepart->brand)
                                                <span class="text-base font-normal font-mono">{{ $sparepart->brand }}</span>
                                            @endif
                                            @if($sparepart->category)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                                                    {{ $sparepart->category }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2 md:items-end md:text-right">
                                        <div class="flex items-center gap-1">
                                            <button
                                                type="button"
                                                wire:click="updatePriority('{{ $sparepart->id }}', 'low')"
                                                class="px-2.5 py-1 text-xs font-medium rounded-full transition-colors {{ $damageSparepart->priority->value === 'low' ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-300' : 'bg-neutral-100 dark:bg-white/10 text-neutral-600 dark:text-white/70 hover:bg-green-50 dark:hover:bg-green-500/10' }}"
                                            >
                                                Low
                                            </button>
                                            <button
                                                type="button"
                                                wire:click="updatePriority('{{ $sparepart->id }}', 'medium')"
                                                class="px-2.5 py-1 text-xs font-medium rounded-full transition-colors {{ $damageSparepart->priority->value === 'medium' ? 'bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-300' : 'bg-neutral-100 dark:bg-white/10 text-neutral-600 dark:text-white/70 hover:bg-yellow-50 dark:hover:bg-yellow-500/10' }}"
                                            >
                                                Medium
                                            </button>
                                            <button
                                                type="button"
                                                wire:click="updatePriority('{{ $sparepart->id }}', 'high')"
                                                class="px-2.5 py-1 text-xs font-medium rounded-full transition-colors {{ $damageSparepart->priority->value === 'high' ? 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300' : 'bg-neutral-100 dark:bg-white/10 text-neutral-600 dark:text-white/70 hover:bg-red-50 dark:hover:bg-red-500/10' }}"
                                            >
                                                High
                                            </button>
                                        </div>
                                        <button
                                            type="button"
                                            wire:click="removeSparepart('{{ $sparepart->id }}')"
                                            class="inline-flex items-center p-2 rounded-full text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors w-fit"
                                        >
                                            @svg('phosphor-trash-light', 'size-5')
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex text-base text-neutral-500 dark:text-white/20">
                            <span>{{ __('_________ No damage spareparts selected yet. Use the search above to add damaged spareparts.') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar - Inspection & Appointment Information -->
    <div class="col-span-1 grid grid-cols-1">
        <!-- Inspection Details -->
        <div class="col-span-1 flex items-start justify-between border-b border-neutral-900 dark:border-neutral-700">
            <div class="flex flex-col gap-2 p-6">
                @svg('phosphor-clipboard-text', 'size-8 text-orange-500')
                <h3 class="text-2xl font-semibold text-neutral-900 dark:text-white">Inspection Details</h3>

                <div class="flex items-center text-2xl text-neutral-900 dark:text-white font-normal">
                    @svg('phosphor-hash-light', 'size-6')
                    <span>{{ $inspection->number }}</span>
                </div>
            </div>
            <div class="flex flex-col border-l border-neutral-900 dark:border-neutral-700">
                <div class="flex flex-col">
                    <div class="flex items-center px-2 py-1 gap-1 text-neutral-600 dark:text-white/70 border-b border-neutral-900 dark:border-neutral-700">
                        @svg('phosphor-clock-light', 'size-4')
                        <span class="text-sm font-normal">Started</span>
                    </div>
                    @if($inspection->started_at)
                        <div class="flex flex-col p-2">
                            <span class="text-2xl font-medium">{{ $inspection->started_at->format('g:i A') }}</span>
                            <span class="-mt-1 text-sm font-normal">{{ $inspection->started_at->format('F j') }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex flex-col border-t border-neutral-900 dark:border-neutral-700">
                    <div class="flex items-center px-2 py-1 gap-1 text-neutral-600 dark:text-white/70 border-b border-neutral-900 dark:border-neutral-700">
                        @svg('phosphor-check-circle-light', 'size-4')
                        <span class="text-sm font-medium">Completed</span>
                    </div>
                    @if($inspection->completed_at)
                        <div class="flex flex-col p-2">
                            <span class="p-2 text-2xl font-medium">{{ $inspection->completed_at->format('g:i A') }}</span>
                            <span class="-mt-1 p-2 text-sm font-normal">{{ $inspection->completed_at->format('F j') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="p-6 border-b border-neutral-900 dark:border-neutral-700">
            <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                @svg('phosphor-calendar-dots', 'size-5')
                Appointment Details
            </h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-hash-light', 'size-4')
                        <span>Appointment Number</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->number }}</span>
                </div>
                @if($appointment->provider)
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                            @svg('phosphor-building-light', 'size-4')
                            <span>Provider</span>
                        </span>
                        <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->provider->name }}</span>
                    </div>
                @endif
                @if($appointment->inspection_type)
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                            @svg('phosphor-wrench-light', 'size-4')
                            <span>Inspection Type</span>
                        </span>
                        <span class="font-medium text-neutral-900 dark:text-white">{{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}</span>
                    </div>
                @endif
                @if($appointment->scheduled_at)
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                            @svg('phosphor-calendar-blank-light', 'size-4')
                            <span>Date</span>
                        </span>
                        <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->scheduled_at->format('M j, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                            @svg('phosphor-clock-light', 'size-4')
                            <span>Time</span>
                        </span>
                        <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->scheduled_at->format('g:i A') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Vehicle Details -->
        <div class="p-6 border-b border-neutral-900 dark:border-neutral-700">
            <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                @svg('phosphor-car', 'size-5')
                Vehicle Details
            </h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-car-simple-light', 'size-4')
                        <span>Vehicle</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-calendar-blank-light', 'size-4')
                        <span>Year & Make</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->year }} {{ $appointment->vehicle->make }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-tag-light', 'size-4')
                        <span>Model</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->model }}</span>
                </div>
            </div>
        </div>

        <!-- Owner Details -->
        <div class="p-6 border-b border-neutral-900 dark:border-neutral-700">
            <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                @svg('phosphor-user', 'size-5')
                Owner Information
            </h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-user-circle-light', 'size-4')
                        <span>Name</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->user->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                        @svg('phosphor-envelope-light', 'size-4')
                        <span>Email</span>
                    </span>
                    <span class="font-medium text-neutral-900 dark:text-white text-xs">{{ $appointment->vehicle->user->email }}</span>
                </div>
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="p-6 grid grid-cols-1 gap-3 space-y-3">
            <h4 class="text-base font-semibold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                @svg('phosphor-check-circle', 'size-5')
                Actions
            </h4>
            @if($inspection->completed_at)
                <div class="col-span-1 px-4 py-3 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 rounded-full flex items-center justify-center gap-2 font-medium text-sm font-montserrat">
                    @svg('phosphor-check-circle-light', 'size-5')
                    Inspection Completed
                </div>
            @else
                <div class="col-span-1 space-y-2">
                    <button
                        type="button"
                        wire:click="completeInspection"
                        class="inline-flex items-center justify-between w-full px-6 py-3 bg-emerald-500 dark:bg-emerald-700 text-white text-base font-medium font-montserrat rounded-full hover:bg-emerald-700 dark:hover:bg-emerald-600 transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-2">
                            @svg('phosphor-check-circle-light', 'size-5')
                            <span>Complete & Notify Owner</span>
                        </div>
                        @svg('phosphor-arrow-right-light', 'size-6')
                    </button>
                    <button
                        type="button"
                        wire:click="saveReport"
                        class="inline-flex items-center justify-between w-full px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full hover:bg-neutral-50 dark:hover:bg-white/5 transition-all duration-200 cursor-pointer"
                    >
                        <div class="flex items-center gap-2">
                            @svg('phosphor-floppy-disk-light', 'size-5')
                            <span>Save Draft</span>
                        </div>
                        @svg('phosphor-arrow-right-light', 'size-6')
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-400 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50">
            @svg('phosphor-check-circle-light', 'size-5')
            {{ session('message') }}
        </div>
    @endif
</div>