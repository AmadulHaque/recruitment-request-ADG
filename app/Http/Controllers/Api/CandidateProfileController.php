<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidates\UpsertCandidateProfileRequest;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use App\Services\CandidateProfileService;
use App\Services\MatchingService;
use Illuminate\Http\Request;

class CandidateProfileController extends Controller
{
    public function __construct(
        private readonly CandidateProfileService $service,
        private readonly MatchingService $matching
    ) {
    }

    public function show(Request $request)
    {
        $candidate = $request->user()->candidate;
        $candidate->load(['skills', 'educations', 'workExperiences']);
        $candidate->profile_completeness = $this->service->completeness($candidate);
        return new CandidateResource($candidate);
    }

    public function store(UpsertCandidateProfileRequest $request)
    {
        $candidate = $this->service->upsert($request->user(), $request->validated());
        $candidate->load(['skills', 'educations', 'workExperiences']);
        $candidate->profile_completeness = $this->service->completeness($candidate);
        return new CandidateResource($candidate);
    }

    public function update(UpsertCandidateProfileRequest $request)
    {
        return $this->store($request);
    }
}

