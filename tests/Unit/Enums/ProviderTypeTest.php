<?php

use App\Enums\ProviderType;

test('provider type enum has all expected cases', function () {
    expect(ProviderType::cases())->toHaveCount(3);
});

test('provider type enum values are correct', function () {
    expect(ProviderType::SPARE_PARTS_SUPPLIER->value)->toBe('spare-parts-supplier')
        ->and(ProviderType::AUTO_REPAIR_WORKSHOP->value)->toBe('auto-repair-workshop')
        ->and(ProviderType::VEHICLE_INSPECTION_CENTER->value)->toBe('vehicle-inspection-center');
});
