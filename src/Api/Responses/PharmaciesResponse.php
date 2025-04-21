<?php

namespace AmaizingCompany\CannaleoClient\Api\Responses;

use AmaizingCompany\CannaleoClient\Api\Concerns\HasError;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasMessage;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasUpdatedAt;
use AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects\PharmacyResponseObject;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class PharmaciesResponse extends BaseResponse
{
    use HasError;
    use HasMessage;
    use HasUpdatedAt;

    protected Collection $pharmacies;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $this->pharmacies = $this->parsePharmacies();
    }

    public function getPharmacies(): Collection
    {
        return $this->pharmacies;
    }

    protected function parsePharmacies(): Collection
    {
        $pharmacies = $this->json('data.pharmacies');
        $collection = new Collection;

        foreach ($pharmacies as $pharmacy) {
            $collection->add(new PharmacyResponseObject($pharmacy));
        }

        return $collection;
    }
}
