<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->word,
            'price' => $this->faker->numberBetween(100, 10000),
            'image' => 'default.jpg',
            'description' => $this->faker->sentence,
            'user_id' => User::factory(),
            'buyer_id' => null,
            'condition' => $this->faker->randomElement([
                '良好',
                '目立った傷や汚れなし',
                'やや傷や汚れあり',
                '状態が悪い',
            ]),
            'is_sold' => $this->faker->boolean(20), 
        ];
    } 
}