<?php

namespace AmaizingCompany\CannaleoClient\Api\Concerns;

use Illuminate\Support\Carbon;

trait HasUpdatedAt
{
    public function getUpdatedAt(): Carbon
    {
        return Carbon::createFromTimestamp($this->json('data.updated_at'));
    }
}
