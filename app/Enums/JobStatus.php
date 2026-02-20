<?php

namespace App\Enums;

enum JobStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case CLOSED = 'closed';
}

