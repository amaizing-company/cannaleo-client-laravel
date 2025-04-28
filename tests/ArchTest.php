<?php

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\DataRequestObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects\DataResponseObject;
use AmaizingCompany\CannaleoClient\Api\Requests\BaseRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\BaseResponse;
use AmaizingCompany\CannaleoClient\Contracts\Models\Pharmacy;
use AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransaction;
use AmaizingCompany\CannaleoClient\Contracts\Models\Product;
use AmaizingCompany\CannaleoClient\Contracts\Models\Terpen;
use AmaizingCompany\CannaleoClient\Models\BaseModel;
use AmaizingCompany\CannaleoClient\Models\PharmacyTransactionProduct;
use AmaizingCompany\CannaleoClient\Models\ProductTerpen;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('api concerns')
    ->expect('AmaizingCompany\CannaleoClient\Api\Concerns')
    ->toBeTraits();

arch('api contracts')
    ->expect('AmaizingCompany\CannaleoClient\Api\Contracts')
    ->toBeInterfaces();

arch()
    ->expect('AmaizingCompany\CannaleoClient\Api\DataObjects')
    ->toBeClasses();

arch()
    ->expect('AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects')
    ->not->toBeAbstract()
    ->ignoring(DataRequestObject::class)
    ->toExtend(DataRequestObject::class)
    ->ignoring(DataRequestObject::class)
    ->toImplement(\AmaizingCompany\CannaleoClient\Api\Contracts\DataRequestObject::class)
    ->ignoring(DataRequestObject::class);

arch()
    ->expect('AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects')
    ->not->toBeAbstract()
    ->ignoring(DataResponseObject::class)
    ->toExtend(DataResponseObject::class)
    ->ignoring(DataResponseObject::class);

arch('data request object is abstract')
    ->expect(DataRequestObject::class)
    ->toBeAbstract();

arch('data response object is abstract')
    ->expect(DataResponseObject::class)
    ->toBeAbstract();

arch()
    ->expect('AmaizingCompany\CannaleoClient\Api\Enums')
    ->toBeEnums();

arch()
    ->expect('AmaizingCompany\CannaleoClient\Api\Requests')
    ->toBeClasses()
    ->not->toBeAbstract()
    ->ignoring(BaseRequest::class)
    ->toExtend(BaseRequest::class)
    ->ignoring(BaseRequest::class)
    ->toImplement(Request::class)
    ->ignoring(BaseRequest::class);

arch()
    ->expect('AmaizingCompany\CannaleoClient\Api\Responses')
    ->toBeClasses()
    ->not->toBeAbstract()
    ->ignoring(BaseResponse::class)
    ->toExtend(BaseResponse::class)
    ->ignoring(BaseResponse::class);

arch()
    ->expect('AmaizingCompany\CannaleoClient\Casts')
    ->toBeClasses()
    ->toImplement(CastsAttributes::class);

arch()
    ->expect('AmaizingCompany\CannaleoClient\Concerns')
    ->toBeTraits();

arch()
    ->expect('AmaizingCompany\CannaleoClient\Contracts')
    ->toBeInterfaces();

arch()
    ->expect('AmaizingCompany\CannaleoClient\Enums')
    ->toBeEnums();

arch()
    ->expect('AmaizingCompany\CannaleoClient\Models')
    ->toBeClasses()
    ->toExtend(BaseModel::class)
    ->ignoring([BaseModel::class, PharmacyTransactionProduct::class, ProductTerpen::class])
    ->not->toBeAbstract()
    ->ignoring(BaseModel::class)
    ->toUse(HasFactory::class)
    ->ignoring([BaseModel::class, ProductTerpen::class]);

arch()
    ->expect(BaseModel::class)
    ->toBeClass()
    ->toBeAbstract()
    ->toExtend(Model::class);

arch('pharmacy transaction product model extends pivot')
    ->expect(PharmacyTransactionProduct::class)
    ->toExtend(Pivot::class);

arch('product terpen model extends pivot')
    ->expect(ProductTerpen::class)
    ->toExtend(Pivot::class);

arch('pharmacy model implements pharmacyContract interface')
    ->expect(\AmaizingCompany\CannaleoClient\Models\Pharmacy::class)
    ->toImplement(Pharmacy::class);

arch('pharmacy transaction model implements pharmacyTransactionContract interface')
    ->expect(\AmaizingCompany\CannaleoClient\Models\PharmacyTransaction::class)
    ->toImplement(PharmacyTransaction::class);

arch('pharmacy transaction product model implements pharmacyTransactionProductContract interface')
    ->expect(PharmacyTransactionProduct::class)
    ->toImplement(\AmaizingCompany\CannaleoClient\Contracts\Models\PharmacyTransactionProduct::class);

arch('product model implements productContract interface')
    ->expect(\AmaizingCompany\CannaleoClient\Models\Product::class)
    ->toImplement(Product::class);

arch('terpen model implements terpenContract interface')
    ->expect(\AmaizingCompany\CannaleoClient\Models\Terpen::class)
    ->toImplement(Terpen::class);

arch('product terpen model implements productTerpenContract interface')
    ->expect(ProductTerpen::class)
    ->toImplement(\AmaizingCompany\CannaleoClient\Contracts\Models\ProductTerpen::class);
