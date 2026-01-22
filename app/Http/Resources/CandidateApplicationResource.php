<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidateApplicationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'candidate' => new CandidateResource($this->whenLoaded('candidate')),
            'request' => new RecruitmentRequestResource($this->whenLoaded('request')),
            'current_status' => $this->current_status,
            'status_history' => ApplicationStatusHistoryResource::collection($this->whenLoaded('statusHistory')),
        ];
    }
}

