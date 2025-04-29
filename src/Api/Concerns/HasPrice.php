<?php

namespace AmaizingCompany\CannaleoClient\Api\Concerns;

use Akaunting\Money\Money;

trait HasPrice
{
    protected static function parsePrice(&$param, float|int|null $value): Money
    {
        $convert = is_float($value);

        $param = new Money($value ?? 0, config('cannaleo-client.default_currency'), $convert);

        return $param;
    }

    protected static function initPriceParam(): Money
    {
        return new Money(0, config('cannaleo-client.default_currency'));
    }
}
