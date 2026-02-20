<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CreateJobDTO;
use App\DTOs\UpdateJobDTO;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Jobs\StoreJobRequest;
use App\Http\Requests\Jobs\UpdateJobRequest;
use App\Http\Requests\Jobs\UpdateJobStatusRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Services\JobService;
use Illuminate\Http\Request;

class CompanyJobController extends Controller
{
    public function __construct(private readonly JobService $jobService)
    {
    }

    public function index(Request $request)
    {
        $companyId = $request->user()->company?->id;
        $jobs = $this->jobService->index($companyId, $request->all());
        return JobResource::collection($jobs);
    }

    public function store(StoreJobRequest $request)
    {
        $companyId = $request->user()->company?->id;
        $dto = new CreateJobDTO(
            company_id: $companyId,
            job_title: $request->validated()['job_title'],
            job_category: $request->validated()['job_category'] ?? null,
            job_type: $request->validated()['job_type'],
            vacancy_count: $request->validated()['vacancy_count'],
            salary_min: $request->validated()['salary_min'] ?? null,
            salary_max: $request->validated()['salary_max'] ?? null,
            salary_type: $request->validated()['salary_type'] ?? null,
            experience_min_year: $request->validated()['experience_min_year'] ?? null,
            experience_max_year: $request->validated()['experience_max_year'] ?? null,
            education_requirement: $request->validated()['education_requirement'] ?? null,
            job_location: $request->validated()['job_location'] ?? null,
            application_deadline: $request->validated()['application_deadline'] ?? null,
            description: $request->validated()['description'] ?? null,
            benefits: $request->validated()['benefits'] ?? null,
            urgency: $request->validated()['urgency'],
            status: $request->validated()['status'],
            attachments: $request->validated()['attachments'] ?? null,
            skills: $request->validated()['skills'] ?? []
        );

        $job = $this->jobService->store($dto);
        return new JobResource($job->load('skills'));
    }

    public function show(Request $request, Job $job)
    {
        $this->authorize('view', $job);
        return new JobResource($job->load('skills'));
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $this->authorize('update', $job);
        $dto = new UpdateJobDTO(
            company_id: $job->company_id,
            job_title: $request->validated()['job_title'],
            job_category: $request->validated()['job_category'] ?? null,
            job_type: $request->validated()['job_type'],
            vacancy_count: $request->validated()['vacancy_count'],
            salary_min: $request->validated()['salary_min'] ?? null,
            salary_max: $request->validated()['salary_max'] ?? null,
            salary_type: $request->validated()['salary_type'] ?? null,
            experience_min_year: $request->validated()['experience_min_year'] ?? null,
            experience_max_year: $request->validated()['experience_max_year'] ?? null,
            education_requirement: $request->validated()['education_requirement'] ?? null,
            job_location: $request->validated()['job_location'] ?? null,
            application_deadline: $request->validated()['application_deadline'] ?? null,
            description: $request->validated()['description'] ?? null,
            benefits: $request->validated()['benefits'] ?? null,
            urgency: $request->validated()['urgency'],
            status: $request->validated()['status'],
            attachments: $request->validated()['attachments'] ?? null,
            skills: $request->validated()['skills'] ?? []
        );
        $job = $this->jobService->update($job, $dto);
        return new JobResource($job->load('skills'));
    }

    public function updateStatus(UpdateJobStatusRequest $request, Job $job)
    {
        $this->authorize('update', $job);
        $job = $this->jobService->updateStatus($job, $request->validated()['status']);
        return new JobResource($job);
    }

    public function applicants(Request $request, Job $job)
    {
        $this->authorize('view', $job);
        $applicants = $job->applications()->with('candidate.skills')->paginate(15);
        $data = collect($applicants->items())->map(function ($app) use ($job) {
            $candidate = $app->candidate;
            $score = app(\App\Services\MatchingService::class)->score($job->loadMissing('skills'), $candidate);
            return [
                'application' => [
                    'id' => $app->id,
                    'application_status' => $app->application_status?->value ?? $app->application_status,
                    'interview_date' => optional($app->interview_date)?->toISOString(),
                    'final_status' => $app->final_status?->value ?? $app->final_status,
                ],
                'candidate' => [
                    'id' => $candidate->id,
                    'user_id' => $candidate->user_id,
                    'headline' => $candidate->headline,
                    'skills' => $candidate->skills->pluck('name'),
                ],
                'matching_score' => $score,
            ];
        })->all();
        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $applicants->currentPage(),
                'last_page' => $applicants->lastPage(),
                'total' => $applicants->total(),
            ],
        ]);
    }
}
