<?php

namespace App\Livewire\Quotations;

use App\Models\QuotationRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewQuotationRequest extends Component
{
    public QuotationRequest $quotationRequest;

    public function mount($quotationRequestId)
    {
        $this->quotationRequest = QuotationRequest::with([
            'inspection.appointment.vehicle.user',
            'quotations.provider',
            'quotations.quotationSpareparts.damageSparepart.sparepart'
        ])->findOrFail($quotationRequestId);
    }

    public function goBack()
    {
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.quotations.view-quotation-request');
    }
}
