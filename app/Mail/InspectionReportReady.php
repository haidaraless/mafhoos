<?php

namespace App\Mail;

use App\Models\Inspection;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InspectionReportReady extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Inspection $inspection,
        public Appointment $appointment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vehicle Inspection Report Ready - ' . $this->appointment->vehicle->make . ' ' . $this->appointment->vehicle->model,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inspection-report-ready',
            with: [
                'inspection' => $this->inspection,
                'appointment' => $this->appointment,
                'vehicle' => $this->appointment->vehicle,
                'user' => $this->appointment->vehicle->user,
            ]
        );
    }
}
