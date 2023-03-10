<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProjectProposal;
use App\Models\User;
use App\Models\Vote;

class VoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vote::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'project_proposal_id' => ProjectProposal::factory(),
            'value' => $this->faker->randomNumber(),
            'reason' => $this->faker->text,
        ];
    }
}
