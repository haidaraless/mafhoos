<div class="w-full p-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="flex-1">
            <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                            @svg('phosphor-wrench', 'size-6')
                        </span>
                        <h2 class="text-2xl font-extrabold">Select Inspection Type</h2>
                    </div>
                    @if($appointment->inspection_type)
                        <div class="text-sm text-neutral-600 dark:text-white/70">
                            <span class="font-medium">Current:</span> {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}
                        </div>
                    @endif
                </div>
                
                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Choose Your Inspection Type</h3>
        
        <div class="grid gap-3">
            @foreach($inspectionTypes as $inspectionType)
                <button 
                    wire:click="selectInspectionType('{{ $inspectionType->value }}')"
                    class="w-full text-left p-4 border rounded-2xl transition-colors duration-200 focus:outline-none {{ $appointment->inspection_type === $inspectionType->value ? 'border-blue-500 bg-blue-50 dark:bg-white/10' : 'border-neutral-300 dark:border-white/10 bg-white dark:bg-white/5 hover:-translate-y-0.5' }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-neutral-900 dark:text-white capitalize">
                                {{ str_replace('-', ' ', $inspectionType->value) }}
                            </h4>
                            <p class="text-sm text-neutral-600 dark:text-white/70 mt-1">
                                @switch($inspectionType)
                                    @case(\App\Enums\InspectionType::UNDERCARRIAGE_INSPECTION)
                                        Complete undercarriage examination
                                        @break
                                    @case(\App\Enums\InspectionType::ENGINE_INSPECTION)
                                        Detailed engine system analysis
                                        @break
                                    @case(\App\Enums\InspectionType::COMPREHENSIVE_INSPECTION)
                                        Full vehicle comprehensive inspection
                                        @break
                                @endswitch
                            </p>
                        </div>
                        @if($appointment->inspection_type === $inspectionType->value)
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">Selected</span>
                        @endif
                    </div>
                </button>
            @endforeach
        </div>
                </div>
                
                @if($appointment->inspection_type)
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
