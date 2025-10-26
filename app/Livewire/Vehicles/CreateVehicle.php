<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Appointment;

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
        
        // Use dummy data for testing
        $dummyData = $this->getDummyData();
        $parsedData = $this->parseDummyData($dummyData);

        // Ensure the result is always an array, even if null
        $this->vehicleData = is_array($parsedData) ? $parsedData : [];

        $this->showVehicleData = !empty($this->vehicleData);
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

            $vehicle = Vehicle::create([
                'user_id' => Auth::user()->id,
                'vin' => $this->vin,
                'name' => $this->vehicleData['make'] . ' ' . $this->vehicleData['model'] . ' ' . $this->vehicleData['year'],
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

            # create draft appointment and redirect to select inspection center
            $appointment = Appointment::createAppointmentViaVehicle($vehicle);
            
            return $this->redirect(route('appointments.inspection-center.select', $appointment), true);

        } catch (\Exception $e) {
            dd($e);
            session()->flash('error', 'Failed to create vehicle. Please try again.');
        }
    }

    private function parseDummyData(array $dummyData): array
    {
        $data = [];
        
        // Navigate to the decoder data in the dummy JSON structure
        if (isset($dummyData['functionResponse']['data']['decoder'])) {
            $decoder = $dummyData['functionResponse']['data']['decoder'];
            
            // Map the dummy data fields to our expected structure
            $data['make'] = $decoder['make']['value'] ?? '';
            $data['model'] = $decoder['model']['value'] ?? '';
            $data['year'] = $decoder['model_year']['value'] ?? '';
            $data['body_class'] = $decoder['body']['value'] ?? '';
            $data['engine_model'] = $decoder['engine_version']['value'] ?? '';
            $data['fuel_type'] = $decoder['fuel_type']['value'] ?? '';
            $data['drive_type'] = $decoder['drive_type']['value'] ?? '';
            $data['transmission_style'] = $decoder['gearbox_type']['value'] ?? '';
            $data['vehicle_type'] = $decoder['vehicle_type']['value'] ?? '';
            $data['doors'] = $decoder['doors']['value'] ?? '';
            $data['cylinders'] = $decoder['engine_cylinders']['value'] ?? '';
            $data['displacement'] = $decoder['engine_displ_l']['value'] ?? '';
        }
        
        return $data;
    }

    private function getDummyData()
    {
        $jsonData = <<<JSON
        {
        "version": "3.0",
        "vin": "WAUZZZ8R3GAXXXXXX",
        "apiStatus": "OK",
        "responseDate": "2025-08-13 14:44:31",
        "functionName": "api/v3/getSimpleDecoder",
        "functionResponse": {
            "data": {
            "api": {
                "core_version": "2.4.15d",
                "endpoint_version": 2,
                "json_version": "1.0.0",
                "api_type": "API Simple - Full mode - en",
                "api_cache": "off",
                "data_precision": 1,
                "data_matching": "62.4%",
                "lex_lang": "en"
            },
            "analyze": {
                "vin_orginal": {
                "desc": "Entered VIN",
                "value": "WAUZZZ8R3GAXXXXXX"
                },
                "vin_corrected": {
                "desc": "Corrected VIN",
                "value": "WAUZZZ8R3GAXXXXXX"
                },
                "vin_year": {
                "desc": "Year Identifier",
                "value": "G"
                },
                "vin_serial": {
                "desc": "Serial number",
                "value": "139917"
                },
                "checkdigit": {
                "desc": "Check Digit",
                "value": "valid"
                }
            },
            "decoder": {
                "make": {
                "desc": "Make",
                "value": "Audi"
                },
                "model": {
                "desc": "Model",
                "value": "Q5"
                },
                "model_year": {
                "desc": "Model year",
                "value": "2016"
                },
                "body": {
                "desc": "Body type",
                "value": "SUV"
                },
                "fuel_type": {
                "desc": "Fuel type",
                "value": "Diesel"
                },
                "vehicle_type": {
                "desc": "Vehicle type",
                "value": "Sport Utility Vehicle"
                },
                "doors": {
                "desc": "Doors number",
                "value": "5"
                },
                "engine_displ_cm3": {
                "desc": "Displacement SI",
                "value": "2967 cm3"
                },
                "engine_displ_l": {
                "desc": "Displacement Nominal",
                "value": "3.0 l"
                },
                "engine_power_hp": {
                "desc": "Horsepower",
                "value": "322 HP"
                },
                "engine_power_kw": {
                "desc": "Kilowatts",
                "value": "240 kW"
                },
                "engine_conf": {
                "desc": "Engine configuration",
                "value": null
                },
                "engine_type": {
                "desc": "Engine type",
                "value": "V6"
                },
                "engine_version": {
                "desc": "Engine version",
                "value": "TDI"
                },
                "engine_head": {
                "desc": "Valve operation",
                "value": null
                },
                "engine_valves": {
                "desc": "Valves",
                "value": "24"
                },
                "engine_cylinders": {
                "desc": "Cylinders",
                "value": "6"
                },
                "engine_displ_cid": {
                "desc": "Displacement CID",
                "value": "181 cid"
                },
                "engine_turbo": {
                "desc": "Charger (turbo/super/diesel)",
                "value": "Y"
                },
                "drive_type": {
                "desc": "Driveline",
                "value": "AWD"
                },
                "gearbox_type": {
                "desc": "Transmission type",
                "value": "Automatic"
                },
                "emission_std": {
                "desc": "Emission Standard",
                "value": "EURO 6",
                "co2_gkm": "174"
                }
            },
            "custom_equipment": {
                "desc": "Custom equipment list",
                "values": [
                {
                    "code": "6141",
                    "value": "4WD/AWD"
                },
                {
                    "code": "6143",
                    "value": "ALLOY WHEELS"
                },
                {
                    "code": "6144",
                    "value": "RADIO RECEIVER"
                }
                ]
            }
            }
        },
        "licenseInfo": {
            "licenseNumber": "xxxx",
            "validTo": "2030-12-31",
            "remainingCredits": 9996,
            "remainingMonthlyLimit": 499,
            "remainingDailyLimit": 49
        }
        }
        JSON;

        return json_decode($jsonData, true);
    }

    private function sendAPIVinRequest()
    {
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
    }

    public function render()
    {
        return view('livewire.vehicles.create-vehicle');
    }
}
