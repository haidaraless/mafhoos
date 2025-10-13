<?php

namespace App\Enums;

enum AccountType: string
{
    case VEHICLE_INSPECTION_CENTER = 'vehicle-inspection-center';
    case AUTO_REPAIR_WORKSHOP = 'auto-repair-workshop';
    case SPARE_PARTS_SUPPLIER = 'spare-parts-supplier';
    case VEHICLE_OWNER = 'vehicle-owner';
}