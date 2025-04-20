<?php

namespace AmaizingCompany\CannaleoClient\Tests;

use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

use function Orchestra\Testbench\package_path;

class ApiTestCase extends TestCase
{
    public function fakeHttpResponses()
    {
        $map = $this->getResponseHelperMap();
        foreach (Endpoint::cases() as $endpoint) {
            $body = file_get_contents(
                package_path('tests/Fixtures/Helpers/' . Arr::get($map, $endpoint->value) . '.json')
            );

            $responses[$endpoint->getRequestUrl()] = Http::response($body);
        }

        Http::fake($responses ?? []);
    }

    public function getResponseHelperMap(): array
    {
        return [
            Endpoint::GET_SERVICE_STATUS->value => 'api_status_data',
            Endpoint::GET_PHARMACIES->value => 'pharmacies_data',
            Endpoint::GET_CATALOG->value => 'catalog_data',
            Endpoint::POST_PRESCRIPTION->value => 'prescription_data',
        ];
    }

    public function getPharmacyResponseObject(): string
    {
        return json_encode([
            "id" => 1,
            "cannabis_pharmacy_name" => "Demo Medicon-Apotheke",
            "official_name" => "Demo Apotheke",
            "domain" => "demo.example.de",
            "email" => "test@example.com",
            "phone_number" => "",
            "street" => "Teststreet",
            "plz" => "12345",
            "city" => "Testtown",
            "shipping" => "yes",
            "express" => "no",
            "local_courier" => "no",
            "pickup" => "yes",
            "shipping_cost_standard" => 7.99,
            "express_cost_standard" => 21.99,
            "local_coure_cost_standard" => 7.99
        ]);
    }

    public function getProductResponseObject(): string
    {
        return json_encode([
            "id" => "testcan-testina",
            "ansayId"=> "nlUP8hTtJ7x3pHmPb9V1",
            "name"=> "Testrocan",
            "genetic"=> "Sativa",
            "country"=> "Niederlande",
            "thc"=> 22,
            "cbd"=> 0.9,
            "price"=> 8.95,
            "pharmacy_name"=> "Demo Pharmacy",
            "pharmacy_domain"=> "demo.example.com",
            "pharmacy_id"=> 4,
            "availibility"=> "1",
            "category"=> "flower",
            "manufacturer"=> "Test Pharma GmbH",
            "grower"=> "",
            "dominance"=> "",
            "terpenes"=> [
                "Terpinolen",
                "Limonen",
                "Beta-Caryophyllen",
                "Myrcen",
                "Cis-Ocimen",
                "Beta-2-Pinen",
                "Alpha-Guaien",
                "Gamma-Cadinen",
                "Trans-Bergamoten",
                "Trans-β-Farnesen"
            ],
            "irradiated"=> 1,
            "strain"=> "Afina"
        ]);
    }
}
