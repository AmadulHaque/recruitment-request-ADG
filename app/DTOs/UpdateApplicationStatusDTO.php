<?php

namespace App\DTOs;

class UpdateApplicationStatusDTO
{
    public function __construct(
        public string $application_status
    ) {
    }
}

