<?php

use AmaizingCompany\CannaleoClient\Tests\ApiTestCase;
use AmaizingCompany\CannaleoClient\Tests\PackageTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(ApiTestCase::class)->in(__DIR__.'/Feature/Api');

uses(PackageTestCase::class)->in(
    __DIR__.'/Feature/Models',
    __DIR__.'/Feature/Services',
    __DIR__.'/Feature/Commands'
);

uses(RefreshDatabase::class)->in(
    __DIR__.'/Feature/Models',
    __DIR__.'/Feature/Services'
);

pest()->group('package', 'models')->in(__DIR__.'/Feature/Models');
pest()->group('package', 'services')->in(__DIR__.'/Feature/Services');
pest()->group('package', 'commands')->in(__DIR__.'/Feature/Commands');
