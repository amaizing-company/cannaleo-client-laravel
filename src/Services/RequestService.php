<?php

namespace AmaizingCompany\CannaleoClient\Services;

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

abstract class RequestService
{
    protected Request $request;

    protected function executeInTransaction(callable $callback): void
    {
        try {
            DB::beginTransaction();
            $callback();
            DB::commit();
            Log::info(static::getSuccessMessage());
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->logError($exception);
            throw $exception;
        }
    }

    protected function handleResponseError($response): void
    {
        $this->logResponseError($response);

        throw new Exception($this->getErrorMessage().': '.$response->getMessage());
    }

    protected function logResponseError($response): void
    {
        Log::error(static::getErrorMessage(), [
            'error' => $response->getMessage(),
            'trace' => $response->json(),
        ]);
    }

    protected function logError(Throwable $exception): void
    {
        Log::error(static::getErrorMessage(), [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
