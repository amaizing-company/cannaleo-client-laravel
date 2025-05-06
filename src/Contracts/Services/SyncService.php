<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

interface SyncService
{
    public function sync();
    public static function getModel(): Model;
    public static function getUniqueIdName(): string;
    public static function getResponseObjects(Response $response): Collection;
    public static function getErrorMessage(): string;
    public static function getSuccessMessage(): string;
    public function createDataArray($item): array;
}
