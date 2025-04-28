<?php

namespace AmaizingCompany\CannaleoClient\Tests\Models;

use AmaizingCompany\CannaleoClient\Concerns\IsCannaleoPrescription;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoPrescription;
use AmaizingCompany\CannaleoClient\Models\BaseModel;
use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;

class Prescription extends BaseModel implements CannaleoPrescription
{
    use HasFactory;
    use IsCannaleoPrescription;

    protected $guarded = [];

    public function getTable(): string
    {
        return DatabaseHelper::getTableName('prescriptions');
    }

    public function getFileContents(): string
    {
        return File::get($this->path);
    }
}
