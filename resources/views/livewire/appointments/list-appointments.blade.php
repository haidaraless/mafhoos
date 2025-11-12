<div class="flex h-full">
    <!-- Left Section: Calendar and Statistics -->
    <div class="w-96 border-r border-neutral-200 dark:border-neutral-700 flex flex-col">
        <!-- Calendar Section -->
        <div class="p-8 border-b border-neutral-200 dark:border-neutral-700">
            <!-- Month Navigation -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-2">
                    @svg('phosphor-calendar-dots', 'size-8 text-violet-600')
                    <span class="text-2xl dark:text-white">{{ $this->getMonthName() }}</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <button 
                        wire:click="previousMonth"
                        class="p-1 hover:bg-neutral-100 dark:hover:bg-white/10 rounded transition-colors"
                    >
                        @svg('phosphor-caret-left', 'size-4 text-neutral-600 dark:text-white/70')
                    </button>
                    <button 
                        wire:click="nextMonth"
                        class="p-1 hover:bg-neutral-100 dark:hover:bg-white/10 rounded transition-colors"
                    >
                        @svg('phosphor-caret-right', 'size-4 text-neutral-600 dark:text-white/70')
                    </button>
                </div>
            </div>

            <!-- Day Headers -->
            <div class="grid grid-cols-7 gap-1 mb-2">
                @foreach(['S', 'S', 'M', 'T', 'W', 'T', 'F'] as $day)
                    <div class="text-center text-lg font-semibold text-neutral-900 dark:text-white/70 py-1">
                        {{ $day }}
                    </div>
                @endforeach
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7 gap-1">
                @foreach($this->getCalendarDays() as $day)
                    <button
                        wire:click="selectDate('{{ $day['date'] }}')"
                        class="aspect-square flex items-center justify-center text-lg rounded transition-colors
                            {{ $day['isSelected'] ? 'bg-orange-500 text-white font-semibold' : '' }}
                            {{ !$day['isSelected'] && $day['isCurrentMonth'] ? 'text-neutral-800 dark:text-white hover:bg-neutral-100 dark:hover:bg-white/10' : '' }}
                            {{ !$day['isCurrentMonth'] ? 'text-neutral-400 dark:text-white/30' : '' }}
                        "
                    >
                        {{ $day['day'] }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 p-8">
            <div class="col-span-1 flex items-center gap-2">
                @svg('phosphor-chart-bar', 'size-8 text-sky-500')
                <h3 class="text-2xl dark:text-white">Statistics</h3>
            </div>
            
            <!-- Statistics content can be added here -->
        </div>
    </div>

    <!-- Right Section: Daily Schedule Timeline -->
    <div class="flex-1 overflow-y-auto">
        <div class="col-span-1 flex items-center gap-2 p-8">
            @svg('phosphor-clock-user', 'size-8 text-blue-500')
            <span class="text-2xl">{{ __('List of Appointments') }}</span>
        </div>
        <div class="relative">
            <!-- Timeline -->
            <div class="relative">
                @php
                    $hours = [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21];
                @endphp

                @foreach($hours as $hour)
                    <div class="relative flex gap-6 px-8 min-h-16 border-b border-neutral-200 dark:border-neutral-700 last:border-b-0">
                        <!-- Time Label with line -->
                        <div class="w-20 flex-shrink-0 relative pt-2 text-neutral-900 dark:text-white/70 font-normal">
                            <span class="text-4xl">
                                @php
                                    $displayHour = $hour;
                                    $ampm = 'AM';
                                    if ($hour == 0) {
                                        $displayHour = 12;
                                    } elseif ($hour == 12) {
                                        $ampm = 'PM';
                                    } elseif ($hour > 12) {
                                        $displayHour = $hour - 12;
                                        $ampm = 'PM';
                                    }
                                    echo str_pad($displayHour, 2, '0', STR_PAD_LEFT);
                                @endphp
                            </span>
                            <span class="-ml-2 text-xs">
                                {{ $ampm }}
                            </span>
                            <!-- Horizontal line extending from time -->
                            {{-- <div class="absolute left-20 top-4 w-full h-px bg-neutral-200 dark:bg-neutral-700"></div> --}}
                        </div>

                        <!-- Appointments for this hour -->
                        <div class="flex-1 pt-2 pb-4">
                            @php
                                $appointmentsForHour = $this->getAppointmentsForTime($hour);
                            @endphp

                            @if($appointmentsForHour->count() > 0)
                                @foreach($appointmentsForHour as $appointment)
                                    <div class="mb-3 p-3 bg-white dark:bg-white/5">
                                        <!-- ID and Status -->
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-mono text-neutral-600 dark:text-white/70">
                                                {{ $appointment->id }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                {{ $appointment->status->value === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300' : '' }}
                                                {{ $appointment->status->value === 'confirmed' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300' : '' }}
                                                {{ $appointment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-300' : '' }}
                                                {{ $appointment->status->value === 'cancelled' ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300' : '' }}
                                            ">
                                                {{ ucfirst($appointment->status->value) }}
                                            </span>
                                        </div>

                                        <!-- Vehicle -->
                                        <div class="mb-1">
                                            <span class="text-sm font-medium text-neutral-800 dark:text-white">
                                                {{ $appointment->vehicle->name ?? 'N/A' }}
                                            </span>
                                        </div>

                                        <!-- Person -->
                                        @if($appointment->vehicle && $appointment->vehicle->user)
                                            <div class="mb-1">
                                                <span class="text-sm text-neutral-600 dark:text-white/70">
                                                    {{ $appointment->vehicle->user->name }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Service -->
                                        @if($appointment->inspection_type)
                                            <div>
                                                <span class="text-sm text-neutral-600 dark:text-white/70">
                                                    {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }} Inspection
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
