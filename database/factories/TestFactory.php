<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'created_at'      => fake()->dateTimeBetween($startDate = '-30 years', $endDate = '-5 years', $timezone = null),
            'updated_at'      => fake()->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null),
        ];
    }
}
