<div class="grid grid-cols-1 lg:grid-cols-3 content-start gap-6 lg:gap-0">
    <!-- Main Content -->
    <div class="col-span-1 lg:col-span-2 grid grid-cols-1 content-start overflow-hidden border border-neutral-200 dark:border-white/10 rounded-3xl bg-white dark:bg-neutral-900">
        <div class="col-span-1 flex flex-col gap-6 bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-white/10">
            <div class="flex items-center gap-2 px-4 sm:px-6 lg:px-8 h-12 border-b border-neutral-200 dark:border-white/10">
                <a href="{{ route('appointments.inspection-center.select', $appointment) }}" class="inline-flex items-center gap-2 text-base font-medium text-neutral-900 dark:text-white hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
                    @svg('phosphor-arrow-left', 'size-5')
                    Back to centers
                </a>
            </div>
            <div class="px-3 md:px-6">
                @svg('phosphor-wrench-light', 'size-10 md:size-12 text-orange-500')
            </div>
            <div class="flex flex-col p-3 md:p-6">
                <h1 class="text-2xl md:text-3xl text-neutral-800 dark:text-white font-bold">Select Inspection Type</h1>
                <p class="text-neutral-600 dark:text-white/70">Choose the type of inspection you need</p>
            </div>
        </div>

        <!-- Types List -->
        <div class="grid grid-cols-1">
            @foreach($inspectionTypes as $inspectionType)
                <div 
                    wire:click="selectInspectionType('{{ $inspectionType->value }}')"
                    class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-t border-neutral-200 dark:border-white/10 p-4 sm:p-6 bg-white dark:bg-transparent hover:-translate-y-0.5 transition-all duration-200 cursor-pointer {{ $appointment->inspection_type === $inspectionType->value ? 'border-blue-500 dark:border-blue-500/40 bg-blue-50 dark:bg-blue-500/10' : '' }}"
                >
                    <div class="flex items-center gap-3">
                        @php
                            $icon = 'phosphor-wrench'; $iconColor = 'text-green-500';
                            if ($inspectionType === \App\Enums\InspectionType::ENGINE_INSPECTION) { $icon = 'phosphor-engine'; $iconColor = 'text-violet-500'; }
                            if ($inspectionType === \App\Enums\InspectionType::UNDERCARRIAGE_INSPECTION) { $icon = 'phosphor-car-simple'; $iconColor = 'text-sky-500'; }
                            if ($inspectionType === \App\Enums\InspectionType::COMPREHENSIVE_INSPECTION) { $icon = 'phosphor-clipboard-text'; $iconColor = 'text-amber-500'; }
                        @endphp
                        @svg($icon, 'size-10 '.$iconColor)
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
                    <div class="flex items-center justify-end gap-4">
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                            {{ number_format($this->getInspectionPrice($inspectionType), 2) }}
                            <span class="-ml-1 text-sm font-medium text-neutral-500 dark:text-white/70">SAR</span>
                        </p>
                        @svg('phosphor-caret-right', 'size-7 text-neutral-900 dark:text-white/70')
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @livewire('appointments.appointment-progress', ['appointment' => $appointment], key('progress-' . $appointment->id))
</div>