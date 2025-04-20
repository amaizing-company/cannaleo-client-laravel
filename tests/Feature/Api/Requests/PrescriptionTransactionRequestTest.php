<?php

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\AddressObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\CustomerObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\DoctorObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\ProductObject;
use AmaizingCompany\CannaleoClient\Api\Requests\PrescriptionTransactionRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\PrescriptionTransactionResponse;
use Illuminate\Support\Carbon;

pest()->group('api', 'api-requests');

beforeEach(function () {
    $address = new AddressObject(
        'Teststreet',
        '20',
        '12345',
        'Testtown'
    );

    $doctor = new DoctorObject(
        'John Doe',
        'Testtown',
        Carbon::today()
    );

    $customer = new CustomerObject(
        'John',
        'Doe',
        'test@example.test',
        $address,
        $address
    );

    $this->request = new PrescriptionTransactionRequest(
        'test_file',
        '1234',
        '1234',
        $doctor,
        $customer
    );
});

it ('can be initiated', function () {
    expect($this->request)->toBeInstanceOf(PrescriptionTransactionRequest::class);
});

it ('can handle prescription data', function () {
    expect($this->request->getPrescription())
        ->toBeString()
        ->toBe(base64_encode('test_file'))
        ->and($this->request->getPrescription(false))
        ->toBeString()
        ->toBe('test_file')
        ->and($this->request->prescription('new_test_file')->getPrescription(false))
        ->toBe('new_test_file');
});

it ('can handle internal order id', function () {
    expect($this->request->getInternalOrderId())
        ->toBeString()
        ->toBe('1234')
        ->and($this->request->internalOrderId('4321')->getInternalOrderId())
        ->toBe('4321');
});

it ('can handle internal pharmacy id', function () {
    expect($this->request->getInternalPharmacyId())
        ->toBeString()
        ->toBe('1234')
        ->and($this->request->internalPharmacyId('4321')->getInternalPharmacyId())
        ->toBe('4321');
});

it ('can handle doctor', function () {
    expect($this->request->getDoctor())
        ->toBeInstanceOf(DoctorObject::class);
});

it ('can handle customer', function () {
    expect($this->request->getCustomer())
        ->toBeInstanceOf(CustomerObject::class);
});

it ('can handle products', function () {
    expect($this->request->getProducts()->isEmpty())
        ->toBeTrue()
        ->and(
            $this->request
                ->addProduct(new ProductObject('1234', 'Testproduct', 799, 'flowers', 1))
                ->getProducts()
                ->isEmpty()
        )
        ->toBeFalse();
});

it ('can send request and receive response', function () {
    $this->fakeHttpResponses();

    $this->request->addProduct(new ProductObject('1234',  'Testproduct', 799, 'flowers', 1));

    $response = $this->request->send();

    expect($response)
        ->toBeInstanceOf(PrescriptionTransactionResponse::class)
        ->and($response->successful())
        ->toBeTrue()
        ->and($response->hasError())
        ->toBeFalse()
        ->and($response->getMessage())
        ->toBeString()
        ->toBe('string')
        ->and($response->getData())
        ->toBe('string');
});
