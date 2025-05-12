<?php

// config for AmaizingCompany/CannaleoClient
use PrinsFrank\Standards\Currency\CurrencyAlpha3;

return [
    'base_url' => 'https://api.curobo.de/api/v1',
    'api_key' => env('CANNALEO_API_KEY'),

    'default_currency' => CurrencyAlpha3::Euro,

    'table_prefix' => 'cannaleo_',
];
