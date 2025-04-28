<?php

namespace AmaizingCompany\CannaleoClient\Tests\Models;

use AmaizingCompany\CannaleoClient\Concerns\IsCannaleoDoctor;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoDoctor;
use AmaizingCompany\CannaleoClient\Models\BaseModel;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends BaseModel implements CannaleoDoctor
{
    use HasFactory;
    use IsCannaleoDoctor;

    protected $guarded = [];

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('doctors');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
