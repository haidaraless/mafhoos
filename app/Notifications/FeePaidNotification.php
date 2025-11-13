<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Models\Fee;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FeePaidNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Appointment $appointment,
        protected Fee $fee
    ) {
    }

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray(mixed $notifiable): array
    {
        $appointment = $this->appointment->refresh();
        $fee = $this->fee->refresh();

        return [
            'title' => 'Inspection fee paid',
            'body' => sprintf(
                'We received SAR %s for inspection %s.',
                number_format((float) $fee->amount, 2),
                $appointment->number
            ),
            'reference' => [
                'appointment_id' => $appointment->id,
                'fee_id' => $fee->id,
            ],
            'action_url' => route('appointments.fees.success', [
                'appointment' => $appointment->id,
                'fee' => $fee->id,
            ]),
            'icon' => 'phosphor-wallet',
        ];
    }
}

