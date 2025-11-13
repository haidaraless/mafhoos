<div class="grid grid-cols-1 lg:grid-cols-3 content-start gap-6 lg:gap-0">
    <!-- Left Section: Calendar -->
    <div class="col-span-1 lg:col-span-2 grid grid-cols-1 content-start overflow-hidden border border-neutral-200 dark:border-white/10 rounded-3xl bg-white dark:bg-neutral-900">
        <div class="col-span-1 flex flex-col gap-6 border-b border-neutral-200 dark:border-white/10 bg-white dark:bg-neutral-900">
            <div class="col-span-1 flex items-center gap-2 px-4 sm:px-6 lg:px-8 h-12 border-b border-neutral-200 dark:border-white/10">
                <a href="{{ route('appointments.inspection-type.select', $appointment) }}" class="inline-flex items-center gap-2 text-base font-medium text-neutral-900 dark:text-white hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
                    @svg('phosphor-arrow-left', 'size-5')
                    Back to inspection type
                </a>
            </div>
            <div class="px-3 md:px-6">
                @svg('phosphor-clock', 'size-10 md:size-12 text-orange-500')
            </div>
            <div class="flex flex-col p-3 md:p-6">
                <h1 class="text-2xl md:text-3xl text-neutral-800 dark:text-white font-bold">Select Inspection Date & Time</h1>
                <p class="text-neutral-600 dark:text-white/70">Choose your preferred date and time with {{ $appointment->provider->name }}</p>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 content-start">
            <!-- Calendar Section -->
            <div class="col-span-1 p-6 lg:p-8 border-b lg:border-b-0 lg:border-r border-neutral-200 dark:border-white/10">
                <!-- Month Navigation -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-2">
                        @svg('phosphor-calendar-dots', 'size-8 text-violet-600')
                        <span class="text-2xl text-neutral-900 dark:text-white">{{ $this->getMonthName() }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <button 
                            wire:click="previousMonth"
                            class="p-1 hover:bg-neutral-100 dark:hover:bg-white/10 rounded-full transition-colors"
                        >
                            @svg('phosphor-caret-left', 'size-6 text-neutral-600 dark:text-white/70')
                        </button>
                        <button 
                            wire:click="nextMonth"
                            class="p-1 hover:bg-neutral-100 dark:hover:bg-white/10 rounded-full transition-colors"
                        >
                            @svg('phosphor-caret-right', 'size-6 text-neutral-600 dark:text-white/70')
                        </button>
                    </div>
                </div>

                <!-- Day Headers -->
                <div class="grid grid-cols-7 gap-1 mb-2">
                    @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                        <div class="text-center text-lg font-semibold text-neutral-900 dark:text-white/70 py-1">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>

                <!-- Calendar Days -->
                <div class="grid grid-cols-7 gap-1">
                    @foreach($this->getCalendarDays() as $day)
                        <button
                            @if(!$day['isPast'])
                                wire:click="selectDate('{{ $day['date'] }}')"
                            @endif
                            class="aspect-square flex items-center justify-center text-lg rounded-full transition-colors
                                {{ $day['isSelected'] ? 'bg-orange-500 text-white font-semibold' : '' }}
                                {{ !$day['isSelected'] && !$day['isPast'] && $day['isCurrentMonth'] ? 'text-neutral-800 dark:text-white hover:bg-neutral-100 dark:hover:bg-white/10' : '' }}
                                {{ ($day['isPast'] || !$day['isCurrentMonth']) ? 'text-neutral-400 dark:text-white/30 cursor-not-allowed opacity-50' : '' }}
                            "
                            @if($day['isPast'])
                                disabled
                                title="Past dates cannot be selected"
                            @endif
                        >
                            {{ $day['day'] }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="col-span-1 lg:col-span-2">
                <!-- Available Times for Selected Date -->
                @if($selectedDate)
                    <div class="grid grid-cols-1">
                        @livewire('appointments.day-selector', [
                            'date' => $selectedDate,
                            'appointmentId' => $appointment->id
                        ], key('day-' . $selectedDate))
                    </div>
                @else
                    <div class="flex items-center justify-center p-8 text-neutral-500 dark:text-white/60">
                        <div class="text-center">
                            @svg('phosphor-calendar-dots', 'size-12 mb-4 mx-auto')
                            <p class="text-lg text-neutral-700 dark:text-white/70">Please select a date from the calendar</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-span-1 lg:col-span-3">
                @if($errors->has('selection'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-500/10 border-l-4 border-red-400 dark:border-red-500/40 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400 dark:text-red-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-red-800 dark:text-red-200 font-medium">{{ $errors->first('selection') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Selection Summary & Confirm Button -->
                @if($selectedDate && $selectedTime)
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 p-6 border-t border-neutral-200 dark:border-white/10">
                        <div class="flex flex-wrap items-center gap-2 text-2xl lg:text-3xl text-neutral-900 dark:text-white font-semibold">
                            @svg('phosphor-calendar-check', 'size-7 text-green-500')
                            <span>{{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}</span>
                            <span>{{ \Carbon\Carbon::createFromFormat('H:i', $selectedTime)->format('g:i A') }}</span>
                        </div>
                        <button wire:click="confirmSelection" class="inline-flex items-center justify-center gap-2 px-6 lg:px-8 py-3 bg-neutral-800 text-white rounded-full hover:bg-neutral-900 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <span>Confirm</span>
                            @svg('phosphor-arrow-right-light', 'size-6')
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Section: Appointment Progress -->
    <div class="col-span-1">
        @livewire('appointments.appointment-progress', ['appointment' => $appointment], key('progress-' . $appointment->id))
    </div>
</div>