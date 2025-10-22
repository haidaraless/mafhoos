<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Appointments Section -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">My Appointments</h2>
            </div>
            <livewire:dashboard-appointments />
        </div>

        <!-- Vehicles Section -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">My Vehicles</h2>
            </div>
            <livewire:vehicles.list-vehicles />
        </div>
    </div>
</x-layouts.app>
