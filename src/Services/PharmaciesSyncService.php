<?php

namespace AmaizingCompany\CannaleoClient\Services;

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects\PharmacyResponseObject;
use AmaizingCompany\CannaleoClient\Api\Requests\PharmaciesRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\PharmaciesResponse;
use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Services\SyncService as SyncServiceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PharmaciesSyncService extends SyncService implements SyncServiceContract
{
    public function __construct(protected PharmaciesRequest|Request $request) {}

    /**
     * @param PharmacyResponseObject $item
     * @return array
     */
    public function createDataArray($item): array
    {
        return [
            'external_id' => $item->getId(),
            'cannabis_pharmacy_name' => $item->getCannabisPharmacyName(),
            'official_name' => $item->getOfficialName(),
            'domain' => $item->getDomain(),
            'email' => $item->getEmail(),
            'phone' => $item->getPhoneNumber(),
            'street' => $item->getStreet(),
            'zip_code' => $item->getZipCode(),
            'city' => $item->getCity(),
            'has_shipping' => $item->isShipping(),
            'has_express' => $item->isExpress(),
            'has_local_courier' => $item->isLocalCourier(),
            'has_pickup' => $item->isPickup(),
            'shipping_price' => $item->getShippingCostStandard(),
            'express_price' => $item->getExpressCostStandard(),
            'local_courier_price' => $item->getLocalCourierCostStandard(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ];
    }

    public static function getErrorMessage(): string
    {
        return 'Pharmacies synchronization failed.';
    }

    public static function getModel(): Model
    {
        return app(Pharmacy::class);
    }

    /**
     * @param PharmaciesResponse $response
     * @return Collection
     */
    public static function getResponseObjects(Response $response): Collection
    {
        return $response->getPharmacies();
    }

    public static function getSuccessMessage(): string
    {
        return 'Pharmacies synchronization completed successfully.';
    }

    public static function getUniqueIdName(): string
    {
        return 'external_id';
    }

    protected function modifyDataForCreate(array $data): array
    {
        $data['id'] = Str::ulid()->toBase32();
        $data['created_at'] = Carbon::now();

        return $data;
    }
}
