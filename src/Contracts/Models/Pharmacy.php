<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface Pharmacy
{
    public function pharmacyTransactions(): HasMany;

    public function products(): HasMany;
}
