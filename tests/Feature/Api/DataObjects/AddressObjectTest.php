<?php

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\AddressObject;

pest()->group('api', 'data-objects', 'data-request-objects');

beforeEach(function () {
    $this->object =  new AddressObject(
        'Teststreet',
        '20',
        '12345',
        'Testtown',
    );
});

it ('can be initialized', function () {
    expect($this->object)
        ->toBeInstanceOf(AddressObject::class);
});

it ('can handle street name', function () {
    expect($this->object->getStreetName())
        ->toBeString()
        ->toBe('Teststreet')
        ->and($this->object->streetName('Test Street')->getStreetName())
        ->toBe('Test Street');
});

it ('can hande house number', function () {
    expect($this->object->getHouseNumber())
        ->toBeString()
        ->toBe('20')
        ->and($this->object->houseNumber('10A')->getHouseNumber())
        ->toBe('10A');
});

it ('can handle city', function () {
    expect($this->object->getCity())
        ->toBeString()
        ->toBe('Testtown')
        ->and($this->object->city('Test Town')->getCity())
        ->toBe('Test Town');
});

it ('can handle postal code', function () {
    expect($this->object->getPostalCode())
        ->toBeString()
        ->toBe('12345')
        ->and($this->object->postalCode('54321')->getPostalCode())
        ->toBe('54321');
});

it ('can be converted in an array', function () {
    expect($this->object->toArray())
        ->toBeArray()
        ->toBe([
            'streetName' => 'Teststreet',
            'houseNumber' => '20',
            'postalCode' => '12345',
            'city' => 'Testtown',
        ]);
});
