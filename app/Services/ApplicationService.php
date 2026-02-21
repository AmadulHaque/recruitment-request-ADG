<?php

namespace App\Services;

use App\DTOs\UpdateApplicationStatusDTO;
use App\Enums\ApplicationFinalStatus;
use App\Enums\ApplicationStatus;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ApplicationService
{
    public function apply(Candidate $candidate, Job $job): JobApplication
    {
        return DB::transaction(function () use ($candidate, $job) {
            $application = JobApplication::firstOrCreate([
                'candidate_id' => $candidate->id,
                'job_id' => $job->id,
            ], [
                'application_status' => ApplicationStatus::APPLIED,
            ]);

            if ($application->wasRecentlyCreated) {
                $this->recordTimeline($application, ApplicationStatus::APPLIED);
            }

            return $application;
        });
    }

    public function forCandidate(Candidate $candidate, array $filters = []): LengthAwarePaginator
    {
        $query = JobApplication::with(['job', 'timeline'])
            ->where('candidate_id', $candidate->id);

        if (!empty($filters['status'])) {
            $query->where('application_status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $sortField = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        
        // Whitelist sortable fields
        if (in_array($sortField, ['created_at', 'updated_at', 'interview_date', 'application_status'])) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function updateStatus(JobApplication $application, UpdateApplicationStatusDTO $dto): JobApplication
    {
        return DB::transaction(function () use ($application, $dto) {
            $oldStatus = $application->application_status;
            $newStatus = $dto->application_status;

            $application->update(['application_status' => $newStatus]);

            if ($oldStatus !== $newStatus) {
                $this->recordTimeline($application, $newStatus);
            }

            return $application;
        });
    }

    public function schedule(JobApplication $application, \DateTimeInterface $date, ?string $note = null, ?string $meetingUrl = null): JobApplication
    {
        return DB::transaction(function () use ($application, $date, $note, $meetingUrl) {
            $application->update([
                'interview_date' => $date,
                'interview_note' => $note,
                'meeting_url' => $meetingUrl,
                'application_status' => ApplicationStatus::INTERVIEW_INVITED,
            ]);

            $this->recordTimeline($application, ApplicationStatus::INTERVIEW_INVITED, $note);

            return $application;
        });
    }

    public function finalize(JobApplication $application, ApplicationFinalStatus $status): JobApplication
    {
        return DB::transaction(function () use ($application, $status) {
            $application->update([
                'final_status' => $status,
                'application_status' => ApplicationStatus::INTERVIEW_COMPLETED,
            ]);

            $this->recordTimeline($application, ApplicationStatus::INTERVIEW_COMPLETED, "Final status: " . $status->value);

            return $application;
        });
    }

    public function uploadDocuments(JobApplication $application, array $documents): JobApplication
    {
        return DB::transaction(function () use ($application, $documents) {
            $application->update(['documents' => $documents]);
            
            $this->recordTimeline($application, $application->application_status, "Documents updated");

            return $application;
        });
    }

    protected function recordTimeline(JobApplication $application, ApplicationStatus|string $status, ?string $notes = null): void
    {
        $statusValue = $status instanceof ApplicationStatus ? $status->value : $status;
        
        $application->timeline()->create([
            'status' => $statusValue,
            'notes' => $notes,
            'occurred_at' => now(),
        ]);
    }
}

