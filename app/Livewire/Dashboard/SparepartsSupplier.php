<?php

namespace App\Livewire\Dashboard;

use App\Enums\ProviderType;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SparepartsSupplier extends Component
{
    public Collection $quotationRequests;
    public Provider $provider;

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

        $this->provider = $currentAccount->accountable;
        
        // Only load for spare parts suppliers
        if ($this->provider->type !== ProviderType::SPARE_PARTS_SUPPLIER) {
            $this->quotationRequests = collect();
            return;
        }

        // TODO: Implement quotation requests when the feature is added
        // For now, return empty collection
        $this->quotationRequests = collect();
    }

    public function render()
    {
        return view('livewire.dashboard.spareparts-supplier');
    }
}
