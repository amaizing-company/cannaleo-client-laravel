<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Product
{
    public function pharmacy(): BelongsTo;

    public function terpenes(): BelongsToMany;

    public function pharmacyTransactions():  BelongsToMany;
}
