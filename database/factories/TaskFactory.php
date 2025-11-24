<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $difficulties = ["Easy", "Medium", "Hard", "Very Hard"];
        $difficulty = $difficulties[array_rand($difficulties)];
        $coin_value = 0;
        if ($difficulty == 'Easy') {
            $coin_value = 50;
        } elseif ($difficulty == 'Medium') {
            $coin_value = 100;
        } elseif ($difficulty == 'Hard') {
            $coin_value = 150;
        } elseif ($difficulty == 'Very Hard') {
            $coin_value = 200;
        }
        
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->optional(0.5)->word(),
            'difficulty' => $difficulty,
            'coin_value' => $coin_value,
            'complete_status' => false,
            'repeats' => false,
        ];
    }
}
