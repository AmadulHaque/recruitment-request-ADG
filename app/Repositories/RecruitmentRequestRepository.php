<?php

namespace App\Repositories;

use App\Contracts\Repositories\RecruitmentRequestRepositoryInterface;
use App\Models\RecruitmentRequest;

class RecruitmentRequestRepository implements RecruitmentRequestRepositoryInterface
{
    public function create(array $attributes): RecruitmentRequest
    {
        return RecruitmentRequest::create($attributes);
    }

    public function findById(string $id): ?RecruitmentRequest
    {
        return RecruitmentRequest::find($id);
    }

    public function paginateForClient(string $clientId, int $perPage = 15)
    {
        return RecruitmentRequest::where('client_id', $clientId)->latest()->paginate($perPage);
    }
}

