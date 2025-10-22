<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\Fee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment,
        public Fee $fee
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Confirmed - Vehicle Inspection',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-confirmation',
            with: [
                'appointment' => $this->appointment,
                'fee' => $this->fee,
                'inspectionPrice' => $this->fee->amount,
            ]
        );
    }
}
