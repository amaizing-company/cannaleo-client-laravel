<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @mixin Model
 */
interface CannaleoPrescription
{
    public function getFileContents(): string;

    public function getSignatureCity(): string;

    public function getSignatureDate(): Carbon;
}
