<div class="max-w-2xl mx-auto p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Vehicle</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Enter a VIN to automatically retrieve vehicle information</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 dark:bg-green-900/20 dark:border-green-800">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200 dark:bg-red-900/20 dark:border-red-800">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- VIN Input Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Vehicle Identification Number (VIN)</h2>
        
        <form wire:submit.prevent="lookupVehicle" class="space-y-4">
            <div>
                <flux:input 
                    type="text" 
                    wire:model="vin" 
                    placeholder="Enter 17-character VIN (e.g., 1HGBH41JXMN109186)"
                    class="uppercase"
                    maxlength="17"
                />
                @error('vin')
                    <flux:error class="mt-1">{{ $message }}</flux:error>
                @enderror
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">VIN must be exactly 17 characters and contain only letters and numbers (excluding I, O, Q)</p>
            </div>
            
            <flux:button 
                type="submit" 
                wire:loading.attr="disabled"
                wire:target="lookupVehicle"
                class="w-full sm:w-auto"
            >
                <span wire:loading.remove wire:target="lookupVehicle">Lookup Vehicle</span>
                <span wire:loading wire:target="lookupVehicle">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Looking up...
                </span>
            </flux:button>
        </form>
    </div>

    <!-- Vehicle Data Display -->
    @if($showVehicleData && !empty($vehicleData))
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Vehicle Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Make</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['make'] ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Model</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['model'] ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Year</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['year'] ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Body Class</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['body_class'] ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Engine Model</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['engine_model'] ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Fuel Type</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['fuel_type'] ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Drive Type</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['drive_type'] ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Transmission</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['transmission_style'] ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Vehicle Type</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['vehicle_type'] ?? 'N/A' }}</p>
                </div>
                
                @if(isset($vehicleData['doors']))
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Doors</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['doors'] }}</p>
                </div>
                @endif
                
                @if(isset($vehicleData['cylinders']))
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Cylinders</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['cylinders'] }}</p>
                </div>
                @endif
                
                @if(isset($vehicleData['displacement']))
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Engine Displacement</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['displacement'] }}</p>
                </div>
                @endif
                
                @if(isset($vehicleData['gvwr']))
                <div>
                    <flux:label class="text-sm font-medium text-gray-500 dark:text-gray-400">Gross Vehicle Weight</flux:label>
                    <p class="text-gray-900 dark:text-white">{{ $vehicleData['gvwr'] }}</p>
                </div>
                @endif
            </div>
            
            <div class="flex gap-3">
                <flux:button 
                    wire:click="createVehicle"
                    wire:loading.attr="disabled"
                    wire:target="createVehicle"
                    type="primary"
                >
                    <span wire:loading.remove wire:target="createVehicle">Create Vehicle</span>
                    <span wire:loading wire:target="createVehicle">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creating...
                    </span>
                </flux:button>
                
                <flux:button 
                    wire:click="$set('showVehicleData', false)"
                    variant="ghost"
                >
                    Cancel
                </flux:button>
            </div>
        </div>
    @endif
</div>
