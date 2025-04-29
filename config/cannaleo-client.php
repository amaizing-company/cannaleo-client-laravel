<?php

// config for AmaizingCompany/CannaleoClient
return [
    'base_url' => 'https://api.curobo.de/api/v1',
    'api_key' => env('CANNALEO_API_KEY'),

    'default_currency' => \Akaunting\Money\Currency::EUR(),

    'table_prefix' => 'cannaleo_',
];
