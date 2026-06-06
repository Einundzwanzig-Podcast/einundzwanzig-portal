<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseEventFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $from = $this->faker->dateTimeBetween('+1 week', '+2 months');

        return [
            'course_id' => Course::factory(),
            'venue_id' => Venue::factory(),
            'from' => $from,
            'to' => (clone $from)->modify('+3 hours'),
            'link' => $this->faker->url(),
        ];
    }
}
