<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Pharmacy
{
    public function pharmacyTransactions(): BelongsToMany;
    public function products(): BelongsToMany;
}
