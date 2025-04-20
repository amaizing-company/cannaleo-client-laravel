<?php

namespace AmaizingCompany\CannaleoClient;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use AmaizingCompany\CannaleoClient\Commands\CannaleoClientCommand;

class CannaleoClientServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('cannaleo-client-laravel')
            ->hasConfigFile('cannaleo-client')
            ->hasMigration('create_cannaleo_client_laravel_table')
            ->hasCommand(CannaleoClientCommand::class);
    }
}
