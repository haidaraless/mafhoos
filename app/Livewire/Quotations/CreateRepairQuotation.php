<?php

namespace App\Livewire\Quotations;

use App\Enums\QuotationRequestStatus;
use App\Mail\QuotationReceived;
use App\Models\Quotation;
use App\Models\QuotationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CreateRepairQuotation extends Component
{
    public QuotationRequest $quotationRequest;
    public $total = '';
    public $notes = '';
    public $showModal = false;

    protected $rules = [
        'total' => 'required|numeric|min:0.01',
        'notes' => 'nullable|string|max:1000',
    ];

    public function mount(QuotationRequest $quotationRequest)
    {
        $this->quotationRequest = $quotationRequest;
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->reset(['total', 'notes']);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['total', 'notes']);
        $this->resetErrorBag();
    }

    public function createQuotation()
    {
        $this->validate();

        $user = Auth::user();
        $provider = $user->currentAccount->accountable;

        // Create the quotation
        $quotation = Quotation::create([
            'quotation_request_id' => $this->quotationRequest->id,
            'provider_id' => $provider->id,
            'type' => $this->quotationRequest->type,
            'total' => $this->total,
            'notes' => $this->notes,
            'status' => 'draft',
        ]);

        $this->closeModal();
        
        session()->flash('message', 'Quotation created successfully as draft. You can now send it to the vehicle owner.');
        
        $this->dispatch('quotation-created');
    }

    public function sendQuotation($quotationId)
    {
        $quotation = Quotation::findOrFail($quotationId);
        
        // Update quotation status to quoted
        $quotation->update(['status' => 'quoted']);
        
        // Update quotation request status
        $this->quotationRequest->update(['status' => QuotationRequestStatus::QUOTED]);
        
        // Send email notification to vehicle owner
        try {
            Mail::to($this->quotationRequest->inspection->appointment->vehicle->user->email)
                ->send(new QuotationReceived($quotation, $this->quotationRequest));
            
            session()->flash('message', 'Quotation sent successfully! The vehicle owner has been notified via email.');
        } catch (\Exception $e) {
            Log::error('Failed to send quotation email: ' . $e->getMessage());
            session()->flash('message', 'Quotation sent successfully! (Email notification failed to send)');
        }
        
        $this->dispatch('quotation-sent');
        $this->dispatch('close-quotation-modal');
        $this->dispatch('refresh-quotation-requests');
    }

    public function render()
    {
        $quotations = Quotation::where('quotation_request_id', $this->quotationRequest->id)
            ->where('provider_id', Auth::user()->currentAccount->accountable_id)
            ->get();

        return view('livewire.quotations.create-repair-quotation', [
            'quotations' => $quotations,
        ]);
    }
}
