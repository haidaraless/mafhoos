<?php

namespace App\Enums;

enum QuotationType: string
{
    case SPARE_PARTS = 'spare-parts';
    case REPAIR = 'repair';
}