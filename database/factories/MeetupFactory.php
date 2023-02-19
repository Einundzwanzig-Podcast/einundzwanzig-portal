<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Meetup;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetupFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'name' => $this->faker->name(),
            'link' => $this->faker->word(),
        ];
    }
}
