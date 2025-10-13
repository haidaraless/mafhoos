<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreateVehicle extends Component
{
    public string $vin = '';
    public bool $isLoading = false;
    public array $vehicleData = [];
    public bool $showVehicleData = false;

    protected $rules = [
        'vin' => 'required|string|size:17|regex:/^[A-HJ-NPR-Z0-9]{17}$/',
    ];

    protected $messages = [
        'vin.required' => 'VIN is required.',
        'vin.size' => 'VIN must be exactly 17 characters.',
        'vin.regex' => 'VIN contains invalid characters.',
    ];

    public function updatedVin()
    {
        $this->validate(['vin' => 'required|string|size:17|regex:/^[A-HJ-NPR-Z0-9]{17}$/']);
        $this->showVehicleData = false;
        $this->vehicleData = [];
    }

    public function lookupVehicle()
    {
        $this->validate();
        
        $this->isLoading = true;
        
        try {
            // Using API.VIN for Saudi Arabia and global vehicle data
            $apiKey = config('services.api_vin.key');
            $secretKey = config('services.api_vin.secret');
            
            if (!$apiKey || !$secretKey) {
                session()->flash('error', 'API configuration missing. Please contact administrator.');
                $this->isLoading = false;
                return;
            }
            
            $vin = strtoupper($this->vin);
            $controlSum = substr(sha1("$vin|decode|$apiKey|$secretKey"), 0, 10);
            $apiUrl = "https://api.vindecoder.eu/3.2/$apiKey/$controlSum/decode/$vin.json";
            
            $response = Http::timeout(30)->get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['decode']) && is_array($data['decode']) && count($data['decode']) > 0) {
                    $this->vehicleData = $this->parseApiVinData($data['decode']);
                    $this->showVehicleData = true;
                } else {
                    session()->flash('error', 'No vehicle data found for this VIN. This VIN may not be in our database.');
                }
            } else {
                $errorMessage = 'Failed to retrieve vehicle information. ';
                if ($response->status() === 401) {
                    $errorMessage .= 'Invalid API credentials.';
                } elseif ($response->status() === 429) {
                    $errorMessage .= 'API rate limit exceeded. Please try again later.';
                } else {
                    $errorMessage .= 'Please check the VIN and try again.';
                }
                session()->flash('error', $errorMessage);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while looking up the vehicle. Please try again.');
        }
        
        $this->isLoading = false;
    }

    public function createVehicle()
    {
        if (empty($this->vehicleData)) {
            session()->flash('error', 'Please lookup vehicle data first.');
            return;
        }

        try {
            // Check if vehicle with this VIN already exists
            if (Vehicle::where('vin', $this->vin)->exists()) {
                session()->flash('error', 'A vehicle with this VIN already exists.');
                return;
            }

            Vehicle::create([
                'vin' => $this->vin,
                'name' => $this->vehicleData['make'] . ' ' . $this->vehicleData['model'] . ' ' . $this->vehicleData['year'],
                'brand' => $this->vehicleData['make'],
                'model' => $this->vehicleData['model'],
                'year' => $this->vehicleData['year'],
                'make' => $this->vehicleData['make'],
                'body_class' => $this->vehicleData['body_class'] ?? null,
                'engine_model' => $this->vehicleData['engine_model'] ?? null,
                'fuel_type' => $this->vehicleData['fuel_type'] ?? null,
                'drive_type' => $this->vehicleData['drive_type'] ?? null,
                'transmission_style' => $this->vehicleData['transmission_style'] ?? null,
                'vehicle_type' => $this->vehicleData['vehicle_type'] ?? null,
            ]);

            session()->flash('success', 'Vehicle created successfully!');
            
            // Reset form
            $this->vin = '';
            $this->vehicleData = [];
            $this->showVehicleData = false;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create vehicle. Please try again.');
        }
    }

    private function parseApiVinData(array $decodeData): array
    {
        $data = [];
        
        foreach ($decodeData as $item) {
            $label = $item['label'] ?? '';
            $value = $item['value'] ?? '';
            
            // Skip empty values
            if (empty($value) || $value === 'Not available') {
                continue;
            }
            
            switch (strtolower($label)) {
                case 'make':
                case 'manufacturer':
                    $data['make'] = $value;
                    break;
                case 'model':
                    $data['model'] = $value;
                    break;
                case 'model year':
                case 'year':
                    $data['year'] = $value;
                    break;
                case 'body class':
                case 'body type':
                case 'vehicle type':
                    $data['body_class'] = $value;
                    break;
                case 'engine model':
                case 'engine':
                    $data['engine_model'] = $value;
                    break;
                case 'fuel type':
                case 'fuel type - primary':
                    $data['fuel_type'] = $value;
                    break;
                case 'drive type':
                case 'drive':
                    $data['drive_type'] = $value;
                    break;
                case 'transmission':
                case 'transmission style':
                    $data['transmission_style'] = $value;
                    break;
                case 'vehicle type':
                    $data['vehicle_type'] = $value;
                    break;
                case 'doors':
                    $data['doors'] = $value;
                    break;
                case 'cylinders':
                    $data['cylinders'] = $value;
                    break;
                case 'displacement':
                    $data['displacement'] = $value;
                    break;
                case 'gross vehicle weight rating':
                    $data['gvwr'] = $value;
                    break;
            }
        }
        
        return $data;
    }

    private function parseVehicleData(array $results): array
    {
        $data = [];
        
        foreach ($results as $result) {
            $variable = $result['Variable'];
            $value = $result['Value'];
            
            switch ($variable) {
                case 'Make':
                    $data['make'] = $value;
                    break;
                case 'Model':
                    $data['model'] = $value;
                    break;
                case 'Model Year':
                    $data['year'] = $value;
                    break;
                case 'Body Class':
                    $data['body_class'] = $value;
                    break;
                case 'Engine Model':
                    $data['engine_model'] = $value;
                    break;
                case 'Fuel Type - Primary':
                    $data['fuel_type'] = $value;
                    break;
                case 'Drive Type':
                    $data['drive_type'] = $value;
                    break;
                case 'Transmission Style':
                    $data['transmission_style'] = $value;
                    break;
                case 'Vehicle Type':
                    $data['vehicle_type'] = $value;
                    break;
            }
        }
        
        return $data;
    }

    public function render()
    {
        return view('livewire.create-vehicle');
    }
}
