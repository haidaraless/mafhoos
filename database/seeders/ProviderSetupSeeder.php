<?php

namespace Database\Seeders;

use App\Enums\ProviderType;
use App\Models\Account;
use App\Models\City;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProviderSetupSeeder extends Seeder
{
    public function run(): void
    {
        $providersByType = [
            ProviderType::VEHICLE_INSPECTION_CENTER->value => [
                [
                    'name' => 'Taqdeer Assessment Center - Riyadh Industrial',
                    'city' => 'Riyadh',
                    'location' => 'Second Industrial City, Riyadh',
                    'commercial_record' => '1010456789',
                    'mobile' => '+966920000460',
                    'email' => 'riyadh-industrial@taqdeer.sa',
                    'user' => [
                        'name' => 'Salman Al-Harbi',
                        'email' => 'salman.alharbi@taqdeer.sa',
                    ],
                ],
                [
                    'name' => 'Taqdeer Assessment Center - Jeddah Prince Sultan',
                    'city' => 'Jeddah',
                    'location' => 'Prince Sultan Road, Al-Shati District',
                    'commercial_record' => '4030456789',
                    'mobile' => '+966920000460',
                    'email' => 'jeddah-prince-sultan@taqdeer.sa',
                    'user' => [
                        'name' => 'Nasser Al-Qahtani',
                        'email' => 'nasser.alqahtani@taqdeer.sa',
                    ],
                ],
                [
                    'name' => 'Motor Vehicle Periodic Inspection - Malaz',
                    'city' => 'Riyadh',
                    'location' => 'Al Malaz District, Riyadh',
                    'commercial_record' => '1010234567',
                    'mobile' => '+966920000356',
                    'email' => 'malaz@mvpi.gov.sa',
                    'user' => [
                        'name' => 'Hassan Al-Mutairi',
                        'email' => 'hassan.almutairi@mvpi.gov.sa',
                    ],
                ],
                [
                    'name' => 'Motor Vehicle Periodic Inspection - Jeddah Al-Marwah',
                    'city' => 'Jeddah',
                    'location' => 'Al Marwah District, Jeddah',
                    'commercial_record' => '4030234567',
                    'mobile' => '+966920000356',
                    'email' => 'jeddah-almarwah@mvpi.gov.sa',
                    'user' => [
                        'name' => 'Omar Al-Shehri',
                        'email' => 'omar.alshehri@mvpi.gov.sa',
                    ],
                ],
                [
                    'name' => 'Saudi Automotive Inspection Company - Dammam',
                    'city' => 'Dammam',
                    'location' => 'King Saud Road, Dammam',
                    'commercial_record' => '2050234567',
                    'mobile' => '+966138345000',
                    'email' => 'dammam@saic.com.sa',
                    'user' => [
                        'name' => 'Majed Al-Otaibi',
                        'email' => 'majed.alotaibi@saic.com.sa',
                    ],
                ],
            ],
            ProviderType::AUTO_REPAIR_WORKSHOP->value => [
                [
                    'name' => 'Petromin Express - Riyadh Anas Bin Malik',
                    'city' => 'Riyadh',
                    'location' => 'Anas Bin Malik Road, Riyadh',
                    'commercial_record' => '1010123456',
                    'mobile' => '+966920006271',
                    'email' => 'riyadh-anas@petrominexpress.com.sa',
                    'user' => [
                        'name' => 'Faisal Al-Dossary',
                        'email' => 'faisal.aldossary@petromin.com.sa',
                    ],
                ],
                [
                    'name' => 'Aljomaih Automotive Service Center - Jeddah',
                    'city' => 'Jeddah',
                    'location' => 'Madinah Road, Jeddah',
                    'commercial_record' => '4030123456',
                    'mobile' => '+966126522000',
                    'email' => 'jeddah-service@aljomaih.com',
                    'user' => [
                        'name' => 'Saad Al-Suwailem',
                        'email' => 'saad.alsuwailem@aljomaih.com',
                    ],
                ],
                [
                    'name' => 'Abdul Latif Jameel Lexus Service Center - Riyadh',
                    'city' => 'Riyadh',
                    'location' => 'Eastern Ring Road, Riyadh',
                    'commercial_record' => '1010567890',
                    'mobile' => '+966920027709',
                    'email' => 'riyadh-lexus@alj.com',
                    'user' => [
                        'name' => 'Yazeed Al-Harbi',
                        'email' => 'yazeed.alharbi@alj.com',
                    ],
                ],
                [
                    'name' => 'Alissa Auto Service Center - Dammam',
                    'city' => 'Dammam',
                    'location' => 'Prince Naif Road, Dammam',
                    'commercial_record' => '2050123456',
                    'mobile' => '+966138470700',
                    'email' => 'dammam-service@alissa-auto.com.sa',
                    'user' => [
                        'name' => 'Talal Al-Anazi',
                        'email' => 'talal.alanazi@alissa-auto.com.sa',
                    ],
                ],
                [
                    'name' => 'Motorworks Garage - Khobar',
                    'city' => 'Khobar',
                    'location' => 'Prince Faisal Bin Fahd Road, Al Khobar',
                    'commercial_record' => '2050678901',
                    'mobile' => '+966138999221',
                    'email' => 'khobar@motorworks.sa',
                    'user' => [
                        'name' => 'Ibrahim Al-Zahrani',
                        'email' => 'ibrahim.alzahrani@motorworks.sa',
                    ],
                ],
            ],
            ProviderType::SPARE_PARTS_SUPPLIER->value => [
                [
                    'name' => 'Abdul Latif Jameel Spare Parts - Jeddah',
                    'city' => 'Jeddah',
                    'location' => 'Al Haramain Road, Jeddah',
                    'commercial_record' => '4030456123',
                    'mobile' => '+966920002727',
                    'email' => 'jeddah@aljspareparts.com',
                    'user' => [
                        'name' => 'Mohammed Al-Amri',
                        'email' => 'mohammed.alamri@aljspareparts.com',
                    ],
                ],
                [
                    'name' => 'ACDelco Parts Center - Riyadh',
                    'city' => 'Riyadh',
                    'location' => 'Al Qassim Road, Riyadh',
                    'commercial_record' => '1010789456',
                    'mobile' => '+966112911700',
                    'email' => 'riyadh@acdelco-sa.com',
                    'user' => [
                        'name' => 'Bandar Al-Shammari',
                        'email' => 'bandar.alshammari@acdelco-sa.com',
                    ],
                ],
                [
                    'name' => 'Universal Motors Agencies Parts - Dammam',
                    'city' => 'Dammam',
                    'location' => 'King Saud Street, Dammam',
                    'commercial_record' => '2050789456',
                    'mobile' => '+966138474000',
                    'email' => 'dammam@uma.com.sa',
                    'user' => [
                        'name' => 'Mansour Al-Naim',
                        'email' => 'mansour.alnaim@uma.com.sa',
                    ],
                ],
                [
                    'name' => 'Saudi Parts Center - Riyadh Exit 18',
                    'city' => 'Riyadh',
                    'location' => 'Southern Ring Road, Exit 18, Riyadh',
                    'commercial_record' => '1010789345',
                    'mobile' => '+966114950000',
                    'email' => 'exit18@saudiparts.com.sa',
                    'user' => [
                        'name' => 'Khaled Al-Juhani',
                        'email' => 'khaled.aljuhani@saudiparts.com.sa',
                    ],
                ],
                [
                    'name' => 'Gulf Star Spare Parts - Khobar',
                    'city' => 'Khobar',
                    'location' => 'King Abdullah Street, Al Khobar',
                    'commercial_record' => '2050334987',
                    'mobile' => '+966138869900',
                    'email' => 'khobar@gulfstarparts.sa',
                    'user' => [
                        'name' => 'Rami Al-Mutlaq',
                        'email' => 'rami.almutlaq@gulfstarparts.sa',
                    ],
                ],
            ],
        ];

        $cityIds = [];

        foreach ($providersByType as $providers) {
            foreach ($providers as $providerData) {
                $cityName = $providerData['city'];

                if (! isset($cityIds[$cityName])) {
                    $city = City::query()->firstOrCreate(
                        ['name' => $cityName],
                        ['name' => $cityName]
                    );

                    $cityIds[$cityName] = $city->id;
                }
            }
        }

        foreach ($providersByType as $typeValue => $providers) {
            $providerType = ProviderType::from($typeValue);

            foreach ($providers as $providerData) {
                $user = User::query()->firstOrCreate(
                    ['email' => $providerData['user']['email']],
                    [
                        'name' => $providerData['user']['name'],
                        'email' => $providerData['user']['email'],
                        'password' => bcrypt('password'),
                    ]
                );

                $provider = Provider::query()->updateOrCreate(
                    [
                        'name' => $providerData['name'],
                        'type' => $providerType->value,
                    ],
                    [
                        'city_id' => $cityIds[$providerData['city']],
                        'commercial_record' => $providerData['commercial_record'],
                        'mobile' => $providerData['mobile'],
                        'email' => $providerData['email'],
                        'location' => $providerData['location'],
                        'type' => $providerType->value,
                    ]
                );

                $account = Account::query()->firstOrCreate([
                    'accountable_id' => $provider->id,
                    'accountable_type' => Provider::class,
                ]);

                if (! $user->current_account_id) {
                    $user->current_account_id = $account->id;
                    $user->save();
                }
            }
        }
    }
}

