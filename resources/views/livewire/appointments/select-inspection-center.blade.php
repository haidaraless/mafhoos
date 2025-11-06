<div class="w-full p-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="flex-1">

            <!-- Inspection Centers Selection -->
            <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                            @svg('phosphor-buildings', 'size-6')
                        </span>
                        <h2 class="text-2xl font-extrabold">Select Inspection Center</h2>
                    </div>
                    @if($appointment->provider_id)
                        <div class="text-sm text-neutral-600 dark:text-white/70">
                            <span class="font-medium">Current:</span> {{ $appointment->provider->name }}
                        </div>
                    @endif
                </div>
                
        
        @if($centers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($centers as $center)
                    <div class="border {{ $appointment->provider_id === $center->id ? 'border-blue-500 bg-blue-50 dark:bg-white/10' : 'border-neutral-300 dark:border-white/10' }} rounded-2xl p-4 bg-white dark:bg-white/5 hover:-translate-y-0.5 transition-all duration-200 cursor-pointer"
                         wire:click="selectCenter('{{ $center->id }}')">
                        <div class="flex flex-col h-full">
                            <h3 class="text-lg font-semibold text-neutral-800 dark:text-white mb-2">{{ $center->name }}</h3>
                            <div class="space-y-2 text-sm text-neutral-600 dark:text-white/70 flex-grow">
                                <div class="flex items-center">
                                    @svg('phosphor-map-pin', 'size-4 mr-2 text-sky-500')
                                    <span>{{ $center->location ?? 'Location not specified' }}</span>
                                </div>
                                <div class="flex items-center">
                                    @svg('phosphor-phone', 'size-4 mr-2 text-green-500')
                                    <span>{{ $center->mobile }}</span>
                                </div>
                                <div class="flex items-center">
                                    @svg('phosphor-envelope-simple', 'size-4 mr-2 text-violet-500')
                                    <span>{{ $center->email }}</span>
                                </div>
                                @if($center->commercial_record)
                                    <div class="flex items-center">
                                        @svg('phosphor-identification-badge', 'size-4 mr-2 text-amber-500')
                                        <span>CR: {{ $center->commercial_record }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 pt-3 border-t border-neutral-200 dark:border-white/10">
                                @if($appointment->provider_id === $center->id)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Selected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Click to Select
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 border border-neutral-300 dark:border-white/10 rounded-2xl bg-white dark:bg-white/5">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">No Inspection Centers Available</h3>
                <p class="text-neutral-600 dark:text-white/70">There are currently no inspection centers available for selection.</p>
            </div>
        @endif
        
        @if($appointment->provider_id)
            <div class="mt-6 text-center">
                <p class="text-neutral-500 text-sm">You can change your selection above</p>
            </div>
        @endif
            </div>
        </div>

        <!-- Progress Sidebar -->
        <div class="lg:w-80">
            @livewire('appointments.appointment-progress', ['appointment' => $appointment], key('progress-' . $appointment->id))
        </div>
    </div>
</div>
