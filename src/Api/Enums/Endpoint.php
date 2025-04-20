<?php

namespace AmaizingCompany\CannaleoClient\Api\Enums;

enum Endpoint: string
{
    case GET_SERVICE_STATUS = '/';
    case GET_CATALOG = '/catalog';
    case GET_PHARMACIES = '/pharmacies';
    case POST_PRESCRIPTION = '/prescription';

    public function getRequestUrl(): string
    {
        return config('cannaleo-client.base_url') . $this->value;
    }
}
