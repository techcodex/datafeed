<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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
        return  [
            'entity_id' => $this->faker->randomNumber(),
            'sku' => fake()->word(),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'shortdesc' => fake()->sentence,
            'price' => fake()->randomFloat(2, 0, 100),
            'link' => fake()->url,
            'image' => fake()->imageUrl(),
            'rating' => fake()->numberBetween(1, 5), // Assuming rating is an integer between 1 and 5
            'caffine_type' => fake()->word,
            'count' => fake()->randomNumber(),
            'flavored' => fake()->randomElement([Product::IS_FLAVOURED_NO, Product::IS_FLAVOURED_YES]),
            'seasonal' => fake()->randomElement([Product::IS_SEASONAL_NO, Product::IS_SEASONAL_YES]),
            'instock' => fake()->randomElement([Product::IS_INSTOCK_NO, Product::IS_INSTOCK_YES]),
            'facebook' => fake()->numberBetween(0, 1), // Assuming it's a boolean-like field
            'is_k_cup' => fake()->randomElement([Product::IS_K_CUP_NO, Product::IS_K_CUP_YES]),
            'category_id' => function(){
                return Category::factory()->create()->id;
            },
            'brand_id' => function(){
                return Brand::factory()->create()->id;
            },
        ];
    }
}
