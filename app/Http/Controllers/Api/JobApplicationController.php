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
        $filters = $request->only([
            'status', 
            'job_id', 
            'date_from', 
            'date_to', 
            'sort_by', 
            'sort_direction', 
            'per_page'
        ]);

        $applications = $this->service->forCandidate($request->user()->candidate, $filters);
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
        return new JobApplicationResource($application->load(['job', 'candidate', 'timeline']));
    }

    public function uploadDocument(Request $request, JobApplication $application)
    {
        $this->authorize('uploadDocument', $application);

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->store('application-documents', 'public');

        $documents = $application->documents ?? [];
        $documents[] = [
            'name' => $file->getClientOriginalName(), 
            'path' => $path, 
            'uploaded_at' => now()->toIso8601String()
        ];

        $application = $this->service->uploadDocuments($application, $documents);

        return new JobApplicationResource($application);
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
        $application = $this->service->schedule(
            $application,
            new \DateTimeImmutable($v['interview_date']),
            $v['interview_note'] ?? null,
            $v['meeting_url'] ?? null
        );
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

