<?php

namespace AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects;

use Akaunting\Money\Money;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasPrice;
use AmaizingCompany\CannaleoClient\Api\Contracts\DataRequestObject as DataRequestObjectContract;

class ProductObject extends DataRequestObject implements DataRequestObjectContract
{
    use HasPrice;

    protected string $id;

    protected string $name;

    protected int $price = 0;

    protected string $category;

    protected int $quantity;

    public function __construct(string $id, string $name, int $price, string $category, int $quantity)
    {
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

    public function getPrice(bool $converted = false): int|string
    {
        return $this->convertPrice($this->price, $converted);
    }

    public function price(int $price): static
    {
        $this->parsePrice($this->price, $price, false);

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
            'price' => $this->getPrice(true),
            'category' => $this->getCategory(),
            'quantity' => $this->getQuantity(),
        ];
    }
}
