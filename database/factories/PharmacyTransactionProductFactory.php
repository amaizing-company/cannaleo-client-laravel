<?php

namespace AmaizingCompany\CannaleoClient\Database\Factories;

use Akaunting\Money\Money;
use AmaizingCompany\CannaleoClient\Models\PharmacyTransaction;
use AmaizingCompany\CannaleoClient\Models\PharmacyTransactionProduct;
use AmaizingCompany\CannaleoClient\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyTransactionProductFactory extends Factory
{
    protected $model = PharmacyTransactionProduct::class;

    public function definition()
    {
        return [
            'pharmacy_transaction_id' => PharmacyTransaction::factory(),
            'product_id' => Product::factory(),
            'price' => fake()->randomNumber(),
        ];
    }
}
