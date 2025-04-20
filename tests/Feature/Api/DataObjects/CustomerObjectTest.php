<?php

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\AddressObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\CustomerObject;

pest()->group('api', 'data-objects', 'data-request-objects');

beforeEach(function () {
    $address = new AddressObject(
        'Teststreet',
        '20',
        '12345',
        'Testtown',
    );

    $this->object = new CustomerObject(
        'John',
        'Doe',
        'test@example.com',
        $address,
        $address
    );
});

it ('can be initialized', function () {
    expect($this->object)->toBeInstanceOf(CustomerObject::class);
});

it ('can handle first name', function () {
    expect($this->object->getFirstName())
        ->toBeString()
        ->toBe('John')
        ->and($this->object->firstname('Max')->getFirstname())
        ->toBe('Max');
});

it ('can handle last name', function () {
    expect($this->object->getLastName())
        ->toBeString()
        ->toBe('Doe')
        ->and($this->object->lastname('Muster')->getLastname())
        ->toBe('Muster');
});

it ('can handle email address', function () {
    expect($this->object->getEmail())
        ->toBeString()
        ->toBe('test@example.com')
        ->and($this->object->email('example@example.com')->getEmail())
        ->toBe('example@example.com');
});

it ('can handle phone number', function () {
    expect($this->object->getPhone())
        ->toBeNull()
        ->and($this->object->phone('0123456789')->getPhone())
        ->toBeString()
        ->toBe('0123456789');
});

it ('can handle home address', function () {
    expect($this->object->getHomeAddress())
        ->toBeInstanceOf(AddressObject::class);
});

it ('can handle delivery address', function () {
    expect($this->object->getDeliveryAddress())
        ->toBeInstanceOf(AddressObject::class);
});

it ('can be converted to an array', function () {
    expect($this->object->toArray())
        ->toBeArray()
        ->toBe([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'test@example.com',
            'phone' => null,
            'homeAddress' => [
                'streetName' => 'Teststreet',
                'houseNumber' => '20',
                'postalCode' => '12345',
                'city' => 'Testtown',
            ],
            'deliveryAddress' => [
                'streetName' => 'Teststreet',
                'houseNumber' => '20',
                'postalCode' => '12345',
                'city' => 'Testtown',
            ],
        ]);
});
