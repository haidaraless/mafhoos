<div class="grid grid-cols-1 overflow-hidden">
    <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white border-b border-neutral-300">
        @svg('phosphor-car-light', 'size-10 md:size-12 text-orange-500')
        <div class="flex flex-col">
            <h1 class="text-2xl md:text-3xl text-neutral-800 font-bold">{{ __('Create Vehicle') }}</h1>
            <p class="text-neutral-600">{{ __('Enter a VIN to automatically retrieve vehicle details') }}</p>
        </div>
    </div>
    <div class="col-span-1 flex flex-col">
        <form wire:submit.prevent="lookupVehicle" class="flex flex-col w-full">
            <label for="vin"
                   class="flex items-center gap-4 px-6 py-4 text-neutral-800 hover:text-green-500 bg-white hover:bg-white transition-all ease-in-out duration-300 cursor-pointer">
                @svg('phosphor-car-light', 'size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-neutral-800 font-medium">Vehicle VIN</h4>
                    <input id="vin" name="vin" type="text" wire:model="vin" maxlength="17"
                           placeholder="1HGBH41JXMN109186" autofocus
                           class="w-full uppercase text-2xl text-neutral-800 placeholder:text-neutral-400 font-semibold focus:outline-none focus:ring-0 focus:border-none" />
                    @error('vin')
                    <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                    @if (session()->has('error'))
                        <div
                            class="mt-0.5 flex items-center gap-3 text-rose-500 dark:text-rose-300">
                            <svg class="size-5 text-rose-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                      clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    @endif
                </div>
            </label>
            @if (!$showVehicleData)
                <button type="submit"
                        class="flex items-center gap-4 p-4 min-h-24 text-sm text-white bg-neutral-800 hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer"
                        wire:loading.attr="disabled" wire:target="lookupVehicle">
                    <div class="flex flex-col w-full text-left">
                        <h4 class="text-2xl font-semibold">Lookup Vehicle</h4>
                        <span wire:loading.remove wire:target="lookupVehicle" class="text-neutral-400">Fetch
                                vehicle information by VIN</span>
                        <span wire:loading wire:target="lookupVehicle" class="text-neutral-400">Looking
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
                class="animate__animated animate__fadeInUp w-full grid grid-cols-1 bg-white dark:bg-neutral-900 border-t border-neutral-300 dark:border-white/10">
                <div class="col-span-1 h-8 flex items-center justify-between px-6 bg-neutral-50 dark:bg-neutral-800 border-b border-neutral-300 dark:border-white/10">
                    <span class="text-sm">Vehicle Details</span>
                    @svg('phosphor-file-text', 'size-4')
                </div>
                <div class="col-span-1 flex items-center h-20 px-6 text-4xl font-black text-neutral-800 dark:text-white leading-tight">
                    <span>{{ trim(($vehicleData['make'] ?? '') . ' ' . ($vehicleData['model'] ?? '') . ' ' . ($vehicleData['year'] ?? '')) }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-6">
                    <div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-car-light', 'size-4') Make</div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['make'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-tag-light', 'size-4') Model</div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['model'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-calendar-blank-light', 'size-4') Year</div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['year'] ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-3">
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-clipboard-light', 'size-4') Body Class
                        </div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['body_class'] ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-3">
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-engine-light', 'size-4') Engine Model
                        </div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['engine_model'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-flame-light', 'size-4') Fuel Type
                        </div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['fuel_type'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-compass-light', 'size-4') Drive Type
                        </div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['drive_type'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-gear-light', 'size-4') Transmission
                        </div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['transmission_style'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-truck-light', 'size-4') Vehicle
                            Type</div>
                        <p class="text-neutral-800 dark:text-white font-semibold">
                            {{ $vehicleData['vehicle_type'] ?? 'N/A' }}</p>
                    </div>
                    @if (isset($vehicleData['doors']))
                        <div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-door-light', 'size-4') Doors
                            </div>
                            <p class="text-neutral-800 dark:text-white font-semibold">
                                {{ $vehicleData['doors'] }}</p>
                        </div>
                    @endif
                    @if (isset($vehicleData['cylinders']))
                        <div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-circle-light', 'size-4')
                                Cylinders</div>
                            <p class="text-neutral-800 dark:text-white font-semibold">
                                {{ $vehicleData['cylinders'] }}</p>
                        </div>
                    @endif
                    @if (isset($vehicleData['displacement']))
                        <div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-drop-light', 'size-4') Engine
                                Displacement</div>
                            <p class="text-neutral-800 dark:text-white font-semibold">
                                {{ $vehicleData['displacement'] }}</p>
                        </div>
                    @endif
                    @if (isset($vehicleData['gvwr']))
                        <div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">@svg('phosphor-scales-light', 'size-4') Gross
                                Vehicle Weight</div>
                            <p class="text-neutral-800 dark:text-white font-semibold">
                                {{ $vehicleData['gvwr'] }}</p>
                        </div>
                    @endif
                </div>
                <div class="grid grid-cols-3 mt-6">
                    <button type="button"
                            class="col-span-2 flex items-center justify-between px-6 py-4 text-sm text-white font-normal bg-neutral-800 hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer"
                            wire:click="createVehicle" wire:loading.attr="disabled" wire:target="createVehicle">
                        <div class="flex items-center gap-4">
                            @svg('phosphor-check', 'size-7')
                            <div class="flex flex-col w-full text-left">
                                <h4 class="text-2xl font-semibold">Create Vehicle</h4>
                                <span wire:loading.remove wire:target="createVehicle" class="-mt-1">Create your new vehicle</span>
                                <span wire:loading wire:target="createVehicle">Creating...</span>
                            </div>
                        </div>
                        <span wire:loading.remove wire:target="createVehicle">
                                @svg('phosphor-arrow-right-light', 'size-6')
                            </span>
                    </button>
                    <button type="button"
                            class="col-span-1 flex items-center justify-center px-6 py-3 text-sm text-white font-medium bg-orange-500 hover:bg-orange-600 transition-all ease-in-out duration-300 cursor-pointer"
                            wire:click="$set('showVehicleData', false)">
                        <span>No, I will do it later</span>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
