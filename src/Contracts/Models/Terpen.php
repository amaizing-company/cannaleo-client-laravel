<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Terpen
{
    public function products(): BelongsToMany;
}
