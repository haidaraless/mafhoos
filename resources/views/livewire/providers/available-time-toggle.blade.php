<button type="button" wire:click="toggle" class="w-full text-left">
    <div class="flex items-center gap-2 rounded border p-3 transition {{ $isSelected ? 'border-blue-600 ring-2 ring-blue-200 bg-blue-50' : 'border-gray-300 hover:border-blue-400' }}">
        <x-phosphor-clock class="h-5 w-5 {{ $isSelected ? 'text-blue-700' : 'text-gray-600' }}" />
        <span class="text-lg font-semibold">{{ $time }}</span>
    </div>
    <input type="checkbox" class="sr-only" aria-hidden="true" {{ $isSelected ? 'checked' : '' }}>
</button>


