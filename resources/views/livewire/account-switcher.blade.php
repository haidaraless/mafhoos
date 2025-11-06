<div>
    <flux:dropdown position="bottom" align="start">
        <flux:button variant="ghost" class="h-10 px-2">
            <span class="truncate max-w-48">
                {{ collect($accounts)->firstWhere('id', $currentAccountId)['label'] ?? __('Account') }}
            </span>
        </flux:button>

        <flux:menu>
            @foreach ($accounts as $account)
                <flux:menu.item wire:click="switch('{{ $account['id'] }}')" :current="$currentAccountId === $account['id']">
                    <span class="truncate">{{ $account['label'] }}</span>
                </flux:menu.item>
            @endforeach
        </flux:menu>
    </flux:dropdown>
</div>


