<?php

namespace App\Livewire\Quotations;

use App\Enums\QuotationRequestStatus;
use App\Mail\QuotationReceived;
use App\Models\DamageSparepart;
use App\Models\Quotation;
use App\Models\QuotationRequest;
use App\Models\QuotationSparepart;
use App\Notifications\QuotationCreatedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CreateSparepartsQuotation extends Component
{
    public QuotationRequest $quotationRequest;
    public $sparepartPrices = [];
    public $notes = '';
    public $damageSpareparts;

    protected $rules = [
        'sparepartPrices.*' => 'required|numeric|min:0.01',
        'notes' => 'nullable|string|max:1000',
    ];

    protected function rules()
    {
        $rules = [
            'notes' => 'nullable|string|max:1000',
        ];

        // Add validation for each sparepart price
        foreach ($this->sparepartPrices as $key => $value) {
            if ($value !== '' && $value !== null) {
                $rules["sparepartPrices.{$key}"] = 'required|numeric|min:0.01';
            }
        }

        return $rules;
    }

    public function mount(QuotationRequest $quotationRequest, bool $inline = false)
    {
        $this->quotationRequest = $quotationRequest;
        $this->loadDamageSpareparts();
        $this->initializePrices();
    }

    public function loadDamageSpareparts()
    {
        $this->damageSpareparts = DamageSparepart::where('inspection_id', $this->quotationRequest->inspection_id)
            ->with('sparepart')
            ->get();
    }

    public function initializePrices()
    {
        foreach ($this->damageSpareparts as $damageSparepart) {
            if (!isset($this->sparepartPrices[$damageSparepart->id])) {
                $this->sparepartPrices[$damageSparepart->id] = '';
            }
        }
    }

    public function createQuotation()
    {
        $this->validate();

        $user = Auth::user();
        $provider = $user->currentAccount->accountable;

        // Calculate total
        $total = array_sum(array_map('floatval', array_filter($this->sparepartPrices, function($value) {
            return $value !== '' && $value !== null;
        })));

        // Check if at least one price is entered
        if ($total <= 0) {
            $this->addError('sparepartPrices', 'Please enter at least one spare part price.');
            return;
        }

        // Create the quotation
        $quotation = Quotation::create([
            'quotation_request_id' => $this->quotationRequest->id,
            'provider_id' => $provider->id,
            'type' => $this->quotationRequest->type,
            'total' => $total,
            'notes' => $this->notes,
            'status' => 'draft',
        ]);

        $this->quotationRequest->loadMissing('inspection.appointment.user');
        $owner = $this->quotationRequest->inspection->appointment->user ?? null;

        if ($owner) {
            $owner->notify(new QuotationCreatedNotification($quotation));
        }

        // Create quotation spareparts
        foreach ($this->sparepartPrices as $damageSparepartId => $price) {
            if ($price > 0) {
                QuotationSparepart::create([
                    'quotation_id' => $quotation->id,
                    'damage_sparepart_id' => $damageSparepartId,
                    'price' => $price,
                ]);
            }
        }

        $this->reset(['notes']);
        $this->initializePrices();
        $this->resetErrorBag();
        
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

    public function getTotalProperty()
    {
        return array_sum(array_map('floatval', array_filter($this->sparepartPrices, function($value) {
            return $value !== '' && $value !== null;
        })));
    }

    public function render()
    {
        $quotations = Quotation::where('quotation_request_id', $this->quotationRequest->id)
            ->where('provider_id', Auth::user()->currentAccount->accountable_id)
            ->with('quotationSpareparts.damageSparepart.sparepart')
            ->get();

        return view('livewire.quotations.create-spareparts-quotation', [
            'quotations' => $quotations,
        ]);
    }
}
