<?php

namespace AmaizingCompany\CannaleoClient\Concerns;

use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
trait IsCannaleoCustomer
{
    public function pharmacyTransactions(): MorphMany
    {
        return $this->morphMany(app(PharmacyTransaction::class), 'customer');
    }
}
