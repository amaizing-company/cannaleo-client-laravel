<?php

namespace AmaizingCompany\CannaleoClient\Models;

use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy as PharmacyContract;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction;
use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property int $external_id
 * @property string|null $cannabis_pharmacy_name
 * @property string|null $official_name
 * @property string|null $domain
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $street
 * @property string|null $zip_code
 * @property string|null $city
 * @property bool $has_shipping
 * @property bool $has_express
 * @property bool $has_local_courier
 * @property bool $has_pickup
 * @property int $shipping_price
 * @property int $express_price
 * @property int $local_courier_price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Pharmacy extends BaseModel implements PharmacyContract
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'external_id' => 'integer',
            'has_shipping' => 'boolean',
            'has_express' => 'boolean',
            'has_local_courier' => 'boolean',
            'has_pickup' => 'boolean',
            'shipping_price' => 'integer',
            'express_price' => 'integer',
            'local_courier_price' => 'integer',
        ];
    }

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('pharmacies');
    }

    public function products(): HasMany
    {
        return $this->hasMany(app(Product::class)->getMorphClass());
    }

    public function pharmacyTransactions(): HasMany
    {
        return $this->hasMany(app(PharmacyTransaction::class)->getMorphClass());
    }
}
