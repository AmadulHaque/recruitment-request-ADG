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
            return JobApplication::firstOrCreate([
                'candidate_id' => $candidate->id,
                'job_id' => $job->id,
            ], [
                'application_status' => ApplicationStatus::APPLIED,
            ]);
        });
    }

    public function forCandidate(Candidate $candidate): LengthAwarePaginator
    {
        return JobApplication::with('job')->where('candidate_id', $candidate->id)->latest()->paginate(15);
    }

    public function updateStatus(JobApplication $application, UpdateApplicationStatusDTO $dto): JobApplication
    {
        $application->update(['application_status' => $dto->application_status]);
        return $application;
    }

    public function schedule(JobApplication $application, \DateTimeInterface $date, ?string $note = null): JobApplication
    {
        $application->update([
            'interview_date' => $date,
            'interview_note' => $note,
            'application_status' => ApplicationStatus::INTERVIEW_INVITED,
        ]);
        return $application;
    }

    public function finalize(JobApplication $application, ApplicationFinalStatus $status): JobApplication
    {
        $application->update([
            'final_status' => $status,
            'application_status' => ApplicationStatus::INTERVIEW_COMPLETED,
        ]);
        return $application;
    }
}

