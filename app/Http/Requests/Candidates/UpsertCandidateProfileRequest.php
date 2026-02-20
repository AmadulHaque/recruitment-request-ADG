<?php

namespace App\Http\Requests\Candidates;

use Illuminate\Foundation\Http\FormRequest;

class UpsertCandidateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'headline' => ['nullable', 'string', 'max:255'],
            'expected_salary_min' => ['nullable', 'integer', 'min:0'],
            'expected_salary_max' => ['nullable', 'integer', 'min:0'],
            'preferred_job_type' => ['nullable', 'in:full-time,part-time,contract,remote'],
            'preferred_location' => ['nullable', 'string', 'max:255'],
            'total_experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'availability' => ['nullable', 'string', 'max:255'],
            'about_me' => ['nullable', 'string'],
            'profile_photo' => ['nullable', 'string', 'max:255'],
            'cv_file' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['string', 'max:100'],
        ];
    }
}

