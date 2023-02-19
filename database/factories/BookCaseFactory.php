<?php

namespace Database\Factories;

use App\Models\BookCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookCaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookCase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'lat' => $this->faker->latitude(),
            'lon' => '{}',
            'address' => $this->faker->text(),
            'type' => $this->faker->word(),
            'open' => $this->faker->word(),
            'comment' => $this->faker->text(),
            'contact' => $this->faker->text(),
            'bcz' => $this->faker->text(),
            'digital' => $this->faker->boolean(),
            'icontype' => $this->faker->word(),
            'deactivated' => $this->faker->boolean(),
            'deactreason' => $this->faker->word(),
            'entrytype' => $this->faker->word(),
            'homepage' => $this->faker->word(),
        ];
    }
}
