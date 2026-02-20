<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'job_id' => $this->job_id,
            'candidate_id' => $this->candidate_id,
            'application_status' => $this->application_status?->value ?? $this->application_status,
            'interview_date' => optional($this->interview_date)?->toISOString(),
            'interview_note' => $this->interview_note,
            'final_status' => $this->final_status?->value ?? $this->final_status,
            'job' => $this->whenLoaded('job', fn () => new JobResource($this->job)),
            'candidate' => $this->whenLoaded('candidate', fn () => new CandidateResource($this->candidate)),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

