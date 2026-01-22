<?php

namespace App\Events;

use App\Enums\ApplicationStatus;
use App\Models\CandidateApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public CandidateApplication $application,
        public ApplicationStatus $status
    ) {
    }
}

