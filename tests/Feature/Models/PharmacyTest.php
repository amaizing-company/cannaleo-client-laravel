<?php

use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Models\Pharmacy;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Base Model Tests
test('pharmacy model can be initiated', function () {
    $pharmacy = new Pharmacy;

    expect($pharmacy)
        ->toBeInstanceOf(Pharmacy::class)
        ->toBeObject();
});

test('pharmacy has correct guarded attributes', function () {
    $pharmacy = new Pharmacy;
    expect($pharmacy->getGuarded())->toBe([]);
});

// Model Configuration Tests
test('pharmacy has correct table name', function () {
    $transaction = new Pharmacy;

    // Assuming the table name follows Laravel conventions
    expect($transaction->getTable())
        ->toBe('cannaleo_pharmacies');
});

// Cast Tests
test('pharmacy has correct casts', function () {
    $pharmacy = new Pharmacy;
    $casts = $pharmacy->casts();

    expect($casts)
        ->toBeArray()
        ->toHaveCount(8)
        ->external_id->toBe('integer')
        ->has_shipping->toBe('boolean')
        ->has_express->toBe('boolean')
        ->has_local_courier->toBe('boolean')
        ->has_pickup->toBe('boolean')
        ->shipping_price->toBe('integer')
        ->express_price->toBe('integer')
        ->local_courier_price->toBe('integer');
});

// Relationship Tests
test('products() returns a HasMany relation', function () {
    $pharmacy = new Pharmacy;
    expect($pharmacy->products())
        ->toBeInstanceOf(HasMany::class);
});

test('products relationship can be loaded', function () {
    $pharmacy = Pharmacy::factory()->create();
    $products = $pharmacy->products;

    expect($products)->toBeCollection();
});

test('pharmacyTransactions() returns a HasMany relation', function () {
    $pharmacy = new Pharmacy;

    expect($pharmacy->pharmacyTransactions())
        ->toBeInstanceOf(HasMany::class);
});

test('pharmacyTransactions relationship can be loaded', function () {
    $pharmacy = Pharmacy::factory()->create();
    $transactions = $pharmacy->pharmacyTransactions;

    expect($transactions)->toBeCollection();
});

// Attribute Type Tests
test('pharmacy attributes have correct types', function () {
    $pharmacy = Pharmacy::factory()->create([
        'external_id' => 123,
        'cannabis_pharmacy_name' => 'Test Pharmacy',
        'official_name' => 'Test Pharmacy',
        'domain' => 'test.com',
        'email' => 'example@example.example',
        'phone' => '0123456789',
        'street' => 'Teststreet 1',
        'zip_code' => '12345',
        'city' => 'Testcity',
        'has_shipping' => true,
        'has_express' => false,
        'has_local_courier' => false,
        'has_pickup' => true,
    ]);

    expect($pharmacy)
        ->id->toBeString()
        ->external_id->toBeInt()
        ->cannabis_pharmacy_name->toBeString()
        ->official_name->toBeString()
        ->domain->toBeString()
        ->email->toBeString()
        ->phone->toBeString()
        ->street->toBeString()
        ->zip_code->toBeString()
        ->city->toBeString()
        ->has_shipping->toBeTrue()
        ->has_express->toBeFalse()
        ->has_local_courier->toBeFalse()
        ->has_pickup->toBeTrue()
        ->shipping_price->toBeInt()
        ->express_price->toBeInt()
        ->local_courier_price->toBeInt();
});

// Nullable Field Tests
test('optional fields can be null', function () {
    $pharmacy = Pharmacy::factory()->make([
        'cannabis_pharmacy_name' => null,
        'official_name' => null,
        'domain' => null,
        'email' => null,
        'phone' => null,
        'street' => null,
        'zip_code' => null,
        'city' => null,
    ]);

    expect($pharmacy)
        ->cannabis_pharmacy_name->toBeNull()
        ->official_name->toBeNull()
        ->domain->toBeNull()
        ->email->toBeNull()
        ->phone->toBeNull()
        ->street->toBeNull()
        ->zip_code->toBeNull()
        ->city->toBeNull();
});

// Shipping Options Tests
test('shipping options can be toggled', function () {
    $pharmacy = new Pharmacy([
        'has_shipping' => true,
        'has_express' => true,
        'has_local_courier' => true,
        'has_pickup' => true,
    ]);

    expect($pharmacy)
        ->has_shipping->toBeTrue()
        ->has_express->toBeTrue()
        ->has_local_courier->toBeTrue()
        ->has_pickup->toBeTrue();

    $pharmacy->has_shipping = false;
    $pharmacy->has_express = false;
    $pharmacy->has_local_courier = false;
    $pharmacy->has_pickup = false;

    expect($pharmacy)
        ->has_shipping->toBeFalse()
        ->has_express->toBeFalse()
        ->has_local_courier->toBeFalse()
        ->has_pickup->toBeFalse();
});

// Product Relationship Tests
test('can add products to pharmacy', function () {
    $pharmacy = Pharmacy::factory()->hasProducts(1)->create();

    expect($pharmacy->products)->toHaveCount(1);
});

test('can handle multiple products', function () {
    $pharmacy = Pharmacy::factory()->hasProducts(5)->create();

    expect($pharmacy->products)->toHaveCount(5);
});

// Model State Tests
test('pharmacy attributes can be mass assigned', function () {
    $attributes = [
        'cannabis_pharmacy_name' => 'Test Pharmacy',
        'official_name' => 'Official Name',
        'domain' => 'test.com',
        'email' => 'test@test.com',
        'phone' => '123456789',
        'street' => 'Test Street 1',
        'zip_code' => '12345',
        'city' => 'Test City',
        'has_shipping' => true,
        'shipping_price' => 1000,
    ];

    $pharmacy = new Pharmacy($attributes);

    foreach ($attributes as $key => $value) {
        expect($pharmacy->$key)->toBe($value);
    }
});

test('pharmacy contract can be resolved to model class', function () {
    $pharmacy = app(\AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy::class);

    expect($pharmacy)
        ->toBeInstanceOf(Pharmacy::class);
});
