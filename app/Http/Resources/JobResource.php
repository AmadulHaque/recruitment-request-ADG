<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'job_title' => $this->job_title,
            'job_category' => $this->job_category,
            'job_type' => $this->job_type?->value ?? $this->job_type,
            'vacancy_count' => $this->vacancy_count,
            'salary_min' => $this->salary_min,
            'salary_max' => $this->salary_max,
            'salary_type' => $this->salary_type?->value ?? $this->salary_type,
            'experience_min_year' => $this->experience_min_year,
            'experience_max_year' => $this->experience_max_year,
            'education_requirement' => $this->education_requirement,
            'job_location' => $this->job_location,
            'application_deadline' => optional($this->application_deadline)->toDateString(),
            'description' => $this->description,
            'benefits' => $this->benefits,
            'urgency' => $this->urgency?->value ?? $this->urgency,
            'status' => $this->status?->value ?? $this->status,
            'attachments' => $this->attachments,
            'skills' => $this->whenLoaded('skills', fn () => $this->skills->pluck('name')),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

