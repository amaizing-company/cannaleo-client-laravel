<?php

namespace AmaizingCompany\CannaleoClient\Services\SyncServices;

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects\ProductResponseObject;
use AmaizingCompany\CannaleoClient\Api\Requests\CatalogRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\CatalogResponse;
use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Contracts\Models\Terpen;
use AmaizingCompany\CannaleoClient\Contracts\Services\SyncService as SyncServiceContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CatalogSyncService extends SyncService implements SyncServiceContract
{
    protected array $pharmaciesMap = [];

    protected array $terpenes = [];

    /**
     * @param  CatalogRequest  $request
     */
    public function __construct(protected Request $request) {}

    public static function getModel(): Model
    {
        return app(Product::class);
    }

    public static function getUniqueIdName(): string
    {
        return 'external_id';
    }

    /**
     * @param  CatalogResponse  $response
     */
    public static function getResponseObjects(Response $response): Collection
    {
        return $response->getProducts();
    }

    public static function getErrorMessage(): string
    {
        return 'Product catalog synchronization failed';
    }

    public static function getSuccessMessage(): string
    {
        return 'Product catalog synchronization successful';
    }

    /**
     * @param  ProductResponseObject  $item
     */
    public function createDataArray($item): array
    {
        $this->syncTerpenesDataArray($item->getId(), $item->getTerpenes());

        return [
            'pharmacy_id' => $this->getPharmacyId($item->getPharmacyId()),
            'external_id' => $item->getId(),
            'name' => $item->getName(),
            'genetic' => $item->getGenetic(),
            'country' => $item->getCountry(),
            'thc' => $item->getThc(),
            'cbd' => $item->getCbd(),
            'available' => $item->isAvailable(),
            'price' => $item->getPrice(),
            'category' => $item->getCategory(),
            'manufacturer' => $item->getManufacturer(),
            'grower' => $item->getGrower(),
            'dominance' => $item->getDominance(),
            'irradiated' => $item->isIrradiated(),
            'strain' => $item->getStrain(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ];
    }

    protected function modifyDataForCreate(array $data): array
    {
        $data['id'] = Str::ulid()->toBase32();
        $data['created_at'] = \Illuminate\Support\Carbon::now();

        return $data;
    }

    protected function getPharmacyId(int $externalPharmacyId): string
    {
        $id = Arr::get($this->pharmaciesMap, $externalPharmacyId);

        if (empty($id)) {
            $id = app(Pharmacy::class)->where('external_id', $externalPharmacyId)->pluck('id')->first();

            $this->pharmaciesMap[$externalPharmacyId] = $id;
        }

        return $id;
    }

    protected function syncTerpenesDataArray(string $externalId, array $terpenes): void
    {
        foreach ($terpenes as $terpen) {
            $this->terpenes[$terpen][] = $externalId;
        }
    }

    protected function prepareData(Collection $items, array $existingIds): void
    {
        parent::prepareData($items, $existingIds);

        $terpenes = array_keys($this->terpenes);
        $terpenIdMap = [];

        foreach ($terpenes as $terpen) {
            $record = app(Terpen::class)::query()->firstOrCreate(['name' => $terpen]);

            $terpenIdMap[$record->id] = $this->terpenes[$terpen];
        }

        $this->terpenes = $terpenIdMap;
    }

    protected function afterSync(): void
    {
        $this->syncTerpenes();
    }

    protected function syncTerpenes(): void
    {
        $uniqueIdName = static::getUniqueIdName();

        $products = static::getModel()::query()->whereIn($uniqueIdName, $this->seenIds)->select(['id', $uniqueIdName])->get();

        /**
         * @var \AmaizingCompany\CannaleoClient\Models\Product $product
         */
        foreach ($products as $product) {
            $syncIds = [];

            foreach ($this->terpenes as $terpenId => $externalProductIds) {
                if (in_array($product->$uniqueIdName, $externalProductIds)) {
                    $syncIds[] = $terpenId;
                }
            }

            $product->terpenes()->sync($syncIds);
        }
    }
}
