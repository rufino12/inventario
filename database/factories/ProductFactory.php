<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->bothify('?###??##'),
            'name' => $this->faker->unique()->sentence(3),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'amount' => $this->faker->randomNumber(),
            'status' => $this->faker->boolean()
        ];
    }
}
