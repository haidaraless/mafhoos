<?php

namespace App\Notifications;

use App\Enums\QuotationType;
use App\Models\QuotationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class QuotationRequestCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(protected QuotationRequest $quotationRequest)
    {
    }

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray(mixed $notifiable): array
    {
        $quotationRequest = $this->quotationRequest->loadMissing('inspection.appointment');
        $type = $quotationRequest->type instanceof QuotationType
            ? $quotationRequest->type->value
            : $quotationRequest->type;

        $typeLabel = Str::headline(str_replace('_', ' ', $type));

        return [
            'title' => sprintf('%s quotation request created', $typeLabel),
            'body' => sprintf(
                'We opened a new %s quotation request for inspection %s.',
                strtolower($typeLabel),
                optional($quotationRequest->inspection?->appointment)->number ?? 'N/A'
            ),
            'reference' => [
                'quotation_request_id' => $quotationRequest->id,
                'inspection_id' => $quotationRequest->inspection_id,
                'type' => $type,
            ],
            'action_url' => route('quotation-requests.view', $quotationRequest->id),
            'icon' => $type === QuotationType::SPARE_PARTS->value
                ? 'phosphor-wrench-screwdriver'
                : 'phosphor-wrench',
        ];
    }
}

