<?php

namespace App\Enums;

enum JobUrgency: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}

