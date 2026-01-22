<?php

namespace App\Listeners;

use App\Events\ApplicationStatusChanged;
use App\Notifications\ApplicationStatusNotification;

class SendApplicationStatusNotification
{
    public function handle(ApplicationStatusChanged $event): void
    {
        $candidate = $event->application->candidate;
        $candidate->notify(new ApplicationStatusNotification($event->application, $event->status));
    }
}

