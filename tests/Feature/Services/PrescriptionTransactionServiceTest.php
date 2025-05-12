<?php

use AmaizingCompany\CannaleoClient\Enums\PharmacyTransactionStatus;
use AmaizingCompany\CannaleoClient\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Models\PharmacyTransaction;
use AmaizingCompany\CannaleoClient\Models\Product;
use AmaizingCompany\CannaleoClient\Services\PrescriptionTransactionService;
use AmaizingCompany\CannaleoClient\Tests\Models\Customer;
use AmaizingCompany\CannaleoClient\Tests\Models\Doctor;
use AmaizingCompany\CannaleoClient\Tests\Models\Order;
use AmaizingCompany\CannaleoClient\Tests\Models\Prescription;
use Illuminate\Support\Collection;

test('prescription transaction service can be initialized', function () {
    $this->fakeHttpResponses();

    $customer = Customer::factory()->create();
    $doctor = Doctor::factory()->create();
    $prescription = Prescription::factory()->create();
    $pharmacy = Pharmacy::factory()->create();
    $product = Product::factory()->create();
    $order = Order::factory()->create();

    $products = Collection::make();
    $products->add($product->getProductObject());

    $service = new PrescriptionTransactionService($pharmacy, $prescription, $customer, $doctor, $order, $products);

    expect($service)
        ->toBeInstanceOf(PrescriptionTransactionService::class);
});

test('prescription transaction service can be executed', function () {
    $this->fakeHttpResponses();

    $customer = Customer::factory()->create();
    $doctor = Doctor::factory()->create();
    $prescription = Prescription::factory()->create();
    $pharmacy = Pharmacy::factory()->create();
    $product = Product::factory()->create();
    $order = Order::factory()->create();

    $products = Collection::make();
    $products->add($product->getProductObject());

    $service = new PrescriptionTransactionService($pharmacy, $prescription, $customer, $doctor, $order, $products);
    $service->handle();

    $transactions = PharmacyTransaction::all();

    expect($transactions)
        ->count()->toBe(1)
        ->and($transactions->first())
        ->status->toBe(PharmacyTransactionStatus::SUCCESS)
        ->and($transactions->first()->products->count())
        ->toBe(1);
});
