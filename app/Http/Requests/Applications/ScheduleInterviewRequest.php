<?php

namespace App\Http\Requests\Applications;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleInterviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'interview_date' => ['required', 'date'],
            'interview_note' => ['nullable', 'string'],
        ];
    }
}

