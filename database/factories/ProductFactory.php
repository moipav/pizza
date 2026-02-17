<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::query()->inRandomOrder()->first(),
            'name' => fake()->unique()->firstName,
            'description' => fake()->text(100),
            'image' => fake()->imageUrl(640, 480, 'animals', true),
            'price' => fake()->randomNumber(4, false)
        ];
    }
}
