<?php

namespace AmaizingCompany\CannaleoClient\Api\Enums;

enum BoolEnum: string
{
    case YES = 'yes';
    case NO = 'no';

    public function toBool(): bool
    {
        return $this === self::YES;
    }
}
