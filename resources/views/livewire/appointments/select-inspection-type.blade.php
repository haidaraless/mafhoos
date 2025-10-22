<div class="w-full p-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="flex-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Select Inspection Type</h2>
                    @if($appointment->inspection_type)
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Current:</span> {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}
                        </div>
                    @endif
                </div>
                
                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Choose Your Inspection Type</h3>
        
        <div class="grid gap-3">
            @foreach($inspectionTypes as $inspectionType)
                <button 
                    wire:click="selectInspectionType('{{ $inspectionType->value }}')"
                    class="w-full text-left p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                    {{ $appointment->inspection_type === $inspectionType->value ? 'border-blue-500 bg-blue-50' : '' }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900 capitalize">
                                {{ str_replace('-', ' ', $inspectionType->value) }}
                            </h4>
                            <p class="text-sm text-gray-600 mt-1">
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
                            <div class="text-blue-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
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
