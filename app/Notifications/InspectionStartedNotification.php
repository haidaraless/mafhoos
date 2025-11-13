<?php

namespace App\Notifications;

use App\Models\Inspection;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InspectionStartedNotification extends Notification
{
    use Queueable;

    public function __construct(protected Inspection $inspection)
    {
    }

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray(mixed $notifiable): array
    {
        $inspection = $this->inspection->loadMissing('appointment');

        return [
            'title' => 'Inspection started',
            'body' => sprintf(
                'Inspection %s has started for your vehicle.',
                $inspection->number ?? optional($inspection->appointment)->number ?? 'N/A'
            ),
            'reference' => [
                'inspection_id' => $inspection->id,
                'appointment_id' => $inspection->appointment_id,
            ],
            'action_url' => route('inspections.view', $inspection->id),
            'icon' => 'phosphor-clipboard-text',
        ];
    }
}

