<div class="grid grid-cols-3 content-start">
    <!-- Inspection Centers Selection -->
    <div class="col-span-2 grid grid-cols-1 content-start overflow-hidden">
        <div class="col-span-1 flex flex-col gap-6 bg-white border-b border-neutral-300">
            <div class="flex items-center gap-2 px-8 h-10 border-b border-neutral-900 dark:border-white/10">
                <a href="{{ route('appointments.vehicle.select', $appointment) }}" class="inline-flex items-center gap-2 text-base font-medium text-neutral-900 hover:text-orange-500 transition-colors duration-200">
                    @svg('phosphor-arrow-left', 'size-5')
                    Back to vehicles
                </a>
            </div>
            <div class="px-3 md:px-6">
                @svg('phosphor-buildings-light', 'size-10 md:size-12 text-orange-500')
            </div>
            <div class="flex flex-col p-3 md:p-6">
                <h1 class="text-2xl md:text-3xl text-neutral-800 font-bold">Select Inspection Center</h1>
                <p class="text-neutral-600">Choose a center that works best for you</p>
            </div>
        </div>

        @if($centers->count() > 0)
            <div class="grid grid-cols-1">
                @foreach($centers as $center)
                    <div class="flex items-center justify-between border-t border-neutral-300 dark:border-white/10 p-4 {{ ($appointment->provider_id === $center->id) ? 'bg-green-50 font-black' : 'bg-white font-semibold' }} dark:bg-white/5 hover:-translate-y-0.5 transition-all duration-200 cursor-pointer {{ $appointment->provider_id === $center->id ? 'border-blue-500 bg-blue-50 dark:bg-white/10' : '' }}"
                        wire:click="selectCenter('{{ $center->id }}')">
                        <div class="flex flex-col">
                            <h3 class="text-lg text-neutral-800 dark:text-white mb-2">{{ $center->name }}</h3>
                            <div class="space-y-2 text-sm text-neutral-600 dark:text-white/70">
                                <div class="flex items-center">
                                    @svg('phosphor-map-pin', 'size-4 mr-2 text-sky-500')
                                    <span class="font-normal">{{ $center->location ?? 'Location not specified' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            @if($appointment->provider_id === $center->id)
                                @svg('phosphor-check-circle', 'size-7 text-green-600')
                            @else
                                @svg('phosphor-circle', 'size-7 text-neutral-400')
                            @endif
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
    </div>
    @livewire('appointments.appointment-progress', ['appointment' => $appointment], key('progress-' . $appointment->id))
</div>