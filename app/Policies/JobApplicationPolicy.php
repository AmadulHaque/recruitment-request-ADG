<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\JobApplication;
use App\Models\User;

class JobApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::CANDIDATE || $user->role === UserRole::COMPANY;
    }

    public function view(User $user, JobApplication $application): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        if ($user->candidate && $user->candidate->id == $application->candidate_id) {
            return true;
        }
        if ($user->company && $user->company->id == $application->job->company_id) {
            return true;
        }
        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function update(User $user, JobApplication $application): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        if ($user->company && $user->company->id == $application->job->company_id) {
            return true;
        }
        return false;
    }

    public function delete(User $user, JobApplication $application): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function restore(User $user, JobApplication $application): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function forceDelete(User $user, JobApplication $application): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function uploadDocument(User $user, JobApplication $application): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        if ($user->candidate && $user->candidate->id == $application->candidate_id) {
            return true;
        }
        if ($user->company && $user->company->id == $application->job->company_id) {
            return true;
        }
        return false;
    }
}
