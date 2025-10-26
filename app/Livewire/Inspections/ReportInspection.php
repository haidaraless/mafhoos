<?php

namespace App\Livewire\Inspections;

use App\Enums\AppointmentStatus;
use App\Enums\Priority;
use App\Models\Inspection;
use App\Models\Sparepart;
use App\Models\Appointment;
use App\Models\DamageSparepart;
use App\Services\SparepartCatalogService;
use App\Mail\InspectionReportReady;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ReportInspection extends Component
{
    public Inspection $inspection;

    public Appointment $appointment;
    // Form fields
    public string $report = '';
    public string $sparepartSearch = '';
    public array $sparepartPriorities = [];
    
    public $sparepartSearchResults = [];

    public function mount(Inspection $inspection)
    {
        $this->inspection = $inspection;

        $this->appointment = Appointment::find($inspection->appointment_id);
        
        // Load existing damage spareparts priorities
        $this->loadExistingDamageSpareparts();
    }

    public function updatedSparepartSearch()
    {
        if (strlen($this->sparepartSearch) < 2) {
            $this->sparepartSearchResults = [];
            return;
        }

        // Get vehicle information for compatibility filtering
        $vehicle = $this->appointment->vehicle;
        $vehicleMake = $vehicle->make;
        $vehicleModel = $vehicle->model;
        $vehicleYear = $vehicle->year;

        // First try to search in the catalog service with vehicle compatibility
        $catalogService = new SparepartCatalogService();
        $catalogResults = $catalogService->searchSpareparts(
            $this->sparepartSearch, 
            $vehicleMake, 
            $vehicleModel, 
            $vehicleYear, 
            null, 
            10
        );
        
        if (!empty($catalogResults)) {
            // Convert catalog results to database records
            $this->sparepartSearchResults = $this->convertCatalogResultsToDatabaseRecords($catalogResults);
        } else {
            // Fallback to database search with vehicle compatibility
            $this->sparepartSearchResults = Sparepart::where('name', 'like', '%' . $this->sparepartSearch . '%')
                ->where(function($query) use ($vehicleMake, $vehicleModel, $vehicleYear) {
                    $query->where(function($q) use ($vehicleMake, $vehicleModel, $vehicleYear) {
                        $q->where('vehicle_make', $vehicleMake)
                          ->where('vehicle_model', $vehicleModel);
                        
                        if ($vehicleYear) {
                            $q->where(function($yearQuery) use ($vehicleYear) {
                                $yearQuery->whereNull('year_range')
                                         ->orWhere('year_range', 'like', '%' . $vehicleYear . '%');
                            });
                        }
                    });
                })
                ->limit(10)
                ->get()
                ->toArray();
        }
    }

    public function selectSparepart($sparepartId)
    {
        DamageSparepart::create([
            'inspection_id' => $this->inspection->id,
            'sparepart_id' => $sparepartId,
            'priority' => Priority::MEDIUM->value,
        ]);
        
        $this->sparepartSearch = '';
        $this->sparepartSearchResults = [];
        
        // Refresh the damage spareparts priorities
        $this->loadExistingDamageSpareparts();
    }

    public function removeSparepart($sparepartId)
    {
        // Delete the DamageSparepart record from database
        DamageSparepart::where('inspection_id', $this->inspection->id)
            ->where('sparepart_id', $sparepartId)
            ->delete();
        
        // Refresh the damage spareparts priorities
        $this->loadExistingDamageSpareparts();
    }

    public function updatePriority($sparepartId, $priority)
    {
        // Update the priority in the database
        DamageSparepart::where('inspection_id', $this->inspection->id)
            ->where('sparepart_id', $sparepartId)
            ->update(['priority' => $priority]);
        
        // Update local state
        $this->sparepartPriorities[$sparepartId] = $priority;
        
        // Refresh the damage spareparts priorities
        $this->loadExistingDamageSpareparts();
    }

    public function saveReport()
    {
        $this->validate([
            'report' => 'required|string|min:10',
        ]);

        // Update inspection report
        $this->inspection->update([
            'report' => $this->report,
            'completed_at' => now(),
        ]);

        session()->flash('message', 'Inspection report saved successfully!');
        
        return redirect()->route('dashboard.vehicle-inspection-center');
    }

    public function completeInspection()
    {
        $this->validate([
            'report' => 'required|string|min:10',
        ]);

        // Update inspection report and mark as completed
        $this->inspection->update([
            'report' => $this->report,
            'completed_at' => now(),
        ]);

        $this->appointment->update([
            'status' => AppointmentStatus::COMPLETED,
            'completed_at' => now()
        ]);

        // Send email notification to vehicle owner
        try {
            Mail::to($this->appointment->vehicle->user->email)
                ->send(new InspectionReportReady($this->inspection, $this->appointment));
            
            session()->flash('message', 'Inspection completed successfully! Email notification sent to vehicle owner.');
        } catch (\Exception $e) {
            // Log the error but don't fail the completion
            Log::error('Failed to send inspection report ready email: ' . $e->getMessage());
            session()->flash('message', 'Inspection completed successfully! (Email notification failed to send)');
        }
        
        return redirect()->route('dashboard.vehicle-inspection-center');
    }

    private function loadExistingDamageSpareparts()
    {
        $existingDamageSpareparts = $this->inspection->damageSpareparts()->with('sparepart')->get();
        
        foreach ($existingDamageSpareparts as $damageSparepart) {
            $this->sparepartPriorities[$damageSparepart->sparepart_id] = $damageSparepart->priority->value;
        }
        
        if ($this->inspection->report) {
            $this->report = $this->inspection->report;
        }
    }

    public function getDamageSparepartsProperty()
    {
        return DamageSparepart::where('inspection_id', $this->inspection->id)
            ->with('sparepart')
            ->get();
    }

    public function getPriorityForSparepart($sparepartId)
    {
        return $this->sparepartPriorities[$sparepartId] ?? 'medium';
    }

    /**
     * Convert catalog results to database records
     */
    private function convertCatalogResultsToDatabaseRecords($catalogResults)
    {
        $databaseRecords = [];
        
        foreach ($catalogResults as $catalogPart) {
            // Create or find sparepart in database
            $sparepart = Sparepart::updateOrCreate(
                ['number' => $catalogPart['part_number']],
                [
                    'name' => $catalogPart['name'],
                    'description' => $catalogPart['description'] ?? null,
                    'brand' => $catalogPart['brand'] ?? null,
                    'vehicle_make' => $catalogPart['vehicle_make'] ?? null,
                    'vehicle_model' => $catalogPart['vehicle_model'] ?? null,
                    'year_range' => $catalogPart['year_range'] ?? null,
                    'category' => $catalogPart['category'] ?? null,
                    'price_range' => $catalogPart['price_range'] ?? null,
                    'availability' => $catalogPart['availability'] ?? 'In Stock',
                ]
            );
            
            $databaseRecords[] = $sparepart->toArray();
        }
        
        return $databaseRecords;
    }

    public function render()
    {
        return view('livewire.inspections.report-inspection');
    }
}