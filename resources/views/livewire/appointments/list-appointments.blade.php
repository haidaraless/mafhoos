<div>
    <div class="flex w-full flex-col gap-4">
        <div class="col-span-1 flex items-center justify-between">
            <span class="text-3xl font-medium">My Appointments</span>
        </div>

        @if($appointments->count() > 0)
            <div class="grid gap-4">
                @foreach($appointments as $appointment)
                    <div class="h-full rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-4">
                                    <flux:badge 
                                        variant="{{ match($appointment->status->value) {
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'cancelled' => 'danger',
                                            'completed' => 'success',
                                            default => 'neutral'
                                        } }}"
                                    >
                                        {{ ucfirst($appointment->status->value) }}
                                    </flux:badge>
                                    @if($appointment->inspection_type)
                                        <flux:badge variant="outline">
                                            {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}
                                        </flux:badge>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                        Appointment #{{ $appointment->id }}
                                    </h3>
                                    
                                    @if($appointment->vehicle)
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                            Vehicle: {{ $appointment->vehicle->make }} {{ $appointment->vehicle->model }} 
                                            ({{ $appointment->vehicle->year }})
                                        </p>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                            Scheduled Date
                                        </p>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $appointment->scheduled_at?->format('M j, Y g:i A') ?? 'Not scheduled' }}
                                        </p>
                                    </div>

                                    @if($appointment->confirmed_at)
                                        <div>
                                            <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Confirmed At
                                            </p>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ $appointment->confirmed_at->format('M j, Y g:i A') }}
                                            </p>
                                        </div>
                                    @endif

                                    @if($appointment->completed_at)
                                        <div>
                                            <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Completed At
                                            </p>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ $appointment->completed_at->format('M j, Y g:i A') }}
                                            </p>
                                        </div>
                                    @endif

                                    @if($appointment->cancelled_at)
                                        <div>
                                            <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Cancelled At
                                            </p>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ $appointment->cancelled_at->format('M j, Y g:i A') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                @if($appointment->fees->count() > 0)
                                    <div>
                                        <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                            Fees
                                        </p>
                                        <div class="space-y-1">
                                            @foreach($appointment->fees as $fee)
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-600 dark:text-zinc-400">
                                                        {{ $fee->description }}
                                                    </span>
                                                    <span class="font-medium text-zinc-900 dark:text-zinc-100">
                                                        SAR {{ number_format($fee->amount, 2) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <flux:callout icon="calendar" heading="{{ __('No appointments found') }}" subtitle="{{ __('You don\'t have any appointments yet. When customers book appointments with you, they will appear here.') }}" />
        @endif
    </div>
</div>
