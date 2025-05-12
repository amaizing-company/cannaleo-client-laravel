<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\AddressObject;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
interface CannaleoCustomer
{
    public function getFirstName(): string;

    public function getLastName(): string;

    public function getEmail(): string;

    public function getPhone(): string;

    public function getHomeAddress(): AddressObject;

    public function getDeliveryAddress(): AddressObject;
}
