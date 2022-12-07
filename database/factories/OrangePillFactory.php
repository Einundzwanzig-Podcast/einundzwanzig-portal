<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\BookCase;
use App\Models\OrangePill;
use App\Models\User;

class OrangePillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrangePill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_case_id' => BookCase::factory(),
            'date' => $this->faker->dateTime(),
            'amount' => $this->faker->randomNumber(),
        ];
    }
}
