<?php

namespace AmaizingCompany\CannaleoClient\Database\Factories;

use AmaizingCompany\CannaleoClient\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Models\PharmacyTransaction;
use AmaizingCompany\CannaleoClient\Tests\Models\Customer;
use AmaizingCompany\CannaleoClient\Tests\Models\Doctor;
use AmaizingCompany\CannaleoClient\Tests\Models\Order;
use AmaizingCompany\CannaleoClient\Tests\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyTransactionFactory extends Factory
{
    protected $model = PharmacyTransaction::class;

    public function definition()
    {
        return [
            'pharmacy_id' => Pharmacy::factory(),
            'order_type' => (new Order)->getMorphClass(),
            'order_id' => Order::factory(),
            'doctor_type' => (new Doctor)->getMorphClass(),
            'doctor_id' => Doctor::factory(),
            'customer_type' => (new Customer)->getMorphClass(),
            'customer_id' => Customer::factory(),
            'prescription_type' => (new Prescription)->getMorphClass(),
            'prescription_id' => Prescription::factory(),
        ];
    }
}
