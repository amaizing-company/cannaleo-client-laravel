<?php

namespace AmaizingCompany\CannaleoClient\Api\Responses;

use Illuminate\Http\Client\Response;
use Psr\Http\Message\MessageInterface;

/**
 * @method Response getResponse()
 */
class BaseResponse extends Response
{
    public function __construct(MessageInterface $response)
    {
        parent::__construct($response);

        $this->boot();
    }

    protected function boot(): void
    {
        //
    }
}
