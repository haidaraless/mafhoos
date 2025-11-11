<?php

namespace App\Livewire\Quotations;

use App\Models\QuotationRequest;
use Livewire\Component;

class ProvideQuotation extends Component
{
    public QuotationRequest $quotationRequest;

    public function mount(int $quotationRequestId): void
    {
        $this->quotationRequest = QuotationRequest::with(['inspection.appointment.vehicle', 'type', 'status'])->findOrFail($quotationRequestId);
    }

    public function render()
    {
        return view('livewire.quotations.provide-quotation');
    }
}


