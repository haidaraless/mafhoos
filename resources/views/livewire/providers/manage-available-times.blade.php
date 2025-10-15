<div>
    <div class="space-y-4">
        <div class="flex items-end gap-2">
            <div>
                <label class="block text-sm font-medium">Day</label>
                <select wire:model="newDay" class="mt-1 block w-40 border rounded px-2 py-1">
                    <option value="">--</option>
                    @foreach($days as $day)
                        <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                    @endforeach
                </select>
                @error('newDay')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Time</label>
                <select wire:model="newTime" class="mt-1 block w-32 border rounded px-2 py-1">
                    <option value="">--</option>
                    @foreach($times as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach
                </select>
                @error('newTime')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button wire:click="addSlot" type="button" class="inline-flex items-center h-9 px-3 rounded bg-blue-600 text-white">Add</button>
        </div>

        <div class="border rounded divide-y">
            @forelse($slots as $index => $slot)
                <div class="flex items-center gap-2 p-2">
                    <div>
                        <select wire:model="slots.{{ $index }}.day" class="w-40 border rounded px-2 py-1">
                            @foreach($days as $day)
                                <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                            @endforeach
                        </select>
                        @error('slots.' . $index . '.day')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <select wire:model="slots.{{ $index }}.time" class="w-32 border rounded px-2 py-1">
                            @foreach($times as $time)
                                <option value="{{ $time }}">{{ $time }}</option>
                            @endforeach
                        </select>
                        @error('slots.' . $index . '.time')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ml-auto flex items-center gap-2">
                        <button wire:click="updateSlot({{ $index }})" type="button" class="h-8 px-3 rounded bg-green-600 text-white">Save</button>
                        <button wire:click="deleteSlot({{ $index }})" type="button" class="h-8 px-3 rounded bg-red-600 text-white">Delete</button>
                    </div>
                </div>
            @empty
                <div class="p-3 text-sm text-gray-600">No available times yet.</div>
            @endforelse
        </div>
    </div>
</div>


