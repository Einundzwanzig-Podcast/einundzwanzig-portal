<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Lecturer;
use App\Models\Team;

class LecturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecturer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'active' => $this->faker->boolean,
        ];
    }
}
