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
     * Seed an account and provider for user with id 1.
     */
    public function run(): void
    {
        $user = User::find(1);
        if (!$user) {
            return; // nothing to do if user 1 does not exist
        }

        // Ensure there is at least one city to attach the provider to
        $city = City::query()->first();
        if (!$city) {
            $city = City::query()->create([ 'name' => 'Riyadh' ]);
        }

        // Create or fetch an account for this user (provider-type account)
        $account = Account::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'type' => AccountType::VEHICLE_INSPECTION_CENTER->value,
            ],
            []
        );

        // Create provider if it does not exist for this account
        $provider = Provider::query()->firstOrCreate(
            [ 'account_id' => $account->id ],
            [
                'city_id' => $city->id,
                'name' => 'Demo Provider',
                'commercial_record' => 'CR-0001',
                'mobile' => '+96550000000',
                'email' => 'provider@example.com',
                'location' => null,
                'type' => ProviderType::VEHICLE_INSPECTION_CENTER->value,
            ]
        );

        // Set as current account for the user if not already set
        if (!$user->current_account_id) {
            $user->current_account_id = $account->id;
            $user->save();
        }
    }
}


