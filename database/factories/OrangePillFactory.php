<?php

namespace Database\Factories;

use App\Models\BookCase;
use App\Models\OrangePill;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrangePillFactory extends Factory
{
    /**
     * Define the model's default state.
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
