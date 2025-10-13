<?php

namespace App\Enums;

enum AccountStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case SUSPENDED = 'suspended';
    case DELETED = 'deleted';
}