<?php

namespace App\Mail;

use App\Models\Quotation;
use App\Models\QuotationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuotationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Quotation $quotation,
        public QuotationRequest $quotationRequest
    ) {}

    public function envelope(): Envelope
    {
        $quotationType = $this->quotation->type === \App\Enums\QuotationType::REPAIR ? 'Repair' : 'Spare Parts';
        return new Envelope(
            subject: "New {$quotationType} Quotation Received - {$this->quotationRequest->inspection->appointment->vehicle->make} {$this->quotationRequest->inspection->appointment->vehicle->model}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quotation-received',
            with: [
                'quotation' => $this->quotation,
                'quotationRequest' => $this->quotationRequest,
                'inspection' => $this->quotationRequest->inspection,
                'appointment' => $this->quotationRequest->inspection->appointment,
                'vehicle' => $this->quotationRequest->inspection->appointment->vehicle,
                'user' => $this->quotationRequest->inspection->appointment->vehicle->user,
                'provider' => $this->quotation->provider,
            ]
        );
    }
}
