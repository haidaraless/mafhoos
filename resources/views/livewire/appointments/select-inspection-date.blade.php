<div class="w-full p-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header Section -->
            <div class="text-neutral-800 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-violet-500/10 text-violet-600">
                            @svg('phosphor-calendar-dots', 'size-6')
                        </span>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-extrabold">Select Inspection Date & Time</h1>
                            <p class="text-neutral-600 dark:text-white/70 mt-1 md:mt-2 text-sm md:text-lg">Choose your preferred date and time for the inspection with {{ $appointment->provider->name }}</p>
                            @if($appointment->scheduled_at)
                                <div class="mt-2 text-sm text-gray-600">
                                    <span class="font-medium">Current:</span> {{ $appointment->scheduled_at->format('l, F j, Y') }} at {{ $appointment->scheduled_at->format('g:i A') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-16 h-16 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="py-6 lg:py-8">
                
        @if($errors->has('selection'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-800 font-medium">{{ $errors->first('selection') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Available Days Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-extrabold text-neutral-900 dark:text-white">Available Days</h2>
                <div class="text-sm text-neutral-600 dark:text-white/70">
                    Select a day to view available times
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-6">
                @foreach($availableDates as $dateInfo)
                    <div class="relative group">
                        @if($dateInfo['isToday'])
                            <div class="absolute -top-2 -right-2 bg-green-500 text-white text-xs px-3 py-1 rounded-full font-medium shadow-lg z-10">
                                Today
                            </div>
                        @elseif($dateInfo['isTomorrow'])
                            <div class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-medium shadow-lg z-10">
                                Tomorrow
                            </div>
                        @endif
                        
                        @livewire('appointments.day-selector', [
                            'date' => $dateInfo['date'],
                            'appointmentId' => $appointment->id
                        ], key('day-' . $dateInfo['date']))
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Selection Summary & Confirm Button -->
        @if($selectedDate && $selectedTime)
            <div class="mt-8 p-6 border border-neutral-300 dark:border-white/10 rounded-2xl bg-white dark:bg-white/5">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Selected Appointment</h3>
                        <div class="flex items-center text-neutral-700 dark:text-white/80">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-medium text-lg">{{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}</span>
                            <span class="mx-3 text-gray-400">•</span>
                            <span class="font-medium text-lg">{{ \Carbon\Carbon::createFromFormat('H:i', $selectedTime)->format('g:i A') }}</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <button 
                            wire:click="confirmSelection"
                            class="w-full lg:w-auto px-8 py-3 bg-neutral-800 text-white rounded-full hover:bg-neutral-900 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            Confirm Selection
                        </button>
                    </div>
                </div>
            </div>
        @endif
        
        @if($appointment->scheduled_at)
            <div class="mt-6 text-center">
                <p class="text-neutral-500 text-sm">You can change your date and time selection above</p>
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
