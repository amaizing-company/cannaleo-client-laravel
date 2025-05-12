<?php

use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use Illuminate\Support\Facades\Http;

test('command can be executed', function () {
    $this->fakeHttpResponses();

    $this->artisan('cannaleo:status')
        ->assertSuccessful();
});

test('command has correct output', function () {
    $this->fakeHttpResponses();

    $this->artisan('cannaleo:status')
        ->expectsOutput('Cannaleo Test API')
        ->expectsOutput('Uptime: 1 week 1 day 9 hours 52 minutes 3 seconds (726723.06895049 s)')
        ->expectsOutput('Version: 1.0.8')
        ->assertSuccessful();
});

test('command can handle errors', function () {
    Http::fake([
         Endpoint::GET_SERVICE_STATUS->getRequestUrl() => Http::response('', 500),
    ]);

    $this->artisan('cannaleo:status')
        ->assertFailed();
});
