<?php

namespace Database\Factories;

use App\Models\BitcoinEvent;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class BitcoinEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BitcoinEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'venue_id' => Venue::factory(),
            'from' => $this->faker->dateTime(),
            'to' => $this->faker->dateTime(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'link' => $this->faker->word(),
        ];
    }
}
