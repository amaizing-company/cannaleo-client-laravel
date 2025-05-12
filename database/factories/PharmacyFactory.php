<?php

namespace AmaizingCompany\CannaleoClient\Database\Factories;

use AmaizingCompany\CannaleoClient\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyFactory extends Factory
{
    protected $model = Pharmacy::class;

    public function definition()
    {
        $pharmacyName = fake()->company();
        $hasShipping = fake()->boolean();
        $hasExpress = fake()->boolean();
        $hasLocalCourier = fake()->boolean();
        $hasPickup = fake()->boolean();

        return [
            'external_id' => fake()->uuid(),
            'cannabis_pharmacy_name' => $pharmacyName,
            'official_name' => $pharmacyName,
            'domain' => fake()->domainName(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'street' => fake()->streetAddress(),
            'zip_code' => fake()->postcode(),
            'city' => fake()->city(),
            'has_shipping' => $hasShipping,
            'has_express' => $hasExpress,
            'has_local_courier' => $hasLocalCourier,
            'has_pickup' => $hasPickup,
            'shipping_price' => fake()->randomNumber(),
            'express_price' => fake()->randomNumber(),
            'local_courier_price' => fake()->randomNumber(),
        ];
    }
}
