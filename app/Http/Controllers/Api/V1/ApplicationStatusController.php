<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Services\ApplicationServiceInterface;
use App\DTOs\UpdateApplicationStatusDTO;
use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateApplicationStatusRequest;
use App\Http\Resources\CandidateApplicationResource;

class ApplicationStatusController extends Controller
{
    public function __construct(
        private readonly ApplicationServiceInterface $service
    ) {
    }

    public function update(UpdateApplicationStatusRequest $request, string $applicationId)
    {
        $dto = new UpdateApplicationStatusDTO(
            applicationId: $applicationId,
            status: ApplicationStatus::from($request->string('status')),
            data: $request->input('data', []),
            scheduledAt: $request->date('scheduled_at')
        );

        $application = $this->service->updateStatus($dto);
        return new CandidateApplicationResource($application->load(['candidate', 'request', 'statusHistory']));
    }
}

