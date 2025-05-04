<?php

use AmaizingCompany\CannaleoClient\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Base Model Tests
test('product model can be initiated', function () {
    $product = new Product;

    expect($product)
        ->toBeInstanceOf(Product::class)
        ->toBeObject();
});

test('product has correct guarded attributes', function () {
    $product = new Product;

    expect($product->getGuarded())
        ->toBe([]);
});

// Model Configuration Tests
test('product has correct table name', function () {
    $product = new Product;

    expect($product->getTable())
        ->toBe('cannaleo_products');
});

// Cast Tests
test('product has correct casts', function () {
    $product = new Product;

    expect($product->getCasts())
        ->toBeArray()
        ->toHaveCount(4)
        ->available->toBe('boolean')
        ->price->toBe('integer')
        ->irradiated->toBe('boolean')
        ->deleted_at->toBe('datetime');
});

// Relationship Tests
test('pharmacy() returns a BelongsTo relation', function () {
    $product = new Product;
    expect($product->pharmacy())
        ->toBeInstanceOf(BelongsTo::class);
});

test('pharmacy relationship can be loaded', function () {
    $product = Product::factory()->create();

    expect($product->pharmacy)
        ->toBeInstanceOf(\AmaizingCompany\CannaleoClient\Models\Pharmacy::class);
});

test('terpenes() returns a BelongsToMany relation', function () {
    $product = new Product;

    expect($product->terpenes())
        ->toBeInstanceOf(BelongsToMany::class);
});

test('terpenes relationship can be loaded', function () {
    $product = Product::factory()->hasTerpenes(3)->create();

    expect($product->terpenes)
        ->toBeCollection()
        ->toHaveCount(3);
});

test('pharmacyTransactions() returns a BelongsToMany relation', function () {
    $product = new Product;
    expect($product->pharmacyTransactions())
        ->toBeInstanceOf(BelongsToMany::class);
});

test('pharmacyTransactions relationship can be loaded', function () {
    $product = Product::factory()->create();
    $transaction = \AmaizingCompany\CannaleoClient\Models\PharmacyTransaction::factory()->create();

    $transaction->products()->attach($product, ['price' => 100]);

    expect($product->pharmacyTransactions)
        ->toBeCollection()
        ->toHaveCount(1);
});

// Attribute Type Tests
test('product attributes have correct types', function () {
    $product = Product::factory()->create();

    expect($product)
        ->id->toBeString()
        ->pharmacy_id->toBeString()
        ->external_id->toBeString()
        ->name->toBeString()
        ->genetic->toBeString()
        ->country->toBeString()
        ->thc->toBeFloat()
        ->cbd->toBeFloat()
        ->available->toBeBool()
        ->price->toBeInt()
        ->category->toBeString()
        ->manufacturer->toBeString()
        ->grower->toBeString()
        ->dominance->toBeNull()
        ->irradiated->toBeBool()
        ->strain->toBeString()
        ->created_at->toBeInstanceOf(\Illuminate\Support\Carbon::class)
        ->updated_at->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

// Nullable Fields test
test('product fields can be null', function () {
    $product = Product::factory()->create([
        'genetic' => null,
        'country' => null,
        'category' => null,
        'manufacturer' => null,
        'grower' => null,
        'dominance' => null,
        'strain' => null,
    ]);

    expect($product)
        ->genetic->toBeNull()
        ->country->toBeNull()
        ->category->toBeNull()
        ->manufacturer->toBeNull()
        ->grower->toBeNull()
        ->dominance->toBeNull()
        ->strain->toBeNull();
});

test('product contract can be resolved to model class', function () {
    $product = app(\AmaizingCompany\CannaleoClient\Contracts\Models\Product::class);

    expect($product)
        ->toBeInstanceOf(Product::class);
});
