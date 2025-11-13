<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
    <!-- Vehicle Stat Card -->
    <div class="col-span-1 grid grid-cols-1 border-r border-neutral-900 dark:border-neutral-700">
        <div class="grid grid-cols-1 gap-6 border-b border-neutral-900 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between gap-6 text-neutral-800 dark:text-white">
                <div class="w-10">
                    @svg('phosphor-car', 'size-10 text-blue-500')
                </div>
                <span class="text-xl font-normal">{{ $vehicle->year }}</span>
            </div>
            <span class="text-3xl font-extrabold">{{ $vehicle->name }}</span>
            <div class="flex flex-col">
                <span>{{ $vehicle->vin }}</span>
                <span>{{ $vehicle->engine_model }}</span>
                <span>{{ $vehicle->fuel_type }}</span>
                <span>{{ $vehicle->drive_type }}</span>
                <span>{{ $vehicle->transmission_style }}</span>
                <span>{{ $vehicle->vehicle_type }}</span>
            </div>
            <div class="flex items-center justify-center gap-6 mt-6">
                <a href="{{  route('appointments.create') }}" class="flex items-center justify-center size-10 hover:scale-125 transition-all duration-300 border border-violet-500 dark:border-violet-500 text-violet-500 dark:text-white text-base font-medium font-montserrat rounded-full">
                    @svg('phosphor-calendar-plus-light', 'size-6')
                </a>
                <a href="" class="flex items-center justify-center size-10 hover:scale-125 transition-all duration-300 border border-fuchsia-500 dark:border-fuchsia-500 text-fuchsia-500 dark:text-white text-base font-medium font-montserrat rounded-full">
                    @svg('phosphor-calculator-light', 'size-6')
                </a>
                <a href="" class="flex items-center justify-center size-10 hover:scale-125 transition-all duration-300 border border-green-500 dark:border-green-500 text-green-500 dark:text-white text-base font-medium font-montserrat rounded-full">
                    @svg('phosphor-wrench-light', 'size-6')
                </a>
            </div>
        </div>
        <div class="flex flex-col gap-6 lg:gap-8 p-6">
            <div class="w-1 h-16 bg-neutral-950 dark:bg-white"></div>
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-extrabold font-montserrat text-neutral-950 dark:text-white">Don’t know where to start?</h2>
                <p class="text-base text-neutral-800">Register your vehicle to get started with inspections and quotation requests.</p>
            </div>
            <div class="flex w-full mt-20">
                <a href="{{ route('vehicles.create') }}"
                        class="inline-flex items-center justify-between w-full px-6 py-3 text-neutral-800 dark:text-white text-base font-medium font-montserrat border border-dashed border-neutral-800 dark:border-neutral-700 rounded-full">
                    <div class="flex items-center gap-2">
                        @svg('phosphor-car', 'size-5 text-orange-500')
                        <span>Create a Vehicle</span>
                    </div>
                    @svg('phosphor-arrow-right-light', 'size-6')
                </a>
            </div>
        </div>
    </div>
    <div class="col-span-3 grid grid-cols-1 gap-8 p-8">
        <div class="grid grid-cols-1 gap-4 content-start">
            <div class="col-span-1 flex items-center gap-2">
                @svg('phosphor-clock-user', 'size-8 text-blue-500')
                <span class="text-2xl">{{ __('Upcoming Appointments') }}</span>
            </div>
            <div class="grid grid-cols-1 content-start pl-10">
                @forelse ($upcomingAppointments as $appointment)
                    <div class="col-span-1 flex gap-4 border-b border-neutral-300 dark:border-neutral-700 pb-4">
                        <div class="flex flex-col text-neutral-900">
                            <span class="text-2xl font-extrabold">{{ $appointment->scheduled_at->format('H:i A') }}</span>
                            <span class="text-lg font-normal">{{ $appointment->scheduled_at->format('M d, Y') }}</span>
                        </div>
                        <div class="grid grid-cols-1">
                            <span>{{ $appointment->provider->name }}</span>
                            <span>{{ $appointment->vehicle->name }}</span>
                        </div>
                    </div>
                @empty
                    <div class="flex text-base text-neutral-500 dark:text-white/20">
                        <span>{{ __('_________ No upcoming inspections scheduled') }}</span>
                    </div>
                @endforelse
            </div>
        </div>
        <!-- Quotation Requests Section (modern cards) -->
        <div class="grid grid-cols-1 gap-2 content-start">
            <div class="col-span-1 flex items-center gap-2">
                @svg('phosphor-calculator', 'size-8 text-fuchsia-500')
                <span class="text-2xl">{{ __('Quotation Requests') }}</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($quotationRequests as $request)
                    <div
                        class="group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 flex flex-col justify-between bg-white dark:bg-white/5 transition-all hover:-translate-y-0.5">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex items-center gap-3">
                                @if ($request->type->value === 'spare-parts')
                                    <span class="inline-flex items-center justify-center size-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                                        @svg('phosphor-calculator', 'size-6')
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center size-10 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                                        @svg('phosphor-wrench', 'size-6')
                                    </span>
                                @endif
                            </div>

                            <span
                                class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold
                                @if ($request->status->value === 'open') bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300
                                @elseif($request->status->value === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300
                                @elseif($request->status->value === 'quoted') bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300
                                @elseif($request->status->value === 'cancelled') bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300
                                @else bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white @endif">
                                {{ ucfirst($request->status->value) }}
                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="text-xl md:text-2xl font-extrabold text-neutral-800 dark:text-white tracking-tight">
                                {{ ucfirst(str_replace('-', ' ', $request->type->value)) }} Quotation
                            </div>

                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                                @svg('phosphor-car', 'size-4 text-sky-500')
                                <span>{{ $request->inspection->appointment->vehicle->make ?? '-' }} {{ $request->inspection->appointment->vehicle->model ?? '' }}</span>
                            </div>

                            <div class="flex items-center gap-2 text-xs text-neutral-600 dark:text-white/70">
                                @svg('phosphor-calendar-dots', 'size-4 text-violet-500')
                                <span>Requested {{ $request->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-6 flex">
                            <a href="{{ route('quotation-requests.view', $request->id) }}"
                                class="inline-flex items-center justify-between gap-16 w-full px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full">
                                <div class="flex items-center gap-2">
                                    @svg('phosphor-file-text', 'size-5 text-indigo-600')
                                    <span>View Details</span>
                                </div>
                                @svg('phosphor-arrow-right-light', 'size-6')
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="flex text-base text-neutral-500 dark:text-white/20">
                        <span>{{ __('_________ No quotation requests yet') }}</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
