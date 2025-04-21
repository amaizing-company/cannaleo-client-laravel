<?php

use AmaizingCompany\CannaleoClient\Api\Requests\PharmaciesRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\PharmaciesResponse;
use Illuminate\Support\Collection;

pest()->group('api', 'api-requests');

beforeEach(function () {
    $this->request = new PharmaciesRequest;
});

it('can be initiated', function () {
    expect($this->request)->toBeInstanceOf(PharmaciesRequest::class);
});

it('can send request and receive response', function () {
    $this->fakeHttpResponses();

    $response = $this->request->send();

    expect($response)
        ->toBeInstanceOf(PharmaciesResponse::class)
        ->and($response->successful())
        ->toBeTrue()
        ->and($response->hasError())
        ->toBeFalse()
        ->and($response->getMessage())
        ->toBeString()
        ->toBe('Result test pharmacies!')
        ->and($response->getPharmacies())
        ->toBeInstanceOf(Collection::class)
        ->and($response->getPharmacies()->isEmpty())
        ->toBeFalse();
});
