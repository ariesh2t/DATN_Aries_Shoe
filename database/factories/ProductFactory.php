<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->unique()->text(10),
            'cost' => rand(300000, 2000000),
            'price' => rand(300000, 2000000),
            'promotion' => rand(300000, 2000000),
            'desc' => $this->faker->text(200),
            'category_id' => rand(1, 20),
            'brand_id' => rand(1, 20),
        ];
    }
}
