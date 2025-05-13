<?php

use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use AmaizingCompany\CannaleoClient\Services\SyncServices\CatalogSyncService;
use AmaizingCompany\CannaleoClient\Services\SyncServices\PharmaciesSyncService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

test('command can be executed', function () {
    $this->fakeHttpResponses();

    $this->artisan('cannaleo:sync')
        ->assertSuccessful();
});

test('command executes synchronization', function () {
    $this->fakeHttpResponses();

    Log::shouldReceive('info')
        ->with(
            PharmaciesSyncService::getSuccessMessage(),
            CatalogSyncService::getSuccessMessage()
        );

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
