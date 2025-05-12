<?php

namespace AmaizingCompany\CannaleoClient\Database\Factories;

use AmaizingCompany\CannaleoClient\Tests\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class PrescriptionFactory extends Factory
{
    protected $model = Prescription::class;

    public function definition()
    {
        return [
            'path' => UploadedFile::fake()->create('document.pdf'),
            'signature_city' => fake()->city(),
            'signature_date' => fake()->dateTime(),
        ];
    }
}
