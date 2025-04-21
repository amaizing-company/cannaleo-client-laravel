<?php

namespace AmaizingCompany\CannaleoClient\Api\Responses;

use AmaizingCompany\CannaleoClient\Api\Concerns\HasError;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasMessage;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasUpdatedAt;
use AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects\ProductResponseObject;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class CatalogResponse extends BaseResponse
{
    use HasError;
    use HasMessage;
    use HasUpdatedAt;

    protected Collection $products;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $this->products = $this->parseProducts();
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    protected function parseProducts(): Collection
    {
        $products = $this->json('data.catalog');

        $collection = new Collection;

        if (empty($products)) {
            return $collection;
        }

        foreach ($products as $product) {
            $collection->add(new ProductResponseObject($product));
        }

        return $collection;
    }
}
