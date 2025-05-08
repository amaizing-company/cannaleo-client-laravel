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
 * @param  string  $id
 * @param  int  $external_id
 * @param  string|null  $cannabis_pharmacy_name
 * @param  string|null  $official_name
 * @param  string|null  $domain
 * @param  string|null  $email
 * @param  string|null  $phone
 * @param  string|null  $street
 * @param  string|null  $zip_code
 * @param  string|null  $city
 * @param  bool  $has_shipping
 * @param  bool  $has_express
 * @param  bool  $has_local_courier
 * @param  bool  $has_pickup
 * @param  int  $shipping_price
 * @param  int  $express_price
 * @param  int  $local_courier_price
 * @param  Carbon  $created_at
 * @param  Carbon  $updated_at
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
