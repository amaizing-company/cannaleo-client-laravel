<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
interface CannaleoDoctor
{
    public function getName(): string;

    public function getEmail(): string;

    public function getPhone(): string;
}
