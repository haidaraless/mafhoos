<?php

namespace Database\Seeders;

use App\Enums\AccountType;
use App\Enums\ProviderType;
use App\Models\Account;
use App\Models\City;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProviderSetupSeeder extends Seeder
{
    /**
     * Seed 5 different demo providers in Riyadh, each with their own user.
     */
    public function run(): void
    {
        // Ensure Riyadh city exists
        $riyadh = City::query()->firstOrCreate(
            ['name' => 'Riyadh'],
            ['name' => 'Riyadh']
        );

        // Demo providers data - all in Riyadh
        $providersData = [
            [
                'name' => 'Al-Riyadh Vehicle Inspection Center',
                'commercial_record' => 'CR-001',
                'mobile' => '+966501234567',
                'email' => 'riyadh.inspection@example.com',
                'location' => 'King Fahd Road, Riyadh',
                'type' => ProviderType::VEHICLE_INSPECTION_CENTER,
                'account_type' => AccountType::VEHICLE_INSPECTION_CENTER,
                'user_name' => 'Ahmed Al-Rashid',
                'user_email' => 'ahmed.rashid@example.com',
            ],
            [
                'name' => 'Riyadh Auto Repair Workshop',
                'commercial_record' => 'CR-002',
                'mobile' => '+966502345678',
                'email' => 'riyadh.repair@example.com',
                'location' => 'Al-Hamra District, Riyadh',
                'type' => ProviderType::AUTO_REPAIR_WORKSHOP,
                'account_type' => AccountType::AUTO_REPAIR_WORKSHOP,
                'user_name' => 'Mohammed Al-Sheikh',
                'user_email' => 'mohammed.sheikh@example.com',
            ],
            [
                'name' => 'Riyadh Spare Parts Supplier',
                'commercial_record' => 'CR-003',
                'mobile' => '+966503456789',
                'email' => 'riyadh.spareparts@example.com',
                'location' => 'Industrial Area, Riyadh',
                'type' => ProviderType::SPARE_PARTS_SUPPLIER,
                'account_type' => AccountType::SPARE_PARTS_SUPPLIER,
                'user_name' => 'Omar Al-Mansouri',
                'user_email' => 'omar.mansouri@example.com',
            ],
            [
                'name' => 'Riyadh Vehicle Services',
                'commercial_record' => 'CR-004',
                'mobile' => '+966504567890',
                'email' => 'riyadh.services@example.com',
                'location' => 'Al-Aziziyah District, Riyadh',
                'type' => ProviderType::VEHICLE_INSPECTION_CENTER,
                'account_type' => AccountType::VEHICLE_INSPECTION_CENTER,
                'user_name' => 'Khalid Al-Zahrani',
                'user_email' => 'khalid.zahrani@example.com',
            ],
            [
                'name' => 'Riyadh Auto Center',
                'commercial_record' => 'CR-005',
                'mobile' => '+966505678901',
                'email' => 'riyadh.autocenter@example.com',
                'location' => 'Quba District, Riyadh',
                'type' => ProviderType::AUTO_REPAIR_WORKSHOP,
                'account_type' => AccountType::AUTO_REPAIR_WORKSHOP,
                'user_name' => 'Saeed Al-Ghamdi',
                'user_email' => 'saeed.ghamdi@example.com',
            ],
        ];

        foreach ($providersData as $providerData) {
            // Create a new user for this provider
            $user = User::query()->firstOrCreate(
                ['email' => $providerData['user_email']],
                [
                    'name' => $providerData['user_name'],
                    'email' => $providerData['user_email'],
                    'password' => bcrypt('password'), // Default password
                ]
            );

            // Create account for this user
            $account = Account::query()->firstOrCreate(
                [
                    'user_id' => $user->id,
                    'type' => $providerData['account_type']->value,
                ],
                []
            );

            // Set this account as current for the user
            if (!$user->current_account_id) {
                $user->current_account_id = $account->id;
                $user->save();
            }

            // Create provider
            Provider::query()->firstOrCreate(
                [ 'account_id' => $account->id ],
                [
                    'city_id' => $riyadh->id,
                    'name' => $providerData['name'],
                    'commercial_record' => $providerData['commercial_record'],
                    'mobile' => $providerData['mobile'],
                    'email' => $providerData['email'],
                    'location' => $providerData['location'],
                    'type' => $providerData['type']->value,
                ]
            );
        }
    }

}


