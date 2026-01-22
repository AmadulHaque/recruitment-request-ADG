<?php

namespace App\Repositories;

use App\Contracts\Repositories\CandidateApplicationRepositoryInterface;
use App\Models\CandidateApplication;

class CandidateApplicationRepository implements CandidateApplicationRepositoryInterface
{
    public function findById(string $id): ?CandidateApplication
    {
        return CandidateApplication::find($id);
    }

    public function save(CandidateApplication $application): void
    {
        $application->save();
    }
}

