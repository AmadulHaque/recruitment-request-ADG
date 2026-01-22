<?php

namespace App\Services;

use App\Contracts\Repositories\CandidateApplicationRepositoryInterface;
use App\Contracts\Services\ApplicationServiceInterface;
use App\DTOs\UpdateApplicationStatusDTO;
use App\Enums\ApplicationStatus;
use App\Events\ApplicationStatusChanged;
use App\Exceptions\Application\StatusUpdateException;
use App\Models\ApplicationStatusHistory;
use App\Models\CandidateApplication;
use Illuminate\Support\Facades\DB;

class ApplicationService implements ApplicationServiceInterface
{
    public function __construct(
        private readonly CandidateApplicationRepositoryInterface $repository
    ) {
    }

    public function updateStatus(UpdateApplicationStatusDTO $dto): CandidateApplication
    {
        try {
            return DB::transaction(function () use ($dto) {
                $application = $this->repository->findById($dto->applicationId);
                if (!$application) {
                    throw new StatusUpdateException('Application not found', ['application_id' => $dto->applicationId]);
                }

                $application->current_status = $dto->status->value;
                $this->repository->save($application);

                ApplicationStatusHistory::create([
                    'candidate_application_id' => $application->id,
                    'status' => $dto->status->value,
                    'data' => $dto->data,
                    'scheduled_at' => $dto->scheduledAt,
                ]);

                ApplicationStatusChanged::dispatch($application, $dto->status);

                return $application;
            });
        } catch (\Throwable $e) {
            if ($e instanceof StatusUpdateException) {
                throw $e;
            }

            throw new StatusUpdateException(
                message: 'Failed to update application status',
                additionalData: ['application_id' => $dto->applicationId],
                previous: $e
            );
        }
    }
}

