<div class="flex flex-col gap-4">
    <h1>Create Vehicle</h1>
    <form wire:submit="store" class="grid gap-4">
        <flux:input type="text" wire:model="name" placeholder="Name"/>
        <flux:input type="text" wire:model="brand" placeholder="Brand"/>
        <flux:input type="text" wire:model="model" placeholder="Model"/>
        <flux:button type="submit">Create</flux:button>
    </form>
</div>
