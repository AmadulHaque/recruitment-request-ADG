<?php

namespace App\Contracts\Services;

use App\DTOs\CreateRecruitmentRequestDTO;
use App\Models\RecruitmentRequest;

interface RecruitmentRequestServiceInterface
{
    public function create(CreateRecruitmentRequestDTO $dto): RecruitmentRequest;
    public function listForClient(string $clientId, int $perPage = 15);
}

