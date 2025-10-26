<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Vehicle Inspection Center</h1>
                <p class="text-gray-600">Manage inspection appointments for your center</p>
            </div>
        </div>
    </div>

    <!-- Inspection Appointments Section -->
    @if($inspectionAppointments->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Inspection Appointments</h3>
                        <p class="text-sm text-gray-600">Manage all inspection appointments</p>
                    </div>
                </div>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $inspectionAppointments->count() }} total
                </span>
            </div>

            <div class="space-y-3">
                @foreach($inspectionAppointments as $appointment)
                    <div class="border-t border-gray-200 p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $appointment->vehicle->name }}</h4>
                                    <span class="text-sm text-gray-500">#{{ $appointment->id }}</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ 
                                        $appointment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($appointment->status->value === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                        ($appointment->status->value === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) 
                                    }}">
                                        {{ ucfirst($appointment->status->value) }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>{{ $appointment->vehicle->user->name }}</span>
                                    </div>
                                    @if($appointment->scheduled_at)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $appointment->scheduled_at->format('l, F j, Y') }} at {{ $appointment->scheduled_at->format('g:i A') }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($appointment->inspection_type)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
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
                                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200"
                                    >
                                        Confirm
                                    </button>
                                @elseif($appointment->status->value === 'confirmed')
                                    <button 
                                        wire:click="completeAppointment('{{ $appointment->id }}')"
                                        wire:confirm="Are you sure you want to mark this appointment as completed?"
                                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                    >
                                        Complete
                                    </button>
                                @endif
                                
                                @if(in_array($appointment->status->value, ['pending', 'confirmed']))
                                    <button 
                                        wire:click="cancelAppointment('{{ $appointment->id }}')"
                                        wire:confirm="Are you sure you want to cancel this appointment?"
                                        class="px-4 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition-colors duration-200"
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
