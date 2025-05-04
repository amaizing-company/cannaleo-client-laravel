<?php

use AmaizingCompany\CannaleoClient\Models\PharmacyTransaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

// Basic Model Tests
test('pharmacy transaction model can be instantiated', function () {
    $transaction = new PharmacyTransaction;

    expect($transaction)
        ->toBeInstanceOf(PharmacyTransaction::class)
        ->and($transaction)->toBeObject();
});

test('pharmacy transaction has correct guarded attributes', function () {
    $pharmacy = new PharmacyTransaction;
    expect($pharmacy->getGuarded())->toBe([]);
});

// Model Configuration Tests
test('pharmacy transaction has correct table name', function () {
    $transaction = new PharmacyTransaction;

    // Assuming the table name follows Laravel conventions
    expect($transaction->getTable())
        ->toBe('cannaleo_pharmacy_transactions');
});

// Relationship Tests
test('pharmacy relation is defined correctly', function () {
    $transaction = new PharmacyTransaction;

    expect($transaction->pharmacy())
        ->toBeInstanceOf(BelongsTo::class)
        ->and($transaction->pharmacy()->getRelated())
        ->toBeInstanceOf(\AmaizingCompany\CannaleoClient\Models\Pharmacy::class);
});

test('pharmacy relationship can be loaded', function () {
    $transaction = PharmacyTransaction::factory()->create();

    expect($transaction->pharmacy)
        ->toBeInstanceOf(\AmaizingCompany\CannaleoClient\Models\Pharmacy::class);
});

test('products relation is defined correctly', function () {
    $transaction = new PharmacyTransaction;
    $relation = $transaction->products();

    expect($relation)
        ->toBeInstanceOf(BelongsToMany::class)
        ->and($relation->getTable())
        ->toBe('cannaleo_pharmacy_transactions_products')
        ->and($relation->getRelated())
        ->toBeInstanceOf(\AmaizingCompany\CannaleoClient\Models\Product::class);
});

test('products relationship can be loaded', function () {
    $products = \AmaizingCompany\CannaleoClient\Models\Product::factory()->count(2)->create();
    $transaction = PharmacyTransaction::factory()->create();

    foreach ($products as $product) {
        $transaction->products()->attach($product, ['price' => 100]);
    }

    expect($transaction->products)
        ->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class)
        ->and($transaction->products->count())
        ->toEqual(2);
});

// Morphable Relationships Tests
test('morphable relationships are properly defined', function () {
    $transaction = new PharmacyTransaction;

    expect($transaction->order())->toBeInstanceOf(MorphTo::class)
        ->and($transaction->customer())->toBeInstanceOf(MorphTo::class)
        ->and($transaction->doctor())->toBeInstanceOf(MorphTo::class)
        ->and($transaction->prescription())->toBeInstanceOf(MorphTo::class);
});

test('morphable relationships can be loaded', function () {
    $transaction = PharmacyTransaction::factory()->create();

    expect($transaction->order)
        ->toBeInstanceOf(\AmaizingCompany\CannaleoClient\Tests\Models\Order::class)
        ->and($transaction->customer)
        ->toBeInstanceOf(\AmaizingCompany\CannaleoClient\Tests\Models\Customer::class)
        ->and($transaction->doctor)
        ->toBeInstanceOf(AmaizingCompany\CannaleoClient\Tests\Models\Doctor::class)
        ->and($transaction->prescription)
        ->toBeInstanceOf(AmaizingCompany\CannaleoClient\Tests\Models\Prescription::class);
});

// Attribute Type Tests
test('pharmacy transaction accepts all expected attributes', function () {
    $transaction = PharmacyTransaction::factory()->create();

    expect($transaction)
        ->id->toBeString()
        ->pharmacy_id->toBeString()
        ->order_type->toBeString()
        ->order_id->toBeString()
        ->customer_type->toBeString()
        ->customer_id->toBeString()
        ->doctor_type->toBeString()
        ->doctor_id->toBeString()
        ->prescription_type->toBeString()
        ->prescription_id->toBeString()
        ->created_at->toBeInstanceOf(Carbon::class)
        ->updated_at->toBeInstanceOf(Carbon::class);
});

// Products Pivot Tests
test('products relation has correct pivot setup', function () {
    $transaction = new PharmacyTransaction;
    $relation = $transaction->products();

    expect($relation->getPivotColumns())
        ->toContain('price')
        ->and($relation->withTimestamps)
        ->toBeTrue();
});

// Feature Tests
test('pharmacy transaction can be persisted to database', function () {
    $attributes = [
        'pharmacy_id' => 'pharmacy-1',
        'order_type' => 'standard',
        'order_id' => 'order-1',
    ];

    $transaction = PharmacyTransaction::factory()->create($attributes);

    expect($transaction->exists)->toBeTrue()
        ->and($transaction->pharmacy_id)->toBe('pharmacy-1')
        ->and($transaction->order_type)->toBe('standard')
        ->and($transaction->order_id)->toBe('order-1');
});

// Polymorphic Relationship Type Tests
test('morphable relationships return correct types', function () {
    $transaction = new PharmacyTransaction;

    expect($transaction->getMorphClass())->toBe(PharmacyTransaction::class)
        ->and($transaction->order()->getMorphType())->toBe('order_type')
        ->and($transaction->customer()->getMorphType())->toBe('customer_type')
        ->and($transaction->doctor()->getMorphType())->toBe('doctor_type')
        ->and($transaction->prescription()->getMorphType())->toBe('prescription_type');
});

test('pharmacy transaction contract can be resolved to model class', function () {
    $pharmacy = app(\AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction::class);

    expect($pharmacy)
        ->toBeInstanceOf(PharmacyTransaction::class);
});
