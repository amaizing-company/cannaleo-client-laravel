<?php

namespace AmaizingCompany\CannaleoClient\Models;

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\ProductObject;
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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $pharmacy_id
 * @property Pharmacy $pharmacy
 * @property string $external_id
 * @property string $name
 * @property string|null $genetic
 * @property string|null $country
 * @property float $thc
 * @property float $cbd
 * @property bool $available
 * @property int $price
 * @property string|null $category
 * @property string|null $manufacturer
 * @property string|null $grower
 * @property string|null $dominance
 * @property bool $irradiated
 * @property string|null $strain
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Product extends BaseModel implements ProductContract
{
    use HasFactory;
    use HasPharmacy;
    use SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'available' => 'boolean',
            'price' => 'integer',
            'irradiated' => 'boolean',
        ];
    }

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('products');
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(app(Pharmacy::class)->getMorphClass());
    }

    public function terpenes(): BelongsToMany
    {
        return $this->belongsToMany(
            app(Terpen::class)->getMorphClass(),
            DatabaseHelper::getTableName('products_terpenes')
        )
            ->using(app(ProductTerpen::class)->getMorphClass())
            ->withTimestamps();
    }

    public function pharmacyTransactions(): BelongsToMany
    {
        return $this->belongsToMany(
            app(PharmacyTransaction::class)->getMorphClass(),
            DatabaseHelper::getTableName('pharmacy_transactions_products')
        )
            ->using(app(PharmacyTransactionProduct::class)->getMorphClass())
            ->withTimestamps();
    }

    public function getProductObject(int $quantity = 1): ProductObject
    {
        return new ProductObject(
            $this->external_id,
            $this->name,
            $this->price,
            $this->category,
            $quantity
        );
    }
}
