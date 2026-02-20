<?php

namespace App\Http\Controllers\Api;

use App\DTOs\UpdateApplicationStatusDTO;
use App\Enums\ApplicationFinalStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\FinalizeApplicationRequest;
use App\Http\Requests\Applications\ScheduleInterviewRequest;
use App\Http\Requests\Applications\UpdateApplicationStatusRequest;
use App\Http\Resources\JobApplicationResource;
use App\Models\Job;
use App\Models\JobApplication;
use App\Services\ApplicationService;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function __construct(private readonly ApplicationService $service)
    {
    }

    public function index(Request $request)
    {
        $applications = $this->service->forCandidate($request->user()->candidate);
        return JobApplicationResource::collection($applications);
    }

    public function apply(Request $request, Job $job)
    {
        $application = $this->service->apply($request->user()->candidate, $job);
        return new JobApplicationResource($application->load('job'));
    }

    public function show(Request $request, JobApplication $application)
    {
        $this->authorize('view', $application);
        return new JobApplicationResource($application->load(['job', 'candidate']));
    }

    public function updateStatus(UpdateApplicationStatusRequest $request, JobApplication $application)
    {
        $this->authorize('update', $application);
        $dto = new UpdateApplicationStatusDTO($request->validated()['application_status']);
        $application = $this->service->updateStatus($application, $dto);
        return new JobApplicationResource($application);
    }

    public function scheduleInterview(ScheduleInterviewRequest $request, JobApplication $application)
    {
        $this->authorize('update', $application);
        $v = $request->validated();
        $application = $this->service->schedule($application, new \DateTimeImmutable($v['interview_date']), $v['interview_note'] ?? null);
        return new JobApplicationResource($application);
    }

    public function finalize(FinalizeApplicationRequest $request, JobApplication $application)
    {
        $this->authorize('update', $application);
        $status = ApplicationFinalStatus::from($request->validated()['final_status']);
        $application = $this->service->finalize($application, $status);
        return new JobApplicationResource($application);
    }
}

