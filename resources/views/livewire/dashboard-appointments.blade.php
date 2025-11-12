<div class="space-y-6">
    <!-- Draft Appointments Section -->
    @if($draftAppointments->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Draft Appointments</h3>
                        <p class="text-sm text-gray-600">Complete your pending appointment bookings</p>
                    </div>
                </div>
                <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $draftAppointments->count() }} pending
                </span>
            </div>

            <div class="space-y-3">
                @foreach($draftAppointments as $appointment)
                    <div class="grid grid-cols-1 gap-4 border-t border-gray-200 p-4 bg-white hover:bg-neutral-50 transition-colors duration-200">
                        <div class="col-span-1 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <h4 class="font-medium text-gray-900">{{ $appointment->vehicle->name }}</h4>
                                <span class="text-sm text-gray-500">{{ $appointment->vehicle->year }} {{ $appointment->vehicle->make }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $appointment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="col-span-1 flex items-center gap-2">
                            <div class="flex items-center gap-2">
                                @if($appointment->provider_id)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Center Selected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Select Center
                                    </span>
                                @endif

                                @if($appointment->inspection_type)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Type Selected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Select Type
                                    </span>
                                @endif

                                @if($appointment->scheduled_at)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Date Selected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Select Date
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center gap-2">
                                <button 
                                    wire:click="continueDraftAppointment('{{ $appointment->id }}')"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                >
                                    Continue
                                </button>
                                <button 
                                    wire:click="cancelDraftAppointment('{{ $appointment->id }}')"
                                    wire:confirm="Are you sure you want to cancel this draft appointment?"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200"
                                >
                                    Cancel
                                </button>
                            </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Upcoming Appointments Section -->
    @if($upcomingAppointments->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Upcoming Appointments</h3>
                        <p class="text-sm text-gray-600">Your confirmed upcoming inspections</p>
                    </div>
                </div>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $upcomingAppointments->count() }} upcoming
                </span>
            </div>

            <div class="space-y-3">
                @foreach($upcomingAppointments as $appointment)
                    <div class="border-t border-gray-200 p-4 hover:bg-blue-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $appointment->vehicle->name }}</h4>
                                    <span class="text-sm text-gray-500">#{{ $appointment->number }}</span>
                                </div>
                                
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $appointment->scheduled_at->format('l, F j, Y') }} at {{ $appointment->scheduled_at->format('g:i A') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $appointment->provider->name }}</span>
                                    </div>
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
                                <button 
                                    wire:click="viewAppointment('{{ $appointment->id }}')"
                                    class="px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors duration-200"
                                >
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Appointments Section -->
    @if($recentAppointments->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Appointments</h3>
                        <p class="text-sm text-gray-600">Your recent appointment history</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                @foreach($recentAppointments as $appointment)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $appointment->vehicle->name }}</h4>
                                    <span class="text-sm text-gray-500">{{ $appointment->vehicle->year }} {{ $appointment->vehicle->make }}</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $appointment->status->value === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($appointment->status->value) }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    @if($appointment->scheduled_at)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $appointment->scheduled_at->format('M j, Y g:i A') }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $appointment->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <button 
                                    wire:click="viewAppointment('{{ $appointment->id }}')"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200"
                                >
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if($draftAppointments->count() === 0 && $upcomingAppointments->count() === 0 && $recentAppointments->count() === 0)
        <div class="grid grid-cols-1 gap-4 bg-white rounded-lg border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900">No Appointments Found</h3>
            @if($canCreateAppointment)
                <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Appointment
                </a>
            @endif
        </div>
    @endif
</div>
