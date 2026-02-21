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
            'recruiter_id' => ['nullable', 'string', 'max:255'],
            'expected_salary_min' => ['nullable', 'integer', 'min:0'],
            'expected_salary_max' => ['nullable', 'integer', 'min:0'],
            'preferred_job_type' => ['nullable', 'in:full-time,part-time,contract,remote'],
            'preferred_location' => ['nullable', 'string', 'max:255'],
            'total_experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'availability' => ['nullable', 'string', 'max:255'],
            'availability_weeks' => ['nullable', 'integer', 'min:0'],
            'about_me' => ['nullable', 'string'],
            'cover_letter' => ['nullable', 'string'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'cv_file' => ['nullable', 'file', 'mimes:pdf,docx,png,jpeg,svg,webp'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['string', 'max:100'],
        ];
    }
}

