<?php

namespace AmaizingCompany\CannaleoClient\Database\Factories;

use AmaizingCompany\CannaleoClient\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Akaunting\Money\Money;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'pharmacy_id' => Pharmacy::factory(),
            'external_id' => fake()->uuid(),
            'name' => 'Test Product',
            'genetic' => 'Sativa',
            'country' => fake()->country(),
            'thc' => fake()->randomFloat(max: 100),
            'cbd' => fake()->randomFloat(max: 100),
            'available' => fake()->boolean(),
            'price' => Money::EUR(fake()->randomNumber()),
            'category' => 'flower',
            'manufacturer' => fake()->company(),
            'grower' => fake()->company(),
            'dominance' => null,
            'irradiated' => fake()->boolean(),
            'strain' => 'Bafokeng Choice',
        ];
    }
}
