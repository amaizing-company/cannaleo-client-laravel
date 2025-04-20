# Cannaleo api client package for laravel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/amaizing-company/cannaleo-client-laravel.svg?style=flat-square)](https://packagist.org/packages/amaizing-company/cannaleo-client-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/amaizing-company/cannaleo-client-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/amaizing-company/cannaleo-client-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/amaizing-company/cannaleo-client-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/amaizing-company/cannaleo-client-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/amaizing-company/cannaleo-client-laravel.svg?style=flat-square)](https://packagist.org/packages/amaizing-company/cannaleo-client-laravel)

This package allows laravel applications to communicate with cannaleo's api services. 

## Installation

You can install the package via composer:

```bash
composer require amaizing-company/cannaleo-client-laravel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="cannaleo-client-laravel-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="cannaleo-client-laravel-config"
```

This is the contents of the published config file:

```php
return [
    'base_url' => 'https://api.curobo.de/api/v1',
    'api_key' => env('CANNALEO_API_KEY'),
];
```

## Usage

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sandro Rümmler](https://github.com/xalabama)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
