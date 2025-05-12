<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Model
 */
interface Pharmacy
{
    public function pharmacyTransactions(): HasMany;

    public function products(): HasMany;
}
