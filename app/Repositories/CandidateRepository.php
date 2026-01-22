<?php

namespace App\Repositories;

use App\Contracts\Repositories\CandidateRepositoryInterface;
use App\Models\Candidate;

class CandidateRepository implements CandidateRepositoryInterface
{
    public function findByPhone(?string $phone): ?Candidate
    {
        return $phone ? Candidate::where('phone', $phone)->first() : null;
    }

    public function findByCode(?string $code): ?Candidate
    {
        return $code ? Candidate::where('candidate_code', $code)->first() : null;
    }
}

