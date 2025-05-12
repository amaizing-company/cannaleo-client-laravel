<?php

namespace AmaizingCompany\CannaleoClient\Models;

use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction as PharmacyTransactionContract;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransactionProduct;
use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Enums\PharmacyTransactionStatus;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property  string  $id
 * @property  PharmacyTransactionStatus $status
 * @property  string  $pharmacy_id
 * @property  Pharmacy  $pharmacy
 * @property  string  $order_type
 * @property  string  $order_id
 * @property  string  $customer_type
 * @property  string  $customer_id
 * @property  string  $doctor_type
 * @property  string  $doctor_id
 * @property  string  $prescription_type
 * @property  string  $prescription_id
 * @property  Carbon  $created_at
 * @property  Carbon  $updated_at
 */
class PharmacyTransaction extends BaseModel implements PharmacyTransactionContract
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => PharmacyTransactionStatus::class,
        ];
    }

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('pharmacy_transactions');
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(app(Pharmacy::class)->getMorphClass());
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            app(Product::class)->getMorphClass(),
            DatabaseHelper::getTableName('pharmacy_transactions_products')
        )
            ->withTimestamps()
            ->withPivot('price')
            ->using(app(PharmacyTransactionProduct::class)->getMorphClass());
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

    public function pending(): static
    {
        $this->update(['status' => PharmacyTransactionStatus::PENDING]);

        return $this;
    }

    public function success(): static
    {
        $this->update(['status' => PharmacyTransactionStatus::SUCCESS]);

        return $this;
    }

    public function failed(): static
    {
        $this->update(['status' => PharmacyTransactionStatus::FAILED]);

        return $this;
    }
}
