<?php

namespace AmaizingCompany\CannaleoClient\Support;

class DatabaseHelper
{
    public static function getTableName(string $table): string
    {
        return config('cannaleo-client.table_prefix').$table;
    }
}
