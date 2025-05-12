<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin Model
 */
interface PharmacyTransaction
{
    public function pharmacy(): BelongsTo;

    public function products(): BelongsToMany;

    public function order(): MorphTo;

    public function customer(): MorphTo;

    public function doctor(): MorphTo;

    public function prescription(): MorphTo;

    public function failed(): static;

    public function pending(): static;

    public function success(): static;
}
