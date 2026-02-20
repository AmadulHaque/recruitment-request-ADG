<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case COMPANY = 'company';
    case CANDIDATE = 'candidate';
}

