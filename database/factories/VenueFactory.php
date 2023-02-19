<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'street' => $this->faker->streetName(),
        ];
    }
}
