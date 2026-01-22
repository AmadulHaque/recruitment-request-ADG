<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationStatusHistoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'data' => $this->data,
            'scheduled_at' => $this->scheduled_at,
            'created_at' => $this->created_at,
        ];
    }
}

