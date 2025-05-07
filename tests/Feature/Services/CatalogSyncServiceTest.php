<?php

use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use AmaizingCompany\CannaleoClient\Api\Requests\CatalogRequest;
use AmaizingCompany\CannaleoClient\Api\Requests\PharmaciesRequest;
use AmaizingCompany\CannaleoClient\Models\Product;
use AmaizingCompany\CannaleoClient\Models\Terpen;
use AmaizingCompany\CannaleoClient\Services\CatalogSyncService;
use AmaizingCompany\CannaleoClient\Services\PharmaciesSyncService;
use Illuminate\Support\Facades\Http;

test('catalog sync service  can synchronize records with empty table', function () {
    $this->fakeHttpResponses();

    $pharmacyRequest = new PharmaciesRequest;
    $pharmaciesSyncService = new PharmaciesSyncService($pharmacyRequest);
    $pharmaciesSyncService->sync();

    $request = new CatalogRequest;
    $service = new CatalogSyncService($request);

    $service->sync();

    $products = Product::all();
    $terpenes = Terpen::all();

    expect($products)
        ->count()->toBe(2)
        ->and($terpenes)
        ->count()->toBe(13);
});

test('catalog sync service has correctly formatted data', function () {
    $this->fakeHttpResponses();

    $pharmacyRequest = new PharmaciesRequest;
    $pharmaciesSyncService = new PharmaciesSyncService($pharmacyRequest);
    $pharmaciesSyncService->sync();

    $request = new CatalogRequest;
    $service = new CatalogSyncService($request);

    $service->sync();

    $products = Product::all();
    $terpenes = Terpen::query()->pluck('name')->toArray();

    foreach ($terpenes as $terpen) {
        expect(in_array($terpen, [
            'Terpinolen',
            'Limonen',
            'Beta-Caryophyllen',
            'Myrcen',
            'Cis-Ocimen',
            'Beta-2-Pinen',
            'Alpha-Guaien',
            'Gamma-Cadinen',
            'Trans-Bergamoten',
            'Trans-β-Farnesen',
            'Test-Terpen-1',
            'Test-Terpen-2',
            'Test-Terpen-3',
        ]))->toBeTrue();
    }

    foreach ($products as $product) {
        switch ($product->external_id) {
            case 'testid':
                expect($product)
                    ->name->toBe('Testproduct')
                    ->genetic->toBe('Sativa')
                    ->country->toBe('Niederlande')
                    ->thc->toBe(22.0)
                    ->cbd->toBe(0.9)
                    ->price->toBe(895)
                    ->available->toBeTrue()
                    ->category->toBe('flower')
                    ->manufacturer->toBe('Demo Pharmacy GmbH')
                    ->grower->toBeNull()
                    ->dominance->toBeNull()
                    ->irradiated->toBeTrue()
                    ->strain->toBe('Afina')
                    ->and($product->terpenes()->count())
                    ->toBe(10)
                    ->and($product->pharmacy()->first())
                    ->external_id->toBe(4);
                break;

            case 'testid-two':
                expect($product)
                    ->name->toBe('Testproduct 2')
                    ->genetic->toBe('Sativa')
                    ->country->toBe('Deutschland')
                    ->thc->toBe(40.0)
                    ->cbd->toBe(5.5)
                    ->price->toBe(1025)
                    ->available->toBeTrue()
                    ->category->toBe('flower')
                    ->manufacturer->toBe('Demo Pharmacy GmbH')
                    ->grower->toBe('Demo Pharmacy GmbH')
                    ->dominance->toBe('test')
                    ->irradiated->toBeFalse()
                    ->strain->toBe('Afina')
                    ->and($product->terpenes()->count())
                    ->toBe(9)
                    ->and($product->pharmacy()->first())
                    ->external_id->toBe(1);
                break;
        }
    }
});

test('catalog sync service can delete obsolete records', function () {
    Http::fake([
        Endpoint::GET_PHARMACIES->getRequestUrl() => Http::response($this->getFakedJsonResponseBody('pharmacies_data_1')),
        Endpoint::GET_CATALOG->getRequestUrl() => Http::sequence()
            ->push($this->getFakedJsonResponseBody('catalog_data_1'))
            ->push($this->getFakedJsonResponseBody('catalog_data_2')),
    ]);

    $pharmacyRequest = new PharmaciesRequest;
    $pharmaciesSyncService = new PharmaciesSyncService($pharmacyRequest);
    $pharmaciesSyncService->sync();

    $request = new CatalogRequest;
    $service = new CatalogSyncService($request);

    for ($i = 0; $i < 2; $i++) {
        $service->sync();
    }

    $products = Product::all();

    expect($products)
        ->count()->toBe(1)
        ->contains('external_id', 'testid')->toBeTrue();
});

test('catalog sync service can update records', function () {
    Http::fake([
        Endpoint::GET_PHARMACIES->getRequestUrl() => Http::response($this->getFakedJsonResponseBody('pharmacies_data_1')),
        Endpoint::GET_CATALOG->getRequestUrl() => Http::sequence()
            ->push($this->getFakedJsonResponseBody('catalog_data_1'))
            ->push($this->getFakedJsonResponseBody('catalog_data_3')),
    ]);

    $pharmacyRequest = new PharmaciesRequest;
    $pharmaciesSyncService = new PharmaciesSyncService($pharmacyRequest);
    $pharmaciesSyncService->sync();

    $request = new CatalogRequest;
    $service = new CatalogSyncService($request);

    $service->sync();

    $productsCount = Product::query()->count();
    $product = Product::query()->where('external_id', 'testid-two')->first();

    expect($productsCount)->toBe(2)
        ->and($product)
        ->name->toBe('Testproduct 2');

    $service->sync();

    $productsCount = Product::query()->count();
    $product = Product::query()->where('external_id', 'testid-two')->first();

    expect($productsCount)->toBe(2)
        ->and($product)
        ->name->toBe('Testproduct with changed name');
});

test('catalog sync service can handle api errors', function () {
    Http::fake([
        Endpoint::GET_CATALOG->getRequestUrl() => Http::response($this->getFakedJsonResponseBody('catalog_data_error')),
    ]);

    $request = new CatalogRequest;
    $service = new CatalogSyncService($request);

    expect(function () use ($service) {
        $service->sync();
    })->toThrow(new Exception('Product catalog synchronization failed: Test Error!'));
});
