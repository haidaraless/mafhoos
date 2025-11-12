<div class="grid grid-cols-4 gap-2 content-start">
    <div class="col-span-1 grid grid-cols-1 border-r border-neutral-900 dark:border-neutral-700">
        <!-- Statistics Section -->
        <div class="grid grid-cols-1 gap-6 border-b border-neutral-900 dark:border-neutral-700 p-6">
            <!-- Total Fees Earned -->
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-neutral-600 dark:text-white/70">Total Fees Earned</span>
                    <span class="inline-flex items-center justify-center size-8 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                        @svg('phosphor-wallet', 'size-5')
                    </span>
                </div>
                <span class="text-3xl font-extrabold text-neutral-800 dark:text-white">
                    {{ number_format($this->totalFeesEarned, 2) }} SAR
                </span>
            </div>

            <!-- Appointments by Status Chart -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-neutral-800 dark:text-white">Appointments by Status</span>
                    <span class="inline-flex items-center justify-center size-8 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-300">
                        @svg('phosphor-chart-pie', 'size-5')
                    </span>
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
        </div>

        <!-- Time-based Statistics -->
        <div class="flex flex-col gap-6 lg:gap-8 p-6 bg-neutral-50 dark:bg-white/5">
            <div class="w-1 h-16 bg-neutral-950 dark:bg-white"></div>
            <div class="flex flex-col gap-2">
                <h2 class="text-2xl font-extrabold font-montserrat text-neutral-950 dark:text-white">Appointment Statistics</h2>
                <p class="text-sm text-neutral-600 dark:text-white/70">Track your appointment activity over time</p>
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                <!-- Today -->
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 hover:shadow-md transition-shadow duration-200">
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
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 hover:shadow-md transition-shadow duration-200">
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
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 hover:shadow-md transition-shadow duration-200">
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
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 hover:shadow-md transition-shadow duration-200">
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
    <div class="col-span-3 grid grid-cols-1 content-start p-8">
        <div class="col-span-1 flex items-center gap-2">
            @svg('phosphor-clock-user', 'size-8 text-blue-500')
            <span class="text-2xl">{{ __('Upcoming Appointments') }}</span>
        </div>
        @forelse($inspectionAppointments as $appointment)
            <div class="group relative overflow-hidden flex flex-col justify-between bg-white dark:bg-white/5 transition-all hover:-translate-y-0.5">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-300">
                            @svg('phosphor-car', 'size-6')
                        </span>
                    </div>

                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{ 
                        $appointment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300' : 
                        ($appointment->status->value === 'confirmed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300' : 
                        ($appointment->status->value === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300')) 
                    }}">
                        {{ ucfirst($appointment->status->value) }}
                    </span>
                </div>

                <div class="space-y-3">
                    <div class="text-xl md:text-2xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                        {{ $appointment->vehicle->name }}
                    </div>
                    
                    <div class="text-sm text-neutral-500 dark:text-white/60">
                        #{{ $appointment->id }}
                    </div>

                    <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                        @svg('phosphor-user', 'size-4 text-sky-500')
                        <span>{{ $appointment->vehicle->user->name }}</span>
                    </div>

                    @if($appointment->scheduled_at)
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                            @svg('phosphor-calendar-dots', 'size-4 text-violet-500')
                            <span>{{ $appointment->scheduled_at->format('M d, Y') }} at {{ $appointment->scheduled_at->format('g:i A') }}</span>
                        </div>
                    @endif

                    @if($appointment->inspection_type)
                        <div class="pt-2">
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">
                                {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex flex-col gap-2">
                    @if($appointment->status->value === 'pending')
                        <button 
                            wire:click="confirmAppointment('{{ $appointment->id }}')"
                            wire:confirm="Are you sure you want to confirm this appointment?"
                            class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-green-600 text-white text-base font-medium font-montserrat rounded-full hover:bg-green-700 transition-colors duration-200"
                        >
                            @svg('phosphor-check', 'size-5')
                            <span>Confirm</span>
                        </button>
                    @elseif($appointment->status->value === 'confirmed')
                        <button 
                            wire:click="startInspection('{{ $appointment->id }}')"
                            class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-blue-600 text-white text-base font-medium font-montserrat rounded-full hover:bg-blue-700 transition-colors duration-200">
                            @svg('phosphor-play', 'size-5')
                            <span>Start Inspection</span>
                        </button>
                    @endif
                    
                    @if(in_array($appointment->status->value, ['pending', 'confirmed']))
                        <button 
                            wire:click="cancelAppointment('{{ $appointment->id }}')"
                            wire:confirm="Are you sure you want to cancel this appointment?"
                            class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 border border-red-300 dark:border-red-500/20 text-red-700 dark:text-red-300 text-base font-medium font-montserrat rounded-full hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors duration-200"
                        >
                            @svg('phosphor-x', 'size-5')
                            <span>Cancel</span>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="flex text-base text-neutral-500 dark:text-white/20">
                <span>{{ __('_________ No upcoming appointments') }}</span>
            </div>
        @endforelse

    </div>
</div>