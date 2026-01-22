<?php

namespace App\Contracts\Repositories;

use App\Models\Candidate;

interface CandidateRepositoryInterface
{
    public function findByPhone(?string $phone): ?Candidate;
    public function findByCode(?string $code): ?Candidate;
}

