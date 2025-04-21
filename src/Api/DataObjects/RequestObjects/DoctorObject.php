<?php

namespace AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects;

use AmaizingCompany\CannaleoClient\Api\Contracts\DataRequestObject as DataRequestObjectContract;
use Illuminate\Support\Carbon;

class DoctorObject extends DataRequestObject implements DataRequestObjectContract
{
    protected string $name;

    protected ?string $phone;

    protected ?string $email;

    protected string $cityOfSignature;

    protected Carbon $dateOfSignature;

    public function __construct(string $name, string $cityOfSignature, Carbon $dateOfSignature)
    {
        $this->name($name);
        $this->cityOfSignature($cityOfSignature);
        $this->dateOfSignature($dateOfSignature);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone ?? null;
    }

    public function phone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    public function email(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCityOfSignature(): string
    {
        return $this->cityOfSignature;
    }

    public function cityOfSignature(string $cityOfSignature): static
    {
        $this->cityOfSignature = $cityOfSignature;

        return $this;
    }

    public function getDateOfSignature(): Carbon
    {
        return $this->dateOfSignature;
    }

    public function dateOfSignature(Carbon $dateOfSignature): static
    {
        $this->dateOfSignature = $dateOfSignature;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'cityOfSignature' => $this->getCityOfSignature(),
            'dateOfSignature' => $this->getDateOfSignature()->toDateString(),
        ];
    }
}
