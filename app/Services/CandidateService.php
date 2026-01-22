<?php

namespace App\Services;

use App\Contracts\Repositories\CandidateRepositoryInterface;
use App\Contracts\Services\CandidateServiceInterface;
use App\DTOs\CandidateLoginDTO;
use App\Exceptions\Auth\CandidateAuthException;
use App\Models\Candidate;

class CandidateService implements CandidateServiceInterface
{
    public function __construct(
        private readonly CandidateRepositoryInterface $repository
    ) {
    }

    public function authenticate(CandidateLoginDTO $dto): Candidate
    {
        $candidate = $this->repository->findByPhone($dto->phone) ?? $this->repository->findByCode($dto->candidateCode);

        if (!$candidate) {
            throw new CandidateAuthException('Candidate not found', [
                'phone' => $dto->phone,
                'candidate_code' => $dto->candidateCode,
            ]);
        }

        return $candidate;
    }
}

