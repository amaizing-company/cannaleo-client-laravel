<?php

namespace AmaizingCompany\CannaleoClient\Models;

use Akaunting\Money\Casts\MoneyCast;
use Akaunting\Money\Money;
use AmaizingCompany\CannaleoClient\Concerns\HasPharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransactionProduct;
use AmaizingCompany\CannaleoClient\Contracts\Models\Product as ProductContract;
use AmaizingCompany\CannaleoClient\Contracts\Models\ProductTerpen;
use AmaizingCompany\CannaleoClient\Contracts\Models\Terpen;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @param  string  $id
 * @param  string  $pharmacy_id
 * @param  Pharmacy  $pharmacy
 * @param  string  $external_id
 * @param  string  $name
 * @param  string|null  $genetic
 * @param  string|null  $country
 * @param  float  $thc
 * @param  float  $cbd
 * @param  bool  $available
 * @param  Money  $price
 * @param  string|null  $category
 * @param  string|null  $manufacturer
 * @param  string|null  $grower
 * @param  string|null  $dominance
 * @param  bool  $irradiated
 * @param  string|null  $strain
 * @param  Carbon  $created_at
 * @param  Carbon  $updated_at
 */
class Product extends BaseModel implements ProductContract
{
    use HasFactory;
    use HasPharmacy;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'available' => 'boolean',
            'price' => MoneyCast::class,
            'irradiated' => 'boolean',
        ];
    }

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('products');
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(app(Pharmacy::class));
    }

    public function terpenes(): BelongsToMany
    {
        return $this->belongsToMany(
            app(Terpen::class),
            DatabaseHelper::getTableName('products_terpenes')
        )
            ->using(app(ProductTerpen::class))
            ->withTimestamps();
    }

    public function pharmacyTransactions(): BelongsToMany
    {
        return $this->belongsToMany(
            app(PharmacyTransaction::class),
            DatabaseHelper::getTableName('pharmacy_transactions_products')
        )
            ->using(app(PharmacyTransactionProduct::class))
            ->withTimestamps();
    }
}
