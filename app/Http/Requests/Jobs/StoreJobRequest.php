<?php

namespace App\Http\Requests\Jobs;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_title' => ['required', 'string', 'max:255'],
            'job_category' => ['nullable', 'string', 'max:255'],
            'job_type' => ['required', 'in:full-time,part-time,contract,remote'],
            'vacancy_count' => ['required', 'integer', 'min:1'],
            'salary_min' => ['nullable', 'integer', 'min:0'],
            'salary_max' => ['nullable', 'integer', 'min:0'],
            'salary_type' => ['nullable', 'in:monthly,yearly,hourly'],
            'experience_min_year' => ['nullable', 'integer', 'min:0', 'max:60'],
            'experience_max_year' => ['nullable', 'integer', 'min:0', 'max:60'],
            'education_requirement' => ['nullable', 'string'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['string', 'max:100'],
            'job_location' => ['nullable', 'string', 'max:255'],
            'application_deadline' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'urgency' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:draft,active,closed'],
            'attachments' => ['nullable', 'file'],
        ];
    }
}

