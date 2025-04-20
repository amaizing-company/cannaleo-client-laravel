<?php

use AmaizingCompany\CannaleoClient\Api\Contracts\Request;
use AmaizingCompany\CannaleoClient\Api\DataObjects\RequestObjects\DataRequestObject;
use AmaizingCompany\CannaleoClient\Api\DataObjects\ResponseObjects\DataResponseObject;
use AmaizingCompany\CannaleoClient\Api\Requests\BaseRequest;
use AmaizingCompany\CannaleoClient\Api\Responses\BaseResponse;

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch()
    ->expect('AmaizingCompany\CannaleoClient\Api\Concerns')
    ->toBeTraits();

arch()
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
