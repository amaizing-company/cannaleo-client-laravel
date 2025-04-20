<?php

namespace AmaizingCompany\CannaleoClient\Api\Requests;

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use AmaizingCompany\CannaleoClient\Api\Responses\CatalogResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;

class CatalogRequest extends BaseRequest implements Request
{
    protected Collection $includedPharmacies;
    protected Collection $excludedPharmacies;

    public function __construct()
    {
        $this->includedPharmacies = new Collection();
        $this->excludedPharmacies = new Collection();
    }

    public function excludePharmacies(array $pharmacyIds): static
    {
        foreach ($pharmacyIds as $pharmacyId) {
            $this->excludedPharmacies->add($pharmacyId);
        }

        return $this;
    }

    public function getExcludedPharmacies(): Collection
    {
        return $this->excludedPharmacies;
    }

    public function includePharmacies(array $pharmacyIds): static
    {
        foreach ($pharmacyIds as $pharmacyId) {
            $this->includedPharmacies->add($pharmacyId);
        }

        return $this;
    }

    public function getIncludedPharmacies(): Collection
    {
        return $this->includedPharmacies;
    }

    /**
     * @throws ConnectionException
     */
    public function send(): CatalogResponse
    {
        $request = static::buildRequest()
            ->acceptJson();

        if (!$this->includedPharmacies->isEmpty()) {
            $queryParams['include'] = $this->includedPharmacies->implode(',');
        }

        if (!$this->excludedPharmacies->isEmpty()) {
            $queryParams['exclude'] = $this->excludedPharmacies->implode(',');
        }

        if (isset($queryParams)) {
            $request->withQueryParameters($queryParams);
        }

        $response = $request->get(Endpoint::GET_CATALOG->value);

        return new CatalogResponse($response->toPsrResponse());
    }
}
