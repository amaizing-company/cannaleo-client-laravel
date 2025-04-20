<?php

namespace AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects;

use AmaizingCompany\CannaleoClient\Api\Contracts\DataRequestObject as DataRequestObjectContract;

class CustomerObject extends DataRequestObject implements DataRequestObjectContract
{
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected ?string $phone;
    protected AddressObject $homeAddress;
    protected AddressObject $deliveryAddress;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        AddressObject $homeAddress,
        AddressObject $deliveryAddress
    )
    {
        $this->firstname($firstname);
        $this->lastname($lastname);
        $this->email($email);
        $this->homeAddress($homeAddress);
        $this->deliveryAddress($deliveryAddress);
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function firstname(string $name): self
    {
        $this->firstname = $name;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function lastname(string $name): static
    {
        $this->lastname = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function email(string $email): static
    {
        $this->email = $email;

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

    public function getHomeAddress(): AddressObject
    {
        return $this->homeAddress;
    }

    public function homeAddress(AddressObject $homeAddress): static
    {
        $this->homeAddress = $homeAddress;

        return $this;
    }

    public function getDeliveryAddress(): AddressObject
    {
        return $this->deliveryAddress;
    }

    public function deliveryAddress(AddressObject $address): static
    {
        $this->deliveryAddress = $address;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'homeAddress' => $this->getHomeAddress()->toArray(),
            'deliveryAddress' => $this->getDeliveryAddress()->toArray(),
        ];
    }
}
