<div class="w-full max-w-sm">
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6 sticky top-6">
        @if($appointment)
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Appointment Progress</h3>
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

        <!-- Progress Steps -->
        <div class="space-y-4 mb-6">
            <!-- Step 1: Inspection Center -->
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    @if($appointment->provider_id)
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @else
                        <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-xs font-semibold text-gray-600">1</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium {{ $appointment->provider_id ? 'text-green-700' : 'text-gray-500' }}">
                        Inspection Center
                    </p>
                    @if($appointment->provider_id)
                        <p class="text-xs text-green-600 truncate">{{ $appointment->provider->name }}</p>
                    @endif
                </div>
            </div>

            <!-- Step 2: Inspection Type -->
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    @if($appointment->inspection_type)
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @else
                        <div class="w-6 h-6 {{ $appointment->provider_id ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                            <span class="text-xs font-semibold {{ $appointment->provider_id ? 'text-white' : 'text-gray-600' }}">2</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium {{ $appointment->inspection_type ? 'text-green-700' : ($appointment->provider_id ? 'text-blue-700' : 'text-gray-500') }}">
                        Inspection Type
                    </p>
                    @if($appointment->inspection_type)
                        <p class="text-xs text-green-600 capitalize">
                            {{ str_replace('-', ' ', $appointment->inspection_type->value) }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Step 3: Date & Time -->
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    @if($appointment->scheduled_at)
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @else
                        <div class="w-6 h-6 {{ $appointment->inspection_type ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                            <span class="text-xs font-semibold {{ $appointment->inspection_type ? 'text-white' : 'text-gray-600' }}">3</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium {{ $appointment->scheduled_at ? 'text-green-700' : ($appointment->inspection_type ? 'text-blue-700' : 'text-gray-500') }}">
                        Date & Time
                    </p>
                    @if($appointment->scheduled_at)
                        <p class="text-xs text-green-600">
                            {{ $appointment->scheduled_at->format('M j, Y') }} at {{ $appointment->scheduled_at->format('g:i A') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="border-t border-gray-200 pt-4">
            <h4 class="text-sm font-semibold text-gray-900 mb-3">Appointment Details</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Appointment ID:</span>
                    <span class="font-medium text-gray-900">{{ $appointment->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Vehicle:</span>
                    <span class="font-medium text-gray-900">{{ $appointment->vehicle->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Year & Make:</span>
                    <span class="font-medium text-gray-900">{{ $appointment->vehicle->year }} {{ $appointment->vehicle->make }}</span>
                </div>
            </div>
        </div>

        <!-- Vehicle Information -->
        <div class="border-t border-gray-200 pt-4">
            <h4 class="text-sm font-semibold text-gray-900 mb-3">Vehicle Details</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Model:</span>
                    <span class="font-medium text-gray-900">{{ $appointment->vehicle->model }}</span>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mt-6">
            @php
                $completedSteps = 0;
                if ($appointment->provider_id) $completedSteps++;
                if ($appointment->inspection_type) $completedSteps++;
                if ($appointment->scheduled_at) $completedSteps++;
                $progressPercentage = ($completedSteps / 3) * 100;
            @endphp
            
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-gray-700">Progress</span>
                <span class="text-xs font-medium text-gray-700">{{ $completedSteps }}/3</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-300" 
                     style="width: {{ $progressPercentage }}%"></div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if($appointment && $appointment->scheduled_at)
            <div class="mt-6">
                <!-- Auto Quotation Request Checkbox -->
                <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input 
                                wire:model.live="autoQuotationRequest"
                                type="checkbox" 
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                id="auto_quotation_request"
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="auto_quotation_request" class="font-medium text-gray-900">
                                Auto Quotation Request
                            </label>
                            <p class="text-gray-600 text-xs mt-1">
                                Automatically create quotation requests for damaged parts after inspection completion
                            </p>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('appointments.fees.pay', $appointment->id) }}"
                    class="w-full bg-green-600 text-white text-sm font-medium py-2 px-4 rounded-lg hover:bg-green-700 transition-colors duration-200"
                >
                    Complete Appointment
                </a>
            </div>
        @endif
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Loading...</h3>
                <p class="text-gray-500">Loading appointment details...</p>
            </div>
        @endif
    </div>
</div>
