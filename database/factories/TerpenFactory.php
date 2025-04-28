<?php

namespace AmaizingCompany\CannaleoClient\Database\Factories;

use AmaizingCompany\CannaleoClient\Models\Terpen;
use Illuminate\Database\Eloquent\Factories\Factory;

class TerpenFactory extends Factory
{
    const array TERPENES = [
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
    ];

    protected $model = Terpen::class;

    public function definition()
    {
        return [
            'name' => fake()->unique()->randomElement(self::TERPENES),
        ];
    }
}
