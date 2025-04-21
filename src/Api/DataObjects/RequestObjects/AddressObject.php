<?php

namespace AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects;

use AmaizingCompany\CannaleoClient\Api\Contracts\DataRequestObject as DataRequestObjectContract;

class AddressObject extends DataRequestObject implements DataRequestObjectContract
{
    protected string $streetName;

    protected string $houseNumber;

    protected string $postalCode;

    protected string $city;

    public function __construct(string $streetName, string $houseNumber, string $postalCode, string $city)
    {
        $this->streetName($streetName);
        $this->houseNumber($houseNumber);
        $this->postalCode($postalCode);
        $this->city($city);
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function streetName(string $streetName): static
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public function houseNumber(string $houseNumber): static
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function postalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function city(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'streetName' => $this->getStreetName(),
            'houseNumber' => $this->getHouseNumber(),
            'postalCode' => $this->getPostalCode(),
            'city' => $this->getCity(),
        ];
    }
}
