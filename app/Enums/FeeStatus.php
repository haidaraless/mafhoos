<?php

namespace App\Enums;

enum FeeStatus: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case REFUNDED = 'refunded';
}