<?php

namespace AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects;

use Akaunting\Money\Money;
use AmaizingCompany\CannaleoClient\Api\Concerns\HasPrice;

class ProductResponseObject extends DataResponseObject
{
    use HasPrice;

    const array MAP = [
        'id' => 'id',
        'name' => 'name',
        'genetic' => 'genetic',
        'country' => 'country',
        'thc' => 'thc',
        'cbd' => 'cbd',
        'price' => 'price',
        'pharmacyName' => 'pharmacy_name',
        'pharmacyDomain' => 'pharmacy_domain',
        'pharmacyId' => 'pharmacy_id',
        'availability' => 'availibility',
        'category' => 'category',
        'manufacturer' => 'manufacturer',
        'grower' => 'grower',
        'dominance' => 'dominance',
        'terpenes' => 'terpenes',
        'irradiated' => 'irradiated',
        'strain' => 'strain',

    ];

    protected string $id;

    protected string $name;

    protected ?string $genetic = null;

    protected ?string $country = null;

    protected int|float $thc;

    protected int|float $cbd;

    protected int $price = 0;

    protected string $pharmacyName;

    protected string $pharmacyDomain;

    protected int $pharmacyId;

    protected bool $availability;

    protected string $category;

    protected string $manufacturer;

    protected ?string $grower = null;

    protected ?string $dominance = null;

    protected array $terpenes;

    protected bool $irradiated;

    protected ?string $strain = null;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGenetic(): ?string
    {
        return $this->genetic;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getThc(): int|float
    {
        return $this->thc;
    }

    public function getCbd(): int|float
    {
        return $this->cbd;
    }

    public function getPrice(bool $converted = false): int|string
    {
        return $this->convertPrice($this->price, $converted);
    }

    public function getPharmacyName(): string
    {
        return $this->pharmacyName;
    }

    public function getPharmacyDomain(): string
    {
        return $this->pharmacyDomain;
    }

    public function getPharmacyId(): int
    {
        return $this->pharmacyId;
    }

    public function isAvailable(): bool
    {
        return $this->availability ?? false;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getGrower(): ?string
    {
        return $this->grower ?? null;
    }

    public function getDominance(): ?string
    {
        return $this->dominance ?? null;
    }

    public function getTerpenes(): array
    {
        return $this->terpenes;
    }

    public function isIrradiated(): bool
    {
        return $this->irradiated ?? false;
    }

    public function getStrain(): ?string
    {
        return $this->strain ?? null;
    }

    protected function availability(string|bool $value): static
    {
        if (is_string($value)) {
            $this->availability = boolval($value);
        } else {
            $this->availability = $value;
        }

        return $this;
    }

    protected function price(float|int|string $value): static
    {
        $this->parsePrice($this->price, $value);

        return $this;
    }
}
