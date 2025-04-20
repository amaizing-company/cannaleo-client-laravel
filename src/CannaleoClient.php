<?php

namespace AmaizingCompany\CannaleoClient;

class CannaleoClient
{
    public function getConfig(?string $key = null): mixed
    {
        if (!empty($key)) {
            $key = ".$key";
        }

        return config('cannaleo-client' . $key);
    }
}
