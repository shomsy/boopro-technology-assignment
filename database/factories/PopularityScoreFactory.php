<?php

namespace Database\Factories;

use App\Models\PopularityScore;
use Illuminate\Database\Eloquent\Factories\Factory;

class PopularityScoreFactory extends Factory
{
    protected $model = PopularityScore::class;

    public function definition()
    {
        return [
            'term' => $this->faker->word(),
            'source_type' => 'github', // TODO: Upgrade later
            'score' => $this->faker->numberBetween(0, 100),
            'positive_count' => $this->faker->numberBetween(0, 100),
            'negative_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
