<?php

namespace App\Contracts\Repositories;

use App\Models\RecruitmentRequest;

interface RecruitmentRequestRepositoryInterface
{
    public function create(array $attributes): RecruitmentRequest;
    public function findById(string $id): ?RecruitmentRequest;
    public function paginateForClient(string $clientId, int $perPage = 15);
}

