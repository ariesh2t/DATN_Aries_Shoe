<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductInforFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(1, 30),
            'color_id' => rand(1, 10),
            'size_id' => rand(1, 10),
            'quantity' => rand(1, 100),
        ];
    }
}
