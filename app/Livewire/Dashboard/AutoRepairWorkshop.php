<?php

namespace App\Livewire\Dashboard;

use App\Enums\QuotationRequestStatus;
use App\Enums\QuotationType;
use App\Models\Provider;
use App\Models\QuotationRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AutoRepairWorkshop extends Component
{
    public Collection $quotationRequests;
    public Provider $provider;

    protected $listeners = ['refresh-quotation-requests' => 'loadQuotationRequests'];

    public function mount()
    {
        $this->provider = Provider::find(id: Auth::user()->currentAccount->accountable_id);
        $this->loadQuotationRequests();
    }

    public function loadQuotationRequests()
    {
        $providerId = $this->provider->id;
        
        $this->quotationRequests = QuotationRequest::whereHas('providers', function ($query) use ($providerId) {
            $query->where('provider_id', $providerId);
        })
        ->where('status', QuotationRequestStatus::OPEN)
        ->where('type', QuotationType::REPAIR)
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
        return view('livewire.dashboard.auto-repair-workshop');
    }
}
