<?php

use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use Illuminate\Support\Facades\Http;

test('command can be executed', function () {
    $this->fakeHttpResponses();

    $this->artisan('cannaleo:sync')
        ->assertSuccessful();
});

test('command can handle failure', function () {
    Http::fake([
        Endpoint::GET_PHARMACIES->getRequestUrl() => Http::response('', 500),
        Endpoint::GET_CATALOG->getRequestUrl() => Http::response('', 500),
    ]);

    $this->artisan('cannaleo:sync')
        ->assertFailed();
});
