<?php

namespace AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects;

use AmaizingCompany\CannaleoClient\Api\Enums\BoolEnum;
use Illuminate\Support\Collection;

abstract class DataResponseObject
{
    const array MAP = [];

    public function __construct(array $data)
    {
        $data = Collection::make($data);

        foreach (static::getMap() as $key => $foreignKey) {
            $value = $data->get($foreignKey);

            if (empty($value) && $value !== 0) {
                continue;
            }

            if (method_exists(static::class, $key)) {
                $this->$key($value);
            } else {
                $this->$key = $value;
            }
        }
    }

    protected static function getMap(): array
    {
        return static::MAP;
    }

    protected function parseBoolean(&$param, $value): bool
    {
        if (is_string($value)) {
            $param = BoolEnum::from($value)->toBool();
        } else {
            $param = $value;
        }

        return $param;
    }

    protected function parsePrice(&$param, int|float $value): static
    {
        if (is_float($value)) {
            $param = (int) round(($value * 100), 0);
        } else {
            $param = $value;
        }

        return $this;
    }
}
