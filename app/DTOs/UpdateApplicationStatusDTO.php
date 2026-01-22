<?php

namespace App\DTOs;

use App\Enums\ApplicationStatus;
use DateTimeInterface;

class UpdateApplicationStatusDTO
{
    public function __construct(
        public string $applicationId,
        public ApplicationStatus $status,
        public array $data = [],
        public ?DateTimeInterface $scheduledAt = null,
    ) {
    }
}

