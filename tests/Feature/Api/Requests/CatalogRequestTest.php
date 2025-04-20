<?php

use AmaizingCompany\CannaleoClient\Api\Requests\CatalogRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\CatalogResponse;

pest()->group('api', 'api-requests');

beforeEach(function () {
    $this->request = new CatalogRequest();
});

it ('can be initiated', function () {
    expect($this->request)->toBeInstanceOf(CatalogRequest::class);
});

it ('can handle excluded pharmacies', function () {
    expect($this->request->excludePharmacies([1,5,22])->getExcludedPharmacies()->toArray())
        ->toBe([1,5,22]);
});

it ('can be handle included pharmacies', function () {
    expect($this->request->includePharmacies([1,5,22])->getIncludedPharmacies()->toArray())
        ->toBe([1,5,22]);
});

it ('can send request and receive response', function () {
    $this->fakeHttpResponses();

    $response = $this->request->send();

    expect($response)
        ->toBeInstanceOf(CatalogResponse::class)
        ->and($response->hasError())
        ->toBeFalse()
        ->and($response->getMessage())
        ->toBeString()
        ->toBe('Result test catalog!')
        ->and($response->getUpdatedAt())
        ->toBeInstanceOf(\Illuminate\Support\Carbon::class)
        ->and($response->getProducts())
        ->toBeCollection()
        ->and($response->getProducts()->isEmpty())
        ->toBeFalse();
});
