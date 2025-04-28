<?php

namespace AmaizingCompany\CannaleoClient\Tests\Models;

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\AddressObject;
use AmaizingCompany\CannaleoClient\Concerns\IsCannaleoCustomer;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoCustomer;
use AmaizingCompany\CannaleoClient\Models\BaseModel;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends BaseModel implements CannaleoCustomer
{
    use HasFactory;
    use IsCannaleoCustomer;

    protected $guarded = [];

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('customers');
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getHomeAddress(): AddressObject
    {
        return new AddressObject(
            'Teststreet',
            '20',
            '12345',
            'Testtown'
        );
    }

    public function getDeliveryAddress(): AddressObject
    {
        return new AddressObject(
            'Teststreet',
            '20',
            '12345',
            'Testtown'
        );
    }
}
