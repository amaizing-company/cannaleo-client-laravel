<?php

namespace AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects;

use Akaunting\Money\Casts\MoneyCast;
use Akaunting\Money\Money;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasPrice;
use AmaizingCompany\CannaleoClient\Api\Contracts\DataRequestObject as DataRequestObjectContract;

class ProductObject extends DataRequestObject implements DataRequestObjectContract
{
    use HasPrice;

    protected string $id;

    protected string $name;

    protected Money $price;

    protected string $category;

    protected int $quantity;

    public function __construct(string $id, string $name, int|float $price, string $category, int $quantity)
    {
        $this->price = static::initPriceParam();

        $this->id($id);
        $this->name($name);
        $this->price($price);
        $this->category($category);
        $this->quantity($quantity);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function id(string $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function getPriceValue(): float
    {
        return $this->getPrice()->getValue();
    }

    public function getPriceAmount(): int
    {
        return (int) $this->getPrice()->getAmount();
    }

    public function price(int|float $price): static
    {
        $this->parsePrice($this->price, $price);

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function category(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function quantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPriceValue(),
            'category' => $this->getCategory(),
            'quantity' => $this->getQuantity(),
        ];
    }
}
