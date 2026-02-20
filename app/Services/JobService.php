<?php

namespace App\Services;

use App\DTOs\CreateJobDTO;
use App\DTOs\UpdateJobDTO;
use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class JobService
{
    public function index(int $companyId, array $filters = []): LengthAwarePaginator
    {
        $query = Job::query()->where('company_id', $companyId);

        $query->when($filters['status'] ?? null, fn (Builder $q, $v) => $q->where('status', $v));
        $query->when($filters['job_type'] ?? null, fn (Builder $q, $v) => $q->where('job_type', $v));
        $query->when($filters['search'] ?? null, function (Builder $q, $v) {
            $q->where(function (Builder $qq) use ($v) {
                $qq->where('job_title', 'like', "%$v%")
                    ->orWhere('job_category', 'like', "%$v%");
            });
        });

        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }

    public function store(CreateJobDTO $dto): Job
    {
        $job = Job::create([
            'company_id' => $dto->company_id,
            'job_title' => $dto->job_title,
            'job_category' => $dto->job_category,
            'job_type' => $dto->job_type,
            'vacancy_count' => $dto->vacancy_count,
            'salary_min' => $dto->salary_min,
            'salary_max' => $dto->salary_max,
            'salary_type' => $dto->salary_type,
            'experience_min_year' => $dto->experience_min_year,
            'experience_max_year' => $dto->experience_max_year,
            'education_requirement' => $dto->education_requirement,
            'job_location' => $dto->job_location,
            'application_deadline' => $dto->application_deadline,
            'description' => $dto->description,
            'benefits' => $dto->benefits,
            'urgency' => $dto->urgency,
            'status' => $dto->status,
            'attachments' => $dto->attachments,
        ]);

        if (!empty($dto->skills)) {
            $skillIds = $this->resolveSkills($dto->skills);
            $job->skills()->sync($skillIds);
        }

        return $job;
    }

    public function update(Job $job, UpdateJobDTO $dto): Job
    {
        $job->update([
            'job_title' => $dto->job_title,
            'job_category' => $dto->job_category,
            'job_type' => $dto->job_type,
            'vacancy_count' => $dto->vacancy_count,
            'salary_min' => $dto->salary_min,
            'salary_max' => $dto->salary_max,
            'salary_type' => $dto->salary_type,
            'experience_min_year' => $dto->experience_min_year,
            'experience_max_year' => $dto->experience_max_year,
            'education_requirement' => $dto->education_requirement,
            'job_location' => $dto->job_location,
            'application_deadline' => $dto->application_deadline,
            'description' => $dto->description,
            'benefits' => $dto->benefits,
            'urgency' => $dto->urgency,
            'status' => $dto->status,
            'attachments' => $dto->attachments,
        ]);

        if (!empty($dto->skills)) {
            $skillIds = $this->resolveSkills($dto->skills);
            $job->skills()->sync($skillIds);
        }

        return $job;
    }

    public function updateStatus(Job $job, string $status): Job
    {
        $job->update(['status' => $status]);
        return $job;
    }

    protected function resolveSkills(array $skills): array
    {
        $ids = [];
        foreach ($skills as $name) {
            $ids[] = Skill::firstOrCreate(['name' => $name])->id;
        }
        return $ids;
    }
}

