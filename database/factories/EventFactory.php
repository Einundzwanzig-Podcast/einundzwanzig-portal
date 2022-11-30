<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Event;
use App\Models\Venue;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

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
