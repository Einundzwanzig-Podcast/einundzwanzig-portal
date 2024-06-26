<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
        ];
    }
}
