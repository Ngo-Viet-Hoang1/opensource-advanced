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
            'category_id' => Category::factory(),
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'sale_price' => fake()->randomFloat(2, 10, 1000),
            'stock' => fake()->numberBetween(10, 100),
            'description' => fake()->paragraph(),
            'image' => 'https://picsum.photos/seed/123abc/1600/1200',
            'is_active' => fake()->boolean(),
            'is_delete' => false,
        ];
    }
}
