<?php

namespace Database\Seeders;

use App\Enums\ProviderType;
use App\Models\Account;
use App\Models\City;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProviderSetupSeeder extends Seeder
{
    /**
     * Seed 10 providers for each provider type in Riyadh, each with their own user.
     */
    public function run(): void
    {
        // Ensure Riyadh city exists
        $riyadh = City::query()->firstOrCreate(
            ['name' => 'Riyadh'],
            ['name' => 'Riyadh']
        );
        
        $this->seedProvidersOfType($riyadh->id, ProviderType::VEHICLE_INSPECTION_CENTER);
        $this->seedProvidersOfType($riyadh->id, ProviderType::AUTO_REPAIR_WORKSHOP);
        $this->seedProvidersOfType($riyadh->id, ProviderType::SPARE_PARTS_SUPPLIER);
    }

    protected function seedProvidersOfType(string $cityId, ProviderType $type): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $companySlug = Str::slug(match ($type) {
                ProviderType::VEHICLE_INSPECTION_CENTER => 'Riyadh Vehicle Inspection Center',
                ProviderType::AUTO_REPAIR_WORKSHOP => 'Riyadh Auto Repair Workshop',
                ProviderType::SPARE_PARTS_SUPPLIER => 'Riyadh Spare Parts Supplier',
            });

            $providerName = match ($type) {
                ProviderType::VEHICLE_INSPECTION_CENTER => "Riyadh Vehicle Inspection Center #{$i}",
                ProviderType::AUTO_REPAIR_WORKSHOP => "Riyadh Auto Repair Workshop #{$i}",
                ProviderType::SPARE_PARTS_SUPPLIER => "Riyadh Spare Parts Supplier #{$i}",
            };

            $userName = match ($type) {
                ProviderType::VEHICLE_INSPECTION_CENTER => "Inspector {$i} Riyadh",
                ProviderType::AUTO_REPAIR_WORKSHOP => "Mechanic {$i} Riyadh",
                ProviderType::SPARE_PARTS_SUPPLIER => "Supplier {$i} Riyadh",
            };

            $userEmail = $companySlug . "-user{$i}@example.com";

            $user = User::query()->firstOrCreate(
                ['email' => $userEmail],
                [
                    'name' => $userName,
                    'email' => $userEmail,
                    'password' => bcrypt('password'),
                ]
            );

            $provider = Provider::create([
                'city_id' => $cityId,
                'name' => $providerName,
                'commercial_record' => 'CR-' . str_pad((string)($type->value[0] === 'v' ? 1 : ($type->value[0] === 'a' ? 2 : 3)) . $i, 3, '0', STR_PAD_LEFT),
                'mobile' => '+9665' . str_pad((string)random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'email' => $companySlug . ".{$i}@example.com",
                'location' => 'Riyadh',
                'type' => $type->value,
            ]);

            $account = Account::create([
                'accountable_id' => $provider->id,
                'accountable_type' => Provider::class,
            ]);

            if (!$user->current_account_id) {
                $user->current_account_id = $account->id;
                $user->save();
            }
        }
    }

}


