<?php

namespace AmaizingCompany\CannaleoClient\Services;

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\CustomerObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\DoctorObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\ProductObject;
use AmaizingCompany\CannaleoClient\Api\Requests\PrescriptionTransactionRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\PrescriptionTransactionResponse;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoCustomer;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoDoctor;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoOrder;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoPrescription;
use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction;
use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Enums\PharmacyTransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PrescriptionTransactionService extends RequestService
{
    /**
     * @param Pharmacy $pharmacy
     * @param CannaleoPrescription $prescription
     * @param CannaleoCustomer $customer
     * @param CannaleoDoctor $doctor
     * @param CannaleoOrder $order
     * @param Collection<ProductObject> $products
     */
    public function __construct(
        protected Pharmacy $pharmacy,
        protected CannaleoPrescription $prescription,
        protected CannaleoCustomer $customer,
        protected CannaleoDoctor $doctor,
        protected CannaleoOrder $order,
        protected Collection $products
    ) {
        $this->buildRequest();
    }

    public function handle()
    {
        $transaction = $this->createNewPharmacyTransaction();
        $this->syncProductsWithTransaction($transaction);

        try {
            /**
             * @var PrescriptionTransactionResponse $response
             */
            $response = $this->request->send();

            if ($response->hasError()) {
                $transaction->failed();
                $this->handleResponseError($response);
            }

            $transaction->success();
        } catch (\Throwable $e) {
            $transaction->failed();
            $this->logError($e);
            throw $e;
        }
    }

    protected function buildRequest(): void
    {
        $doctor = new DoctorObject(
            $this->doctor->getName(),
            $this->prescription->getSignatureCity(),
            $this->prescription->getSignatureDate(),
        );

        $customer = new CustomerObject(
            $this->customer->getFirstName(),
            $this->customer->getLastName(),
            $this->customer->getEmail(),
            $this->customer->getHomeAddress(),
            $this->customer->getDeliveryAddress()
        );

        $request = new PrescriptionTransactionRequest(
            $this->prescription->getFileContents(),
            $this->order->getKey(),
            $this->pharmacy->getKey(),
            $doctor,
            $customer
        );

        foreach ($this->products as $product) {
            $request->addProduct($product);
        }

        $this->request = $request;
    }

    protected function createNewPharmacyTransaction(): PharmacyTransaction|Model
    {
        return app(PharmacyTransaction::class)->create([
            'status' => PharmacyTransactionStatus::PENDING,
            'pharmacy_id' => $this->pharmacy->getKey(),
            'order_type' => $this->order->getMorphClass(),
            'order_id' =>  $this->order->getKey(),
            'customer_type' => $this->customer->getMorphClass(),
            'customer_id' => $this->customer->getKey(),
            'doctor_type' =>  $this->doctor->getMorphClass(),
            'doctor_id' => $this->doctor->getKey(),
            'prescription_type' => $this->prescription->getMorphClass(),
            'prescription_id' => $this->prescription->getKey(),
        ]);
    }

    protected function syncProductsWithTransaction(PharmacyTransaction $transaction): void
    {
        foreach ($this->products as $product) {
            $externalProductIds[] = $product->getId();
        }

        if (!isset($externalProductIds)) {
            return;
        }

        $productIds = app(Product::class)->query()
            ->whereIn('external_id', $externalProductIds)
            ->pluck('id', 'external_id');

        foreach ($this->products as $product) {
            $id = Arr::get($productIds, $product->getId());
            $productsToSync[$id] = [
                'price' => $product->getPrice(),
            ];
        }

        if (!isset($productsToSync)) {
            return;
        }

        $transaction->products()->sync($productsToSync);
    }
}
