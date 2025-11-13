<?php

namespace App\Services;

use App\Enums\InspectionType;

class InspectionFeeService
{
    /**
     * Get the price for an inspection type
     *
     * @param InspectionType|string|null $inspectionType
     * @return float
     */
    public function getInspectionPrice($inspectionType): float
    {
        if (!$inspectionType) {
            return 0.00;
        }

        $type = is_string($inspectionType) ? InspectionType::from($inspectionType) : $inspectionType;
        
        return match ($type) {
            InspectionType::UNDERCARRIAGE_INSPECTION => 150.00,
            InspectionType::ENGINE_INSPECTION => 200.00,
            InspectionType::COMPREHENSIVE_INSPECTION => 300.00,
        };
    }
}

