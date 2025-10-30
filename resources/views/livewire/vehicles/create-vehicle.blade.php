<div class="flex flex-col justify-between w-full h-full">
    <div class="grid grid-cols-1 gap-12">
        <div class="col-span-1 max-w-lg">
            <h1 class="text-5xl text-dark-lavender font-bold">Create Vehicle</h1>
            <p class="mt-2 text-rose-quartz">Enter a VIN to automatically retrieve vehicle information</p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="flex items-center gap-3 p-4 max-w-xl rounded-2xl bg-green-500/10 text-green-700 dark:text-green-300">
                <svg class="size-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="flex items-center gap-3 p-4 max-w-xl rounded-2xl bg-rose-500/10 text-rose-700 dark:text-rose-300">
                <svg class="size-5 text-rose-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- VIN Input Form and Result → vertical stack (details under form) -->
        <div class="flex flex-col w-full gap-4">
            <form wire:submit.prevent="lookupVehicle" class="flex flex-col gap-4 w-full max-w-xl">
                <label for="vin"
                    class="flex items-center gap-4 p-4 max-w-xl text-rose-quartz hover:text-green-500 bg-rose-quartz/10 hover:bg-white border border-rose-quartz/10 transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                    @svg('phosphor-car-light', 'size-10')
                    <div class="flex flex-col w-full">
                        <h4 class="text-lg text-dark-lavender font-medium">Vehicle VIN</h4>
                        <input id="vin" name="vin" type="text" wire:model="vin" maxlength="17"
                            placeholder="1HGBH41JXMN109186"
                            class="w-full uppercase text-2xl text-dark-lavender placeholder:text-pale-dogwood font-semibold focus:outline-none focus:ring-0 focus:border-none" />
                        @error('vin')
                            <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                        @enderror
                    </div>
                </label>
                @if (!$showVehicleData)
                    <button type="submit"
                        class="flex items-center gap-4 p-4 max-w-xl min-h-24 text-sm text-white bg-light-lavender hover:bg-dark-lavender transition-all ease-in-out duration-300 cursor-pointer rounded-2xl"
                        wire:loading.attr="disabled" wire:target="lookupVehicle">
                        <div class="flex flex-col w-full text-left">
                            <h4 class="text-2xl font-semibold">Lookup Vehicle</h4>
                            <span wire:loading.remove wire:target="lookupVehicle" class="text-pale-dogwood">Fetch
                                vehicle information by VIN</span>
                            <span wire:loading wire:target="lookupVehicle" class="text-pale-dogwood">Looking
                                up...</span>
                        </div>
                        <span wire:loading wire:target="lookupVehicle">
                            <svg class="animate-spin size-10 text-white inline" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        <span wire:loading.remove wire:target="lookupVehicle">
                            @svg('phosphor-arrow-right-light', 'size-10')
                        </span>
                    </button>
                @endif
            </form>
            @if ($showVehicleData && !empty($vehicleData))
                <div
                    class="animate__animated animate__fadeInUp w-full max-w-xl p-6 flex flex-col gap-5 rounded-2xl bg-alabaster dark:bg-dark-lavender mt-2">
                    <div class="flex flex-col items-start mb-4">
                        <div
                            class="text-4xl lg:text-5xl font-black text-dark-lavender dark:text-alabaster leading-tight flex items-center gap-4 drop-shadow">
                            {{ trim(($vehicleData['make'] ?? '') . ' ' . ($vehicleData['model'] ?? '') . ' ' . ($vehicleData['year'] ?? '')) }}
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                        <div>
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-car-light', 'size-4') Make</div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['make'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-tag-light', 'size-4') Model</div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['model'] ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-calendar-blank-light', 'size-4') Year</div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['year'] ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-clipboard-light', 'size-4') Body Class
                            </div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['body_class'] ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-engine-light', 'size-4') Engine Model
                            </div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['engine_model'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-flame-light', 'size-4') Fuel Type
                            </div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['fuel_type'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-compass-light', 'size-4') Drive Type
                            </div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['drive_type'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-gear-light', 'size-4') Transmission
                            </div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['transmission_style'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-truck-light', 'size-4') Vehicle
                                Type</div>
                            <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                {{ $vehicleData['vehicle_type'] ?? 'N/A' }}</p>
                        </div>
                        @if (isset($vehicleData['doors']))
                            <div>
                                <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-door-light', 'size-4') Doors
                                </div>
                                <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                    {{ $vehicleData['doors'] }}</p>
                            </div>
                        @endif
                        @if (isset($vehicleData['cylinders']))
                            <div>
                                <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-circle-light', 'size-4')
                                    Cylinders</div>
                                <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                    {{ $vehicleData['cylinders'] }}</p>
                            </div>
                        @endif
                        @if (isset($vehicleData['displacement']))
                            <div>
                                <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-drop-light', 'size-4') Engine
                                    Displacement</div>
                                <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                    {{ $vehicleData['displacement'] }}</p>
                            </div>
                        @endif
                        @if (isset($vehicleData['gvwr']))
                            <div>
                                <div class="flex items-center gap-2 text-sm text-rose-quartz">@svg('phosphor-scales-light', 'size-4') Gross
                                    Vehicle Weight</div>
                                <p class="text-dark-lavender dark:text-alabaster font-semibold">
                                    {{ $vehicleData['gvwr'] }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-3 mt-2">
                        <button type="button"
                            class="flex items-center gap-3 px-5 py-3 text-sm text-white bg-light-lavender hover:bg-dark-lavender transition-all ease-in-out duration-300 rounded-xl"
                            wire:click="createVehicle" wire:loading.attr="disabled" wire:target="createVehicle">
                            <span wire:loading.remove wire:target="createVehicle" class="text-white">Create
                                Vehicle</span>
                            <span wire:loading wire:target="createVehicle" class="text-white">Creating...</span>
                            <span wire:loading.remove wire:target="createVehicle">
                                @svg('phosphor-check-circle-light', 'size-5')
                            </span>
                        </button>
                        <button type="button"
                            class="px-5 py-3 text-sm text-dark-lavender hover:text-green-600 transition-colors rounded-xl"
                            wire:click="$set('showVehicleData', false)">
                            Cancel
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
