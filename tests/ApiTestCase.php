<?php

namespace AmaizingCompany\CannaleoClient\Tests;

class ApiTestCase extends TestCase
{
    public function getPharmacyResponseObject(): string
    {
        return json_encode([
            'id' => 1,
            'cannabis_pharmacy_name' => 'Demo Medicon-Apotheke',
            'official_name' => 'Demo Apotheke',
            'domain' => 'demo.example.de',
            'email' => 'test@example.com',
            'phone_number' => '',
            'street' => 'Teststreet',
            'plz' => '12345',
            'city' => 'Testtown',
            'shipping' => 'yes',
            'express' => 'no',
            'local_courier' => 'no',
            'pickup' => 'yes',
            'shipping_cost_standard' => 7.99,
            'express_cost_standard' => 21.99,
            'local_coure_cost_standard' => 7.99,
        ]);
    }

    public function getPharmacyResponseObjectWithMinimumValues(): string
    {
        return json_encode([
            'id' => 1,
            'cannabis_pharmacy_name' => 'Demo Medicon-Apotheke',
            'official_name' => 'Demo Apotheke',
            'domain' => 'demo.example.de',
            'email' => 'test@example.com',
            'phone_number' => '',
            'street' => 'Teststreet',
            'plz' => '12345',
            'city' => 'Testtown',
            'shipping' => 'yes',
            'express' => 'no',
            'local_courier' => 'no',
            'pickup' => 'yes',
        ]);
    }

    public function getProductResponseObject(): string
    {
        return json_encode([
            'id' => 'testcan-testina',
            'ansayId' => 'nlUP8hTtJ7x3pHmPb9V1',
            'name' => 'Testrocan',
            'genetic' => 'Sativa',
            'country' => 'Niederlande',
            'thc' => 22,
            'cbd' => 0.9,
            'price' => 8.95,
            'pharmacy_name' => 'Demo Pharmacy',
            'pharmacy_domain' => 'demo.example.com',
            'pharmacy_id' => 4,
            'availibility' => '1',
            'category' => 'flower',
            'manufacturer' => 'Test Pharma GmbH',
            'grower' => '',
            'dominance' => '',
            'terpenes' => [
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
            ],
            'irradiated' => 1,
            'strain' => 'Afina',
        ]);
    }
}
