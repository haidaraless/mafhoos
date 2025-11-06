<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $make = $this->faker->randomElement(['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes', 'Audi']);
        $model = $this->faker->word();
        $year = (string) $this->faker->numberBetween(1990, 2024);

        return [
            'user_id' => \App\Models\User::factory(),
            'vin' => $this->faker->regexify('[A-HJ-NPR-Z0-9]{17}'),
            'name' => "$make $model $year",
            'model' => $model,
            'year' => $year,
            'make' => $make,
        ];
    }
}
