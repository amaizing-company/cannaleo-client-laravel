<?php

namespace AmaizingCompany\CannaleoClient\Concerns;

use AmaizingCompany\CannaleoClient\Models\Pharmacy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Model
 */
trait HasPharmacy
{
    public function pharmacy(): BelongsTo
    {
       return $this->belongsTo(Pharmacy::class);
    }
}
