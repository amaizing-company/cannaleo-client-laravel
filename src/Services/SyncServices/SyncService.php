<?php

namespace AmaizingCompany\CannaleoClient\Services\SyncServices;

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Services\RequestService;
use Exception;
use Illuminate\Support\Collection;
use Throwable;

abstract class SyncService extends RequestService
{
    protected array $toUpdate = [];

    protected array $toCreate = [];

    protected array $seenIds = [];

    protected function reset(): void
    {
        $this->toCreate = [];
        $this->toUpdate = [];
        $this->seenIds = [];
    }

    /**
     * @throws Throwable
     */
    public function sync(): void
    {
        $this->reset();

        $this->executeInTransaction(function () {
            $response = $this->buildRequest()->send();

            if ($response->hasError()) {
                $this->handleSyncError($response);
            }

            $responseObjects = static::getResponseObjects($response);
            $existingIds = static::getExistingIds();
            $this->prepareData($responseObjects, $existingIds);

            $this->updateExisting();
            $this->createMissing();
            $this->deleteObsolete();

            $this->afterSync();
        });
    }

    protected function afterSync(): void
    {
        //
    }

    protected function handleSyncError($response): void
    {
        $this->logResponseError($response);

        throw new Exception($this->getErrorMessage().': '.$response->getMessage());
    }

    protected function prepareData(Collection $items, array $existingIds): void
    {
        foreach ($items as $item) {
            $itemId = $this->getItemId($item);

            $this->seenIds[] = $itemId;
            $data = static::createDataArray($item);

            if (in_array($itemId, $existingIds)) {
                $this->toUpdate[] = $this->modifyDataForUpdate($data);
            } else {
                $this->toCreate[] = $this->modifyDataForCreate($data);
            }
        }
    }

    protected function modifyDataForUpdate(array $data): array
    {
        return $data;
    }

    protected function modifyDataForCreate(array $data): array
    {
        return $data;
    }

    protected function getItemId($item)
    {
        return $item->getId();
    }

    protected function buildRequest(): Request
    {
        return $this->request;
    }

    protected function updateExisting(): void
    {
        foreach ($this->toUpdate as $item) {
            $uniqueIdName = static::getUniqueIdName();

            static::getModel()::query()
                ->withTrashed()
                ->where($uniqueIdName, $item[$uniqueIdName])
                ->update($item);
        }
    }

    protected function createMissing(): void
    {
        if (! empty($this->toCreate)) {
            static::getModel()::query()->insert($this->toCreate);
        }
    }

    protected function deleteObsolete(): void
    {
        if (! empty($this->seenIds)) {
            static::getModel()::query()->whereNotIn(static::getUniqueIdName(), $this->seenIds)->delete();
        }
    }

    protected static function getExistingIds(): array|Collection
    {
        return static::getModel()::query()->pluck(static::getUniqueIdName())->all();
    }
}
