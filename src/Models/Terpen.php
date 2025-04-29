<?php

namespace AmaizingCompany\CannaleoClient\Models;

use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Contracts\Models\ProductTerpen;
use AmaizingCompany\CannaleoClient\Contracts\Models\Terpen as TerpenContract;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @param  string  $id
 * @param  string  $name
 * @param  Carbon  $created_at
 * @param  Carbon  $updated_at
 */
class Terpen extends BaseModel implements TerpenContract
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('terpenes');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            app(Product::class)->getMorphClass(),
            'cannaleo_products_terpenes'
        )
            ->using(app(ProductTerpen::class)->getMorphClass())
            ->withTimestamps();
    }
}
