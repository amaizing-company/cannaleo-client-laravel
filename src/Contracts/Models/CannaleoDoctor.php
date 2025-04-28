<?php

namespace AmaizingCompany\CannaleoClient\Contracts\Models;

interface CannaleoDoctor
{
    public function getName(): string;

    public function getEmail(): string;

    public function getPhone(): string;
}
