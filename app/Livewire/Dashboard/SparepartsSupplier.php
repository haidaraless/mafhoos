<?php

namespace App\Livewire\Dashboard;

use App\Enums\ProviderType;
use App\Enums\QuotationRequestStatus;
use App\Enums\QuotationType;
use App\Models\Provider;
use App\Models\QuotationRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SparepartsSupplier extends Component
{
    public Collection $quotationRequests;
    public Provider $provider;

    protected $listeners = ['refresh-quotation-requests' => 'loadQuotationRequests'];

    public function mount()
    {
        $this->loadQuotationRequests();
    }

    public function loadQuotationRequests()
    {
        $user = Auth::user();
        $currentAccount = $user?->currentAccount;
        
        if (!$currentAccount || !$currentAccount->isProvider()) {
            $this->quotationRequests = collect();
            return;
        }

        $this->provider = Provider::find($currentAccount->accountable_id);
        
        // Only load for spare parts suppliers
        if ($this->provider->type !== ProviderType::SPARE_PARTS_SUPPLIER) {
            $this->quotationRequests = collect();
            return;
        }

        $providerId = $this->provider->id;
        
        $this->quotationRequests = QuotationRequest::whereHas('providers', function ($query) use ($providerId) {
            $query->where('provider_id', $providerId);
        })
        ->whereIn('status', [
            QuotationRequestStatus::OPEN,
            QuotationRequestStatus::PENDING,
            QuotationRequestStatus::QUOTED,
        ])
        ->where('type', QuotationType::SPARE_PARTS)
        ->with([
            'inspection.appointment.vehicle.user',
            'inspection.damageSpareparts.sparepart',
            'quotations' => function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            }
        ])
        ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.spareparts-supplier');
    }
}
