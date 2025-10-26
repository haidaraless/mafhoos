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
        return [
            'user_id' => \App\Models\User::factory(),
            'vin' => $this->faker->regexify('[A-HJ-NPR-Z0-9]{17}'),
            'make' => $this->faker->randomElement(['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes', 'Audi']),
            'model' => $this->faker->word(),
            'year' => $this->faker->numberBetween(1990, 2024),
            'color' => $this->faker->colorName(),
            'plate_number' => $this->faker->regexify('[A-Z]{3}[0-9]{4}'),
        ];
    }
}
