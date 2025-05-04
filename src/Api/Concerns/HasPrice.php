<?php

namespace AmaizingCompany\CannaleoClient\Api\Concerns;

use PrinsFrank\Standards\Currency\CurrencyAlpha3;

trait HasPrice
{
    protected static function parsePrice(&$param, float|int|string|null $value, bool $convert = true): int
    {
        if ($convert) {
            $param = intval(round($value * 100));

            return $param;
        }

        $param = intval(round($value));
        return $param;
    }

    protected function convertPrice(int $price, bool $convert = true): int|string
    {
        if ($convert) {
            return number_format($price / 100, $this->getCurrencyMinorUnits());
        }

        return $price;
    }

    protected function getCurrencyMinorUnits(): int
    {
        return config('cannaleo-client.default_currency')->getMinorUnits();
    }
}
