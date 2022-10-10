<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $productName = fake()->regexify('[A-Z][A-Z][A-Z]');
        return [
            'product_id'     => $productName,
            'product_name'   => 'Sản Phẩm '.$productName,
            'product_image'  => fake()->text(10),
            'product_price' => fake()->randomFloat(2, 0, 100),
            'is_sales'      => fake()->numberBetween($min = 0, $max = 1),
            'description'   => 'Chức năng sản phẩm '.$productName,
            'created_at'     => fake()->dateTimeBetween($startDate = '-5 years', $endDate = '-1 years', $timezone = null),
            'updated_at'     => fake()->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        ];
    }
}
