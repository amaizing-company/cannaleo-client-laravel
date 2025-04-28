<?php

namespace AmaizingCompany\CannaleoClient;

use AmaizingCompany\CannaleoClient\Commands\CannaleoClientCommand;
use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransactionProduct;
use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Contracts\Models\ProductTerpen;
use AmaizingCompany\CannaleoClient\Contracts\Models\Terpen;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasMigrations(
                'create_cannaleo_pharmacies_table',
                'create_cannaleo_terpenes_table',
                'create_cannaleo_products_table',
                'create_cannaleo_product_terpenes_table',
                'create_cannaleo_pharmacy_transactions_table',
                'create_cannaleo_pharmacy_transactions_products_table'
            )
            ->hasCommand(CannaleoClientCommand::class);
    }

    public function packageRegistered(): void
    {
        // Bind model contracts
        $this->app->bind(Pharmacy::class, Models\Pharmacy::class);
        $this->app->bind(PharmacyTransaction::class,  Models\PharmacyTransaction::class);
        $this->app->bind(PharmacyTransactionProduct::class,  Models\PharmacyTransactionProduct::class);
        $this->app->bind(Product::class, Models\Product::class);
        $this->app->bind(ProductTerpen::class, Models\ProductTerpen::class);
        $this->app->bind(Terpen::class,  Models\Terpen::class);
    }
}
