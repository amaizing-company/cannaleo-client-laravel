<?php

namespace AmaizingCompany\CannaleoClient\Jobs;

use AmaizingCompany\CannaleoClient\Api\Requests\PharmaciesRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ProcessPharmaciesSync implements ShouldQueue
{
    public function handle()
    {
        $request = new PharmaciesRequest;

        try {
            $response = $request->send();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return;
        }

        if ($response->hasError()) {
            Log::error($response->getMessage(), $response->json());

            return;
        }

    }
}
