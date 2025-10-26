<?php

namespace App\Enums;

enum InspectionType: string
{
    case UNDERCARRIAGE_INSPECTION = 'undercarriage-inspection';
    case ENGINE_INSPECTION = 'engine-inspection';
    case COMPREHENSIVE_INSPECTION = 'comprehensive-inspection';
}