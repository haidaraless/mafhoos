<div class="border border-neutral-300 dark:border-white/10 rounded-lg bg-white dark:bg-neutral-900">
    <flux:dropdown position="bottom" align="start">
        <flux:button variant="ghost" class="h-8">
            @php
                $currentAccount = collect($accounts)->firstWhere('id', $currentAccountId);
            @endphp
            @if ($currentAccount)
                <div class="flex items-center gap-2">
                    @svg($currentAccount['icon'], 'size-5 shrink-0 ' . $currentAccount['color'])
                    <span class="truncate max-w-48">
                        {{ $currentAccount['label'] }}
                    </span>
                </div>
            @else
                <span class="truncate max-w-48">
                    {{ __('Account') }}
                </span>
            @endif
        </flux:button>

        <flux:menu>
            @foreach ($accounts as $account)
                <flux:menu.item wire:click="switch('{{ $account['id'] }}')" :current="$currentAccountId === $account['id']">
                    <div class="flex items-center gap-2">
                        @svg($account['icon'], 'size-5 shrink-0 ' . $account['color'])
                        <span class="truncate">{{ $account['label'] }}</span>
                    </div>
                </flux:menu.item>
            @endforeach
        </flux:menu>
    </flux:dropdown>
</div>


