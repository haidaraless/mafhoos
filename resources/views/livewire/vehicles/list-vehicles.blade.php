<div class="flex w-full flex-col gap-4">
    @if($vehicles->isEmpty())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No Vehicles Found') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('You don\'t have any vehicles yet. Add your first vehicle to get started.') }}</p>
            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                {{ __('Create Vehicle') }}
            </a>
        </div>

    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($vehicles as $vehicle)
                <livewire:vehicles.vehicle-card :vehicle="$vehicle" :key="$vehicle->id" />
            @endforeach
        </div>

        <div>
            {{ $vehicles->links() }}
        </div>
    @endif
</div>


