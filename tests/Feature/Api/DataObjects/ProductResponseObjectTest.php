<?php

use AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects\ProductResponseObject;

pest()->group('api', 'data-objects', 'data-response-objects');

beforeEach(function () {
    $this->object = new ProductResponseObject(json_decode($this->getProductResponseObject(), true));
});

it('can be initiated', function () {
    expect($this->object)->toBeInstanceOf(ProductResponseObject::class);
});

it('can get id', function () {
    expect($this->object->getId())
        ->toBeString()
        ->toBe('testcan-testina');
});

it('can get name', function () {
    expect($this->object->getName())
        ->toBeString()
        ->toBe('Testrocan');
});

it('can get genetic', function () {
    expect($this->object->getGenetic())
        ->toBeString()
        ->toBe('Sativa');
});

it('can get country', function () {
    expect($this->object->getCountry())
        ->toBeString()
        ->toBe('Niederlande');
});

it('can get thc', function () {
    expect($this->object->getThc())
        ->toBeNumeric()
        ->toBe(22);
});

it('can get cbd', function () {
    expect($this->object->getCbd())
        ->toBeNumeric()
        ->toBe(0.9);
});

it('can get price', function () {
    expect($this->object->getPrice())
        ->toBeInt()
        ->toBe(895)
        ->and($this->object->getPrice(true))
        ->toBeString()
        ->toBe('8.95');
});

it('can get pharmacy name', function () {
    expect($this->object->getPharmacyName())
        ->toBeString()
        ->toBe('Demo Pharmacy');
});

it('can get pharmacy domain', function () {
    expect($this->object->getPharmacyDomain())
        ->toBeString()
        ->toBe('demo.example.com');
});

it('can get pharmacy id', function () {
    expect($this->object->getPharmacyId())
        ->toBeInt()
        ->toBe(4);
});

it('can check availability', function () {
    expect($this->object->isAvailable())
        ->toBeTrue();
});

it('can get category', function () {
    expect($this->object->getCategory())
        ->toBeString()
        ->toBe('flower');
});

it('can get manufacturer', function () {
    expect($this->object->getManufacturer())
        ->toBeString()
        ->toBe('Test Pharma GmbH');
});

it('can get grower', function () {
    expect($this->object->getGrower())
        ->toBeNull();
});

it('can get dominance', function () {
    expect($this->object->getDominance())
        ->toBeNull();
});

it('can get terpenes', function () {
    expect($this->object->getTerpenes())
        ->toBeArray()
        ->toBe([
            'Terpinolen',
            'Limonen',
            'Beta-Caryophyllen',
            'Myrcen',
            'Cis-Ocimen',
            'Beta-2-Pinen',
            'Alpha-Guaien',
            'Gamma-Cadinen',
            'Trans-Bergamoten',
            'Trans-β-Farnesen',
        ]);
});

it('can check if is irradiated', function () {
    expect($this->object->isIrradiated())
        ->toBeTrue();
});

it('can get strain', function () {
    expect($this->object->getStrain())
        ->toBeString()
        ->toBe('Afina');
});
