<div class="p-4 sm:p-6 bg-white dark:bg-neutral-900 border border-transparent dark:border-white/5 rounded-2xl">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
        <div>
            <h3 class="text-2xl font-normal font-montserrat text-neutral-900 dark:text-white">{{ $displayDate->format('l, M j') }}</h3>
            <p class="text-sm text-neutral-500 dark:text-white/60">{{ $displayDate->format('Y') }}</p>
        </div>
        <div class="text-sm text-neutral-500 dark:text-white/60">
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
    <div class="flex text-base text-neutral-500 dark:text-white/40">
        <span>{{ __('_________ No times available') }}</span>
    </div>
    @else
        <div class="flex flex-wrap gap-2">
            @foreach($availableTimes as $time)
                @php
                    $isBooked = $this->isTimeBooked($time);
                    $isInPast = $this->isTimeInPast($time);
                    $isAvailable = $this->isTimeAvailable($time);
                @endphp
                
                @if($isBooked)
                    <div class="p-2 text-sm border bg-red-50 dark:bg-red-500/10 border-red-200 dark:border-red-500/30 text-red-600 dark:text-red-300 cursor-not-allowed flex items-center justify-center rounded-lg">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-xs">{{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</span>
                    </div>
                @elseif($isInPast)
                    <div class="p-2 text-sm border bg-gray-100 dark:bg-white/5 border-gray-300 dark:border-white/10 text-gray-500 dark:text-white/50 cursor-not-allowed flex items-center justify-center rounded-lg">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-xs">{{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</span>
                    </div>
                @else
                    <button 
                        wire:click="selectTime('{{ $time }}')"
                        class="p-2 text-sm border rounded-lg transition-colors duration-200 {{ $selectedTime === $time ? 'border-blue-500 bg-blue-100 dark:bg-blue-500/10 text-blue-700 dark:text-blue-300' : 'border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 hover:bg-gray-50 dark:hover:bg-white/5 text-neutral-700 dark:text-white' }}"
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
