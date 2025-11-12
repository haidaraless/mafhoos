<div class="bg-white dark:bg-neutral-900 overflow-hidden">
    <div class="flex flex-wrap items-center justify-between gap-4 p-6 border-b border-neutral-900 dark:border-neutral-700">
        <div class="space-y-1">
            <span class="text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">Time Slots</span>
            <div class="flex items-center gap-3">
                @svg('phosphor-clock-user', 'size-7 text-blue-500')
                <span class="text-2xl font-semibold text-neutral-900 dark:text-white">
                    {{ ucfirst($day) }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2 text-sm text-neutral-500 dark:text-white/60">
            @svg('phosphor-toggle-left', 'size-5 text-neutral-400 dark:text-white/50')
            <span>{{ __('Tap a slot to toggle availability') }}</span>
        </div>
    </div>

    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
            @foreach($times as $time)
                <livewire:providers.available-time-toggle :$provider :$day :$time :key="'time-'.$day.'-'.$time" />
            @endforeach
        </div>

        <p class="text-sm text-neutral-500 dark:text-white/50">
            Tip: Highlighted slots are visible to clients when booking this provider.
        </p>
    </div>
</div>