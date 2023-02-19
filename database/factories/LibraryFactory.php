<?php

namespace Database\Factories;

use App\Models\Library;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibraryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'language_code' => $this->faker->word(),
        ];
    }
}
