<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\JobApplication;
use App\Models\User;

class JobApplicationPolicy
{
    public function view(User $user, JobApplication $application): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        if ($user->candidate && $user->candidate->id === $application->candidate_id) {
            return true;
        }
        if ($user->company && $user->company->id === $application->job->company_id) {
            return true;
        }
        return false;
    }

    public function update(User $user, JobApplication $application): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        if ($user->company && $user->company->id === $application->job->company_id) {
            return true;
        }
        return false;
    }
}

