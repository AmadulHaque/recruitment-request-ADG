<?php

namespace App\Contracts\Services;

use App\DTOs\UpdateApplicationStatusDTO;
use App\Models\CandidateApplication;

interface ApplicationServiceInterface
{
    public function updateStatus(UpdateApplicationStatusDTO $dto): CandidateApplication;
}

