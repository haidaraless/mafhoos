<div class="col-span-1">
    <label class="block text-xl font-medium capitalize">Select Time</label>
    <div class="mt-2 grid grid-cols-2 md:grid-cols-6 gap-2">
        @foreach($times as $time)
            <livewire:providers.available-time-toggle :$provider :$day :$time :key="'time-'.$day.'-'.$time" />
        @endforeach
    </div>
</div>