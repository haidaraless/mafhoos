<?php

namespace App\Enums;

enum ProviderType: string
{
    case SPARE_PARTS_SUPPLIER = 'spare-parts-supplier';
    case AUTO_REPAIR_WORKSHOP = 'auto-repair-workshop';
    case VEHICLE_INSPECTION_CENTER = 'vehicle-inspection-center';
}