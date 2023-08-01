<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
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
        Product::truncate();

        $name = fake()->word;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => fake()->numberBetween(500,10000),
            'quantity' => fake()->numberBetween(0,10),
            'uom' => fake()->randomElement(['cm', 'inch', 'kgs']),
        ];
    }
}
