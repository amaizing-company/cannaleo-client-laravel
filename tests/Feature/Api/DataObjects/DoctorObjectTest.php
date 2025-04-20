<?php

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\DoctorObject;
use Illuminate\Support\Carbon;

pest()->group('api', 'data-objects', 'data-request-objects');

beforeEach(function () {
    $this->object =  new DoctorObject(
        'John Doe',
        'Testtown',
        Carbon::today()
    );
});

it ('can be initialized', function () {
    expect($this->object)->toBeInstanceOf(DoctorObject::class);
});

it ('can handle name', function () {
    expect($this->object->getName())
        ->toBeString()
        ->toBe('John Doe')
        ->and($this->object->name('Max Muster')->getName())
        ->toBe('Max Muster');
});

it ('can handle city of signature', function () {
    expect($this->object->getCityOfSignature())
        ->toBeString()
        ->toBe('Testtown')
        ->and($this->object->cityOfSignature('Test Town')->getCityOfSignature())
        ->toBe('Test Town');
});

it ('can handle date of signature', function () {
    expect($this->object->getDateOfSignature())
        ->toBeInstanceOf(Carbon::class)
        ->and($this->object->getDateOfSignature()->toDateString())
        ->toBe(Carbon::today()->toDateString())
        ->and($this->object->dateOfSignature(Carbon::yesterday())->getDateOfSignature()->toDateString())
        ->toBe(Carbon::yesterday()->toDateString());
});

it ('can handle phone number', function () {
    expect($this->object->getPhone())
        ->toBeNull()
        ->and($this->object->phone('123456789')->getPhone())
        ->toBeString()
        ->toBe('123456789');
});

it ('can handle email address', function () {
    expect($this->object->getEmail())
        ->toBeNull()
        ->and($this->object->email('test@example.com')->getEmail())
        ->toBeString()
        ->toBe('test@example.com');
});

it ('can be converted to an array', function () {
    expect($this->object->toArray())
        ->toBeArray()
        ->toBe([
            'name' => 'John Doe',
            'phone' => null,
            'email' => null,
            'cityOfSignature' => 'Testtown',
            'dateOfSignature' => Carbon::today()->toDateString(),
        ]);
});
