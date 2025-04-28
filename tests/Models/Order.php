<?php

namespace AmaizingCompany\CannaleoClient\Tests\Models;

use AmaizingCompany\CannaleoClient\Concerns\IsCannaleoOrder;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoOrder;
use AmaizingCompany\CannaleoClient\Models\BaseModel;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel implements CannaleoOrder
{
    use HasFactory;
    use IsCannaleoOrder;

    protected $guarded = [];

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('orders');
    }
}
