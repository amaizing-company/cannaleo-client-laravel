<?php

namespace AmaizingCompany\CannaleoClient\Api\Requests;

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\CustomerObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\DoctorObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\ProductObject;
use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use AmaizingCompany\CannaleoClient\Api\Responses\PrescriptionTransactionResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;

class PrescriptionTransactionRequest extends BaseRequest implements Request
{
    protected string $prescription;

    protected string $internalOrderId;

    protected string $internalPharmacyId;

    protected DoctorObject $doctor;

    protected CustomerObject $customer;

    protected Collection $products;

    public function __construct(
        string $prescription,
        string $internalOrderId,
        string $internalPharmacyId,
        DoctorObject $doctor,
        CustomerObject $customer
    ) {
        $this->prescription($prescription);
        $this->internalOrderId($internalOrderId);
        $this->internalPharmacyId($internalPharmacyId);
        $this->doctor($doctor);
        $this->customer($customer);
        $this->products = new Collection;
    }

    public function getPrescription(bool $encoded = true): string
    {
        if ($encoded) {
            return $this->prescription;
        }

        return base64_decode($this->prescription);
    }

    public function prescription(string $fileContents): static
    {
        $this->prescription = base64_encode($fileContents);

        return $this;
    }

    public function getInternalOrderId(): string
    {
        return $this->internalOrderId;
    }

    public function internalOrderId(string $internalOrderId): static
    {
        $this->internalOrderId = $internalOrderId;

        return $this;
    }

    public function getInternalPharmacyId(): string
    {
        return $this->internalPharmacyId;
    }

    public function internalPharmacyId(string $internalPharmacyId): static
    {
        $this->internalPharmacyId = $internalPharmacyId;

        return $this;
    }

    public function getDoctor(): DoctorObject
    {
        return $this->doctor;
    }

    public function doctor(DoctorObject $doctor): static
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getCustomer(): CustomerObject
    {
        return $this->customer;
    }

    public function customer(CustomerObject $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getProducts(bool $asArray = false): Collection|array
    {
        if ($asArray) {
            foreach ($this->products as $product) {
                $result[] = $product->toArray();
            }

            return $result ?? [];
        }

        return $this->products;
    }

    public function addProduct(ProductObject $product): static
    {
        $this->products->add($product);

        return $this;
    }

    /**
     * @throws ConnectionException
     */
    public function send(): PrescriptionTransactionResponse
    {
        $response = static::buildRequest()
            ->acceptJson()
            ->asJson()
            ->withBody(json_encode([
                'prescription' => $this->getPrescription(),
                'internalOrderId' => $this->getInternalOrderId(),
                'internalPharmacyId' => $this->getInternalPharmacyId(),
                'doctor' => $this->getDoctor()->toArray(),
                'customer' => $this->getCustomer()->toArray(),
                'products' => $this->getProducts(true),
            ]))
            ->post(Endpoint::POST_PRESCRIPTION->value);

        return new PrescriptionTransactionResponse($response->toPsrResponse());
    }
}
