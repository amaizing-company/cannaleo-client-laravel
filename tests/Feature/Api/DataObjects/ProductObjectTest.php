<?php

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\ProductObject;

pest()->group('api', 'data-objects', 'data-request-objects');

beforeEach(function () {
    $this->object = new ProductObject(
        'test_id',
        'Test Product',
        799,
        'flower',
        1
    );
});

it('can be initialized', function () {
    expect($this->object)->toBeInstanceOf(ProductObject::class);
});

it('can handle id', function () {
    expect($this->object->getId())
        ->toBeString()
        ->toBe('test_id')
        ->and($this->object->id('id_test')->getId())
        ->toBe('id_test');
});

it('can handle name', function () {
    expect($this->object->getName())
        ->toBeString()
        ->toBe('Test Product')
        ->and($this->object->name('Product Name')->getName())
        ->toBe('Product Name');
});

it('can handle price', function () {
    expect($this->object->getPrice())
        ->toBeInt()
        ->toBe(799)
        ->and($this->object->getPrice(true))
        ->toBeString()
        ->toBe('7.99')
        ->and($this->object->price(800)->getPrice())
        ->toBeInt()
        ->toBe(800)
        ->and($this->object->getPrice(true))
        ->toBeString()
        ->toBe('8.00');
});

it('can handle category', function () {
    expect($this->object->getCategory())
        ->toBeString()
        ->toBe('flower')
        ->and($this->object->category('Category')->getCategory())
        ->toBe('Category');
});

it('can handle quantity', function () {
    expect($this->object->getQuantity())
        ->toBeInt()
        ->toBe(1)
        ->and($this->object->quantity(2)->getQuantity())
        ->toBe(2);
});

it('can be converted to an array', function () {
    expect($this->object->toArray())
        ->toBeArray()
        ->toBe([
            'id' => 'test_id',
            'name' => 'Test Product',
            'price' => '7.99',
            'category' => 'flower',
            'quantity' => 1,
        ]);
});
