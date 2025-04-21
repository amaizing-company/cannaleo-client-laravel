<?php

namespace AmaizingCompany\CannaleoClient\Api\Responses;

class ApiStatusResponse extends BaseResponse
{
    public function getLabel(): string
    {
        return $this->json('label');
    }

    public function getUptime(): float|int
    {
        return $this->json('uptime');
    }

    public function getVersion(): string
    {
        return $this->json('version');
    }
}
