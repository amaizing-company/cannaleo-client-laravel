<?php

use AmaizingCompany\CannaleoClient\Api\Requests\ApiStatusRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\ApiStatusResponse;

pest()->group('api', 'api-requests');

beforeEach(function () {
    $this->request = new ApiStatusRequest;
});

it('can be initiated', function () {
    expect($this->request)->toBeInstanceOf(ApiStatusRequest::class);
});

it('can send request and receive response', function () {
    $this->fakeHttpResponses();

    $response = $this->request->send();

    expect($response)
        ->toBeInstanceOf(ApiStatusResponse::class)
        ->and($response->successful())
        ->toBeTrue()
        ->and($response->getLabel())
        ->toBe('Cannaleo Test API')
        ->toBeString()
        ->and($response->getUptime())
        ->toBeNumeric()
        ->and($response->getVersion())
        ->toBeString();
});
