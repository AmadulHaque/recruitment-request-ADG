<?php

namespace App\Notifications;

use App\Enums\ApplicationStatus;
use App\Models\CandidateApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly CandidateApplication $application,
        private readonly ApplicationStatus $status
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'application_id' => $this->application->id,
            'status' => $this->status->value,
            'label' => $this->status->label(),
        ]);
    }
}

