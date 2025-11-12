<div class="grid grid-cols-1 lg:grid-cols-4 content-start">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-neutral-900 border-r border-neutral-900 dark:border-neutral-700 overflow-hidden">
            <div class="flex items-center justify-between gap-3 p-6 border-b border-neutral-900 dark:border-neutral-700">
                <div class="space-y-1">
                    <span class="text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">Availability</span>
                    <div class="flex items-center gap-2">
                        @svg('phosphor-calendar-dots', 'size-7 text-violet-600')
                        <span class="text-2xl font-semibold text-neutral-900 dark:text-white">Manage Times</span>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <span class="text-base font-medium text-neutral-800 dark:text-white/60">Provider</span>
                    <div class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-white">
                        {{ $provider->name }}
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-base font-medium text-neutral-800 dark:text-white/80">Select Day</label>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($days as $day)
                            <label class="cursor-pointer">
                                <input
                                    type="radio"
                                    class="sr-only"
                                    name="newDay"
                                    value="{{ $day }}"
                                    wire:model.live="newDay"
                                >

                                <div class="flex items-center justify-between gap-3 rounded-2xl border px-4 py-3 transition-all focus-within:ring-2 focus-within:ring-orange-300
                                    {{ ($newDay === $day)
                                        ? 'border-orange-400 bg-orange-50 text-orange-900 dark:border-orange-400/60 dark:bg-orange-500/10 dark:text-orange-200 ring-2 ring-orange-200 dark:ring-orange-500/40'
                                        : 'border-neutral-200 dark:border-neutral-700 hover:border-orange-300 hover:bg-neutral-50 dark:hover:bg-white/5'
                                    }}">
                                    <div class="flex items-center gap-3">
                                        @svg('phosphor-calendar-check', ($newDay === $day) ? 'size-6 text-orange-500' : 'size-6 text-neutral-500 dark:text-white/60')
                                        <span class="text-base font-semibold capitalize {{ ($newDay === $day) ? 'text-orange-900 dark:text-orange-100' : 'text-neutral-900 dark:text-white' }}">
                                            {{ $day }}
                                        </span>
                                    </div>

                                    <span class="text-xs font-medium uppercase tracking-wide {{ ($newDay === $day) ? 'text-orange-600 dark:text-orange-200' : 'text-neutral-400 dark:text-white/40' }}">
                                        {{ ($newDay === $day) ? __('Selected') : __('Choose') }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('newDay')
                        <div class="text-sm text-red-600 dark:text-red-300">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <p class="hidden lg:block px-6 text-sm text-neutral-500 dark:text-white/60">
            Toggle days to load the matching time slots. Use the cards on the right to activate or disable availability.
        </p>
    </div>

    <div class="lg:col-span-3 space-y-6">
        @if($newDay)
            <livewire:providers.available-time-of-day :$provider :day="$newDay" />
        @else
            <div class="bg-white dark:bg-neutral-900 p-12 text-center">
                <div class="flex flex-col items-center gap-3">
                    @svg('phosphor-calendar-star', 'size-10 text-violet-500')
                    <div class="space-y-1">
                        <p class="text-lg font-semibold text-neutral-900 dark:text-white">Choose a day to get started</p>
                        <p class="text-sm text-neutral-500 dark:text-white/60">Your available time slots will appear here once a day is selected.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>