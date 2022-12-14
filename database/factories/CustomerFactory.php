<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->regexify('[A-Z][A-Z][A-Z]');
        $address = ['1 Điện Biên Phủ, quận Bình Thạnh, Tp.HCM', '2 Ba Tháng Hai, quận 10, Tp.HCM', '3 Nguyễn Thị Thập, quận 7, Tp.HCM'];
        return [
            'customer_name' => 'Nguyễn Văn '.$name,
            'email' => 'nguyenvan'.$name.'@gmail.com',
            'tel_num' => fake()->randomNumber(9, true),
            'address' => fake()->randomElement($address),
            'is_active' => fake()->numberBetween($min = 0, $max = 1),
            'created_at'     => fake()->dateTimeBetween($startDate = '-5 years', $endDate = '-1 years', $timezone = null),
            'updated_at'     => fake()->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        ];
    }
}
