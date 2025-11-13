<?php

namespace App\Livewire\Inspections;

use App\Enums\AppointmentStatus;
use App\Enums\Priority;
use App\Enums\ProviderType;
use App\Enums\QuotationRequestStatus;
use App\Enums\QuotationType;
use App\Models\Inspection;
use App\Models\Sparepart;
use App\Models\Appointment;
use App\Models\DamageSparepart;
use App\Models\QuotationRequest;
use App\Services\SparepartCatalogService;
use App\Mail\InspectionReportReady;
use App\Models\Provider;
use App\Models\QuotationProvider;
use App\Notifications\InspectionCompletedNotification;
use App\Notifications\QuotationRequestCreatedNotification;
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

    public function updatedAppointmentAutoQuotationRequest()
    {
        $this->appointment->save();
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

        if ($this->appointment->user) {
            $this->appointment->user->notify(new InspectionCompletedNotification($this->inspection));
        }

        // Create automatic quotation requests if enabled
        if ($this->appointment->auto_quotation_request) {
            $this->createAutomaticQuotationRequests();
        }

        // Send email notification to vehicle owner
        try {
            Mail::to($this->appointment->vehicle->user->email)
                ->send(new InspectionReportReady($this->inspection, $this->appointment));
            
            $message = 'Inspection completed successfully! Email notification sent to vehicle owner.';
            if ($this->appointment->auto_quotation_request) {
                $message .= ' Quotation requests have been automatically created.';
            }
            session()->flash('message', $message);
        } catch (\Exception $e) {
            // Log the error but don't fail the completion
            Log::error('Failed to send inspection report ready email: ' . $e->getMessage());
            $message = 'Inspection completed successfully! (Email notification failed to send)';
            if ($this->appointment->auto_quotation_request) {
                $message .= ' Quotation requests have been automatically created.';
            }
            session()->flash('message', $message);
        }
        
        return redirect()->route('dashboard.vehicle-inspection-center');
    }

    private function createAutomaticQuotationRequests()
    {
        // Create spare parts quotation request if there are damaged spareparts
        if ($this->inspection->damageSpareparts->count() > 0) {
            $qr1 = QuotationRequest::create([
                'inspection_id' => $this->inspection->id,
                'type' => QuotationType::SPARE_PARTS,
                'status' => QuotationRequestStatus::OPEN,
            ]);

            $this->notifyQuotationRequestCreated($qr1);

            # get providers that are spare parts suppliers in the same city as the inspection
            $qr1_providers = Provider::where('city_id', $this->inspection->provider->city_id)
                ->where('type', ProviderType::SPARE_PARTS_SUPPLIER)
                ->get();

            foreach ($qr1_providers as $qr1_provider) {
                QuotationProvider::create([
                    'quotation_request_id' => $qr1->id,
                    'provider_id' => $qr1_provider->id,
                ]);
            }
        }

        // Always create repair quotation request
        $qr2 = QuotationRequest::create([
            'inspection_id' => $this->inspection->id,
            'type' => QuotationType::REPAIR,
            'status' => QuotationRequestStatus::OPEN,
        ]);

        $this->notifyQuotationRequestCreated($qr2);

        # get providers that are auto repair workshops in the same city as the inspection
        $qr2_providers = Provider::where('city_id', $this->inspection->provider->city_id)
            ->where('type', ProviderType::AUTO_REPAIR_WORKSHOP)
            ->get();

        foreach ($qr2_providers as $qr2_provider) {
            QuotationProvider::create([
                'quotation_request_id' => $qr2->id,
                'provider_id' => $qr2_provider->id,
            ]);
        }
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

    private function notifyQuotationRequestCreated(QuotationRequest $quotationRequest): void
    {
        if ($this->appointment->user) {
            $this->appointment->user->notify(new QuotationRequestCreatedNotification($quotationRequest));
        }
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