<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Model
 */
interface Terpen
{
    public function products(): BelongsToMany;
}
