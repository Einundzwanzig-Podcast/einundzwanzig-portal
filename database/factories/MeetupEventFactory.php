<?php

namespace Database\Factories;

use App\Models\Meetup;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetupEventFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'meetup_id' => Meetup::factory(),
            'date' => $this->faker->date(),
            'start' => $this->faker->time(),
            'end' => $this->faker->time(),
            'location' => $this->faker->word(),
            'description' => $this->faker->text(),
            'link' => $this->faker->word(),
        ];
    }
}
