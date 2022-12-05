<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Lecturer;
use App\Models\Library;
use App\Models\LibraryItems;

class LibraryItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LibraryItems::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'lecturer_id' => Lecturer::factory(),
            'library_id' => Library::factory(),
            'order_column' => $this->faker->randomNumber(),
            'type' => $this->faker->word,
            'value' => $this->faker->text,
        ];
    }
}
