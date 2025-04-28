<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

interface PharmacyTransaction
{
    public function pharmacy(): BelongsTo;

    public function products(): BelongsToMany;

    public function order(): MorphTo;

    public function customer(): MorphTo;

    public function doctor(): MorphTo;

    public function prescription(): MorphTo;
}
