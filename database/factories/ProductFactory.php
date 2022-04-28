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
        $cost = rand(300000, 2000000);
        return [
            'name' => $this->faker->unique()->text(10),
            'cost' => $cost,
            'price' => $cost * rand(14, 17) / 10,
            'promotion' => $cost * rand(10, 14) / 10,
            'desc' => $this->faker->text(200),
            'category_id' => rand(1, 20),
            'brand_id' => rand(1, 20),
        ];
    }
}
