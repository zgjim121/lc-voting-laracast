<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 20),
            'category_id' => fake()->numberBetween(1, 4),
            'status_id' => fake()->numberBetween(1, 5),
            'title' => ucwords(fake()->words(4, true)),
            'description' => fake()->paragraph(5),

        ];
    }
}
