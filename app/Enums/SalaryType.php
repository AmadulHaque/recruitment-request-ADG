<?php

namespace App\Enums;

enum SalaryType: string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case HOURLY = 'hourly';
}

