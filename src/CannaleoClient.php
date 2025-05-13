<?php

namespace AmaizingCompany\CannaleoClient;

use AmaizingCompany\CannaleoClient\Api\Requests\CatalogRequest;
use AmaizingCompany\CannaleoClient\Api\Requests\PharmaciesRequest;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoCustomer;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoDoctor;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoOrder;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoPrescription;
use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Services\PrescriptionTransactionService;
use AmaizingCompany\CannaleoClient\Services\SyncServices\CatalogSyncService;
use AmaizingCompany\CannaleoClient\Services\SyncServices\PharmaciesSyncService;
use Illuminate\Support\Collection;
use Throwable;

class CannaleoClient
{
    public function getConfig(?string $key = null): mixed
    {
        if (! empty($key)) {
            $key = ".$key";
        }

        return config('cannaleo-client'.$key);
    }

    /**
     * @throws Throwable
     */
    public function syncCatalog(): void
    {
        $request = new CatalogRequest;
        $service = new CatalogSyncService($request);

        $service->sync();
    }

    /**
     * @throws Throwable
     */
    public function syncPharmacies(): void
    {
        $request = new PharmaciesRequest;
        $service = new PharmaciesSyncService($request);

        $service->sync();
    }

    /**
     * @throws Throwable
     */
    public function sendPrescription(
        Pharmacy $pharmacy,
        CannaleoPrescription $prescription,
        CannaleoCustomer $customer,
        CannaleoDoctor $doctor,
        CannaleoOrder $order,
        Collection $products
    ): void {
        $service = new PrescriptionTransactionService(
            $pharmacy,
            $prescription,
            $customer,
            $doctor,
            $order,
            $products
        );

        $service->handle();
    }
}
