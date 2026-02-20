<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Candidate;
use App\Models\User;

class CandidatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function view(User $user, Candidate $candidate): bool
    {
        return $user->role === UserRole::ADMIN || $user->id === $candidate->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function update(User $user, Candidate $candidate): bool
    {
        return $user->role === UserRole::ADMIN || $user->id === $candidate->user_id;
    }

    public function delete(User $user, Candidate $candidate): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}

