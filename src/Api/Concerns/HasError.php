<?php

namespace AmaizingCompany\CannaleoClient\Api\Concerns;

trait HasError
{
    public function hasError(): bool
    {
        return $this->json('error');
    }
}
