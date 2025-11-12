<div class="grid grid-cols-4 content-start">
    <div class="col-span-1 grid grid-cols-1 border-r border-neutral-900 dark:border-neutral-700">
        <!-- Statistics Section -->
        <div class="grid grid-cols-1 gap-8 content-start p-8">
            <!-- Total Fees Earned -->
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-2xl">{{ __('Total Fees Earned') }}</span>
                    @svg('phosphor-wallet', 'size-8 text-green-500')
                </div>
                <span class="text-3xl font-extrabold text-neutral-800 dark:text-white">
                    {{ number_format($this->totalFeesEarned, 2) }} SAR
                </span>
            </div>
            <!-- Appointments by Status Chart -->
            <div class="grid grid-cols-1 gap-4">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-2xl">{{ __('Statistics') }}</span>
                    @svg('phosphor-chart-pie', 'size-8 text-blue-500')
                </div>  
                <div class="space-y-3">
                    @php
                        $statusCounts = $this->appointmentsByStatus;
                        $total = array_sum($statusCounts);
                    @endphp
                    @foreach(['pending' => 'yellow', 'confirmed' => 'blue', 'completed' => 'green', 'cancelled' => 'red'] as $status => $color)
                        @php
                            $count = $statusCounts[$status] ?? 0;
                            $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        @endphp
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-neutral-600 dark:text-white/70 capitalize">{{ $status }}</span>
                                <span class="font-semibold text-neutral-800 dark:text-white">{{ $count }}</span>
                            </div>
                            <div class="w-full h-2 bg-neutral-200 dark:bg-white/10 rounded-full overflow-hidden">
                                <div 
                                    class="h-full rounded-full transition-all duration-500 {{ 
                                        $color === 'yellow' ? 'bg-yellow-500' : 
                                        ($color === 'blue' ? 'bg-blue-500' : 
                                        ($color === 'green' ? 'bg-green-500' : 'bg-red-500')) 
                                    }}"
                                    style="width: {{ $percentage }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <!-- Today -->
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-300">
                            @svg('phosphor-calendar-check', 'size-5')
                        </span>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-600 dark:text-white/70">Today</span>
                            <span class="text-xl font-extrabold text-neutral-800 dark:text-white">{{ $this->todayAppointments }}</span>
                        </div>
                    </div>
                </div>
    
                <!-- Yesterday -->
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-300">
                            @svg('phosphor-calendar', 'size-5')
                        </span>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-600 dark:text-white/70">Yesterday</span>
                            <span class="text-xl font-extrabold text-neutral-800 dark:text-white">{{ $this->yesterdayAppointments }}</span>
                        </div>
                    </div>
                </div>
    
                <!-- This Week -->
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                            @svg('phosphor-calendar-dots', 'size-5')
                        </span>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-600 dark:text-white/70">This Week</span>
                            <span class="text-xl font-extrabold text-neutral-800 dark:text-white">{{ $this->thisWeekAppointments }}</span>
                        </div>
                    </div>
                </div>
    
                <!-- This Month -->
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                            @svg('phosphor-calendar-blank', 'size-5')
                        </span>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-600 dark:text-white/70">This Month</span>
                            <span class="text-xl font-extrabold text-neutral-800 dark:text-white">{{ $this->thisMonthAppointments }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-3 grid grid-cols-1 content-start">
        <div class="col-span-1 flex items-center justify-between gap-2 p-8">
            <span class="text-2xl">{{ __('Upcoming Appointments') }}</span>
            @svg('phosphor-clock-user', 'size-8 text-blue-500')
        </div>
        @php
            $hours = [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21];
        @endphp
        @foreach($hours as $hour)
            @php
                $appointmentsForHour = $inspectionAppointments
                    ->filter(fn($appointment) => $appointment->scheduled_at && $appointment->scheduled_at->format('H') === sprintf('%02d', $hour))
                    ->sortBy(fn($appointment) => $appointment->scheduled_at)
                    ->values();
                $time = \Carbon\Carbon::createFromTime($hour);
            @endphp
            <div class="col-span-1 flex gap-6 items-center px-4 lg:px-8 min-h-16 border-b border-neutral-200 dark:border-neutral-700 last:border-b-0">
                <div class="w-20 flex-shrink-0 relative text-neutral-900 dark:text-white/70 font-normal">
                    <span class="text-4xl leading-none">
                        {{ $time->format('h') }}
                    </span>
                    <span class="-ml-2 text-xs uppercase tracking-wide">
                        {{ $time->format('A') }}
                    </span>
                </div>
                <div class="flex-1 space-y-4">
                    @foreach($appointmentsForHour as $appointment)
                        <div class="group relative overflow-hidden flex flex-col gap-4 rounded-xl bg-white dark:bg-white/5 border border-neutral-200/60 dark:border-white/10 px-6 py-5 transition-all hover:border-blue-300 dark:hover:border-blue-500/40">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center size-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-300">
                                        @svg('phosphor-car', 'size-6')
                                    </span>
                                    <div class="flex flex-col gap-1">
                                        <span class="text-lg font-semibold text-neutral-800 dark:text-white">
                                            {{ $appointment->vehicle->name ?? __('Unknown Vehicle') }}
                                        </span>
                                        <span class="text-xs text-neutral-500 dark:text-white/60 font-mono">
                                            #{{ $appointment->number }}
                                        </span>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{
                                    $appointment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300' :
                                    ($appointment->status->value === 'confirmed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300' :
                                    ($appointment->status->value === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300'))
                                }}">
                                    {{ ucfirst($appointment->status->value) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 gap-2 text-sm text-neutral-600 dark:text-white/70">
                                @if($appointment->vehicle && $appointment->vehicle->user)
                                    <div class="flex items-center gap-2">
                                        @svg('phosphor-user', 'size-4 text-sky-500')
                                        <span>{{ $appointment->vehicle->user->name }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center gap-2">
                                    @svg('phosphor-calendar-dots', 'size-4 text-violet-500')
                                    <span>
                                        {{ optional($appointment->scheduled_at)->format('M d, Y') }}
                                        @if($appointment->scheduled_at)
                                            <span class="text-neutral-500 dark:text-white/40">•</span>
                                            {{ $appointment->scheduled_at->format('g:i A') }}
                                        @endif
                                    </span>
                                </div>

                                @if($appointment->inspection_type)
                                    <div class="flex items-center gap-2">
                                        @svg('phosphor-car', 'size-4 text-blue-500')
                                        <span>{{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }} Inspection</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col gap-2 pt-2">
                                @if($appointment->status->value === 'pending')
                                    <button 
                                        wire:click="confirmAppointment('{{ $appointment->id }}')"
                                        wire:confirm="Are you sure you want to confirm this appointment?"
                                        class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-green-600 text-white text-sm font-medium font-montserrat rounded-full hover:bg-green-700 transition-colors duration-200"
                                    >
                                        @svg('phosphor-check', 'size-5')
                                        <span>Confirm</span>
                                    </button>
                                @elseif($appointment->status->value === 'confirmed')
                                    <button 
                                        wire:click="startInspection('{{ $appointment->id }}')"
                                        class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-blue-600 text-white text-sm font-medium font-montserrat rounded-full hover:bg-blue-700 transition-colors duration-200"
                                    >
                                        @svg('phosphor-play', 'size-5')
                                        <span>Start Inspection</span>
                                    </button>
                                @endif

                                @if(in_array($appointment->status->value, ['pending', 'confirmed']))
                                    <button 
                                        wire:click="cancelAppointment('{{ $appointment->id }}')"
                                        wire:confirm="Are you sure you want to cancel this appointment?"
                                        class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 border border-red-300 dark:border-red-500/20 text-red-700 dark:text-red-300 text-sm font-medium font-montserrat rounded-full hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors duration-200"
                                    >
                                        @svg('phosphor-x', 'size-5')
                                        <span>Cancel</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>