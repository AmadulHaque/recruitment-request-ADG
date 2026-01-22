<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'position' => $this->position,
            'job_description' => $this->job_description,
            'num_employees' => $this->num_employees,
            'salary_min' => $this->salary_min,
            'salary_max' => $this->salary_max,
            'urgency' => $this->urgency,
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'attachments' => RequestAttachmentResource::collection($this->whenLoaded('attachments')),
            'created_at' => $this->created_at,
        ];
    }
}

