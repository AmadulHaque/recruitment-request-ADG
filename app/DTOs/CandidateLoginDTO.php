<?php

namespace App\DTOs;

class CandidateLoginDTO
{
    public function __construct(
        public ?string $phone = null,
        public ?string $candidateCode = null,
    ) {
    }
}

