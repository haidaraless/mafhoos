<?php

namespace App\Enums;

enum QuotationRequestStatus: string
{
    case DRAFT = 'draft';
    case OPEN = 'open';
    case PENDING = 'pending';
    case QUOTED = 'quoted';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';
}