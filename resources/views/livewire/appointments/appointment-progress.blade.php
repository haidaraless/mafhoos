<div class="col-span-1 border-l border-neutral-300 dark:border-white/10 bg-white dark:bg-white/5 p-6 sticky top-6">
    @if($appointment)
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                <span class="inline-flex items-center justify-center size-10 rounded-xl bg-sky-500/10 text-sky-600 dark:text-sky-300">
                    @svg('phosphor-calendar-dots', 'size-6')
                </span>
                <h3 class="text-lg font-extrabold">Appointment Progress</h3>
            </div>
        </div>

    <!-- Progress Steps -->
    <div class="space-y-4 mb-6">
        <!-- Step 1: Inspection Center -->
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                @if($appointment->provider_id)
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">Center</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white">Center</span>
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
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">Type</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{ $appointment->provider_id ? 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300' : 'bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white' }}">Type</span>
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
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">Date</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{ $appointment->inspection_type ? 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300' : 'bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white' }}">Date</span>
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
     <div class="border-t border-neutral-200 dark:border-white/10 pt-4">
         <h4 class="text-sm font-semibold text-neutral-900 dark:text-white mb-3">Appointment Details</h4>
         <div class="space-y-2 text-sm">
             <div class="flex items-center justify-between">
                 <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                     @svg('phosphor-identification-badge-light', 'size-4')
                     <span>Appointment ID</span>
                 </span>
                 <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->id }}</span>
             </div>
             <div class="flex items-center justify-between">
                 <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                     @svg('phosphor-car-light', 'size-4')
                     <span>Vehicle</span>
                 </span>
                 <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->name }}</span>
             </div>
             <div class="flex items-center justify-between">
                 <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                     @svg('phosphor-calendar-blank-light', 'size-4')
                     <span>Year & Make</span>
                 </span>
                 <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->year }} {{ $appointment->vehicle->make }}</span>
             </div>
         </div>
     </div>

     <!-- Vehicle Information -->
     <div class="border-t border-neutral-200 dark:border-white/10 pt-4">
         <h4 class="text-sm font-semibold text-neutral-900 dark:text-white mb-3">Vehicle Details</h4>
         <div class="space-y-2 text-sm">
             <div class="flex items-center justify-between">
                 <span class="flex items-center gap-2 text-neutral-600 dark:text-white/70">
                     @svg('phosphor-tag-light', 'size-4')
                     <span>Model</span>
                 </span>
                 <span class="font-medium text-neutral-900 dark:text-white">{{ $appointment->vehicle->model }}</span>
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
            <span class="text-xs font-medium text-neutral-700 dark:text-white/70">Progress</span>
            <span class="text-xs font-medium text-neutral-700 dark:text-white/70">{{ $completedSteps }}/3</span>
        </div>
        <div class="w-full bg-neutral-200 dark:bg-white/10 rounded-full h-2">
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