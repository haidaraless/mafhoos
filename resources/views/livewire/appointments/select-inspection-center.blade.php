<div class="w-full p-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="flex-1">

            <!-- Inspection Centers Selection -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Select Inspection Center</h2>
                    @if($appointment->provider_id)
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Current:</span> {{ $appointment->provider->name }}
                        </div>
                    @endif
                </div>
                
        
        @if($centers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($centers as $center)
                    <div class="border {{ $appointment->provider_id === $center->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-lg p-4 hover:border-blue-500 hover:shadow-md transition-all duration-200 cursor-pointer"
                         wire:click="selectCenter('{{ $center->id }}')">
                        <div class="flex flex-col h-full">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $center->name }}</h3>
                            <div class="space-y-2 text-sm text-gray-600 flex-grow">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $center->location ?? 'Location not specified' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>{{ $center->mobile }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $center->email }}</span>
                                </div>
                                @if($center->commercial_record)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>CR: {{ $center->commercial_record }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                @if($appointment->provider_id === $center->id)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Selected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Click to Select
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Inspection Centers Available</h3>
                <p class="text-gray-500">There are currently no inspection centers available for selection.</p>
            </div>
        @endif
        
        @if($appointment->provider_id)
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
