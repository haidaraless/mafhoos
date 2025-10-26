<?php

namespace App\Livewire\Dashboard;

use App\Enums\ProviderType;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AutoRepairWorkshop extends Component
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
        
        // Only load for auto repair workshops
        if ($this->provider->type !== ProviderType::AUTO_REPAIR_WORKSHOP) {
            $this->quotationRequests = collect();
            return;
        }

        // TODO: Implement quotation requests when the feature is added
        // For now, return empty collection
        $this->quotationRequests = collect();
    }

    public function render()
    {
        return view('livewire.dashboard.auto-repair-workshop');
    }
}
