<button
    type="button"
    wire:click="toggle"
    class="group w-full text-left focus:outline-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-orange-400 focus-visible:ring-offset-white dark:focus-visible:ring-offset-neutral-900"
    aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
>
    <div class="flex items-center justify-between gap-3 rounded-2xl border px-4 py-3 transition-all
        {{ $isSelected
            ? 'border-orange-400 bg-orange-50 text-orange-900 shadow-sm dark:border-orange-400/60 dark:bg-orange-500/10 dark:text-orange-100 ring-2 ring-orange-200 dark:ring-orange-500/40'
            : 'border-neutral-200 dark:border-neutral-700 hover:border-orange-300 hover:bg-neutral-50 dark:hover:bg-white/5'
        }}">
        <div class="flex items-center gap-3">
            @svg('phosphor-clock', $isSelected ? 'size-6 text-orange-500' : 'size-6 text-neutral-500 dark:text-white/60')
            <div class="flex flex-col">
                <span class="text-base font-semibold {{ $isSelected ? 'text-orange-900 dark:text-orange-100' : 'text-neutral-900 dark:text-white' }}">
                    {{ $time }}
                </span>
                <span class="text-xs font-medium uppercase tracking-wide {{ $isSelected ? 'text-orange-600 dark:text-orange-200' : 'text-neutral-400 dark:text-white/40' }}">
                    {{ $isSelected ? __('Available') : __('Disabled') }}
                </span>
            </div>
        </div>

        <div class="flex items-center">
            @if($isSelected)
                @svg('phosphor-check-circle', 'size-5 text-orange-500')
            @else
                @svg('phosphor-circle', 'size-5 text-neutral-300 dark:text-white/30 group-hover:text-orange-400')
            @endif
        </div>
    </div>

    <input type="checkbox" class="sr-only" aria-hidden="true" {{ $isSelected ? 'checked' : '' }}>
</button>