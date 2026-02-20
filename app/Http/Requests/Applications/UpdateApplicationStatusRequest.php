<?php

namespace App\Http\Requests\Applications;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'application_status' => ['required', 'in:applied,under_review,sent_to_company,interview_invited,interview_completed'],
        ];
    }
}

