<?php

namespace AmaizingCompany\CannaleoClient\Models;

use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction as PharmacyTransactionContract;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransactionProduct;
use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @param  string  $id
 * @param  string  $pharmacy_id
 * @param  Pharmacy  $pharmacy
 * @param  string  $order_type
 * @param  string  $order_id
 * @param  string  $customer_type
 * @param  string  $customer_id
 * @param  string  $doctor_type
 * @param  string  $doctor_id
 * @param  string  $prescription_type
 * @param  string  $prescription_id
 * @param  Carbon  $created_at
 * @param  Carbon  $updated_at
 */
class PharmacyTransaction extends BaseModel implements PharmacyTransactionContract
{
    use HasFactory;

    protected $guarded = [];

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('pharmacy_transactions');
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(app(Pharmacy::class));
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            app(Product::class),
            DatabaseHelper::getTableName('pharmacy_transactions_products')
        )
            ->withTimestamps()
            ->withPivot('price')
            ->using(app(PharmacyTransactionProduct::class));
    }

    public function order(): MorphTo
    {
        return $this->morphTo('order');
    }

    public function customer(): MorphTo
    {
        return $this->morphTo('customer');
    }

    public function doctor(): MorphTo
    {
        return $this->morphTo('doctor');
    }

    public function prescription(): MorphTo
    {
        return $this->morphTo('prescription');
    }
}
