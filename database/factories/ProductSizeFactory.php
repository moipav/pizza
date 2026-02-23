<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSize>
 */
class ProductSizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'size_name' => $this->faker->randomElement(['Маленькая', 'Средняя', 'Большая']),
            'size_value' => $this->faker->numberBetween(1, 100),
            'unit' => 'cm',
            'price_adjustment' => $this->faker->randomFloat(2, 0, 250),
        ];
    }

}
