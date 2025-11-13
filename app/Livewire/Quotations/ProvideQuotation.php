<?php

namespace App\Livewire\Quotations;

use App\Models\QuotationRequest;
use Livewire\Component;

class ProvideQuotation extends Component
{
    public QuotationRequest $quotationRequest;

    public function mount($quotationRequestId = null, QuotationRequest $quotationRequest = null): void
    {
        if ($quotationRequest) {
            $this->quotationRequest = $quotationRequest->load(['inspection.appointment.vehicle']);
        } elseif ($quotationRequestId) {
            $this->quotationRequest = QuotationRequest::with(['inspection.appointment.vehicle'])->findOrFail($quotationRequestId);
        }
    }

    public function render()
    {
        return view('livewire.quotations.provide-quotation');
    }
}


