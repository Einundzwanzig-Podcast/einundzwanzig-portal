<?php

namespace Database\Factories;

use App\Models\Episode;
use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'podcast_id' => Podcast::factory(),
            'data' => '{}',
        ];
    }
}
