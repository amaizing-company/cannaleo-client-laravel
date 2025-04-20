<?php

namespace AmaizingCompany\CannaleoClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AmaizingCompany\CannaleoClient\CannaleoClient
 *
 * @method static mixed getConfig(?string $key = null)
 */
class CannaleoClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AmaizingCompany\CannaleoClient\CannaleoClient::class;
    }
}
