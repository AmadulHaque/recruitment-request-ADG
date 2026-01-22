<?php

namespace App\Contracts\Repositories;

use App\Models\CandidateApplication;

interface CandidateApplicationRepositoryInterface
{
    public function findById(string $id): ?CandidateApplication;
    public function save(CandidateApplication $application): void;
}

