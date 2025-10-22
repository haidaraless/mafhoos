<div class="border rounded-lg p-4 {{ $isSelected ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} transition-colors duration-200">
    <div class="flex justify-between items-center mb-3">
        <div>
            <h3 class="font-semibold text-gray-900">{{ $displayDate->format('l, M j') }}</h3>
            <p class="text-sm text-gray-500">{{ $displayDate->format('Y') }}</p>
        </div>
        <div class="text-sm text-gray-500">
            @php
                $availableCount = count($availableTimes);
                $bookedCount = count($bookedTimes);
                $pastCount = 0;
                foreach($availableTimes as $time) {
                    if($this->isTimeInPast($time)) {
                        $pastCount++;
                    }
                }
                $actualAvailableCount = $availableCount - $pastCount;
            @endphp
            {{ $actualAvailableCount }} available, {{ $bookedCount }} booked{{ $pastCount > 0 ? ', ' . $pastCount . ' past' : '' }}
        </div>
    </div>

    @if(empty($availableTimes))
        <div class="text-center py-4 text-gray-400">
            <svg class="mx-auto h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-xs">No times available</p>
        </div>
    @else
        <div class="grid grid-cols-2 gap-2">
            @foreach($availableTimes as $time)
                @php
                    $isBooked = $this->isTimeBooked($time);
                    $isInPast = $this->isTimeInPast($time);
                    $isAvailable = $this->isTimeAvailable($time);
                @endphp
                
                @if($isBooked)
                    <div class="p-2 text-sm border rounded bg-red-50 border-red-200 text-red-600 cursor-not-allowed flex items-center justify-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-xs">{{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</span>
                    </div>
                @elseif($isInPast)
                    <div class="p-2 text-sm border rounded bg-gray-100 border-gray-300 text-gray-500 cursor-not-allowed flex items-center justify-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-xs">{{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</span>
                    </div>
                @else
                    <button 
                        wire:click="selectTime('{{ $time }}')"
                        class="p-2 text-sm border rounded transition-colors duration-200 {{ $selectedTime === $time ? 'border-blue-500 bg-blue-100 text-blue-700' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}"
                    >
                        {{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
                    </button>
                @endif
            @endforeach
        </div>
        
        @if($errors->has('time'))
            <div class="mt-2 text-xs text-red-600">
                {{ $errors->first('time') }}
            </div>
        @endif
    @endif
</div>
