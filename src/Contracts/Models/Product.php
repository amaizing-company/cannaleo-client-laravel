<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\ProductObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Model
 */
interface Product
{
    public function pharmacy(): BelongsTo;

    public function terpenes(): BelongsToMany;

    public function pharmacyTransactions(): BelongsToMany;
    public function getProductObject(): ProductObject;
}
