<?php

namespace AmaizingCompany\CannaleoClient\Api\Requests;

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use AmaizingCompany\CannaleoClient\Api\Responses\ApiStatusResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class ApiStatusRequest extends BaseRequest implements Request
{
    /**
     * @throws ConnectionException
     */
    public function send(): ApiStatusResponse
    {
            $response = static::buildRequest()
                ->acceptJson()
                ->get(Endpoint::GET_SERVICE_STATUS->value);

        return new ApiStatusResponse($response->toPsrResponse());
    }
}
