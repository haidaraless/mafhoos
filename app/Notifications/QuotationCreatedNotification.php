<?php

namespace App\Notifications;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class QuotationCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(protected Quotation $quotation)
    {
    }

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray(mixed $notifiable): array
    {
        $quotation = $this->quotation->loadMissing('quotationRequest.inspection.appointment');
        $typeLabel = Str::headline(str_replace('_', ' ', $quotation->type->value ?? $quotation->type));

        return [
            'title' => sprintf('%s quotation drafted', $typeLabel),
            'body' => sprintf(
                'A %s quotation draft is ready for inspection %s.',
                strtolower($typeLabel),
                optional($quotation->quotationRequest?->inspection?->appointment)->number ?? 'N/A'
            ),
            'reference' => [
                'quotation_id' => $quotation->id,
                'quotation_request_id' => $quotation->quotation_request_id,
                'type' => $quotation->type?->value ?? $quotation->type,
            ],
            'action_url' => route('quotation-requests.view', $quotation->quotation_request_id),
            'icon' => 'phosphor-file-text',
        ];
    }
}

