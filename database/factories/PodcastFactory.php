<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PodcastFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'link' => $this->faker->word(),
            'data' => '{}',
        ];
    }
}
