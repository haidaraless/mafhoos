<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => \App\Models\Account::factory(),
            'city_id' => 1, // Assuming city with ID 1 exists
            'name' => $this->faker->company(),
            'commercial_record' => $this->faker->numerify('########'),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'location' => $this->faker->address(),
            'type' => $this->faker->randomElement(['vehicle-inspection-center', 'auto-repair-workshop', 'spare-parts-supplier']),
        ];
    }
}
