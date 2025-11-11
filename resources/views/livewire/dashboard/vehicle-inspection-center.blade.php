<div class="space-y-6">
    <!-- Header -->
    <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
        <div class="flex items-center gap-3">
            @svg('phosphor-clock-user', 'size-8 text-blue-500')
            <div class="flex flex-col">
                <h1 class="text-2xl font-extrabold text-neutral-800 dark:text-white">Vehicle Inspection Center</h1>
                <p class="text-sm text-neutral-600 dark:text-white/70">Manage inspection appointments for your center</p>
            </div>
        </div>
    </div>

    <!-- Inspection Appointments Section -->
    @if($inspectionAppointments->count() > 0)
        <div class="border border-neutral-300 dark:border-white/10 rounded-2xl overflow-hidden bg-white dark:bg-white/5">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center size-10 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                        @svg('phosphor-calendar-dots', 'size-6')
                    </span>
                    <div class="flex flex-col">
                        <h3 class="text-lg font-extrabold text-neutral-800 dark:text-white">Inspection Appointments</h3>
                        <p class="text-sm text-neutral-600 dark:text-white/70">Manage all inspection appointments</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">
                    {{ $inspectionAppointments->count() }} total
                </span>
            </div>

            <div class="space-y-3">
                @foreach($inspectionAppointments as $appointment)
                    <div class="border-t border-neutral-300 dark:border-white/10 p-4 hover:bg-neutral-50 dark:hover:bg-white/10 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-extrabold text-neutral-800 dark:text-white">{{ $appointment->vehicle->name }}</h4>
                                    <span class="text-sm text-neutral-500 dark:text-white/60">#{{ $appointment->id }}</span>
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{ 
                                        $appointment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300' : 
                                        ($appointment->status->value === 'confirmed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300' : 
                                        ($appointment->status->value === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300')) 
                                    }}">
                                        {{ ucfirst($appointment->status->value) }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center space-x-4 text-sm text-neutral-600 dark:text-white/70 mb-2">
                                    <div class="flex items-center">
                                        @svg('phosphor-user', 'size-4 mr-1 text-neutral-500')
                                        <span>{{ $appointment->vehicle->user->name }}</span>
                                    </div>
                                    @if($appointment->scheduled_at)
                                        <div class="flex items-center">
                                            @svg('phosphor-calendar', 'size-4 mr-1 text-neutral-500')
                                            <span>{{ $appointment->scheduled_at->format('l, F j, Y') }} at {{ $appointment->scheduled_at->format('g:i A') }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($appointment->inspection_type)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">
                                            {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                @if($appointment->status->value === 'pending')
                                    <button 
                                        wire:click="confirmAppointment('{{ $appointment->id }}')"
                                        wire:confirm="Are you sure you want to confirm this appointment?"
                                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-full hover:bg-green-700 transition-colors duration-200"
                                    >
                                        Confirm
                                    </button>
                                @elseif($appointment->status->value === 'confirmed')
                                    <button 
                                        wire:click="startInspection('{{ $appointment->id }}')"
                                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors duration-200">
                                        Start Inspection
                                    </button>
                                @endif
                                
                                @if(in_array($appointment->status->value, ['pending', 'confirmed']))
                                    <button 
                                        wire:click="cancelAppointment('{{ $appointment->id }}')"
                                        wire:confirm="Are you sure you want to cancel this appointment?"
                                        class="px-4 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-full hover:bg-red-200 transition-colors duration-200"
                                    >
                                        Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mt-4">No Inspection Appointments</h3>
            <p class="text-gray-600 mt-2">You don't have any inspection appointments yet.</p>
        </div>
    @endif
</div>
