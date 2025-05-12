<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
interface CannaleoPrescription
{
    public function getFileContents(): string;
}
