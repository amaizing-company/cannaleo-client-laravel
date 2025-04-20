<?php

namespace AmaizingCompany\CannaleoClient\Api\Responses;

use AmaizingCompany\CannaleoClient\Api\Concerns\HasError;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasMessage;

class PrescriptionTransactionResponse extends BaseResponse
{
    use HasError;
    use HasMessage;

    public function getData(): string
    {
        return $this->json('data');
    }
}
