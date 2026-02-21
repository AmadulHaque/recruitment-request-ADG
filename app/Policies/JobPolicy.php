<?php

namespace App\Policies;

use App\Enums\JobStatus;
use App\Enums\UserRole;
use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Job $job): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        if ($user->company && $user->company->id === $job->company_id) {
            return true;
        }
        // Candidates can view jobs
        if ($user->role === UserRole::CANDIDATE) {
            return true;
        }
        
        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN || ($user->company && $user->role === UserRole::COMPANY);
    }

    public function update(User $user, Job $job): bool
    {
        return $user->role === UserRole::ADMIN || $user->company?->id === $job->company_id;
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->role === UserRole::ADMIN || $user->company?->id === $job->company_id;
    }
}
