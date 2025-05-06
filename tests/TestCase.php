<?php

namespace AmaizingCompany\CannaleoClient\Tests;

use AmaizingCompany\CannaleoClient\Api\Enums\Endpoint;
use AmaizingCompany\CannaleoClient\CannaleoClientServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as Orchestra;

use function Orchestra\Testbench\package_path;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'AmaizingCompany\\CannaleoClient\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CannaleoClientServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        foreach (File::allFiles(__DIR__.'/../database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
        }

        foreach (File::allFiles(__DIR__.'/migrations') as $migration) {
            (include $migration->getRealPath())->up();
        }
    }

    public function fakeHttpResponses(array $map = []): void
    {
        $map = $this->getResponseHelperMap($map);

        foreach (Endpoint::cases() as $endpoint) {
            $responses[$endpoint->getRequestUrl()] = Arr::get($map, $endpoint->value);
        }

        Http::fake($responses ?? []);
    }

    public function getFakedJsonResponseBody(string $filename): string
    {
        return file_get_contents(
            package_path("tests/Fixtures/Helpers/$filename.json")
        );
    }

    public function resetFakeHttpResponse(): void
    {
        $fake = app(\Illuminate\Http\Client\Factory::class);

        Http::swap($fake);
    }

    public function getResponseHelperMap(array $map = []): array
    {
        $result = array_merge([
            Endpoint::GET_SERVICE_STATUS->value => Http::response(
                $this->getFakedJsonResponseBody('api_status_data')
            ),
            Endpoint::GET_PHARMACIES->value => Http::response(
                $this->getFakedJsonResponseBody('pharmacies_data_1')
            ),
            Endpoint::GET_CATALOG->value => Http::response(
                $this->getFakedJsonResponseBody('catalog_data_1')
            ),
            Endpoint::POST_PRESCRIPTION->value => Http::response(
                $this->getFakedJsonResponseBody('prescription_data')
            ),
        ], $map);

        return $result;
    }
}
