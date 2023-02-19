<?php

namespace Database\Factories;

use App\Models\Lecturer;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class LecturerFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'active' => $this->faker->boolean(),
        ];
    }
}
