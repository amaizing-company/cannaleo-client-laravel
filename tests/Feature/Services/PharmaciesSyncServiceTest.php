<?php

use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use AmaizingCompany\CannaleoClient\Api\Requests\PharmaciesRequest;
use AmaizingCompany\CannaleoClient\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Services\PharmaciesSyncService;
use Illuminate\Support\Facades\Http;

test('pharmacies sync service can synchronize records with empty table', function () {
    $this->fakeHttpResponses();

    $request = new PharmaciesRequest;

    $service = new PharmaciesSyncService($request);

    $service->sync();

    $pharmacies = Pharmacy::all();

    expect($pharmacies)
        ->count()->toBe(3);
});

test('ensure pharmacies sync service has correctly formatted data', function () {
    $this->fakeHttpResponses();

    $request = new PharmaciesRequest;
    $service = new PharmaciesSyncService($request);
    $service->sync();

    $pharmacies = Pharmacy::all();

    foreach ($pharmacies as $pharmacy) {
        switch ($pharmacy->external_id) {
            case 1:
                expect($pharmacy)
                    ->cannabis_pharmacy_name->toBe('Demo Medicon-Apotheke')
                    ->official_name->toBeNull()
                    ->domain->toBe('test.demo')
                    ->email->toBeNull()
                    ->phone->toBeNull()
                    ->street->toBeNull()
                    ->zip_code->toBeNull()
                    ->city->toBeNull()
                    ->has_shipping->toBeFalse()
                    ->has_express->toBeFalse()
                    ->has_local_courier->toBeFalse()
                    ->has_pickup->toBeFalse()
                    ->shipping_price->toBe(0)
                    ->express_price->toBe(0)
                    ->local_courier_price->toBe(0);

                break;
            case 4:
                expect($pharmacy)
                    ->cannabis_pharmacy_name->toBe('Test Apotheke')
                    ->official_name->toBe('Test Apotheke')
                    ->domain->toBe('test.demo')
                    ->email->toBe('test-apotheke@example.example')
                    ->phone->toBe('0123456789')
                    ->street->toBe('Test Street 20')
                    ->zip_code->toBe('12345')
                    ->city->toBe('Testtown')
                    ->has_shipping->toBeTrue()
                    ->has_express->toBeTrue()
                    ->has_local_courier->toBeFalse()
                    ->has_pickup->toBeTrue()
                    ->shipping_price->toBe(799)
                    ->express_price->toBe(2199)
                    ->local_courier_price->toBe(0);

                break;
            case 20:
                expect($pharmacy)
                    ->cannabis_pharmacy_name->toBe('Test Apotheke 20')
                    ->official_name->toBe('Test Apotheke 20')
                    ->domain->toBe('test.demo')
                    ->email->toBe('test-apotheke-20@example.example')
                    ->phone->toBe('0123456789')
                    ->street->toBe('Test Street 20')
                    ->zip_code->toBe('12345')
                    ->city->toBe('Testtown')
                    ->has_shipping->toBeFalse()
                    ->has_express->toBeTrue()
                    ->has_local_courier->toBeTrue()
                    ->has_pickup->toBeTrue()
                    ->shipping_price->toBe(0)
                    ->express_price->toBe(2199)
                    ->local_courier_price->toBe(799);
                break;
        }
    }
});

test('pharmacies sync service can delete obsolete records', function () {
    Http::fake([
        Endpoint::GET_PHARMACIES->getRequestUrl() => Http::sequence()
            ->push($this->getFakedJsonResponseBody('pharmacies_data_1'))
            ->push($this->getFakedJsonResponseBody('pharmacies_data_2')),
    ]);

    $request = new PharmaciesRequest;
    $service = new PharmaciesSyncService($request);

    for ($i = 0; $i < 2; $i++) {
        $service->sync();
    }

    $pharmacies = Pharmacy::all();

    expect($pharmacies)
        ->count()->toBe(2)
        ->contains('external_id', 1)->toBeTrue()
        ->contains('external_id', 4)->toBeTrue()
        ->contains('external_id', 20)->toBeFalse();
});

test('pharmacies sync service can update records', function () {
    Http::fake([
        Endpoint::GET_PHARMACIES->getRequestUrl() => Http::sequence()
            ->push($this->getFakedJsonResponseBody('pharmacies_data_1'))
            ->push($this->getFakedJsonResponseBody('pharmacies_data_3')),
    ]);

    $request = new PharmaciesRequest;
    $service = new PharmaciesSyncService($request);

    $service->sync();

    $pharmaciesCount = Pharmacy::query()->count();
    $pharmacy = Pharmacy::query()->where('external_id', 20)->first();

    expect($pharmaciesCount)->toBe(3)
        ->and($pharmacy)
        ->cannabis_pharmacy_name->toBe('Test Apotheke 20')
        ->official_name->toBe('Test Apotheke 20');

    $service->sync();

    $pharmaciesCount = Pharmacy::query()->count();
    $pharmacy = Pharmacy::query()->where('external_id', 20)->first();

    expect($pharmaciesCount)->toBe(3)
        ->and($pharmacy)
        ->cannabis_pharmacy_name->toBe('Test Apotheke 40')
        ->official_name->toBe('Test Apotheke 40');
});
