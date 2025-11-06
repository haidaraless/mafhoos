<div class="grid grid-cols-1 gap-6 lg:gap-8">
    {{-- <!-- Hero Banner/Header Section -->
    <div class="flex flex-col gap-2 bg-neutral-800 h-64 px-4 py-12 sm:px-6 md:p-16">
        <h1 class="w-96 text-5xl font-extrabold text-white">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="text-xl text-white font-normal">Get started with your vehicle inspections and quotations.</p>
    </div> --}}

    <!-- Quick Stats Cards Row -->
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4 lg:px-16 pt-6 lg:pt-8">
        <!-- Vehicle Stat Card -->
        <div class="grid grid-cols-1 gap-6 border border-neutral-300 dark:border-white/10 p-6 rounded-2xl">
            <div class="flex items-center gap-6 text-neutral-800 dark:text-white">
                @svg('phosphor-car', 'size-8 text-sky-500')
                <span class="text-2xl">{{ __('My Vehicles') }}</span>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-neutral-800 dark:text-white">{{ $vehicles->count() }}</p>
            </div>
        </div>
        <!-- Drafts Stat Card -->
        <div class="grid grid-cols-1 gap-6 border border-neutral-300 dark:border-white/10 p-6 rounded-2xl">
            <div class="flex items-center gap-6 text-neutral-800 dark:text-white">
                @svg('phosphor-clock', 'size-8 text-blue-500')
                <span class="text-2xl">{{ __('Draft Appointments') }}</span>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-neutral-800 dark:text-white">{{ $draftAppointments->count() }}</p>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 border border-neutral-300 dark:border-white/10 p-6 rounded-2xl">
            <div class="flex items-center gap-6 text-neutral-800 dark:text-white">
                @svg('phosphor-calendar-dots', 'size-8 text-violet-500')
                <span class="text-2xl">{{ __('Upcoming Appointments') }}</span>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-neutral-800 dark:text-white">{{ $upcomingAppointments->count() }}</p>
            </div>
        </div>
        <!-- Completed Stat Card -->
        <div class="grid grid-cols-1 gap-6 border border-neutral-300 dark:border-white/10 p-6 rounded-2xl">
            <div class="flex items-center gap-6 text-neutral-800 dark:text-white">
                @svg('phosphor-calendar-check', 'size-8 text-orange-500')
                <span class="text-2xl">{{ __('Completed Inspections') }}</span>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-neutral-800 dark:text-white">{{ $completedInspections->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Banner/Action Section: Add Vehicle and Action Buttons -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 px-4 lg:px-16">
        <!-- Main Banner Card -->
        <div
            class="md:col-span-3 flex flex-col gap-6 lg:gap-8 p-6 lg:p-8 bg-orange-200 rounded-2xl">
            <div class="flex flex-col">
                <h2 class="text-3xl font-extrabold font-montserrat text-orange-950 dark:text-white">Don’t know where to start?</h2>
                <p class="text-base text-orange-800">Register your vehicle to get started with inspections andquotation requests.</p>
            </div>
            <div class="flex">
                <a href="{{ route('vehicles.create') }}"
                        class="inline-flex items-center justify-between gap-16 px-6 py-3 bg-white text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full">
                    <div class="flex items-center gap-2">
                        @svg('phosphor-car', 'size-5 text-orange-500')
                        <span>Create a Vehicle</span>
                    </div>
                    @svg('phosphor-arrow-right-light', 'size-6')
                </a>
            </div>
        </div>
        <!-- Right-Aligned Buttons -->
        <div class="col-span-1 flex flex-col gap-4 justify-start">
            <a href="{{ route('appointments.create') }}"
                class="inline-flex items-center justify-between w-full px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full">
                <div class="flex items-center gap-2">
                    @svg('phosphor-calendar-plus', 'size-5 text-violet-500')
                    <span>Create Inspection Appointment</span>
                </div>
                @svg('phosphor-arrow-right-light', 'size-6')
            </a>
            <a href="{{ route('quotation-requests.browse') }}"
                class="inline-flex items-center justify-between w-full px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full">
                <div class="flex items-center gap-2">
                    @svg('phosphor-calculator', 'size-5 text-amber-500')
                    <span>Request a Spare Parts Quotation</span>
                </div>
                @svg('phosphor-arrow-right-light', 'size-6')
            </a>
            <a href="{{ route('quotation-requests.browse') }}"
                class="inline-flex items-center justify-between w-full px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full">
                <div class="flex items-center gap-2">
                    @svg('phosphor-wrench', 'size-5 text-green-500')
                    <span>Request a Repair Workshop Quotation</span>
                </div>
                @svg('phosphor-arrow-right-light', 'size-6')
            </a>
        </div>
    </div>

    <div class="border-t border-neutral-300 dark:border-white/10"></div>

    <!-- Quotation Requests Section (modern cards) -->
    <div class="px-4 sm:px-6 lg:px-16">
        <h2 class="text-2xl font-extrabold font-montserrat mb-4 text-neutral-800 dark:text-white">Your Quotation Requests</h2>
        @if ($quotationRequests->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($quotationRequests as $request)
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
                @endforeach
            </div>
        @else
            <div class="border border-neutral-300 dark:border-white/20 text-base text-neutral-800 dark:text-white/70 text-center py-12 rounded-xl">
                No quotation
                requests yet.</div>
        @endif
    </div>

    {{-- <!-- Vehicles Section -->
    @if ($vehicles->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
        <h3 class="text-lg font-semibold text-neutral-800 dark:text-white">My Vehicles</h3>
                        <p class="text-sm text-gray-600">Your registered vehicles</p>
                    </div>
                </div>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $vehicles->count() }} vehicles
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                @foreach ($vehicles as $vehicle)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-neutral-800 dark:text-white">{{ $vehicle->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $vehicle->year }} {{ $vehicle->make }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span>{{ $vehicle->model }}</span>
                            </div>
                            @if ($vehicle->vin)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-mono text-xs">{{ $vehicle->vin }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Draft Appointments Section -->
    @if ($draftAppointments->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-800 dark:text-white">Draft Appointments</h3>
                        <p class="text-sm text-gray-600">Complete your pending appointment bookings</p>
                    </div>
                </div>
                <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $draftAppointments->count() }} pending
                </span>
            </div>

            <div class="space-y-3">
                @foreach ($draftAppointments as $appointment)
                    <div class="border-t border-gray-200 p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-medium text-neutral-800 dark:text-white">{{ $appointment->vehicle->name }}</h4>
                                    <span class="text-sm text-gray-500">#{{ $appointment->id }}</span>
                                </div>

                                <div class="flex items-center gap-2 mb-2">
                                    @if ($appointment->provider_id)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Center Selected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            Select Center
                                        </span>
                                    @endif

                                    @if ($appointment->inspection_type)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Type Selected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            Select Type
                                        </span>
                                    @endif

                                    @if ($appointment->scheduled_at)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Date Selected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            Select Date
                                        </span>
                                    @endif
                                </div>

                                <div class="text-sm text-gray-600">
                                    <span>{{ $appointment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <button wire:click="continueDraftAppointment('{{ $appointment->id }}')"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    Continue
                                </button>
                                <button wire:click="cancelDraftAppointment('{{ $appointment->id }}')"
                                    wire:confirm="Are you sure you want to cancel this draft appointment?"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Upcoming Appointments Section -->
    @if ($upcomingAppointments->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-800 dark:text-white">Upcoming Appointments</h3>
                        <p class="text-sm text-gray-600">Your confirmed upcoming inspections</p>
                    </div>
                </div>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $upcomingAppointments->count() }} upcoming
                </span>
            </div>

            <div class="space-y-3">
                @foreach ($upcomingAppointments as $appointment)
                    <div class="border-t border-gray-200 p-4 hover:bg-blue-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-medium text-neutral-800 dark:text-white">{{ $appointment->vehicle->name }}</h4>
                                    <span class="text-sm text-gray-500">#{{ $appointment->id }}</span>
                                </div>

                                <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ $appointment->scheduled_at->format('l, F j, Y') }} at
                                            {{ $appointment->scheduled_at->format('g:i A') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $appointment->provider->name }}</span>
                                    </div>
                                </div>

                                @if ($appointment->inspection_type)
                                    <div class="mt-2">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst(str_replace('-', ' ', $appointment->inspection_type->value)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center space-x-2">
                                <button wire:click="viewAppointment('{{ $appointment->id }}')"
                                    class="px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Completed Inspections Section -->
    @if ($completedInspections->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-800 dark:text-white">Completed Inspections</h3>
                        <p class="text-sm text-gray-600">View your inspection reports and request quotations</p>
                    </div>
                </div>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $completedInspections->count() }} completed
                </span>
            </div>

            <div class="space-y-3">
                @foreach ($completedInspections as $inspection)
                    <div class="border-t border-gray-200 p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-medium text-neutral-800 dark:text-white">{{ $inspection->vehicle->name }}</h4>
                                    <span class="text-sm text-gray-500">#{{ $inspection->number }}</span>
                                </div>

                                <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ $inspection->completed_at->format('M j, Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $inspection->provider->name }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ ucfirst(str_replace('-', ' ', $inspection->type->value)) }}
                                    </span>
                                    @if ($inspection->damageSpareparts->count() > 0)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            {{ $inspection->damageSpareparts->count() }} damaged parts
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <button wire:click="viewInspection('{{ $inspection->id }}')"
                                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                    View Report & Request Quotes
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif --}}
</div>
