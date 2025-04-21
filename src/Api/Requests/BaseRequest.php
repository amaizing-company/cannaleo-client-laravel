<?php

namespace AmaizingCompany\CannaleoClient\Api\Requests;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BaseRequest
{
    protected static function buildRequest(): PendingRequest
    {
        return Http::baseUrl(config('cannaleo-client.base_url'))
            ->withHeader('Api-Key', config('cannaleo-client.api_key'));
    }
}
