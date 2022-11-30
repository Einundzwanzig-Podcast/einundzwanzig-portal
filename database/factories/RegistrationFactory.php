<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;

class RegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Registration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'participant_id' => Participant::factory(),
            'active' => $this->faker->boolean,
        ];
    }
}
