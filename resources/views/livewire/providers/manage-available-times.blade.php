<div class="grid grid-cols-1 gap-6 content-start">
    <div class="col-span-1">
        <span class="text-3xl font-medium">Manage Available Times: {{ $provider->name }}</span>
    </div>
    <div class="col-span-1 grid grid-cols-1 gap-2">
        <label class="block text-xl font-medium">Select Day</label>
        <div class="grid grid-cols-2 md:grid-cols-7 gap-2">
            @foreach($days as $day)
                <label class="cursor-pointer">
                    <input type="radio" class="sr-only" name="newDay" value="{{ $day }}" wire:model.live="newDay">
                    <div class="flex items-center gap-2 rounded border p-3 transition {{ ($newDay === $day) ? 'border-blue-600 ring-2 ring-blue-200 bg-blue-50' : 'border-gray-300 hover:border-blue-400' }}">
                        <x-phosphor-calendar class="h-5 w-5 {{ ($newDay === $day)  ? 'text-blue-700' : 'text-gray-600' }}" />
                        <span class="text-lg font-medium capitalize">{{ $day }}</span>
                    </div>
                </label>
            @endforeach
        </div>
        @error('newDay')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>


    @if($newDay)
        <livewire:providers.available-time-of-day :$provider :day="$newDay" />
    @endif
</div>