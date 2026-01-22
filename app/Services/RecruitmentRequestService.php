<?php

namespace App\Services;

use App\Contracts\Repositories\RecruitmentRequestRepositoryInterface;
use App\Contracts\Services\RecruitmentRequestServiceInterface;
use App\DTOs\CreateRecruitmentRequestDTO;
use App\Exceptions\Request\RequestCreationException;
use App\Models\RecruitmentRequest;
use Illuminate\Support\Facades\DB;

class RecruitmentRequestService implements RecruitmentRequestServiceInterface
{
    public function __construct(
        private readonly RecruitmentRequestRepositoryInterface $repository
    ) {
    }

    public function create(CreateRecruitmentRequestDTO $dto): RecruitmentRequest
    {
        try {
            return DB::transaction(function () use ($dto) {
                return $this->repository->create([
                    'client_id' => $dto->clientId,
                    'position' => $dto->position,
                    'job_description' => $dto->jobDescription,
                    'num_employees' => $dto->numEmployees,
                    'salary_min' => $dto->salaryMin,
                    'salary_max' => $dto->salaryMax,
                    'urgency' => $dto->urgency->value,
                    'contact_phone' => $dto->contactPhone,
                    'contact_email' => $dto->contactEmail,
                ]);
            });
        } catch (\Throwable $e) {
            throw new RequestCreationException(
                message: 'Failed to create recruitment request',
                additionalData: ['client_id' => $dto->clientId],
                previous: $e
            );
        }
    }

    public function listForClient(string $clientId, int $perPage = 15)
    {
        return $this->repository->paginateForClient($clientId, $perPage);
    }
}

