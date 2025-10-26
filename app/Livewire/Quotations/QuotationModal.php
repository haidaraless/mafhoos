<?php

namespace App\Livewire\Quotations;

use App\Enums\QuotationType;
use App\Models\QuotationRequest;
use Livewire\Component;

class QuotationModal extends Component
{
    public $showModal = false;
    public $quotationRequestId;
    public $quotationRequest;

    protected $listeners = [
        'open-quotation-modal' => 'openModal',
        'close-quotation-modal' => 'closeModal'
    ];

    public function openModal($quotationRequestId)
    {
        $this->quotationRequestId = $quotationRequestId;
        $this->quotationRequest = QuotationRequest::with(['inspection.appointment.vehicle'])->find($quotationRequestId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->quotationRequestId = null;
        $this->quotationRequest = null;
    }

    public function render()
    {
        return view('livewire.quotations.quotation-modal');
    }
}
