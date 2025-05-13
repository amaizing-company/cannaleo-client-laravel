# Cannaleo api client package for laravel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/amaizing-company/cannaleo-client-laravel.svg?style=flat-square)](https://packagist.org/packages/amaizing-company/cannaleo-client-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/amaizing-company/cannaleo-client-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/amaizing-company/cannaleo-client-laravel/actions?query=workflow%3Arun-tests+branch%3A1.x)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/amaizing-company/cannaleo-client-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/amaizing-company/cannaleo-client-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3A1.x)
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
    
    'default_currency' => CurrencyAlpha3::Euro,

    'table_prefix' => 'cannaleo_',
];
```

## Configuration

Set your Cannaleo API Key inside your .env file:

```dotenv
CANNALEO_API_KEY=YOUR_API_KEY
```

### Prepare models

If you want to use the package database feature, you need to define some models they will interact with package services.

#### Customer model
```php
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\AddressObject;
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoCustomer;
use AmaizingCompany\CannaleoClient\Concerns\IsCannaleoCustomer;

class CustomerModel extends Model implements CannaleoCustomer
{
    use IsCannaleoCustomer;
    
    public function getFirstName(): string 
    {
        // Return first name of the customer.
    }
    
    public function getLastName(): string 
    {
        // Return last name of the customer.
    }
    
    public function getEmail(): string 
    {
        // Return the email address of the customer. 
    }
    
    public function getPhone(): string 
    {
        // Return the phone number of the customer.
    }
    
    public function getHomeAddress(): AddressObject 
    {
        // Return the customer's address as an AddressObject.
    }
    
    public function getDeliveryAddress(): AddressObject
    {
        // Return the customer's address as an AddressObject.
    }
}
```

#### Doctor model

```php
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoDoctor;
use AmaizingCompany\CannaleoClient\Concerns\IsCannaleoDoctor;

class DoctorModel extends Model implements CannaleoDoctor
{
    use IsCannaleoDoctor;
    
    public function getName(): string 
    {
        // Return the full name of the doctor.
    }
    
    public function getEmail(): string 
    {
        // Return the email address of the doctor. 
    }
    
    public function getPhone(): string 
    {
        // Return the phone number of the doctor.
    }
}
```


#### Order model
```php
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoOrder;
use AmaizingCompany\CannaleoClient\Concerns\IsCannaleoOrder;

class OrderModel extends Model implements CannaleoOrder
{
    use IsCannaleoOrder;
}
```

#### Prescription model
```php
use AmaizingCompany\CannaleoClient\Contracts\Models\CannaleoPrescription;
use AmaizingCompany\CannaleoClient\Concerns\IsCannaleoPrescription;
use Illuminate\Support\Carbon;

class OrderModel extends Model implements CannaleoPrescription
{
    use IsCannaleoPrescription;
    
    public function getFileContents(): string
    {
        // Return the file contents as raw string.
    }

    public function getSignatureCity(): string
    {
        // Return the city where the prescription was signed.
    }

    public function getSignatureDate(): Carbon
    {
        // Return the date of the signature.
    }
}
```

## Usage

### Synchronizing data

To synchronize data from the api with your applications database, you need to call the sync services. Before sync the 
product catalog, always run the pharmacies sync service. Otherwise some products could maybe not related to pharmacies.

#### Pharmacies
```php
use AmaizingCompany\CannaleoClient\Facades\CannaleoClient

CannaleoClient::syncPharmacies();
```

#### Product Catalog
```php
use AmaizingCompany\CannaleoClient\Facades\CannaleoClient

CannaleoClient::syncCatalog();
```

### Transferring a prescription to a pharmacy

```php
use AmaizingCompany\CannaleoClient\Facades\CannaleoClient
use AmaizingCompany\CannaleoClient\Models\Product;
use AmaizingCompany\CannaleoClient\Services\PrescriptionTransactionService;

$productModel = Product::query()->first();

// Build the products collection
$products = \Illuminate\Support\Collection::make();
$products->add($productModel->getProductObject(quantity: 1))

CannaleoClient::sendPrescription(
    $pharmacy, // Pharmacy Model
    $prescription, // Prescription Model
    $customer, // Customer Model
    $doctor, // Doctor Model
    $order, // Order Model
    $products
);
```

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
