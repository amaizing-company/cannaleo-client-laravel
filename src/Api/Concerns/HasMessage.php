<?php

namespace AmaizingCompany\CannaleoClient\Api\Concerns;

trait HasMessage
{
    public function getMessage(): string
    {
        return $this->json('message');
    }
}
