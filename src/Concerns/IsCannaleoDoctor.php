<?php

namespace AmaizingCompany\CannaleoClient\Concerns;

use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait IsCannaleoDoctor
{
    public function pharmacyTransactions(): MorphMany
    {
        return $this->morphMany(app(PharmacyTransaction::class), 'doctor');
    }
}
