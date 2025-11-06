<div class="flex items-center justify-center w-full py-12">
    <div class="grid grid-cols-3 overflow-hidden border border-dashed border-neutral-300 rounded-2xl">
        <!-- Main Content -->
        <div class="col-span-2 grid grid-cols-1 overflow-hidden">
            <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-neutral-50 border-b border-neutral-300">
                @svg('phosphor-wrench-light', 'size-10 md:size-12 text-orange-500')
                <div class="flex flex-col">
                    <h1 class="text-2xl md:text-3xl text-neutral-800 font-bold">Select Inspection Type</h1>
                    <p class="text-neutral-600">Choose the type of inspection you need</p>
                    @if($appointment->inspection_type)
                        <span class="mt-1 text-sm text-neutral-600 dark:text-white/70">
                            <span class="font-medium">Current:</span> {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Types List -->
            <div class="grid grid-cols-1">
                @foreach($inspectionTypes as $inspectionType)
                    <div 
                        wire:click="selectInspectionType('{{ $inspectionType->value }}')"
                        class="flex items-center justify-between border-t border-neutral-300 dark:border-white/10 p-4 bg-white dark:bg-white/5 hover:-translate-y-0.5 transition-all duration-200 cursor-pointer {{ $appointment->inspection_type === $inspectionType->value ? 'border-blue-500 bg-blue-50 dark:bg-white/10' : '' }}"
                    >
                        <div class="flex items-center gap-3">
                            @php
                                $icon = 'phosphor-wrench'; $iconColor = 'text-green-500';
                                if ($inspectionType === \App\Enums\InspectionType::ENGINE_INSPECTION) { $icon = 'phosphor-engine'; $iconColor = 'text-violet-500'; }
                                if ($inspectionType === \App\Enums\InspectionType::UNDERCARRIAGE_INSPECTION) { $icon = 'phosphor-car-simple'; $iconColor = 'text-sky-500'; }
                                if ($inspectionType === \App\Enums\InspectionType::COMPREHENSIVE_INSPECTION) { $icon = 'phosphor-clipboard-text'; $iconColor = 'text-amber-500'; }
                            @endphp
                            @svg($icon, 'size-7 '.$iconColor)
                            <div>
                                <h4 class="text-xl font-semibold text-neutral-900 dark:text-white capitalize">
                                    {{ str_replace('-', ' ', $inspectionType->value) }}
                                </h4>
                                <p class="text-sm text-neutral-600 dark:text-white/70">
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
                        </div>
                        <div class="flex justify-end">
                            @if($appointment->inspection_type === $inspectionType->value)
                                @svg('phosphor-check-circle', 'size-7 text-green-600')
                            @else
                                @svg('phosphor-circle', 'size-7 text-neutral-400')
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($appointment->inspection_type)
                <div class="mt-6 text-center">
                    <p class="text-neutral-500 text-sm">You can change your selection above</p>
                </div>
            @endif
        </div>

        @livewire('appointments.appointment-progress', ['appointment' => $appointment], key('progress-' . $appointment->id))
    </div>
</div>
