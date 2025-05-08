<?php

namespace AmaizingCompany\CannaleoClient\Enums;

enum PharmacyTransactionStatus: string
{
    case INTENT = 'intent';
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
