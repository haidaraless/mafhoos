<?php

namespace App\Livewire\Inspections;

use App\Enums\ProviderType;
use App\Enums\QuotationRequestStatus;
use App\Enums\QuotationType;
use App\Models\Inspection;
use App\Models\Provider;
use App\Models\QuotationProvider;
use App\Models\QuotationRequest;
use App\Notifications\QuotationRequestCreatedNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewInspection extends Component
{
    public Inspection $inspection;
    public $quotationRequests = [];

    public function mount(Inspection $inspection)
    {
        $this->inspection = $inspection;
        
        // Check if user owns the vehicle
        if ($this->inspection->vehicle->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to view this inspection.');
        }
        
        $this->loadQuotationRequests();
    }

    public function createQuotationRequest($type)
    {
        $quotationType = QuotationType::from($type);
        $providerType = match ($type) {
            'spare-parts' => ProviderType::SPARE_PARTS_SUPPLIER,
            'repair' => ProviderType::AUTO_REPAIR_WORKSHOP,
            default => null,
        };
        
        // Check if quotation request already exists for this type
        $existingRequest = QuotationRequest::where('inspection_id', $this->inspection->id)
            ->where('type', $quotationType)
            ->first();
            
        if ($existingRequest) {
            $this->addError('quotation', 'A quotation request for ' . str_replace('-', ' ', $type) . ' already exists.');
            return;
        }
        
        // Create new quotation request
        $quotationRequest = QuotationRequest::create([
            'inspection_id' => $this->inspection->id,
            'type' => $quotationType,
            'status' => QuotationRequestStatus::OPEN,
        ]);

        $owner = $quotationRequest->inspection->appointment->user ?? null;

        if ($owner) {
            $owner->notify(new QuotationRequestCreatedNotification($quotationRequest));
        }

        # get providers that are auto repair workshops in the same city as the inspection
        $providers = Provider::where('city_id', $this->inspection->provider->city_id)
            ->where('type', $providerType)
            ->get();

        foreach ($providers as $provider) {
            QuotationProvider::create([
                'quotation_request_id' => $quotationRequest->id,
                'provider_id' => $provider->id,
            ]);
        }
        
        $this->loadQuotationRequests();
        session()->flash('message', 'Quotation request created successfully!');
    }

    private function loadQuotationRequests()
    {
        $this->quotationRequests = QuotationRequest::where('inspection_id', $this->inspection->id)
            ->with(['providers.provider'])
            ->get();
    }

    public function render()
    {
        return view('livewire.inspections.view-inspection');
    }
}