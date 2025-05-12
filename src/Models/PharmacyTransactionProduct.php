<?php

namespace AmaizingCompany\CannaleoClient\Models;

use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransactionProduct as PharmacyTransactionProductContract;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * @property  string  $id
 * @property  string  $pharmacy_transaction_id
 * @property  string  $product_id
 * @property  int  $price
 * @property  Carbon  $created_at
 * @property  Carbon  $updated_at
 */
class PharmacyTransactionProduct extends Pivot implements PharmacyTransactionProductContract
{
    use HasFactory;
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

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('pharmacy_transactions_products');
    }

    protected function casts()
    {
        return [
            'price' => 'integer',
        ];
    }
}
