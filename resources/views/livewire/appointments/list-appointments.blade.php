<div class="grid grid-cols-4 content-start">
    <!-- Left Section: Calendar and Statistics -->
    <div class="col-span-1 grid grid-cols-1 content-start border-r border-neutral-900 dark:border-neutral-700">
        <!-- Calendar Section -->
        <div class="col-span-1 p-8 border-b border-neutral-900 dark:border-neutral-700">
            <!-- Month Navigation -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-2">
                    @svg('phosphor-calendar-dots', 'size-8 text-violet-600')
                    <span class="text-2xl dark:text-white">{{ $this->getMonthName() }}</span>
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
                        class="aspect-square flex items-center justify-center text-lg rounded-full transition-colors
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
        <div class="grid grid-cols-1 p-8 space-y-6">
            <div class="col-span-1 flex items-center justify-between gap-2">
                <span class="text-2xl dark:text-white">Statistics</span>
                @svg('phosphor-chart-bar', 'size-8 text-sky-500')
            </div>
            
            <!-- Selected Date Total -->
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                    @svg('phosphor-calendar-check', 'size-4')
                    <span>Selected Date</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-neutral-900 dark:text-white">{{ $this->getTotalForSelectedDate() }}</span>
                    <span class="text-sm text-neutral-500 dark:text-white/60">appointments</span>
                </div>
            </div>

            <!-- Status Breakdown -->
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                    @svg('phosphor-stack', 'size-4')
                    <span>Status Breakdown</span>
                </div>
                <div class="space-y-2">
                    <!-- Pending -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-yellow-50 dark:bg-yellow-500/10 border border-yellow-200 dark:border-yellow-500/20">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Pending</span>
                        </div>
                        <span class="text-lg font-bold text-yellow-700 dark:text-yellow-300">{{ $this->getStatusCount('pending') }}</span>
                    </div>

                    <!-- Confirmed -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Confirmed</span>
                        </div>
                        <span class="text-lg font-bold text-blue-700 dark:text-blue-300">{{ $this->getStatusCount('confirmed') }}</span>
                    </div>

                    <!-- Completed -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Completed</span>
                        </div>
                        <span class="text-lg font-bold text-green-700 dark:text-green-300">{{ $this->getStatusCount('completed') }}</span>
                    </div>

                    <!-- Cancelled -->
                    @if($this->getStatusCount('cancelled') > 0)
                    <div class="flex items-center justify-between p-2 rounded-lg bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Cancelled</span>
                        </div>
                        <span class="text-lg font-bold text-red-700 dark:text-red-300">{{ $this->getStatusCount('cancelled') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Peak Hour -->
            @if($this->getPeakHour())
            <div class="space-y-2 p-4 rounded-xl bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-500/10 dark:to-orange-500/5 border border-orange-200 dark:border-orange-500/20">
                <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-orange-700 dark:text-orange-300">
                    @svg('phosphor-trend-up', 'size-4')
                    <span>Peak Hour</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-orange-900 dark:text-orange-200">{{ $this->getPeakHour()['hour'] }}</span>
                    <span class="text-lg text-orange-700 dark:text-orange-300">{{ $this->getPeakHour()['ampm'] }}</span>
                    <span class="ml-auto text-sm text-orange-600 dark:text-orange-400">({{ $this->getPeakHour()['count'] }} {{ $this->getPeakHour()['count'] === 1 ? 'appointment' : 'appointments' }})</span>
                </div>
            </div>
            @endif

            <!-- Monthly Completion Rate -->
            <div class="space-y-2 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                        @svg('phosphor-gauge', 'size-4')
                        <span>Monthly Rate</span>
                    </div>
                    <span class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->getCompletionRate() }}%</span>
                </div>
                <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 overflow-hidden">
                    <div 
                        class="h-full bg-gradient-to-r from-green-500 to-emerald-500 transition-all duration-500"
                        style="width: {{ $this->getCompletionRate() }}%"
                    ></div>
                </div>
                <p class="text-xs text-neutral-500 dark:text-white/50">Completion rate for {{ $this->getMonthName() }}</p>
            </div>

            <!-- Today's Total -->
            @php
                $isToday = $selectedDate === now()->format('Y-m-d');
            @endphp
            @if($this->getTodayTotal() > 0 && !$isToday)
                <div class="space-y-2 p-3 rounded-lg bg-violet-50 dark:bg-violet-500/10 border border-violet-200 dark:border-violet-500/20">
                    <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-violet-700 dark:text-violet-300">
                        @svg('phosphor-calendar-star', 'size-4')
                        <span>Today</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-violet-900 dark:text-violet-200">{{ $this->getTodayTotal() }}</span>
                        <span class="text-sm text-violet-600 dark:text-violet-400">appointments scheduled</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Section: Daily Schedule Timeline -->
    <div class="col-span-3 grid grid-cols-1 overflow-y-auto">
        <div class="col-span-1 flex items-center justify-between gap-2 p-8">
            <span class="text-2xl">{{ __('List of Appointments') }}</span>
            @svg('phosphor-clock-user', 'size-8 text-blue-500')
        </div>
        @php
        $hours = [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21];
    @endphp

    @foreach($hours as $hour)
        <div class="col-span-1 flex items-center px-4 lg:px-8 min-h-16 border-b border-neutral-200 dark:border-neutral-700 last:border-b-0">
            <!-- Time Label with line -->
            <div class="w-20 flex-shrink-0 relative text-neutral-900 dark:text-white/70 font-normal">
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
            <div class="flex-1 grid grid-cols-1 gap-4 content-start">
                @php
                    $appointmentsForHour = $this->getAppointmentsForTime($hour);
                @endphp

                @if($appointmentsForHour->count() > 0)
                    @foreach($appointmentsForHour as $appointment)
                        <div class="grid grid-cols-5 gap-1 pl-4 items-center overflow-hidden bg-white dark:bg-white/5">
                            <div class="col-span-2 flex flex-col">
                                <span class="text-xl font-semibold text-neutral-800 dark:text-white">
                                    {{ $appointment->vehicle->name ?? __('Unknown Vehicle') }}
                                </span>
                                <span class="text-sm text-neutral-500 dark:text-white/60 font-mono">
                                    #{{ $appointment->number }}
                                </span>
                            </div>

                            <div class="col-span-2 flex flex-col">
                                @if($appointment->vehicle && $appointment->vehicle->user)
                                    <span class="text-xl font-semibold text-neutral-800 dark:text-white">{{ $appointment->vehicle->user->name }}</span>
                                @endif
                                @if($appointment->inspection_type)
                                    <span class="text-sm text-neutral-600 dark:text-white/70">{{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }} Inspection</span>
                                @endif
                            </div>

                            <div class="flex justify-end">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    {{ $appointment->status->value === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300' : '' }}
                                    {{ $appointment->status->value === 'confirmed' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300' : '' }}
                                    {{ $appointment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-300' : '' }}
                                    {{ $appointment->status->value === 'cancelled' ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300' : '' }}
                                ">
                                    {{ ucfirst($appointment->status->value) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
    </div>
</div>
