<?php

namespace AmaizingCompany\CannaleoClient\Facades;

use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoCustomer;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoDoctor;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoOrder;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoPrescription;
use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @see \AmaizingCompany\CannaleoClient\CannaleoClient
 *
 * @method static mixed getConfig(?string $key = null)
 * @method static void syncCatalog()
 * @method static void syncPharmacies()
 * @method static void sendPrescription(Pharmacy $pharmacy, CannaleoPrescription $prescription, CannaleoCustomer $customer, CannaleoDoctor $doctor, CannaleoOrder $order, Collection $products)
 */
class CannaleoClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AmaizingCompany\CannaleoClient\CannaleoClient::class;
    }
}
