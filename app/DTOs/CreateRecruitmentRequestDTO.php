<?php

namespace App\DTOs;

use App\Enums\Urgency;

class CreateRecruitmentRequestDTO
{
    public function __construct(
        public string $clientId,
        public string $position,
        public ?string $jobDescription,
        public int $numEmployees,
        public ?float $salaryMin,
        public ?float $salaryMax,
        public Urgency $urgency,
        public ?string $contactPhone,
        public ?string $contactEmail,
    ) {
    }
}

