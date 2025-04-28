<?php

namespace AmaizingCompany\CannaleoClient\Models;

use AmaizingCompany\CannaleoClient\Contracts\Models\ProductTerpen as ProductTerpenContract;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductTerpen extends Pivot implements ProductTerpenContract
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
             $model->id = $model->newUniqueId();
        });
    }

    public function getTable()
    {
        return DatabaseHelper::getTableName('products_terpenes');
    }
}
