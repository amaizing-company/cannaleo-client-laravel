<?php

use AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects\PharmacyResponseObject;

pest()->group('api', 'data-objects', 'data-response-objects');

beforeEach(function () {
    $this->object = new PharmacyResponseObject(json_decode($this->getPharmacyResponseObject(), true));
});

it('can be initialized', function () {
    expect($this->object)->toBeInstanceOf(PharmacyResponseObject::class);
});

it('can get id', function () {
    expect($this->object->getId())
        ->toBeInt()
        ->toEqual(1);
});

it('can get cannabis pharmacy name', function () {
    expect($this->object->getCannabisPharmacyName())
        ->toBeString()
        ->toBe('Demo Medicon-Apotheke');
});

it('can get official name', function () {
    expect($this->object->getOfficialName())
        ->toBeString()
        ->toBe('Demo Apotheke');
});

it('can get domain', function () {
    expect($this->object->getDomain())
        ->toBeString()
        ->toBe('demo.example.de');
});

it('can get email address', function () {
    expect($this->object->getEmail())
        ->toBeString()
        ->toBe('test@example.com');
});

it('can get phone number', function () {
    expect($this->object->getPhoneNumber())
        ->toBeNull();
});

it('can get street', function () {
    expect($this->object->getStreet())
        ->toBeString()
        ->toBe('Teststreet');
});

it('can get zip code', function () {
    expect($this->object->getZipCode())
        ->toBeString()
        ->toBe('12345');
});

it('can get city', function () {
    expect($this->object->getCity())
        ->toBeString()
        ->toBe('Testtown');
});

it('can check if shipping is available', function () {
    expect($this->object->isShipping())
        ->toBeTrue();
});

it('can check if express shipping is available', function () {
    expect($this->object->isExpress())
        ->toBeFalse();
});

it('can check if local courier is available', function () {
    expect($this->object->isLocalCourier())
        ->toBeFalse();
});

it('can check if pickup is available', function () {
    expect($this->object->isPickup())
        ->toBeTrue();
});

it('can get shipping costs', function () {
    expect($this->object->getShippingCostStandard())
        ->toBeInt()
        ->toBe(799);
});

it('can get express shipping cost', function () {
    expect($this->object->getExpressCostStandard())
        ->toBeInt()
        ->toBe(2199);
});

it('can get local courier cost', function () {
    expect($this->object->getLocalCourierCostStandard())
        ->toBeInt()
        ->toBe(799);
});
