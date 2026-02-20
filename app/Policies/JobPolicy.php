<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    public function view(User $user, Job $job): bool
    {
        return $user->role === UserRole::ADMIN || $user->company?->id === $job->company_id;
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

