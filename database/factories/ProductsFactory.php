<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductsFactory extends Factory
{
    protected $model = Products::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Schema::disableForeignKeyConstraints();
        // Schema::enableForeignKeyConstraints();
        return [
            'name'            => fake()->name,
            'content'         => fake()->text(100),
            'price'           => fake()->numberBetween($min = 1000, $max = 1000000000),
            'product_cat_id ' => fake()->numberBetween($min = 1, $max = 1000000000),
            'user_id '        => fake()->numberBetween($min = 1, $max = 1000000000),
            'created_at'      => fake()->dateTimeBetween($startDate = '-30 years', $endDate = '-5 years', $timezone = null),
            'updated_at'      => fake()->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null),
        ];
    }
}
