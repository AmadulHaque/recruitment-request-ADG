<?php

namespace App\Contracts\Services;

use App\DTOs\CandidateLoginDTO;
use App\Models\Candidate;

interface CandidateServiceInterface
{
    public function authenticate(CandidateLoginDTO $dto): Candidate;
}

