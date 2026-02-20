<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'headline' => $this->headline,
            'recruiter_id' => $this->recruiter_id,
            'expected_salary_min' => $this->expected_salary_min,
            'expected_salary_max' => $this->expected_salary_max,
            'preferred_job_type' => $this->preferred_job_type,
            'preferred_location' => $this->preferred_location,
            'total_experience_years' => $this->total_experience_years,
            'availability' => $this->availability,
            'availability_weeks' => $this->availability_weeks,
            'about_me' => $this->about_me,
            'cover_letter' => $this->cover_letter,
            'profile_photo' => $this->profile_photo,
            'cv_file' => $this->cv_file,
            'has_consented' => $this->has_consented,
            'skills' => $this->whenLoaded('skills', fn () => $this->skills->pluck('name')),
            'educations' => $this->whenLoaded('educations'),
            'work_experiences' => $this->whenLoaded('workExperiences'),
            'profile_completeness' => $this->when(isset($this->profile_completeness), $this->profile_completeness),
        ];
    }
}

