<?php

namespace AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects;

use Akaunting\Money\Money;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasPrice;

class PharmacyResponseObject extends DataResponseObject
{
    use HasPrice;

    const array MAP = [
        'id' => 'id',
        'cannabisPharmacyName' => 'cannabis_pharmacy_name',
        'officialName' => 'official_name',
        'domain' => 'domain',
        'email' => 'email',
        'phoneNumber' => 'phone_number',
        'street' => 'street',
        'zipCode' => 'plz',
        'city' => 'city',
        'shipping' => 'shipping',
        'express' => 'express',
        'localCourier' => 'local_courier',
        'pickup' => 'pickup',
        'shippingCostStandard' => 'shipping_cost_standard',
        'expressCostStandard' => 'express_cost_standard',
        'localCourierCostStandard' => 'local_coure_cost_standard',
    ];

    protected int $id;

    protected string $cannabisPharmacyName;

    protected ?string $officialName = null;

    protected string $domain;

    protected ?string $email = null;

    protected ?string $phoneNumber = null;

    protected ?string $street = null;

    protected ?string $zipCode = null;

    protected ?string $city = null;

    protected bool $shipping = false;

    protected bool $express = false;

    protected bool $localCourier = false;

    protected bool $pickup = false;

    protected Money $shippingCostStandard;

    protected Money $expressCostStandard;

    protected Money $localCourierCostStandard;

    public function __construct(array $data)
    {
        $this->shippingCostStandard = static::initPriceParam();
        $this->expressCostStandard = static::initPriceParam();
        $this->localCourierCostStandard = static::initPriceParam();

        parent::__construct($data);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCannabisPharmacyName(): string
    {
        return $this->cannabisPharmacyName;
    }

    public function getOfficialName(): ?string
    {
        return $this->officialName ?? null;
    }

    public function getDomain(): ?string
    {
        return $this->domain ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber ?? null;
    }

    public function getStreet(): ?string
    {
        return $this->street ?? null;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode ?? null;
    }

    public function getCity(): ?string
    {
        return $this->city ?? null;
    }

    public function isShipping(): bool
    {
        return $this->shipping ?? false;
    }

    public function isExpress(): bool
    {
        return $this->express ?? false;
    }

    public function isLocalCourier(): bool
    {
        return $this->localCourier ?? false;
    }

    public function isPickup(): bool
    {
        return $this->pickup ?? false;
    }

    public function getShippingCostStandard(): Money
    {
        return $this->shippingCostStandard;
    }

    public function getShippingCostStandardValue(): float
    {
        return $this->getShippingCostStandard()->getValue();
    }

    public function getShippingCostStandardAmount(): int
    {
        return (int) $this->getShippingCostStandard()->getAmount();
    }

    public function getExpressCostStandard(): Money
    {
        return $this->expressCostStandard;
    }

    public function getExpressCostStandardValue(): float
    {
        return $this->getExpressCostStandard()->getValue();
    }

    public function getExpressCostStandardAmount(): int
    {
        return (int) $this->getExpressCostStandard()->getAmount();
    }

    public function getLocalCourierCostStandard(): Money
    {
        return $this->localCourierCostStandard;
    }

    public function getLocalCourierCostStandardValue(): float
    {
        return $this->getLocalCourierCostStandard()->getValue();
    }

    public function getLocalCourierCostStandardAmount(): int
    {
        return $this->getLocalCourierCostStandard()->getAmount();
    }

    protected function shipping(bool|string $value): static
    {
        $this->parseBoolean($this->shipping, $value);

        return $this;
    }

    protected function express(bool|string $value): static
    {
        $this->parseBoolean($this->express, $value);

        return $this;
    }

    protected function localCourier(bool|string $value): static
    {
        $this->parseBoolean($this->localCourier, $value);

        return $this;
    }

    protected function pickup(bool|string $value): static
    {
        $this->parseBoolean($this->pickup, $value);

        return $this;
    }

    protected function shippingCostStandard(int|float|null $value): static
    {
        $this->parsePrice($this->shippingCostStandard, $value);

        return $this;
    }

    protected function expressCostStandard(int|float|null $value): static
    {
        $this->parsePrice($this->expressCostStandard, $value);

        return $this;
    }

    protected function localCourierCostStandard(int|float|null $value): static
    {
        $this->parsePrice($this->localCourierCostStandard, $value);

        return $this;
    }
}
