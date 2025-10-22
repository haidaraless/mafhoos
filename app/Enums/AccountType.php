<?php

namespace App\Enums;

enum AccountType: string
{
    case VEHICLE_OWNER = 'vehicle-owner';
    case PROVIDER = 'provider';
}