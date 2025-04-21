<?php

namespace AmaizingCompany\CannaleoClient\Api\Requests;

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use AmaizingCompany\CannaleoClient\Api\Responses\PharmaciesResponse;
use Illuminate\Http\Client\ConnectionException;

class PharmaciesRequest extends BaseRequest implements Request
{
    /**
     * @throws ConnectionException
     */
    public function send(): PharmaciesResponse
    {
        $response = static::buildRequest()
            ->acceptJson()
            ->get(Endpoint::GET_PHARMACIES->value);

        return new PharmaciesResponse($response->toPsrResponse());
    }
}
