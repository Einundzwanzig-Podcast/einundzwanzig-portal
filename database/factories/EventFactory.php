<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'venue_id' => Venue::factory(),
            'from' => $this->faker->dateTime(),
            'to' => $this->faker->dateTime(),
        ];
    }
}
